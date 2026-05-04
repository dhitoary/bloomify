<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
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

        return view('checkout.index', compact('cartItems', 'total'));
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

        return view('checkout.index', compact('cartItems', 'total', 'user'));
    }

    /**
     * Submit checkout and create order
     */
    public function submit(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|min:10',
            'phone' => 'required|string|min:10',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
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

            // Calculate total
            $total = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

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
