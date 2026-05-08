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
            ->take(3)
            ->get();

        // Get special occasion products (dengan rating tertinggi)
        $specialOccasion = Product::where('stock', '>', 0)
            ->with(['reviews', 'category'])
            ->withAvg('reviews', 'rating')
            ->orderBy('reviews_avg_rating', 'desc')
            ->take(3)
            ->get();

        // Get new arrivals
        $newArrivals = Product::where('stock', '>', 0)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Filter by category if selected
        $categoryFilter = null;
        $filteredProducts = null;
        if ($request->filled('category')) {
            $categoryFilter = $request->category;
            $query = Product::where('stock', '>', 0)->with('category');
            if ($categoryFilter) {
                $query->where('category_id', $categoryFilter);
            }
            $filteredProducts = $query->paginate(12);
        }

        // Filter by occasion (rekomendasi)
        if ($request->filled('occasion')) {
            $query = Product::where('stock', '>', 0)->with('category');
            
            // Filter by budget if provided
            if ($request->filled('budget')) {
                $budget = (int) $request->budget;
                $query->where('price', '<=', $budget);
            }

            // Apply occasion-based filtering (you can expand this based on your product categories)
            $occasion = $request->occasion;
            switch($occasion) {
                case 'anniversary':
                case 'wedding':
                    // Select premium and romantic products
                    $query->orderBy('price', 'desc');
                    break;
                case 'congratulations':
                    // Select vibrant colored products
                    break;
                case 'love':
                    // Select red/pink themed products
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }

            $filteredProducts = $query->paginate(12);
            $categoryFilter = 'recommendation';
        }

        return view('products.index', compact(
            'categories', 
            'bestSellers', 
            'specialOccasion', 
            'newArrivals',
            'categoryFilter',
            'filteredProducts'
        ));
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
