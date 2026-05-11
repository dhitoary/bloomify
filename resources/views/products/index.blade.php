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
    <div class="bg-gradient-to-b from-bloom-fuchsia/15 to-bloom-bg-main py-16 mb-12 border-b-4 border-bloom-fuchsia">
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
        @if(!$filteredProducts)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
                <!-- Best Seller Card -->
                <div class="bg-gradient-to-br from-bloom-bg-cream to-bloom-primary-lighter border-2 border-bloom-border rounded-2xl p-8 shadow-soft hover:shadow-soft-lg hover:-translate-y-1 transition-all duration-300">
                    <h3 class="text-lg font-semibold text-bloom-accent mb-3 uppercase tracking-wide">BEST SELLER</h3>
                    <p class="text-bloom-text-secondary font-light text-sm leading-relaxed">
                        Produk favorit dengan tampilan paling menarik.
                    </p>
                </div>

                <!-- Special Occasion Card -->
                <div class="bg-gradient-to-br from-bloom-primary-lighter to-bloom-secondary border-2 border-bloom-border rounded-2xl p-8 shadow-soft hover:shadow-soft-lg hover:-translate-y-1 transition-all duration-300">
                    <h3 class="text-lg font-semibold text-bloom-accent mb-3 uppercase tracking-wide">SPECIAL OCCASION</h3>
                    <p class="text-bloom-text-secondary font-light text-sm leading-relaxed">
                        Pilihan untuk anniversary, wedding, dan hadiah spesial.
                    </p>
                </div>

                <!-- New Arrivals Card -->
                <div class="bg-gradient-to-br from-bloom-bg-cream to-bloom-secondary border-2 border-bloom-border rounded-2xl p-8 shadow-soft hover:shadow-soft-lg hover:-translate-y-1 transition-all duration-300">
                    <h3 class="text-lg font-semibold text-bloom-accent mb-3 uppercase tracking-wide">NEW ARRIVALS</h3>
                    <p class="text-bloom-text-secondary font-light text-sm leading-relaxed">
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
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                        @foreach($filteredProducts as $product)
                            <a href="{{ route('products.show', $product->slug) }}" class="group block h-full">
                                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition duration-300 h-full flex flex-col hover:border-bloom-teal">
                                    <!-- Image Container -->
                                    <div class="relative overflow-hidden h-72 bg-gradient-to-br from-bloom-cream to-bloom-ivory">
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

                                    <!-- Content -->
                                    <div class="p-6 flex flex-col flex-grow">
                                        @if($product->category)
                                            <div class="mb-3">
                                                <span class="inline-block px-3 py-1 rounded-full bg-bloom-primary/10 text-bloom-primary border border-bloom-primary/20 text-xs font-medium font-semibold">
                                                    {{ $product->category->name }}
                                                </span>
                                            </div>
                                        @endif

                                        <h3 class="font-semibold text-gray-900 mb-3 line-clamp-2 text-base group-hover:text-bloom-primary transition">
                                            {{ $product->name }}
                                        </h3>

                                        <p class="text-sm text-gray-600 font-light mb-4 line-clamp-2 flex-grow">
                                            {{ $product->description }}
                                        </p>

                                        <div class="border-t border-gray-100 pt-4 mt-auto">
                                            <div class="flex justify-between items-end mb-4">
                                                <p class="text-2xl font-light text-gray-900">
                                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                                </p>
                                            </div>
                                            <button type="button" class="w-full bg-bloom-secondary hover:bg-bloom-secondary-dark text-white py-3 rounded-lg transition font-semibold text-sm duration-200 shadow-md hover:shadow-lg">
                                                Keranjang
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </a>
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
                        <h2 class="text-2xl font-semibold text-gray-900">BEST SELLER</h2>
                        <p class="text-sm text-gray-600 font-light">Produk favorit dengan tampilan paling menarik</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($bestSellers as $product)
                            <a href="{{ route('products.show', $product->slug) }}" class="group block h-full">
                                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition duration-300 h-full flex flex-col hover:border-bloom-teal">
                                    <div class="relative overflow-hidden h-72 bg-gradient-to-br from-bloom-cream to-bloom-ivory">
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
                                    <div class="p-6 flex flex-col flex-grow">
                                        @if($product->category)
                                            <div class="mb-3">
                                                <span class="inline-block px-3 py-1 rounded-full bg-bloom-mint/10 text-bloom-mint border border-bloom-mint/20 text-xs font-medium">
                                                    {{ $product->category->name }}
                                                </span>
                                            </div>
                                        @endif
                                        <h3 class="font-semibold text-gray-900 mb-3 line-clamp-2 text-base group-hover:text-bloom-teal transition">
                                            {{ $product->name }}
                                        </h3>
                                        <p class="text-sm text-gray-600 font-light mb-4 line-clamp-2 flex-grow">
                                            {{ $product->description }}
                                        </p>
                                        <div class="border-t border-gray-100 pt-4 mt-auto">
                                            <div class="flex justify-between items-end mb-4">
                                                <p class="text-2xl font-light text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                                <div class="flex gap-1">
                                                    @for($i = 0; $i < 5; $i++)
                                                        <span class="text-lg">★</span>
                                                    @endfor
                                                </div>
                                            </div>
                                            <button type="button" class="w-full bg-bloom-coral hover:bg-bloom-coral/90 text-white py-3 rounded-lg transition font-semibold text-sm duration-200">
                                                Keranjang
                                            </button>
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
                        <h2 class="text-2xl font-semibold text-gray-900">SPECIAL OCCASION</h2>
                        <p class="text-sm text-gray-600 font-light">Pilihan untuk anniversary, wedding, dan hadiah spesial</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($specialOccasion as $product)
                            <a href="{{ route('products.show', $product->slug) }}" class="group block h-full">
                                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition duration-300 h-full flex flex-col hover:border-bloom-teal">
                                    <div class="relative overflow-hidden h-72 bg-gradient-to-br from-bloom-cream to-bloom-ivory">
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
                                    <div class="p-6 flex flex-col flex-grow">
                                        @if($product->category)
                                            <div class="mb-3">
                                                <span class="inline-block px-3 py-1 rounded-full bg-bloom-mint/10 text-bloom-mint border border-bloom-mint/20 text-xs font-medium">
                                                    {{ $product->category->name }}
                                                </span>
                                            </div>
                                        @endif
                                        <h3 class="font-semibold text-gray-900 mb-3 line-clamp-2 text-base group-hover:text-bloom-teal transition">
                                            {{ $product->name }}
                                        </h3>
                                        <p class="text-sm text-gray-600 font-light mb-4 line-clamp-2 flex-grow">
                                            {{ $product->description }}
                                        </p>
                                        <div class="border-t border-gray-100 pt-4 mt-auto">
                                            <div class="flex justify-between items-end mb-4">
                                                <p class="text-2xl font-light text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                                <div class="flex gap-1">
                                                    @for($i = 0; $i < 5; $i++)
                                                        <span class="text-lg">★</span>
                                                    @endfor
                                                </div>
                                            </div>
                                            <button type="button" class="w-full bg-bloom-coral hover:bg-bloom-coral/90 text-white py-3 rounded-lg transition font-semibold text-sm duration-200">
                                                Keranjang
                                            </button>
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
                        <h2 class="text-2xl font-semibold text-gray-900">NEW ARRIVALS</h2>
                        <p class="text-sm text-gray-600 font-light">Rangkaian terbaru dengan nuansa pastoral yang terbaru</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($newArrivals as $product)
                            <a href="{{ route('products.show', $product->slug) }}" class="group block h-full">
                                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition duration-300 h-full flex flex-col hover:border-bloom-teal">
                                    <div class="relative overflow-hidden h-72 bg-gradient-to-br from-bloom-cream to-bloom-ivory">
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
                                    <div class="p-6 flex flex-col flex-grow">
                                        @if($product->category)
                                            <div class="mb-3">
                                                <span class="inline-block px-3 py-1 rounded-full bg-bloom-mint/10 text-bloom-mint border border-bloom-mint/20 text-xs font-medium">
                                                    {{ $product->category->name }}
                                                </span>
                                            </div>
                                        @endif
                                        <h3 class="font-semibold text-gray-900 mb-3 line-clamp-2 text-base group-hover:text-bloom-teal transition">
                                            {{ $product->name }}
                                        </h3>
                                        <p class="text-sm text-gray-600 font-light mb-4 line-clamp-2 flex-grow">
                                            {{ $product->description }}
                                        </p>
                                        <div class="border-t border-gray-100 pt-4 mt-auto">
                                            <div class="flex justify-between items-end mb-4">
                                                <p class="text-2xl font-light text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                                <div class="flex gap-1">
                                                    @for($i = 0; $i < 5; $i++)
                                                        <span class="text-lg">★</span>
                                                    @endfor
                                                </div>
                                            </div>
                                            <button type="button" class="w-full bg-bloom-coral hover:bg-bloom-coral/90 text-white py-3 rounded-lg transition font-semibold text-sm duration-200">
                                                Keranjang
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
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
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 animate-fade-in';
        modal.innerHTML = `
            <div class="bg-white rounded-2xl max-w-md w-full shadow-xl max-h-[90vh] overflow-y-auto">
                <div class="sticky top-0 bg-gradient-to-r from-bloom-teal/10 to-bloom-mint/10 px-6 py-4 border-b border-bloom-mint-light flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-900">Rekomendasi Produk</h2>
                    <button onclick="this.closest('.fixed').remove()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                </div>
                
                <div class="p-6 space-y-6">
                    <div class="space-y-4">
                        <label class="flex items-center cursor-pointer group">
                            <input type="radio" name="occasion" value="anniversary" class="w-4 h-4 text-bloom-teal">
                            <span class="ml-3 text-gray-700 group-hover:text-bloom-teal transition">Ultah / Anniversary</span>
                        </label>
                        <label class="flex items-center cursor-pointer group">
                            <input type="radio" name="occasion" value="wedding" class="w-4 h-4 text-bloom-teal">
                            <span class="ml-3 text-gray-700 group-hover:text-bloom-teal transition">Pernikahan / Wedding</span>
                        </label>
                        <label class="flex items-center cursor-pointer group">
                            <input type="radio" name="occasion" value="congratulations" class="w-4 h-4 text-bloom-teal">
                            <span class="ml-3 text-gray-700 group-hover:text-bloom-teal transition">Ucapan Selamat</span>
                        </label>
                        <label class="flex items-center cursor-pointer group">
                            <input type="radio" name="occasion" value="condolence" class="w-4 h-4 text-bloom-teal">
                            <span class="ml-3 text-gray-700 group-hover:text-bloom-teal transition">Duka Cita</span>
                        </label>
                        <label class="flex items-center cursor-pointer group">
                            <input type="radio" name="occasion" value="love" class="w-4 h-4 text-bloom-teal">
                            <span class="ml-3 text-gray-700 group-hover:text-bloom-teal transition">Ungkapan Cinta</span>
                        </label>
                        <label class="flex items-center cursor-pointer group">
                            <input type="radio" name="occasion" value="random" class="w-4 h-4 text-bloom-teal">
                            <span class="ml-3 text-gray-700 group-hover:text-bloom-teal transition">Surprise Random</span>
                        </label>
                    </div>

                    <div class="border-t border-gray-200 pt-4 space-y-4">
                        <label class="block">
                            <span class="text-sm font-semibold text-gray-700 mb-2 block">Budget Maksimal (Rp)</span>
                            <input type="number" id="budgetInput" placeholder="Masukkan budget" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-bloom-teal">
                        </label>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button onclick="this.closest('.fixed').remove()" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                            Batal
                        </button>
                        <button onclick="submitRecommendation()" class="flex-1 px-4 py-2 bg-bloom-teal hover:bg-bloom-teal/90 text-white rounded-lg transition font-medium">
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
        const occasion = document.querySelector('input[name="occasion"]:checked');
        const budget = document.getElementById('budgetInput').value;
        
        if (!occasion) {
            alert('Silakan pilih acara terlebih dahulu');
            return;
        }

        // Redirect ke halaman produk dengan filter
        window.location.href = `{{ route('products.index') }}?occasion=${occasion.value}&budget=${budget}`;
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
