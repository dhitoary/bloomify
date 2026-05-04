<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Calculate shipping cost based on city
     */
    private function calculateShippingCost($city, $courier = 'jne', $service = 'REG')
    {
        $shippingConfig = config('shipping');
        
        // Get base cost from zone
        $baseCost = $shippingConfig['zones'][$city] ?? $shippingConfig['zones']['Jakarta'];
        $cost = $baseCost['cost'];
        
        // Apply courier service multiplier
        $courierConfig = $shippingConfig['couriers'][$courier];
        $serviceMultiplier = $courierConfig['services'][$service]['multiplier'] ?? 1.0;
        
        return (int)($cost * $serviceMultiplier);
    }

    /**
     * Get available couriers and services
     */
    private function getAvailableCouriers()
    {
        return config('shipping.couriers');
    }

    /**
     * Notify all admins about new order
     */
    private function notifyAdminsNewOrder(Order $order, $shippingCost)
    {
        // Get all admin users
        $admins = User::where('is_admin', true)->get();

        $itemsCount = $order->items()->count();
        $message = "Pesanan baru diterima - No. Pesanan: {$order->order_number} | Pembeli: {$order->user->name} | Total: Rp " . number_format($order->total_price, 0, ',', '.');

        foreach ($admins as $admin) {
            OrderNotification::create([
                'order_id' => $order->id,
                'admin_id' => $admin->id,
                'title' => 'Pesanan Baru: ' . $order->order_number,
                'message' => $message,
                'is_read' => false,
            ]);
        }
    }

    /**
     * Prepare checkout with selected items
     */
    public function create(Request $request)
    {
        $request->validate([
            'cart_ids' => 'required|array|min:1',
            'cart_ids.*' => 'exists:carts,id',
        ]);

        $cartIds = $request->cart_ids;
        
        // Verify all cart items belong to authenticated user
        $cartItems = Cart::whereIn('id', $cartIds)
            ->where('user_id', Auth::id())
            ->with('product')
            ->get();

        if ($cartItems->count() !== count($cartIds)) {
            return back()->with('error', 'Data keranjang tidak valid');
        }

        // Calculate total
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Store selected cart IDs in session
        session(['checkout_cart_ids' => $cartIds, 'checkout_total' => $total]);

        $user = Auth::user();
        $couriers = $this->getAvailableCouriers();
        
        return view('checkout.index', compact('cartItems', 'total', 'user', 'couriers'));
    }

    /**
     * Display checkout form
     */
    public function index()
    {
        $cartIds = session('checkout_cart_ids');
        
        if (!$cartIds) {
            return redirect()->route('cart.index')->with('error', 'Silakan pilih produk untuk checkout');
        }

        $cartItems = Cart::whereIn('id', $cartIds)
            ->where('user_id', Auth::id())
            ->with('product')
            ->get();

        $total = session('checkout_total');
        $user = Auth::user();
        $couriers = $this->getAvailableCouriers();

        return view('checkout.index', compact('cartItems', 'total', 'user', 'couriers'));
    }

    /**
     * Get shipping cost via AJAX
     */
    public function getShippingCost(Request $request)
    {
        $request->validate([
            'city' => 'required|string',
            'courier' => 'required|string',
            'service' => 'required|string',
        ]);

        $shippingConfig = config('shipping');
        $city = $request->city;
        
        // Check if city exists in zones
        if (!isset($shippingConfig['zones'][$city])) {
            return response()->json([
                'success' => false,
                'message' => 'Kota tidak tersedia. Silakan hubungi kami untuk zona lain.',
            ], 400);
        }

        $cost = $this->calculateShippingCost($city, $request->courier, $request->service);
        $baseCost = $shippingConfig['zones'][$city];
        $courierName = $shippingConfig['couriers'][$request->courier]['name'];
        $serviceName = $shippingConfig['couriers'][$request->courier]['services'][$request->service]['name'];

        return response()->json([
            'success' => true,
            'cost' => $cost,
            'formatted_cost' => 'Rp ' . number_format($cost, 0, ',', '.'),
            'courier' => $courierName,
            'service' => $serviceName,
            'estimate' => $baseCost['days'] . ' hari',
        ]);
    }

    /**
     * Submit checkout and create order
     */
    public function submit(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|min:10',
            'phone' => 'required|string|min:10',
            'city' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'courier' => 'required|string',
            'service' => 'required|string',
            'notes' => 'nullable|string|max:500',
        ]);

        $cartIds = session('checkout_cart_ids');
        
        if (!$cartIds) {
            return redirect()->route('cart.index')->with('error', 'Sesi checkout telah berakhir');
        }

        try {
            DB::beginTransaction();

            // Get cart items
            $cartItems = Cart::whereIn('id', $cartIds)
                ->where('user_id', Auth::id())
                ->with('product')
                ->get();

            // Calculate subtotal
            $subtotal = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            // Calculate shipping cost
            $shippingCost = $this->calculateShippingCost($request->city, $request->courier, $request->service);

            // Calculate total (subtotal + shipping)
            $total = $subtotal + $shippingCost;

            // Prepare full address with city and postal code
            $fullAddress = $request->shipping_address;
            if ($request->city) {
                $fullAddress .= ', ' . $request->city;
            }
            if ($request->postal_code) {
                $fullAddress .= ' ' . $request->postal_code;
            }

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ORD-' . time(),
                'total_price' => $total,
                'status' => 'pending',
                'shipping_address' => $fullAddress,
                'notes' => $request->notes,
            ]);

            // Store shipping info (bisa tambah ke order model nanti jika perlu)
            session([
                'last_order_shipping' => [
                    'courier' => $request->courier,
                    'service' => $request->service,
                    'cost' => $shippingCost,
                ],
            ]);

            // Create order items and update product stock
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                // Reduce product stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Notify all admins about new order
            $this->notifyAdminsNewOrder($order, $shippingCost);

            // Delete selected cart items
            Cart::whereIn('id', $cartIds)->delete();

            // Clear session
            session()->forget(['checkout_cart_ids', 'checkout_total']);

            DB::commit();

            return redirect()->route('order.show', $order->id)
                ->with('success', 'Pesanan berhasil dibuat. No. Pesanan: ' . $order->order_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat membuat pesanan: ' . $e->getMessage());
        }
    }
}
