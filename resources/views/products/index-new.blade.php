@extends('layouts.app')

@section('content')
<div class="bg-white min-h-screen">
    <!-- Header Section -->
    <div class="border-b border-bloom-accent-light/30 py-10 mb-10">
        <div class="max-w-7xl mx-auto px-6">
            <h1 class="text-4xl font-light text-gray-900 mb-2">Katalog Produk</h1>
            <p class="text-gray-500 font-light text-base">Koleksi buket bunga premium untuk setiap momen istimewa</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-6 gap-6">
            <!-- Sidebar Filters - Improved -->
            <div class="lg:col-span-1">
                <div class="sticky top-20 space-y-4 max-h-[calc(100vh-100px)] overflow-y-auto">
                    <!-- Filter Title & Reset -->
                    <div class="flex justify-between items-center px-4 py-2 bg-bloom-bg-cream/50 rounded-lg border border-bloom-accent-light/20">
                        <h3 class="font-semibold text-gray-900 text-sm">🔍 Filter</h3>
                        @if(request()->query())
                            <a href="{{ route('products.index') }}" class="text-xs text-bloom-secondary hover:text-bloom-primary font-medium transition">Reset</a>
                        @endif
                    </div>

                    <form method="GET" action="{{ route('products.index') }}" id="filterForm" class="space-y-4">
                        <!-- Category Filter -->
                        <div class="bg-white rounded-lg border border-bloom-accent-light/20 p-4">
                            <h4 class="text-xs font-semibold uppercase text-gray-600 mb-3 tracking-wider">Kategori</h4>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }} class="w-4 h-4 text-bloom-primary cursor-pointer accent-bloom-primary" onchange="document.getElementById('filterForm').submit()">
                                    <span class="text-sm text-gray-700 group-hover:text-bloom-primary transition">Semua</span>
                                </label>
                                @foreach($categories as $cat)
                                    <label class="flex items-center justify-between gap-2 cursor-pointer group">
                                        <div class="flex items-center gap-2">
                                            <input type="radio" name="category" value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'checked' : '' }} class="w-4 h-4 text-bloom-primary cursor-pointer accent-bloom-primary" onchange="document.getElementById('filterForm').submit()">
                                            <span class="text-sm text-gray-700 group-hover:text-bloom-primary transition">{{ $cat->name }}</span>
                                        </div>
                                        <span class="text-xs text-gray-400 bg-gray-50 px-2 py-0.5 rounded">{{ $cat->products_count }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price Filter -->
                        <div class="bg-white rounded-lg border border-bloom-accent-light/20 p-4">
                            <h4 class="text-xs font-semibold uppercase text-gray-600 mb-3 tracking-wider">Harga</h4>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs text-gray-600 font-medium mb-1.5">Minimum (Rp)</label>
                                    <input type="number" name="min_price" value="{{ request('min_price', '') }}" placeholder="0" class="w-full px-3 py-2 border border-bloom-accent-light/30 rounded-lg text-sm bg-bloom-bg-light/30 focus:outline-none focus:ring-2 focus:ring-bloom-secondary/30 focus:border-bloom-secondary/30 transition">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 font-medium mb-1.5">Maksimum (Rp)</label>
                                    <input type="number" name="max_price" value="{{ request('max_price', '') }}" placeholder="999.999" class="w-full px-3 py-2 border border-bloom-accent-light/30 rounded-lg text-sm bg-bloom-bg-light/30 focus:outline-none focus:ring-2 focus:ring-bloom-secondary/30 focus:border-bloom-secondary/30 transition">
                                </div>
                                @if($priceStats)
                                    <p class="text-xs text-gray-500 pt-2 border-t border-bloom-accent-light/20">
                                        <span class="text-gray-600 font-medium">Range: </span>Rp {{ number_format($priceStats->min_price, 0, ',', '.') }} - Rp {{ number_format($priceStats->max_price, 0, ',', '.') }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <!-- Stock Status Filter -->
                        <div class="bg-white rounded-lg border border-bloom-accent-light/20 p-4">
                            <h4 class="text-xs font-semibold uppercase text-gray-600 mb-3 tracking-wider">Ketersediaan</h4>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="radio" name="stock_status" value="" {{ !request('stock_status') ? 'checked' : '' }} class="w-4 h-4 text-bloom-accent cursor-pointer accent-bloom-accent" onchange="document.getElementById('filterForm').submit()">
                                    <span class="text-sm text-gray-700 group-hover:text-bloom-accent transition">Semua Status</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="radio" name="stock_status" value="available" {{ request('stock_status') === 'available' ? 'checked' : '' }} class="w-4 h-4 text-bloom-accent cursor-pointer accent-bloom-accent" onchange="document.getElementById('filterForm').submit()">
                                    <span class="text-sm text-gray-700 group-hover:text-bloom-accent transition">Tersedia</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="radio" name="stock_status" value="abundant" {{ request('stock_status') === 'abundant' ? 'checked' : '' }} class="w-4 h-4 text-bloom-accent cursor-pointer accent-bloom-accent" onchange="document.getElementById('filterForm').submit()">
                                    <span class="text-sm text-gray-700 group-hover:text-bloom-accent transition">Stok Melimpah</span>
                                </label>
                            </div>
                        </div>

                        <!-- Sorting -->
                        <div class="bg-white rounded-lg border border-bloom-accent-light/20 p-4">
                            <h4 class="text-xs font-semibold uppercase text-gray-600 mb-3 tracking-wider">Urutkan</h4>
                            <select name="sort" onchange="document.getElementById('filterForm').submit()" class="w-full px-3 py-2 border border-bloom-accent-light/30 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-bloom-secondary/30 focus:border-bloom-secondary/30 transition">
                                <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
                                <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                                <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Nama: A-Z</option>
                                <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Nama: Z-A</option>
                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <button type="submit" class="w-full bg-bloom-secondary hover:bg-bloom-secondary/90 text-white font-medium py-2.5 rounded-lg transition duration-200 text-sm">
                            Terapkan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Products Grid Section -->
            <div class="lg:col-span-5">
                <!-- Results Header -->
                <div class="mb-6 pb-4 border-b border-bloom-accent-light/20 flex justify-between items-center flex-wrap gap-4">
                    <p class="text-sm text-gray-600">
                        Menampilkan <span class="font-semibold text-gray-900">{{ $products->count() }}</span> dari <span class="font-semibold text-gray-900">{{ $products->total() }}</span> produk
                    </p>
                </div>

                @if($products->isEmpty())
                    <!-- Empty State -->
                    <div class="text-center py-20">
                        <div class="w-24 h-24 mx-auto mb-6 bg-bloom-bg-cream/50 rounded-full flex items-center justify-center border-2 border-bloom-accent-light/30">
                            <svg class="w-12 h-12 text-bloom-accent/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 015.646 5.646 9 9 0 0120.354 15.354z" />
                            </svg>
                        </div>
                        <p class="text-gray-600 text-lg font-light mb-2">Tidak ada produk yang sesuai</p>
                        <p class="text-gray-500 text-sm mb-6">Coba ubah filter atau urutkan ulang hasil pencarian</p>
                        <a href="{{ route('products.index') }}" class="inline-block bg-bloom-primary hover:bg-bloom-primary/90 text-white px-8 py-2.5 rounded-lg transition font-medium text-sm">
                            Lihat Semua Produk
                        </a>
                    </div>
                @else
                    <!-- Products Grid - 4-5 Column Layout -->
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-12">
                        @foreach($products as $product)
                            <a href="{{ route('products.show', $product->slug) }}" class="group block h-full">
                                <div class="bg-white border border-bloom-accent-light/25 rounded-lg overflow-hidden hover:shadow-md transition duration-300 h-full flex flex-col hover:border-bloom-accent-light/60">
                                    <!-- Image Container -->
                                    <div class="relative overflow-hidden h-56 bg-gradient-to-br from-bloom-bg-cream to-bloom-bg-light">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-16 h-16 text-bloom-accent/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        
                                        <!-- Stock Badge -->
                                        @if($product->stock <= 3)
                                            <div class="absolute top-3 right-3">
                                                <span class="inline-block px-2 py-1 rounded-full {{ $product->stock > 0 ? 'bg-bloom-primary/20 text-bloom-primary border border-bloom-primary/30' : 'bg-red-100/80 text-red-600 border border-red-200' }} text-xs font-semibold">
                                                    {{ $product->stock > 0 ? 'Terbatas' : 'Habis' }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Content -->
                                    <div class="p-4 flex flex-col flex-grow">
                                        <!-- Category Badge -->
                                        @if($product->category)
                                            <div class="mb-2">
                                                <span class="inline-block px-2 py-0.5 rounded-full bg-bloom-accent/8 text-bloom-accent border border-bloom-accent/15 text-xs font-medium">
                                                    {{ $product->category->name }}
                                                </span>
                                            </div>
                                        @endif

                                        <!-- Title -->
                                        <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2 text-sm group-hover:text-bloom-primary transition">
                                            {{ $product->name }}
                                        </h3>

                                        <!-- Description - Hidden on mobile -->
                                        <p class="text-xs text-gray-500 font-light mb-3 line-clamp-1 hidden md:block flex-grow">
                                            {{ $product->description }}
                                        </p>

                                        <!-- Footer -->
                                        <div class="border-t border-bloom-accent-light/20 pt-3 mt-auto">
                                            <div class="flex justify-between items-end gap-2">
                                                <div class="flex-1">
                                                    <p class="text-sm font-light text-gray-900 leading-tight">
                                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                                    </p>
                                                    <p class="text-xs text-gray-500">Stok: {{ $product->stock }}</p>
                                                </div>
                                            </div>
                                            <button type="button" class="w-full bg-bloom-secondary hover:bg-bloom-secondary/90 text-white py-2 rounded-lg transition font-medium text-xs mt-2 duration-200">
                                                Lihat
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
                            <div class="inline-flex gap-1 bg-white border border-bloom-accent-light/20 rounded-lg p-1">
                                {{-- Previous --}}
                                @if($products->onFirstPage())
                                    <span class="px-3 py-2 text-gray-300 rounded">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </span>
                                @else
                                    <a href="{{ $products->previousPageUrl() }}" class="px-3 py-2 text-gray-600 hover:bg-bloom-bg-cream rounded transition">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </a>
                                @endif

                                {{-- Pages --}}
                                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                    @if ($page == $products->currentPage())
                                        <span class="px-3 py-2 bg-bloom-primary text-white rounded-lg font-medium text-sm">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}" class="px-3 py-2 text-gray-600 hover:bg-bloom-bg-cream rounded transition text-sm">{{ $page }}</a>
                                    @endif
                                @endforeach

                                {{-- Next --}}
                                @if($products->hasMorePages())
                                    <a href="{{ $products->nextPageUrl() }}" class="px-3 py-2 text-gray-600 hover:bg-bloom-bg-cream rounded transition">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                @else
                                    <span class="px-3 py-2 text-gray-300 rounded">
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

