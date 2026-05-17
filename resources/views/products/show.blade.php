@extends('layouts.app')

@section('content')
<div style="background: linear-gradient(to bottom right, #e2d0d0, #F5E6E6); background-attachment: fixed;" class="min-h-screen">
    <div class="max-w-7xl mx-auto px-6 py-8">
        <!-- Breadcrumb Navigation -->
        <div class="mb-12 flex items-center text-sm">
            <a href="{{ route('products.index') }}" style="color: #b78493;" class="hover:opacity-80 transition font-bold">Katalog</a>
            <svg style="color: #cc93a2;" class="w-4 h-4 mx-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('products.category', $product->category->slug) }}" style="color: #b78493;" class="hover:opacity-80 transition font-bold">{{ $product->category->name }}</a>
            <svg style="color: #cc93a2;" class="w-4 h-4 mx-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span style="color: #aa6778;" class="font-bold line-clamp-1">{{ $product->name }}</span>
        </div>

        <!-- Product Details Section -->
        <div style="background: linear-gradient(to bottom right, #d6acad, #cc93a2); border-color: #aa6778;" class="border-2 rounded-2xl shadow-soft overflow-hidden mb-20">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-0">
                <!-- Product Image -->
                <div style="background: linear-gradient(to bottom right, #e2d0d0, #d6acad); border-right-color: #aa6778;" class="lg:col-span-1 border-r-2 lg:border-r h-96 p-6 flex items-center justify-center">
                    <div style="background: linear-gradient(to bottom right, #e2d0d0, #F5E6E6); border-color: #cc93a2;" class="w-full h-full border-2 rounded-xl overflow-hidden flex items-center justify-center shadow-soft">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="flex flex-col items-center justify-center text-gray-400 p-4 text-center">
                                <svg class="w-20 h-20 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-xs">Tidak ada gambar</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Information Box -->
                <div style="background: linear-gradient(to bottom right, #cc93a2, #d6acad); border-left-color: #aa6778;" class="lg:col-span-2 p-8 border-l-2">
                    <!-- Product Title -->
                    <h1 style="color: #ffffff;" class="text-3xl font-semibold mb-6 leading-tight">
                        {{ $product->name }}
                    </h1>

                    <!-- Product Detail Table -->
                    <div style="border: 2px solid #aa6778;" class="rounded-xl overflow-hidden mb-6">
                        <table class="w-full border-collapse">
                            <tbody>
                                <!-- Kategori -->
                                <tr style="background: rgba(255,255,255,0.15); border-bottom: 1px solid #aa6778;">
                                    <td style="border-right: 1px solid #aa6778; color: #ffffff; width: 35%;" class="px-5 py-3 text-sm font-bold uppercase tracking-wide">Kategori</td>
                                    <td style="color: #ffffff;" class="px-5 py-3 text-sm">
                                        <span style="background: #d6acad; border: 1px solid #aa6778; color: #ffffff;" class="inline-block px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider">
                                            {{ $product->category->name }}
                                        </span>
                                    </td>
                                </tr>
                                <!-- Rating -->
                                <tr style="background: rgba(255,255,255,0.08); border-bottom: 1px solid #aa6778;">
                                    <td style="border-right: 1px solid #aa6778; color: #ffffff;" class="px-5 py-3 text-sm font-bold uppercase tracking-wide">Rating</td>
                                    <td style="color: #ffffff;" class="px-5 py-3 text-sm">
                                        @php $avg = $product->averageRating(); @endphp
                                        <div class="flex items-center gap-2">
                                            <div class="flex">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-4 h-4 {{ $i <= round($avg) ? 'text-yellow-300' : 'text-white/30' }}" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                @endfor
                                            </div>
                                            <span class="font-bold">{{ number_format($avg, 1) }}</span>
                                            <span style="color: rgba(255,255,255,0.6);">|</span>
                                            <a href="#ulasan" class="hover:underline" style="color: rgba(255,255,255,0.8);">{{ $product->totalReviews() }} Ulasan</a>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Harga -->
                                <tr style="background: rgba(255,255,255,0.15); border-bottom: 1px solid #aa6778;">
                                    <td style="border-right: 1px solid #aa6778; color: #ffffff;" class="px-5 py-3 text-sm font-bold uppercase tracking-wide">Harga</td>
                                    <td style="color: #ffffff;" class="px-5 py-4">
                                        <p class="text-2xl font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    </td>
                                </tr>
                                <!-- Stok -->
                                <tr style="background: rgba(255,255,255,0.08); border-bottom: 1px solid #aa6778;">
                                    <td style="border-right: 1px solid #aa6778; color: #ffffff;" class="px-5 py-3 text-sm font-bold uppercase tracking-wide">Stok</td>
                                    <td style="color: #ffffff;" class="px-5 py-3 text-sm">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2.5 h-2.5 rounded-full {{ $product->stock > 0 ? 'bg-green-400' : 'bg-red-400' }}"></span>
                                            @if($product->stock > 0)
                                                <span class="font-bold">Tersedia</span> &bull; <span style="color: rgba(255,255,255,0.8);">{{ $product->stock }} unit</span>
                                            @else
                                                <span class="font-bold text-red-300">Habis Terjual</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <!-- Deskripsi -->
                                <tr style="background: rgba(255,255,255,0.15);">
                                    <td style="border-right: 1px solid #aa6778; color: #ffffff; vertical-align: top;" class="px-5 py-3 text-sm font-bold uppercase tracking-wide">Deskripsi</td>
                                    <td style="color: rgba(255,255,255,0.9);" class="px-5 py-3 text-sm font-light leading-relaxed">
                                        {{ $product->description ?? 'Tidak ada deskripsi tambahan untuk produk ini.' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Add to Cart Section -->
                    @auth
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                
                                <!-- Quantity Selector -->
                                <div class="mb-6">
                                    <label for="quantity" class="block text-xs font-bold style="color: #aa6778;" mb-2 uppercase tracking-wider">Jumlah</label>
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-center border-2 style="border-color: #aa6778;"/50 rounded-lg overflow-hidden bg-rgba(170, 103, 120, 0.15) hover:style="border-color: #aa6778;" hover:bg-rgba(170, 103, 120, 0.25) transition">
                                            <button type="button" class="px-3 py-2 style="color: #aa6778;" hover:bg-bloom-primary hover:text-white transition" onclick="document.getElementById('quantity').value = Math.max(1, parseInt(document.getElementById('quantity').value) - 1)">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                                </svg>
                                            </button>
                                            <input type="number" id="quantity" name="quantity" min="1" max="{{ $product->stock }}" value="1" class="w-16 px-2 py-2 text-center border-l-2 border-r-2 style="border-color: #aa6778;"/50 focus:outline-none focus:ring-2 focus:ring-bloom-primary focus:ring-offset-1 font-medium text-sm bg-white" required>
                                            <button type="button" class="px-3 py-2 style="color: #aa6778;" hover:bg-bloom-primary hover:text-white transition" onclick="document.getElementById('quantity').value = Math.min({{ $product->stock }}, parseInt(document.getElementById('quantity').value) + 1)">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                        </div>
                                    <p class="text-xs style="color: #b78493;"\">Maks {{ $product->stock }}</p>
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <div class="space-y-3">
                                    <button type="submit" class="w-full bg-bloom-primary hover:bg-bloom-primary/90 text-white font-bold py-3 rounded-lg transition duration-300 flex items-center justify-center gap-2 text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Tambah ke Keranjang
                                    </button>

                                    <a href="{{ route('products.index') }}" class="block text-center w-full border-2 border-bloom-border style="color: #aa6778;" font-semibold py-2 rounded-lg hover:style="border-color: #aa6778;" hover:bg-bloom-bg-cream transition duration-300 text-sm">
                                        Lanjut Belanja
                                    </a>
                                </div>
                            </form>
                        @else
                            <div class="p-4 bg-red-50 text-red-700 rounded-lg border border-red-200 text-sm">
                                <p class="font-semibold mb-3">Produk sedang tidak tersedia</p>
                                <a href="{{ route('products.index') }}" class="inline-block text-xs font-medium underline hover:no-underline">
                                    Lihat produk lainnya â†’
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="p-4 bg-gradient-to-br from-bloom-bg-cream to-white border border-bloom-accent/20 rounded-lg mb-4">
                            <p class="font-semibold text-gray-900 mb-3 text-sm">Daftar untuk berbelanja</p>
                            <div class="flex gap-2 flex-col sm:flex-row">
                                <a href="{{ route('login') }}" class="flex-1 bg-bloom-primary hover:bg-bloom-primary/90 text-white font-semibold py-2 rounded-lg transition text-center text-xs">
                                    Login
                                </a>
                                <a href="{{ route('register') }}" class="flex-1 border style="border-color: #aa6778;" text-bloom-primary hover:bg-bloom-bg-cream font-semibold py-2 rounded-lg transition text-center text-xs">
                                    Daftar
                                </a>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div id="ulasan" class="mb-20">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <p style="color: #cc93a2;" class="text-sm font-semibold mb-2 uppercase tracking-widest">Suara Pelanggan</p>
                    <h2 style="color: #aa6778;" class="text-4xl font-light">Ulasan Pembeli</h2>
                </div>
            </div>

            @if($product->reviews->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    <!-- Rating Snapshot -->
                    <div class="lg:col-span-1">
                        <div style="background: linear-gradient(to bottom right, #e2d0d0, #F5E6E6); border: 2px solid #cc93a2;" class="rounded-2xl p-8 sticky top-8 shadow-sm">
                            <p style="color: #b78493;" class="text-sm mb-2">Rating Rata-rata</p>
                            <div class="flex items-end gap-3 mb-6">
                                <span style="color: #aa6778;" class="text-6xl font-light leading-none">{{ number_format($product->averageRating(), 1) }}</span>
                                <div class="flex flex-col">
                                    <div class="flex mb-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= round($product->averageRating()) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                        @endfor
                                    </div>
                                    <span style="color: #b78493;" class="text-sm font-medium">Dari {{ $product->totalReviews() }} Ulasan</span>
                                </div>
                            </div>

                            <!-- Rating Bars -->
                            <div class="space-y-3">
                                @for($i = 5; $i >= 1; $i--)
                                    @php 
                                        $count = $product->reviews->where('rating', $i)->count();
                                        $percent = $product->totalReviews() > 0 ? ($count / $product->totalReviews()) * 100 : 0;
                                    @endphp
                                    <div class="flex items-center gap-3">
                                        <span style="color: #aa6778;" class="text-xs font-bold w-3">{{ $i }}</span>
                                        <div style="background: rgba(170, 103, 120, 0.2);" class="flex-1 h-2 rounded-full overflow-hidden">
                                            <div style="width: {{ $percent }}%; background: #cc93a2;" class="h-full rounded-full"></div>
                                        </div>
                                        <span style="color: #b78493;" class="text-xs w-6 text-right">{{ $count }}</span>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <!-- Review List -->
                    <div class="lg:col-span-2 space-y-6">
                        @foreach($product->reviews()->latest()->get() as $review)
                            <div style="background: linear-gradient(to bottom right, #F5E6E6, #e2d0d0); border: 1px solid #cc93a2;" class="rounded-xl p-6 shadow-sm">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex items-center gap-3">
                                        <div style="background: rgba(170, 103, 120, 0.2); border: 1px solid #cc93a2; color: #aa6778;" class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm">
                                            {{ substr($review->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h4 style="color: #aa6778;" class="text-sm font-bold">{{ $review->user->name }}</h4>
                                            <p style="color: #b78493;" class="text-xs">{{ $review->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="flex">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                        @endfor
                                    </div>
                                </div>
                                <p style="color: #7A6A63;" class="font-light leading-relaxed text-sm">
                                    {{ $review->comment }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div style="background: #F5E6E6; border: 2px dashed #cc93a2;" class="rounded-2xl p-12 text-center">
                    <div style="background: #ffffff; border: 1px solid #cc93a2;" class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                        <svg style="color: #cc93a2;" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </div>
                    <h3 style="color: #aa6778;" class="text-lg font-bold mb-1">Belum Ada Ulasan</h3>
                    <p style="color: #b78493;" class="font-light">Jadilah yang pertama memberikan ulasan untuk produk ini!</p>
                </div>
            @endif
        </div>

        <!-- Related Products Section -->
        @if($relatedProducts->count() > 0)
            <div style="border-top: 2px solid #cc93a2;" class="pt-20 pb-12">
                <div class="mb-12">
                    <p style="color: #cc93a2;" class="text-sm font-semibold mb-3 uppercase tracking-widest">Pilihan Lainnya</p>
                    <h2 style="color: #aa6778;" class="text-4xl font-light">Produk Serupa</h2>
                </div>

                <!-- Related Products Table -->
                <div style="background: #F5E6E6; border: 2px solid #cc93a2;" class="rounded-2xl overflow-hidden shadow-sm">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr style="background: linear-gradient(to right, #cc93a2, #d6acad);">
                                <th style="border-bottom: 2px solid #aa6778; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Gambar</th>
                                <th style="border-bottom: 2px solid #aa6778; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Nama Produk</th>
                                <th style="border-bottom: 2px solid #aa6778; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Harga</th>
                                <th style="border-bottom: 2px solid #aa6778; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Stok</th>
                                <th style="border-bottom: 2px solid #aa6778; color: #ffffff;" class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($relatedProducts as $index => $related)
                                <tr style="background: {{ $index % 2 === 0 ? 'rgba(255,255,255,0.5)' : 'rgba(255,255,255,0.2)' }};" class="hover:brightness-95 transition duration-200">
                                    <td style="border-bottom: 1px solid #cc93a2;" class="px-6 py-4">
                                        <div style="border: 2px solid #cc93a2;" class="w-14 h-14 rounded-xl overflow-hidden shadow-sm">
                                            @if($related->image)
                                                <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div style="background: linear-gradient(to bottom right, #F5E6E6, #e2d0d0); color: #cc93a2;" class="w-full h-full flex items-center justify-center">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td style="border-bottom: 1px solid #cc93a2;" class="px-6 py-4">
                                        <p style="color: #aa6778;" class="text-sm font-semibold">{{ $related->name }}</p>
                                        @if($related->category)
                                            <p style="color: #b78493;" class="text-xs mt-0.5">{{ $related->category->name }}</p>
                                        @endif
                                    </td>
                                    <td style="border-bottom: 1px solid #cc93a2;" class="px-6 py-4">
                                        <p style="color: #aa6778;" class="text-sm font-bold">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                                    </td>
                                    <td style="border-bottom: 1px solid #cc93a2;" class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $related->stock > 0 ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}" style="border: 1px solid {{ $related->stock > 0 ? '#bbf7d0' : '#fecaca' }};">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $related->stock > 0 ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                            {{ $related->stock > 0 ? 'Tersedia' : 'Habis' }}
                                        </span>
                                    </td>
                                    <td style="border-bottom: 1px solid #cc93a2;" class="px-6 py-4 text-center">
                                        <a href="{{ route('products.show', $related->slug) }}" style="background: #cc93a2; color: #ffffff;" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-xs font-semibold hover:opacity-90 transition shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Lihat
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
