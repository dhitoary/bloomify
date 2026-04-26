<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display all products
     */
    public function index(): View
    {
        $products = Product::where('stock', '>', 0)
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = Category::withCount('products')
            ->get();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Display a specific product
     */
    public function show(Product $product): View
    {
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('stock', '>', 0)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Filter products by category
     */
    public function filterByCategory(Category $category): View
    {
        $products = $category->products()
            ->where('stock', '>', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = Category::withCount('products')->get();

        return view('products.index', compact('products', 'categories', 'category'));
    }
}
