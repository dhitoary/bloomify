@extends('layouts.app')

@section('content')
<div class="bg-bloom-ivory min-h-screen">
    <!-- Header Section -->
    <div class="bg-white border-b border-bloom-mint-light py-12 mb-12">
        <div class="max-w-7xl mx-auto px-6">
            <h1 class="text-5xl font-light text-gray-900 mb-3">Dashboard</h1>
            <p class="text-gray-600 font-light text-lg">Selamat datang, <span class="text-bloom-teal">{{ Auth::user()->name }}</span></p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6 pb-20">
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <!-- Pesanan Saya -->
            <div class="bg-white rounded-lg p-6 border border-bloom-mint-light hover:shadow-lg transition">
                <p class="text-gray-600 text-sm font-medium uppercase tracking-wide mb-4">Pesanan Saya</p>
                <p class="text-4xl font-light text-gray-900">0</p>
                <p class="text-gray-500 text-sm mt-3 font-light">Belum ada pesanan</p>
            </div>

            <!-- Keranjang Saya -->
            <div class="bg-white rounded-lg p-6 border border-bloom-mint-light hover:shadow-lg transition">
                <p class="text-gray-600 text-sm font-medium uppercase tracking-wide mb-4">Keranjang Saya</p>
                <p class="text-4xl font-light text-gray-900">0</p>
                <p class="text-gray-500 text-sm mt-3 font-light">Item dalam keranjang</p>
            </div>

            <!-- Total Belanja -->
            <div class="bg-white rounded-lg p-6 border border-bloom-mint-light hover:shadow-lg transition">
                <p class="text-gray-600 text-sm font-medium uppercase tracking-wide mb-4">Total Belanja</p>
                <p class="text-4xl font-light text-gray-900">Rp 0</p>
                <p class="text-gray-500 text-sm mt-3 font-light">Tahun ini</p>
            </div>
        </div>

        <!-- Featured Products -->
        <div class="mb-16">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-light text-gray-900">Produk Rekomendasi</h2>
                <a href="{{ route('products.index') }}" class="text-bloom-teal hover:text-bloom-coral font-medium transition">
                    Lihat Semua
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $products = \App\Models\Product::where('stock', '>', 0)
                        ->orderBy('created_at', 'desc')
                        ->limit(4)
                        ->get();
                @endphp

                @forelse($products as $product)
                    <a href="{{ route('products.show', $product->slug) }}" class="group">
                        <div class="bg-white rounded-lg border border-bloom-mint-light overflow-hidden hover:shadow-md transition duration-300">
                            <div class="relative overflow-hidden h-48 bg-bloom-cream">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-bloom-teal text-4xl font-light">🌸</div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h4 class="font-medium text-gray-900 mb-3 line-clamp-2 group-hover:text-bloom-coral transition text-sm">{{ $product->name }}</h4>
                                <p class="text-bloom-coral font-medium text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <p class="text-gray-500 text-xs mt-2 font-light">Stok: {{ $product->stock }} unit</p>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 text-lg font-light">Belum ada produk tersedia</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Profile Section -->
        <div class="bg-white rounded-lg border border-bloom-mint-light overflow-hidden">
            <div class="px-8 py-6 border-b border-bloom-mint-light">
                <h2 class="text-2xl font-light text-gray-900">Profil Saya</h2>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <p class="text-gray-600 text-xs font-semibold uppercase mb-3">Nama</p>
                        <p class="text-2xl font-light text-gray-900">{{ Auth::user()->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-xs font-semibold uppercase mb-3">Email</p>
                        <p class="text-2xl font-light text-gray-900">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="text-bloom-teal hover:text-bloom-coral font-medium transition">
                    Edit Profil
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
