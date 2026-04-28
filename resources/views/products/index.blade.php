@extends('layouts.app')

@section('content')
<div class="bg-white min-h-screen">
    <!-- Header Section -->
    <div class="bg-stone-50 border-b border-stone-200 py-12 mb-12">
        <div class="max-w-7xl mx-auto px-6">
            <h1 class="text-5xl font-light text-stone-900 mb-3">Katalog Produk</h1>
            <p class="text-stone-600 font-light text-lg">Koleksi buket bunga premium untuk setiap momen istimewa</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar Kategori -->
            <div class="lg:col-span-1">
                <div class="bg-white border border-stone-200 rounded-lg p-6 sticky top-20">
                    <h3 class="text-lg font-medium text-stone-900 mb-6">Kategori</h3>
                    <div class="space-y-2">
                        <a href="{{ route('products.index') }}" class="block px-4 py-2 rounded-lg transition {{ !isset($category) ? 'bg-rose-50 text-rose-600 border border-rose-200 font-medium' : 'text-stone-700 hover:bg-stone-50' }}">
                            Semua Produk
                        </a>
                        @foreach($categories as $cat)
                            <a href="{{ route('products.category', $cat->slug) }}" class="block px-4 py-2 rounded-lg transition {{ isset($category) && $category->id === $cat->id ? 'bg-rose-50 text-rose-600 border border-rose-200 font-medium' : 'text-stone-700 hover:bg-stone-50' }}">
                                <span class="flex justify-between items-center">
                                    <span>{{ $cat->name }}</span>
                                    <span class="text-xs text-stone-500 ml-2">{{ $cat->products_count }}</span>
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="lg:col-span-3">
                @if($products->isEmpty())
                    <div class="text-center py-20">
                        <p class="text-stone-500 text-lg font-light">Tidak ada produk tersedia saat ini</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                        @foreach($products as $product)
                            <a href="{{ route('products.show', $product->slug) }}" class="group block">
                                <div class="bg-white border border-stone-200 rounded-lg overflow-hidden hover:shadow-lg transition duration-300 h-full flex flex-col">
                                    <!-- Image -->
                                    <div class="relative overflow-hidden h-64 bg-stone-100">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-stone-400">
                                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Content -->
                                    <div class="p-5 flex flex-col flex-grow">
                                        <h3 class="font-medium text-stone-900 mb-2 line-clamp-2 text-base">{{ $product->name }}</h3>
                                        
                                        @if($product->category)
                                            <p class="text-xs text-stone-500 mb-3">{{ $product->category->name }}</p>
                                        @endif

                                        <p class="text-sm text-stone-600 font-light mb-4 line-clamp-2 flex-grow">{{ $product->description }}</p>

                                        <div class="border-t border-stone-100 pt-4">
                                            <div class="flex justify-between items-center mb-3">
                                                <span class="text-2xl font-light text-stone-900">
                                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                                </span>
                                                <span class="text-xs font-medium px-3 py-1 rounded-full {{ $product->stock > 5 ? 'bg-amber-50 text-amber-700 border border-amber-200' : ($product->stock > 0 ? 'bg-amber-100 text-amber-800 border border-amber-300' : 'bg-red-50 text-red-700 border border-red-200') }}">
                                                    {{ $product->stock > 0 ? 'Tersedia' : 'Habis' }}
                                                </span>
                                            </div>

                                            <p class="text-xs text-stone-500 mb-4">Stok: {{ $product->stock }} unit</p>

                                            <button class="w-full bg-rose-600 hover:bg-rose-700 text-white py-2 rounded-lg transition font-medium text-sm">
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
                            <div class="inline-flex gap-2">
                                @if($products->onFirstPage())
                                    <span class="px-3 py-2 text-stone-400 bg-stone-100 rounded-lg">← Sebelumnya</span>
                                @else
                                    <a href="{{ $products->previousPageUrl() }}" class="px-3 py-2 text-stone-700 hover:bg-stone-50 border border-stone-200 rounded-lg transition">← Sebelumnya</a>
                                @endif

                                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                    @if ($page == $products->currentPage())
                                        <span class="px-3 py-2 bg-rose-600 text-white rounded-lg font-medium">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}" class="px-3 py-2 text-stone-700 hover:bg-stone-50 border border-stone-200 rounded-lg transition">{{ $page }}</a>
                                    @endif
                                @endforeach

                                @if($products->hasMorePages())
                                    <a href="{{ $products->nextPageUrl() }}" class="px-3 py-2 text-stone-700 hover:bg-stone-50 border border-stone-200 rounded-lg transition">Selanjutnya →</a>
                                @else
                                    <span class="px-3 py-2 text-stone-400 bg-stone-100 rounded-lg">Selanjutnya →</span>
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
