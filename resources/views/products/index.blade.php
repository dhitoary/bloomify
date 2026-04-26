@extends('layouts.app')

@section('content')
<div class="bg-bloom-ivory">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-bloom-teal to-bloom-teal-light py-12 mb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Katalog Bunga Premium</h1>
            <p class="text-bloom-cream text-lg">Pilihan buket bunga segar untuk setiap momen istimewa Anda</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar Kategori -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h3 class="text-xl font-bold text-bloom-teal mb-4">Kategori</h3>
                    <div class="space-y-2">
                        <a href="{{ route('products.index') }}" class="block px-4 py-2 rounded-lg {{ !isset($category) ? 'bg-bloom-mint-light text-bloom-teal font-semibold' : 'text-gray-700 hover:bg-bloom-cream' }} transition">
                            Semua Produk
                        </a>
                        @foreach($categories as $cat)
                            <a href="{{ route('products.category', $cat->slug) }}" class="block px-4 py-2 rounded-lg {{ isset($category) && $category->id === $cat->id ? 'bg-bloom-mint-light text-bloom-teal font-semibold' : 'text-gray-700 hover:bg-bloom-cream' }} transition">
                                {{ $cat->name }}
                                <span class="text-sm text-gray-500">({{ $cat->products_count }})</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="lg:col-span-3">
                @if($products->isEmpty())
                    <div class="text-center py-12">
                        <p class="text-gray-500 text-lg">Tidak ada produk tersedia saat ini</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                        @foreach($products as $product)
                            <a href="{{ route('products.show', $product->slug) }}" class="group">
                                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 transform hover:scale-105">
                                    <!-- Image -->
                                    <div class="relative overflow-hidden h-64 bg-bloom-cream">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Content -->
                                    <div class="p-5">
                                        <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">{{ $product->name }}</h3>
                                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $product->description }}</p>

                                        <div class="flex justify-between items-center mb-3">
                                            <span class="text-2xl font-bold text-bloom-coral">
                                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </span>
                                            <span class="text-sm font-semibold px-3 py-1 rounded-full {{ $product->stock > 5 ? 'bg-green-100 text-green-700' : ($product->stock > 0 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                                {{ $product->stock > 0 ? 'Tersedia' : 'Habis' }}
                                            </span>
                                        </div>

                                        <p class="text-xs text-gray-500 mb-4">Stok: {{ $product->stock }} unit</p>

                                        <button class="w-full bg-bloom-teal text-white py-2 rounded-lg hover:bg-bloom-teal-light transition font-medium">
                                            Lihat Detail
                                        </button>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($products->hasPages())
                        <div class="mt-12 flex justify-center">
                            {{ $products->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
