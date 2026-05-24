@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-br from-bloom-bg-main to-bloom-primary/5 min-h-screen">
    <!-- Product Card Component Include -->
    @php
        $renderCard = function($product) {
            return view('products.card', compact('product'))->render();
        };
    @endphp
    <!-- Header Section -->
    <div style="background: linear-gradient(to bottom, #DA4582, #EC91C3, #FECEEE, #FFF5FA); border-bottom: 3px solid #EC91C3;" class="py-16 mb-12">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="inline-block bg-bloom-bg-card border-2 border-bloom-accent rounded-full px-6 py-2 mb-6 shadow-soft">
                <p class="text-bloom-accent text-xs font-semibold tracking-widest uppercase">Koleksi Pilihan Hari Ini</p>
            </div>
            
            <h1 class="text-6xl font-display font-light italic text-bloom-text-primary mb-4" style="letter-spacing: -1px;">Katalog Produk</h1>
            <p class="text-bloom-text-secondary font-light text-lg max-w-2xl mx-auto mb-8">Temukan rangkaian bunga yang dibuat untuk momen paling berarti, dari hadiah manis sampai keluarga yang bersama.</p>
            
            <!-- CTA Buttons -->
            <div class="flex justify-center gap-4">
                <button id="viewAllBtn" class="px-8 py-3 bg-bloom-accent hover:bg-bloom-accent-dark text-white rounded-full font-semibold transition-all duration-300 shadow-soft-lg hover:shadow-soft-hover hover:scale-105">
                    Lihat Koleksi
                </button>
                <button id="recommendedBtn" class="px-8 py-3 bg-white hover:bg-bloom-bg-card text-bloom-accent border-2 border-bloom-accent rounded-full font-semibold transition-all duration-300 hover:shadow-soft">
                    Rekomendasi
                </button>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 pb-20">
        <!-- Category Filter - Horizontal with Icons -->
        <div class="mb-16">
            <div class="flex gap-2 overflow-x-auto pb-2 justify-center">
                <form method="GET" action="{{ route('products.index') }}" class="inline-flex gap-2 justify-center">
                    <button type="submit" name="category" value="" class="px-4 py-2 rounded-full text-sm font-semibold transition whitespace-nowrap {{ !$categoryFilter ? 'bg-bloom-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-50 border-2 border-gray-200' }}">
                        ★ Semua Produk
                    </button>
                    @foreach($categories as $cat)
                        <button type="submit" name="category" value="{{ $cat->id }}" class="px-4 py-2 rounded-full text-sm font-semibold transition whitespace-nowrap {{ $categoryFilter == $cat->id ? 'bg-bloom-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-50 border-2 border-gray-200' }}">
                            ★ {{ $cat->name }}
                        </button>
                    @endforeach
                </form>
            </div>
        </div>

        <!-- Category Description Cards -->
        @if(!$filteredProducts || $showAllProducts)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
                <!-- Best Seller Card -->
                <div class="bg-gradient-to-br from-bloom-fuchsia/40 to-bloom-accent/40 border-2 border-bloom-border rounded-2xl p-8 shadow-soft hover:shadow-soft-lg hover:-translate-y-1 transition-all duration-300">
                    <h3 class="text-xl font-bold text-bloom-text-primary mb-3 uppercase tracking-wide">BEST SELLER</h3>
                    <p class="text-bloom-text-primary font-medium text-sm leading-relaxed">
                        Produk favorit dengan tampilan paling menarik.
                    </p>
                </div>

                <!-- Special Occasion Card -->
                <div class="bg-gradient-to-br from-bloom-primary/50 to-bloom-fuchsia/50 border-2 border-bloom-border rounded-2xl p-8 shadow-soft hover:shadow-soft-lg hover:-translate-y-1 transition-all duration-300">
                    <h3 class="text-xl font-bold text-bloom-text-primary mb-3 uppercase tracking-wide">SPECIAL OCCASION</h3>
                    <p class="text-bloom-text-primary font-medium text-sm leading-relaxed">
                        Pilihan untuk anniversary, wedding, dan hadiah spesial.
                    </p>
                </div>

                <!-- New Arrivals Card -->
                <div class="bg-gradient-to-br from-bloom-accent/40 to-bloom-primary/40 border-2 border-bloom-border rounded-2xl p-8 shadow-soft hover:shadow-soft-lg hover:-translate-y-1 transition-all duration-300">
                    <h3 class="text-xl font-bold text-bloom-text-primary mb-3 uppercase tracking-wide">NEW ARRIVALS</h3>
                    <p class="text-bloom-text-primary font-medium text-sm leading-relaxed">
                        Rangkaian terbaru dengan nuansa pastel yang lembut dan modern.
                    </p>
                </div>
            </div>
        @endif

        <!-- If category/occasion filtered, show all products for that filter -->
        @if($filteredProducts)
            <section class="mb-20">
                @if($categoryFilter === 'recommendation')
                    <h2 class="text-3xl font-semibold text-bloom-text-primary mb-8">Hasil Rekomendasi Kami Untuk Anda</h2>
                @else
                    <h2 class="text-3xl font-semibold text-bloom-text-primary mb-8">Hasil Pencarian</h2>
                @endif
                
                @if($filteredProducts->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 gap-6 mb-12">
                        @foreach($filteredProducts as $product)
                            @if($product->stock > 0)
                                <a href="{{ route('products.show', $product->slug) }}" class="group">
                                    <div class="bg-bloom-bg-card border-2 border-bloom-border rounded-2xl overflow-hidden hover:shadow-soft-hover transition-all duration-300 h-full flex flex-col hover:-translate-y-1 hover:border-bloom-primary">
                                        <!-- Product Image -->
                                        <div class="relative overflow-hidden h-48 bg-gradient-to-br from-bloom-bg-cream to-bloom-primary-lighter">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-bloom-text-secondary">
                                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Product Info -->
                                        <div class="p-5 flex flex-col flex-grow">
                                            <h3 class="font-medium text-bloom-text-primary mb-1 line-clamp-2 text-sm group-hover:text-bloom-accent transition duration-300">{{ $product->name }}</h3>
                                            @if($product->category)
                                                <p class="text-xs text-bloom-text-secondary mb-3">{{ $product->category->name }}</p>
                                            @endif
                                            <p class="text-xs text-bloom-text-secondary font-light mb-4 line-clamp-2 flex-grow">{{ $product->description }}</p>
                                            
                                            <div class="border-t border-bloom-border pt-4">
                                                <div class="flex justify-between items-center">
                                                    <span class="font-semibold text-bloom-accent text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-bloom-accent/10 text-bloom-accent border border-bloom-accent">Tersedia</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @else
                                <div class="group">
                                    <div class="bg-bloom-bg-card border-2 border-gray-300 rounded-2xl overflow-hidden h-full flex flex-col opacity-60 cursor-not-allowed relative">
                                        <!-- Product Image -->
                                        <div class="relative overflow-hidden h-48 bg-gradient-to-br from-bloom-bg-cream to-bloom-primary-lighter">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-bloom-text-secondary">
                                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                            <!-- SOLD Overlay -->
                                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                                <div style="background: rgba(220, 38, 38, 0.9); transform: rotate(-15deg);" class="px-4 py-2 rounded-lg font-bold text-white">SOLD</div>
                                            </div>
                                        </div>

                                        <!-- Product Info -->
                                        <div class="p-5 flex flex-col flex-grow">
                                            <h3 class="font-medium text-gray-500 mb-1 line-clamp-2 text-sm">{{ $product->name }}</h3>
                                            @if($product->category)
                                                <p class="text-xs text-gray-400 mb-3">{{ $product->category->name }}</p>
                                            @endif
                                            <p class="text-xs text-gray-400 font-light mb-4 line-clamp-2 flex-grow">{{ $product->description }}</p>
                                            
                                            <div class="border-t border-gray-300 pt-4">
                                                <div class="flex justify-between items-center">
                                                    <span class="font-semibold text-gray-400 text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-red-100 text-red-600 border border-red-300">SOLD</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    @if($filteredProducts->hasPages())
                        <div class="mt-12 flex justify-center">
                            <div class="inline-flex gap-2 border border-gray-200 rounded-lg p-2 bg-white">
                                @if($filteredProducts->onFirstPage())
                                    <span class="px-4 py-2 text-gray-400 rounded-lg">←</span>
                                @else
                                    <a href="{{ $filteredProducts->previousPageUrl() }}" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">←</a>
                                @endif

                                @foreach ($filteredProducts->getUrlRange(1, $filteredProducts->lastPage()) as $page => $url)
                                    @if ($page == $filteredProducts->currentPage())
                                        <span class="px-4 py-2 bg-bloom-primary text-white rounded-lg font-medium">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">{{ $page }}</a>
                                    @endif
                                @endforeach

                                @if($filteredProducts->hasMorePages())
                                    <a href="{{ $filteredProducts->nextPageUrl() }}" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">→</a>
                                @else
                                    <span class="px-4 py-2 text-gray-400">→</span>
                                @endif
                            </div>
                        </div>
                    @endif
                @else
                    <div class="text-center py-20">
                        <p class="text-gray-500 text-lg">Tidak ada produk dalam kategori ini</p>
                    </div>
                @endif
            </section>
        @else
            <!-- Best Sellers Section -->
            @if($bestSellers->count() > 0)
                <section class="mb-20">
                    <div class="flex items-center gap-3 mb-8">
                        <h2 class="text-2xl font-semibold text-bloom-text-primary">BEST SELLER</h2>
                        <p class="text-sm text-bloom-text-secondary font-light">Produk favorit dengan tampilan paling menarik</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 gap-6">
                        @foreach($bestSellers as $product)
                            <a href="{{ route('products.show', $product->slug) }}" class="group">
                                <div class="bg-bloom-bg-card border-2 border-bloom-border rounded-2xl overflow-hidden hover:shadow-soft-hover transition-all duration-300 h-full flex flex-col hover:-translate-y-1 hover:border-bloom-primary">
                                    <!-- Product Image -->
                                    <div class="relative overflow-hidden h-48 bg-gradient-to-br from-bloom-bg-cream to-bloom-primary-lighter">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-bloom-text-secondary">
                                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Info -->
                                    <div class="p-5 flex flex-col flex-grow">
                                        <h3 class="font-medium text-bloom-text-primary mb-1 line-clamp-2 text-sm group-hover:text-bloom-accent transition duration-300">{{ $product->name }}</h3>
                                        @if($product->category)
                                            <p class="text-xs text-bloom-text-secondary mb-3">{{ $product->category->name }}</p>
                                        @endif
                                        <p class="text-xs text-bloom-text-secondary font-light mb-4 line-clamp-2 flex-grow">{{ $product->description }}</p>
                                        
                                        <div class="border-t border-bloom-border pt-4">
                                            <div class="flex justify-between items-center">
                                                <span class="font-semibold text-bloom-accent text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-bloom-accent/10 text-bloom-accent border border-bloom-accent">Tersedia</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- Special Occasion Section -->
            @if($specialOccasion->count() > 0)
                <section class="mb-20">
                    <div class="flex items-center gap-3 mb-8">
                        <h2 class="text-2xl font-semibold text-bloom-text-primary">SPECIAL OCCASION</h2>
                        <p class="text-sm text-bloom-text-secondary font-light">Pilihan untuk anniversary, wedding, dan hadiah spesial</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 gap-6">
                        @foreach($specialOccasion as $product)
                            <a href="{{ route('products.show', $product->slug) }}" class="group">
                                <div class="bg-bloom-bg-card border-2 border-bloom-border rounded-2xl overflow-hidden hover:shadow-soft-hover transition-all duration-300 h-full flex flex-col hover:-translate-y-1 hover:border-bloom-primary">
                                    <!-- Product Image -->
                                    <div class="relative overflow-hidden h-48 bg-gradient-to-br from-bloom-bg-cream to-bloom-primary-lighter">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-bloom-text-secondary">
                                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Info -->
                                    <div class="p-5 flex flex-col flex-grow">
                                        <h3 class="font-medium text-bloom-text-primary mb-1 line-clamp-2 text-sm group-hover:text-bloom-accent transition duration-300">{{ $product->name }}</h3>
                                        @if($product->category)
                                            <p class="text-xs text-bloom-text-secondary mb-3">{{ $product->category->name }}</p>
                                        @endif
                                        <p class="text-xs text-bloom-text-secondary font-light mb-4 line-clamp-2 flex-grow">{{ $product->description }}</p>
                                        
                                        <div class="border-t border-bloom-border pt-4">
                                            <div class="flex justify-between items-center">
                                                <span class="font-semibold text-bloom-accent text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-bloom-accent/10 text-bloom-accent border border-bloom-accent">Tersedia</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- New Arrivals Section -->
            @if($newArrivals->count() > 0)
                <section>
                    <div class="flex items-center gap-3 mb-8">
                        <h2 class="text-2xl font-semibold text-bloom-text-primary">NEW ARRIVALS</h2>
                        <p class="text-sm text-bloom-text-secondary font-light">Rangkaian terbaru dengan nuansa pastel yang lembut dan modern</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 gap-6">
                        @foreach($newArrivals as $product)
                            <a href="{{ route('products.show', $product->slug) }}" class="group">
                                <div class="bg-bloom-bg-card border-2 border-bloom-border rounded-2xl overflow-hidden hover:shadow-soft-hover transition-all duration-300 h-full flex flex-col hover:-translate-y-1 hover:border-bloom-primary">
                                    <div class="relative overflow-hidden h-48 bg-gradient-to-br from-bloom-bg-cream to-bloom-primary-lighter">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-20 h-20 text-bloom-mint/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Info -->
                                    <div class="p-5 flex flex-col flex-grow">
                                        <h3 class="font-medium text-bloom-text-primary mb-1 line-clamp-2 text-sm group-hover:text-bloom-accent transition duration-300">{{ $product->name }}</h3>
                                        @if($product->category)
                                            <p class="text-xs text-bloom-text-secondary mb-3">{{ $product->category->name }}</p>
                                        @endif
                                        <p class="text-xs text-bloom-text-secondary font-light mb-4 line-clamp-2 flex-grow">{{ $product->description }}</p>
                                        
                                        <div class="border-t border-bloom-border pt-4">
                                            <div class="flex justify-between items-center">
                                                <span class="font-semibold text-bloom-accent text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-bloom-accent/10 text-bloom-accent border border-bloom-accent">Tersedia</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- Semua Produk Section (shown when Semua Produk button is clicked) -->
            @if($showAllProducts && $filteredProducts)
                <section class="mb-20">
                    <h2 class="text-3xl font-semibold text-bloom-text-primary mb-8">Semua Produk</h2>
                    
                    @if($filteredProducts->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 gap-6 mb-12">
                            @foreach($filteredProducts as $product)
                                @if($product->stock > 0)
                                    <a href="{{ route('products.show', $product->slug) }}" class="group">
                                        <div class="bg-bloom-bg-card border-2 border-bloom-border rounded-2xl overflow-hidden hover:shadow-soft-hover transition-all duration-300 h-full flex flex-col hover:-translate-y-1 hover:border-bloom-primary">
                                            <!-- Product Image -->
                                            <div class="relative overflow-hidden h-48 bg-gradient-to-br from-bloom-bg-cream to-bloom-primary-lighter">
                                                @if($product->image)
                                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-bloom-text-secondary">
                                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                            </div>

                                            <!-- Product Info -->
                                            <div class="p-5 flex flex-col flex-grow">
                                                <h3 class="font-medium text-bloom-text-primary mb-1 line-clamp-2 text-sm group-hover:text-bloom-accent transition duration-300">{{ $product->name }}</h3>
                                                @if($product->category)
                                                    <p class="text-xs text-bloom-text-secondary mb-3">{{ $product->category->name }}</p>
                                                @endif
                                                <p class="text-xs text-bloom-text-secondary font-light mb-4 line-clamp-2 flex-grow">{{ $product->description }}</p>
                                                
                                                <div class="border-t border-bloom-border pt-4">
                                                    <div class="flex justify-between items-center">
                                                        <span class="font-semibold text-bloom-accent text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                                        <span class="text-xs font-semibold px-3 py-1 rounded-full bg-bloom-accent/10 text-bloom-accent border border-bloom-accent">Tersedia</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @else
                                    <div class="group">
                                        <div class="bg-bloom-bg-card border-2 border-gray-300 rounded-2xl overflow-hidden h-full flex flex-col opacity-60 cursor-not-allowed relative">
                                            <!-- Product Image -->
                                            <div class="relative overflow-hidden h-48 bg-gradient-to-br from-bloom-bg-cream to-bloom-primary-lighter">
                                                @if($product->image)
                                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-bloom-text-secondary">
                                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                                <!-- SOLD Overlay -->
                                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                                    <div style="background: rgba(220, 38, 38, 0.9); transform: rotate(-15deg);" class="px-4 py-2 rounded-lg font-bold text-white">SOLD</div>
                                                </div>
                                            </div>

                                            <!-- Product Info -->
                                            <div class="p-5 flex flex-col flex-grow">
                                                <h3 class="font-medium text-gray-500 mb-1 line-clamp-2 text-sm">{{ $product->name }}</h3>
                                                @if($product->category)
                                                    <p class="text-xs text-gray-400 mb-3">{{ $product->category->name }}</p>
                                                @endif
                                                <p class="text-xs text-gray-400 font-light mb-4 line-clamp-2 flex-grow">{{ $product->description }}</p>
                                                
                                                <div class="border-t border-gray-300 pt-4">
                                                    <div class="flex justify-between items-center">
                                                        <span class="font-semibold text-gray-400 text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                                        <span class="text-xs font-semibold px-3 py-1 rounded-full bg-red-100 text-red-600 border border-red-300">SOLD</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        @if($filteredProducts->hasPages())
                            <div class="mt-12 flex justify-center">
                                <div class="inline-flex gap-2 border border-gray-200 rounded-lg p-2 bg-white">
                                    @if($filteredProducts->onFirstPage())
                                        <span class="px-4 py-2 text-gray-400 rounded-lg">←</span>
                                    @else
                                        <a href="{{ $filteredProducts->previousPageUrl() }}" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">←</a>
                                    @endif

                                    @foreach ($filteredProducts->getUrlRange(1, $filteredProducts->lastPage()) as $page => $url)
                                        @if ($page == $filteredProducts->currentPage())
                                            <span class="px-4 py-2 bg-bloom-primary text-white rounded-lg font-medium">{{ $page }}</span>
                                        @else
                                            <a href="{{ $url }}" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">{{ $page }}</a>
                                        @endif
                                    @endforeach

                                    @if($filteredProducts->hasMorePages())
                                        <a href="{{ $filteredProducts->nextPageUrl() }}" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">→</a>
                                    @else
                                        <span class="px-4 py-2 text-gray-400">→</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endif
                </section>
            @endif
        @endif
    </div>
</div>

<script>
    document.getElementById('viewAllBtn')?.addEventListener('click', function() {
        const form = document.querySelector('.inline-flex form');
        const buttons = form.querySelectorAll('button[name="category"]');
        buttons[0].click();
    });

    document.getElementById('recommendedBtn')?.addEventListener('click', function() {
        showRecommendationModal();
    });

    function showRecommendationModal() {
        const categories = @json($categories);
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 animate-fade-in';
        
        let categoryOptions = `
            <label class="flex items-center cursor-pointer group">
                <input type="radio" name="rec_category" value="all" class="w-4 h-4" style="accent-color: #DA4582;">
                <span class="ml-3 text-gray-700 group-hover:text-bloom-accent transition">Semua Kategori</span>
            </label>
        `;
        
        categories.forEach(cat => {
            categoryOptions += `
                <label class="flex items-center cursor-pointer group">
                    <input type="radio" name="rec_category" value="${cat.id}" class="w-4 h-4" style="accent-color: #DA4582;">
                    <span class="ml-3 text-gray-700 group-hover:text-bloom-accent transition">${cat.name}</span>
                </label>
            `;
        });
        
        modal.innerHTML = `
            <div class="bg-white rounded-2xl max-w-md w-full shadow-xl max-h-[90vh] overflow-y-auto">
                <div class="sticky top-0 px-6 py-4 border-b-2 flex items-center justify-between" style="background: linear-gradient(to right, #DA4582, #EC91C3); border-color: #9F254F;">
                    <h2 class="text-lg font-semibold text-white">🌸 Rekomendasi Produk</h2>
                    <button onclick="this.closest('.fixed').remove()" class="text-white hover:opacity-80 text-2xl" style="line-height: 1;">&times;</button>
                </div>
                
                <div class="p-6 space-y-6">
                    <div class="space-y-3">
                        ${categoryOptions}
                    </div>

                    <div style="border-top: 2px solid #EC91C3;" class="pt-4 space-y-4">
                        <label class="block">
                            <span style="color: #9F254F;" class="text-sm font-semibold mb-2 block">💰 Budget Maksimal (Rp)</span>
                            <input type="number" id="budgetInput" placeholder="Tidak ada batas" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2" style="focus:border-color: #EC91C3; focus:ring-color: #EC91C3;">
                        </label>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button onclick="this.closest('.fixed').remove()" class="flex-1 px-4 py-2 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                            Batal
                        </button>
                        <button onclick="submitRecommendation()" class="flex-1 px-4 py-2 text-white rounded-lg transition font-medium" style="background: #DA4582;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                            Lihat Rekomendasi
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        modal.addEventListener('click', function(e) {
            if (e.target === modal) modal.remove();
        });
    }

    function submitRecommendation() {
        const category = document.querySelector('input[name="rec_category"]:checked');
        const budget = document.getElementById('budgetInput').value;
        
        if (!category) {
            alert('Silakan pilih kategori terlebih dahulu');
            return;
        }

        // Build URL with category and optional budget
        let url = `{{ route('products.index') }}?rec_category=${category.value}`;
        if (budget) {
            url += `&budget=${budget}`;
        }
        
        window.location.href = url;
    }
</script>

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    
    .animate-fade-in {
        animation: fade-in 0.3s ease-in-out;
    }
</style>
@endsection
