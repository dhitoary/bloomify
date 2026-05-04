@extends('layouts.app')

@section('content')
<div class="bg-white min-h-screen">
    <!-- Header Section -->
    <div class="border-b border-bloom-mint-light py-12 mb-12">
        <div class="max-w-7xl mx-auto px-6">
            <h1 class="text-5xl font-light text-gray-900 mb-3">Katalog Produk</h1>
            <p class="text-gray-600 font-light text-lg">Koleksi buket bunga premium untuk setiap momen istimewa</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar Filter -->
            <div class="lg:col-span-1">
                <div class="bg-white border border-gray-200 rounded-xl p-6 sticky top-20 shadow-sm">
                    <form method="GET" action="{{ route('products.index') }}" id="filterForm" class="space-y-6">
                        <!-- Categories Filter -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <span class="w-2 h-2 bg-bloom-teal rounded-full mr-3"></span>
                                Kategori
                            </h3>
                            <div class="space-y-2">
                                <label class="flex items-center cursor-pointer group">
                                    <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }} class="w-4 h-4 text-bloom-teal cursor-pointer" onchange="document.getElementById('filterForm').submit()">
                                    <span class="ml-3 text-gray-700 group-hover:text-bloom-teal transition text-sm font-medium">Semua Kategori</span>
                                </label>
                                @foreach($categories as $cat)
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="radio" name="category" value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'checked' : '' }} class="w-4 h-4 text-bloom-teal cursor-pointer" onchange="document.getElementById('filterForm').submit()">
                                        <span class="ml-3 text-gray-700 group-hover:text-bloom-teal transition text-sm">{{ $cat->name }}</span>
                                        <span class="ml-auto text-xs text-gray-500">({{ $cat->products_count }})</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price Range Filter -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <span class="w-2 h-2 bg-bloom-coral rounded-full mr-3"></span>
                                Harga
                            </h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-2">Harga Minimum (Rp)</label>
                                    <input type="number" name="min_price" value="{{ request('min_price', '') }}" placeholder="Dari" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-bloom-teal focus:border-transparent text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 mb-2">Harga Maksimum (Rp)</label>
                                    <input type="number" name="max_price" value="{{ request('max_price', '') }}" placeholder="Hingga" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-bloom-teal focus:border-transparent text-sm">
                                </div>
                                @if($priceStats)
                                    <p class="text-xs text-gray-500 mt-2">
                                        <span class="block">Min: Rp {{ number_format($priceStats->min_price, 0, ',', '.') }}</span>
                                        <span class="block">Max: Rp {{ number_format($priceStats->max_price, 0, ',', '.') }}</span>
                                    </p>
                                @endif
                            </div>
                        </div>

                        <!-- Stock Status Filter -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <span class="w-2 h-2 bg-bloom-mint rounded-full mr-3"></span>
                                Ketersediaan
                            </h3>
                            <div class="space-y-2">
                                <label class="flex items-center cursor-pointer group">
                                    <input type="radio" name="stock_status" value="" {{ !request('stock_status') ? 'checked' : '' }} class="w-4 h-4 text-bloom-mint cursor-pointer" onchange="document.getElementById('filterForm').submit()">
                                    <span class="ml-3 text-gray-700 group-hover:text-bloom-mint transition text-sm">Semua Stok</span>
                                </label>
                                <label class="flex items-center cursor-pointer group">
                                    <input type="radio" name="stock_status" value="available" {{ request('stock_status') === 'available' ? 'checked' : '' }} class="w-4 h-4 text-bloom-mint cursor-pointer" onchange="document.getElementById('filterForm').submit()">
                                    <span class="ml-3 text-gray-700 group-hover:text-bloom-mint transition text-sm">Tersedia</span>
                                </label>
                                <label class="flex items-center cursor-pointer group">
                                    <input type="radio" name="stock_status" value="abundant" {{ request('stock_status') === 'abundant' ? 'checked' : '' }} class="w-4 h-4 text-bloom-mint cursor-pointer" onchange="document.getElementById('filterForm').submit()">
                                    <span class="ml-3 text-gray-700 group-hover:text-bloom-mint transition text-sm">Stok Banyak (5+)</span>
                                </label>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="border-t border-gray-200 pt-6 space-y-3">
                            <button type="submit" class="w-full bg-bloom-teal hover:bg-bloom-teal/90 text-white py-2 rounded-lg transition font-medium text-sm">
                                Terapkan Filter
                            </button>
                            @if(request()->query())
                                <a href="{{ route('products.index') }}" class="block text-center w-full bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 rounded-lg transition font-medium text-sm">
                                    Hapus Filter
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Products Section -->
            <div class="lg:col-span-3">
                <!-- Sorting & Results Count -->
                <div class="flex justify-between items-center mb-8 pb-6 border-b border-gray-200">
                    <p class="text-gray-600 text-sm">
                        Menampilkan <span class="font-semibold text-gray-900">{{ $products->count() }}</span> dari <span class="font-semibold text-gray-900">{{ $products->total() }}</span> produk
                    </p>
                    <div class="flex items-center gap-3">
                        <label class="text-sm text-gray-600">Urutkan:</label>
                        <form method="GET" action="{{ route('products.index') }}" class="inline">
                            @foreach(request()->query() as $key => $value)
                                @if($key !== 'sort')
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endif
                            @endforeach
                            <select name="sort" onchange="this.form.submit()" class="px-4 py-2 pr-10 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-bloom-teal text-sm bg-white cursor-pointer appearance-none bg-no-repeat bg-right-2 bg-center" style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%226B9A94%22 stroke-width=%222%22%3e%3cpath d=%22M19 14l-7 7-7-7%22/%3e%3c/svg%3e'); background-size: 1.5em 1.5em;">
                                <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                                <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                                <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Nama (Z-A)</option>
                            </select>
                        </form>
                    </div>
                </div>

                @if($products->isEmpty())
                    <div class="text-center py-24">
                        <div class="w-20 h-20 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 015.646 5.646 9 9 0 0120.354 15.354z" />
                            </svg>
                        </div>
                        <p class="text-gray-600 text-lg font-light mb-2">Tidak ada produk yang sesuai</p>
                        <p class="text-gray-500 text-sm mb-6">Coba ubah filter atau urutkan ulang hasil pencarian</p>
                        <a href="{{ route('products.index') }}" class="inline-block bg-bloom-teal hover:bg-bloom-teal/90 text-white px-6 py-2 rounded-lg transition font-medium text-sm">
                            Lihat Semua Produk
                        </a>
                    </div>
                @else
                    <!-- Products Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                        @foreach($products as $product)
                            <a href="{{ route('products.show', $product->slug) }}" class="group block h-full">
                                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition duration-300 h-full flex flex-col hover:border-bloom-teal">
                                    <!-- Image Container -->
                                    <div class="relative overflow-hidden h-72 bg-gradient-to-br from-bloom-cream to-bloom-ivory">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-20 h-20 text-bloom-mint/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <!-- Stock Badge -->
                                        @if($product->stock <= 5)
                                            <div class="absolute top-4 right-4">
                                                <span class="inline-block px-3 py-1 rounded-full {{ $product->stock > 0 ? 'bg-bloom-teal/20 text-bloom-teal border border-bloom-teal/30' : 'bg-red-100 text-red-700 border border-red-300' }} text-xs font-semibold">
                                                    {{ $product->stock > 0 ? 'Terbatas' : 'Habis' }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Content -->
                                    <div class="p-6 flex flex-col flex-grow">
                                        <!-- Category Badge -->
                                        @if($product->category)
                                            <div class="mb-3">
                                                <span class="inline-block px-3 py-1 rounded-full bg-bloom-mint/10 text-bloom-mint border border-bloom-mint/20 text-xs font-medium">
                                                    {{ $product->category->name }}
                                                </span>
                                            </div>
                                        @endif

                                        <!-- Title -->
                                        <h3 class="font-semibold text-gray-900 mb-3 line-clamp-2 text-base group-hover:text-bloom-teal transition">
                                            {{ $product->name }}
                                        </h3>

                                        <!-- Description -->
                                        <p class="text-sm text-gray-600 font-light mb-4 line-clamp-2 flex-grow">
                                            {{ $product->description }}
                                        </p>

                                        <!-- Divider -->
                                        <div class="border-t border-gray-100 pt-4 mt-auto">
                                            <!-- Price & Stock -->
                                            <div class="flex justify-between items-end mb-4">
                                                <div>
                                                    <p class="text-3xl font-light text-gray-900 leading-none mb-1">
                                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                                    </p>
                                                    <p class="text-xs text-gray-500">
                                                        Stok: <span class="font-semibold text-gray-700">{{ $product->stock }} unit</span>
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- CTA Button -->
                                            <button type="button" class="w-full bg-bloom-coral hover:bg-bloom-coral/90 text-white py-3 rounded-lg transition font-semibold text-sm duration-200 shadow-sm hover:shadow-md">
                                                Lihat Detail
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($products->hasPages())
                        <div class="mt-12 flex justify-center">
                            <div class="inline-flex gap-2 border border-gray-200 rounded-lg p-2 bg-white">
                                {{-- Previous Page Link --}}
                                @if($products->onFirstPage())
                                    <span class="px-4 py-2 text-gray-400 rounded-lg">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </span>
                                @else
                                    <a href="{{ $products->previousPageUrl() }}" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </a>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                    @if ($page == $products->currentPage())
                                        <span class="px-4 py-2 bg-bloom-teal text-white rounded-lg font-medium">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">{{ $page }}</a>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if($products->hasMorePages())
                                    <a href="{{ $products->nextPageUrl() }}" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                @else
                                    <span class="px-4 py-2 text-gray-400">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
