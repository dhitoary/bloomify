<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    public function index(): View
    {
        // Get latest 4 products as featured
        $featuredProducts = Product::with('category')
            ->where('stock', '>', 0)
            ->latest()
            ->take(4)
            ->get();

        return view('welcome', [
            'featuredProducts' => $featuredProducts,
        ]);
    }
}
