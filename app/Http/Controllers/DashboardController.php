<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Count total orders
        $ordersCount = $user->orders()->count();

        // Count cart items
        $cartItemsCount = $user->carts()->count();

        // Calculate total spending this year
        $currentYear = date('Y');
        $totalSpending = $user->orders()
            ->whereYear('created_at', $currentYear)
            ->sum('total_price');

        // Get recent orders (last 5)
        $recentOrders = $user->orders()
            ->with('items')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'ordersCount',
            'cartItemsCount',
            'totalSpending',
            'recentOrders'
        ));
    }
}
