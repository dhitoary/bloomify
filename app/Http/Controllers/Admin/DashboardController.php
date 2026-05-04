<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Statistics
        $totalOrders = Order::count();
        $ordersThisMonth = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        $totalRevenue = Order::sum('total_price');
        
        $totalProducts = Product::count();
        
        $totalUsers = User::where('is_admin', false)->count();
        $newUsersThisMonth = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('is_admin', false)
            ->count();

        // Recent Orders
        $recentOrders = Order::with('user')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        // Products & Categories
        $products = Product::with('category')->paginate(10);
        $categories = Category::withCount('products')->paginate(10);
        
        // Sales data (7 days)
        $salesData = [];
        $salesLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $sales = Order::whereDate('created_at', $date->toDateString())->sum('total_price');
            $salesData[] = $sales;
            $salesLabels[] = $date->format('d M');
        }

        // Category sales data
        $categorySales = Category::withCount('products')
            ->get()
            ->map(fn($cat) => [
                'name' => $cat->name,
                'count' => $cat->products_count ?? 0
            ]);
        
        // Orders & Users
        $orders = Order::with('user')->paginate(10);
        $users = User::where('is_admin', false)->paginate(10);

        return view('admin.dashboard', [
            'totalOrders' => $totalOrders,
            'ordersThisMonth' => $ordersThisMonth,
            'totalRevenue' => $totalRevenue,
            'totalProducts' => $totalProducts,
            'totalUsers' => $totalUsers,
            'newUsersThisMonth' => $newUsersThisMonth,
            'recentOrders' => $recentOrders,
            'products' => $products,
            'categories' => $categories,
            'orders' => $orders,
            'users' => $users,
            'salesData' => $salesData,
            'salesLabels' => $salesLabels,
            'categorySales' => $categorySales,
        ]);
    }
}
