<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Update the status of the specified order.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,shipped,delivered,completed,cancelled',
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status pesanan #' . $order->order_number . ' berhasil diperbarui menjadi ' . ucfirst($request->status));
    }
}
