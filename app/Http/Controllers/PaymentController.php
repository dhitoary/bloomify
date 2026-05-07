<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\OrderNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isSanitized = true;
        Config::$is3ds = true;
        Config::$isProduction = config('midtrans.is_production');
    }

    /**
     * Show payment page for an order
     */
    public function show($orderId)
    {
        $order = Order::with('items', 'payment')->findOrFail($orderId);

        // Verify user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Check if payment already exists and is successful
        if ($order->payment && $order->payment->status === 'success') {
            return redirect()->route('order.show', $order)->with('info', 'Pesanan sudah dibayar');
        }

        return view('payment.show', compact('order'));
    }

    /**
     * Create Snap token for payment
     */
    public function createToken(Request $request, $orderId)
    {
        $order = Order::with('items', 'user')->findOrFail($orderId);

        // Verify user owns this order
        if ($order->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        try {
            // Jika sudah ada token, langsung gunakan kembali (jangan buat baru untuk order_id yang sama)
            if ($order->snap_token) {
                return response()->json([
                    'success' => true,
                    'snap_token' => $order->snap_token,
                ]);
            }

            // Prepare transaction data. Tambahkan timestamp agar order_id selalu unik di Midtrans
            // untuk mengatasi error "transaction_details.order_id has already been taken" pada retry
            $midtransOrderId = $order->order_number . '-' . time();
            
            $transactionDetails = [
                'order_id' => $midtransOrderId,
                'gross_amount' => $order->total_price,
            ];

            $customerDetails = [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
                'phone' => $order->user->phone ?? $order->shipping_address,
            ];

            $items = [];
            foreach ($order->items as $item) {
                $items[] = [
                    'id' => 'item-' . $item->product_id,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'name' => $item->product->name,
                ];
            }

            // Tambahkan shipping cost sebagai line item jika ada
            if ($order->shipping_cost > 0) {
                $items[] = [
                    'id' => 'shipping',
                    'price' => $order->shipping_cost,
                    'quantity' => 1,
                    'name' => 'Biaya Pengiriman',
                ];
            }

            $payload = [
                'transaction_details' => $transactionDetails,
                'customer_details' => $customerDetails,
                'item_details' => $items,
                'callbacks' => [
                    'finish' => route('payment.finish', $order->id),
                    'error' => route('payment.error', $order->id),
                    'pending' => route('payment.pending', $order->id),
                ],
            ];

            $snapToken = Snap::getSnapToken($payload);

            // Simpan token ke database untuk dipakai nanti jika user buka ulang atau close popup
            $order->update(['snap_token' => $snapToken]);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat token pembayaran: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle payment notification from Midtrans
     */
    public function notification(Request $request)
    {
        $notif = new \Midtrans\Notification();

        try {
            $transactionStatus = $notif->transaction_status;
            $transactionId = $notif->transaction_id;
            
            // Dapatkan order_id dari notif (contoh: ORD-123456-1777895000)
            $midtransOrderId = $notif->order_id;
            
            // Hapus suffix timestamp untuk mencari di database kita
            // Asumsi format asli adalah ORD-timestamp (2 bagian), jadi kita ambil bagian 0 dan 1
            $parts = explode('-', $midtransOrderId);
            $orderNumber = $parts[0] . '-' . $parts[1];

            // Find order by order_number
            $order = Order::where('order_number', $orderNumber)->firstOrFail();

            // Get or create payment record
            $payment = Payment::firstOrCreate(
                ['transaction_id' => $transactionId],
                [
                    'order_id' => $order->id,
                    'amount' => $notif->gross_amount,
                    'status' => 'pending',
                    'response' => json_encode($notif),
                ]
            );

            // Update payment status based on transaction status
            if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                $payment->update([
                    'status' => 'success',
                    'payment_method' => $notif->payment_type ?? null,
                    'paid_at' => now(),
                ]);
                $order->update(['status' => 'confirmed']);
                $this->notifyAdminsPaymentSuccess($order);
            } elseif ($transactionStatus == 'pending') {
                $payment->update(['status' => 'pending']);
            } elseif ($transactionStatus == 'deny' || $transactionStatus == 'cancel') {
                $payment->update(['status' => 'failed']);
            } elseif ($transactionStatus == 'expire') {
                $payment->update(['status' => 'expired']);
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle payment finish callback
     */
    public function finish(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        
        // Fallback update status (berguna jika webhook tidak bisa masuk karena localhost)
        if ($request->has('transaction_status') && $order->status === 'pending') {
            $transactionStatus = $request->transaction_status;
            
            $payment = Payment::firstOrCreate(
                ['order_id' => $order->id],
                [
                    'amount' => $order->total_price,
                    'status' => 'pending',
                ]
            );

            if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                $payment->update([
                    'status' => 'success',
                    'paid_at' => now(),
                ]);
                $order->update(['status' => 'confirmed']);
            }
        }
        
        return view('payment.finish', compact('order'));
    }

    /**
     * Handle payment error callback
     */
    public function error($orderId)
    {
        $order = Order::findOrFail($orderId);
        
        return view('payment.error', compact('order'));
    }

    /**
     * Handle payment pending callback
     */
    public function pending($orderId)
    {
        $order = Order::findOrFail($orderId);
        
        return view('payment.pending', compact('order'));
    }

    /**
     * Notify admins about successful payment
     */
    private function notifyAdminsPaymentSuccess(Order $order)
    {
        $admins = User::where('is_admin', true)->get();

        $message = "Pembayaran diterima - No. Pesanan: {$order->order_number} | Total: Rp " . number_format($order->total_price, 0, ',', '.');

        foreach ($admins as $admin) {
            OrderNotification::create([
                'order_id' => $order->id,
                'admin_id' => $admin->id,
                'title' => 'Pembayaran Berhasil: ' . $order->order_number,
                'message' => $message,
                'is_read' => false,
            ]);
        }
    }
}
