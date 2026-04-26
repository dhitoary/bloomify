@extends('layouts.app')

@section('content')
<div class="bg-bloom-ivory">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Breadcrumb -->
        <div class="mb-8 text-sm text-gray-600">
            <a href="{{ route('products.index') }}" class="text-bloom-teal hover:underline">Katalog</a>
            <span class="mx-2">›</span>
            <a href="{{ route('products.category', $product->category->slug) }}" class="text-bloom-teal hover:underline">{{ $product->category->name }}</a>
            <span class="mx-2">›</span>
            <span class="text-gray-900">{{ $product->name }}</span>
        </div>

        <!-- Product Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-12">
            <!-- Product Image -->
            <div class="flex items-center justify-center">
                <div class="bg-white rounded-lg shadow-md overflow-hidden w-full">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-96 object-cover">
                    @else
                        <div class="w-full h-96 bg-bloom-cream flex items-center justify-center text-gray-400">
                            <svg class="w-32 h-32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <div class="mb-6">
                    <a href="{{ route('products.category', $product->category->slug) }}" class="inline-block text-sm font-semibold text-bloom-teal hover:text-bloom-coral mb-3">
                        {{ $product->category->name }}
                    </a>
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                </div>

                <!-- Price and Stock -->
                <div class="mb-8 pb-8 border-b border-bloom-mint-light">
                    <p class="text-4xl font-bold text-bloom-coral mb-4">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>

                    <div class="flex items-center gap-4 mb-4">
                        <div class="flex items-center">
                            <span class="text-gray-700 font-semibold mr-3">Ketersediaan:</span>
                            <span class="px-4 py-2 rounded-full font-semibold {{ $product->stock > 5 ? 'bg-green-100 text-green-700' : ($product->stock > 0 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                @if($product->stock > 0)
                                    Stok: {{ $product->stock }} unit
                                @else
                                    Habis Terjual
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Deskripsi Produk</h3>
                    <p class="text-gray-700 leading-relaxed">{{ $product->description ?? 'Tidak ada deskripsi tambahan.' }}</p>
                </div>

                <!-- Add to Cart -->
                @if($product->stock > 0)
                    <form class="mb-8">
                        <div class="flex items-center gap-4 mb-6">
                            <label for="quantity" class="font-semibold text-gray-700">Jumlah:</label>
                            <input type="number" id="quantity" name="quantity" min="1" max="{{ $product->stock }}" value="1" class="w-24 px-4 py-2 border border-bloom-mint-light rounded-lg focus:outline-none focus:ring-2 focus:ring-bloom-teal">
                        </div>

                        <button type="submit" class="w-full bg-bloom-coral text-white font-bold py-3 rounded-lg hover:bg-bloom-coral/90 transition duration-300 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Tambah ke Keranjang
                        </button>
                    </form>
                @else
                    <div class="mb-8 p-4 bg-red-100 text-red-700 rounded-lg font-semibold text-center">
                        Produk sedang tidak tersedia
                    </div>
                @endif

                <!-- Share -->
                <div class="border-t border-bloom-mint-light pt-6">
                    <p class="text-gray-700 font-semibold mb-3">Bagikan:</p>
                    <div class="flex gap-4">
                        <a href="#" class="inline-flex items-center justify-center w-10 h-10 bg-bloom-mint-light text-bloom-teal rounded-full hover:bg-bloom-mint transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5c-.563-.074-1.396-.146-2.278-.146-2.27 0-3.846 1.481-3.846 4.188v2.158z"/></svg>
                        </a>
                        <a href="#" class="inline-flex items-center justify-center w-10 h-10 bg-bloom-mint-light text-bloom-teal rounded-full hover:bg-bloom-mint transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2s9 5 20 5a9.5 9.5 0 00-9-5.5c4.75 2.25 7-7 7-7z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="mb-20">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Produk Serupa</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                        <a href="{{ route('products.show', $related->slug) }}" class="group">
                            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 transform hover:scale-105">
                                <div class="relative overflow-hidden h-48 bg-bloom-cream">
                                    @if($related->image)
                                        <img src="{{ asset('storage/' . $related->image) }}" 
                                             alt="{{ $related->name }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">{{ $related->name }}</h3>
                                    <p class="text-2xl font-bold text-bloom-coral">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
