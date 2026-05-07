<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'order_id' => 'required|exists:orders,id',
        'product_id' => 'required|exists:products,id',
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:500',
    ]);

    // Cek apakah user sudah pernah kasih ulasan untuk produk ini di order ini
    $existing = \App\Models\Review::where('user_id', auth()->id())
        ->where('order_id', $request->order_id)
        ->where('product_id', $request->product_id)
        ->first();

    if ($existing) {
        return back()->with('error', 'Anda sudah memberikan ulasan untuk produk ini.');
    }

    \App\Models\Review::create([
        'user_id' => auth()->id(),
        'order_id' => $request->order_id,
        'product_id' => $request->product_id,
        'rating' => $request->rating,
        'comment' => $request->comment,
    ]);

    return back()->with('success', 'Terima kasih atas ulasan Anda!');
}

}
