<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display all products with advanced filtering
     */
    public function index(Request $request): View
    {
        $categories = Category::withCount('products')->get();
        
        // Get best sellers (products dengan review terbanyak)
        $bestSellers = Product::where('stock', '>', 0)
            ->with('reviews')
            ->withCount('reviews')
            ->orderBy('reviews_count', 'desc')
            ->take(4)
            ->get();

        // Get special occasion products (dengan rating tertinggi)
        $specialOccasion = Product::where('stock', '>', 0)
            ->with(['reviews', 'category'])
            ->withAvg('reviews', 'rating')
            ->orderBy('reviews_avg_rating', 'desc')
            ->take(4)
            ->get();

        // Get new arrivals
        $newArrivals = Product::where('stock', '>', 0)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // Filter by category if selected
        $categoryFilter = null;
        $filteredProducts = null;
        $showAllProducts = false; // Flag untuk menampilkan "Semua Produk" section
        
        if ($request->filled('category')) {
            $categoryFilter = $request->category;
            $query = Product::with('category');
            
            // If "Semua Produk" (empty category), show section dengan all products di bawah
            if ($categoryFilter === '' || $categoryFilter === '0') {
                // Don't filter, just show all products in a separate section
                $allProductsPaginated = $query
                    ->orderBy('stock', 'desc')  // Available products first (stock > 0), sold last (stock = 0)
                    ->orderBy('created_at', 'desc')  // Then by created date
                    ->paginate(12)
                    ->appends($request->query());
                $filteredProducts = $allProductsPaginated;
                $showAllProducts = true;
            } else {
                // For specific category, show all products (available first, then sold)
                $query->where('category_id', $categoryFilter);
                $filteredProducts = $query
                    ->orderBy('stock', 'desc')  // Available products first (stock > 0), sold last (stock = 0)
                    ->orderBy('created_at', 'desc')  // Then by created date
                    ->paginate(12)
                    ->appends($request->query());
            }
        }

        // Filter by category (using recommendation feature)
        if ($request->filled('rec_category')) {
            $recCategory = $request->rec_category;
            $query = Product::with('category');
            
            if ($recCategory !== 'all') {
                $query->where('category_id', $recCategory);
            }
            
            // Filter by budget if provided
            if ($request->filled('budget')) {
                $budget = (int) $request->budget;
                $query->where('price', '<=', $budget);
            }
            
            $filteredProducts = $query->orderBy('created_at', 'desc')->paginate(12)->appends($request->query());
            $categoryFilter = 'recommendation';
        }

        return view('products.index', compact(
            'categories', 
            'bestSellers', 
            'specialOccasion', 
            'newArrivals',
            'categoryFilter',
            'filteredProducts',
            'showAllProducts'
        ));
    }

    /**
     * Display a specific product (including sold products)
     */
    public function show(Product $product): View
    {
        // Allow viewing all products, including sold ones
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Filter products by category
     */
    public function filterByCategory(Request $request, Category $category): View
    {
        $query = $category->products()
            ->where('stock', '>', 0);

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(12);
        $categories = Category::withCount('products')->get();
        
        // Get price statistics for filter
        $priceStats = $category->products()
            ->selectRaw('MIN(price) as min_price, MAX(price) as max_price')
            ->first();

        return view('products.index', compact('products', 'categories', 'category', 'priceStats'));
    }
}
