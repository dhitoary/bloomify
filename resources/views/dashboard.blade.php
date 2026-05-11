@extends('layouts.app')

@section('content')
<div class="bg-white min-h-screen">
    <!-- Header Section -->
    <div class="bg-white border-b border-gray-200 py-12 mb-12">
        <div class="max-w-7xl mx-auto px-6">
            <h1 class="text-5xl font-light text-gray-900 mb-3">Dashboard</h1>
            <p class="text-gray-600 font-light text-lg">Selamat datang, <span class="text-bloom-primary">{{ Auth::user()->name }}</span></p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6 pb-20">
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <!-- Pesanan Saya -->
            <a href="#pesanan" class="group">
                <div class="bg-white rounded-lg p-6 border border-gray-200 hover:shadow-lg hover:border-bloom-primary transition">
                    <p class="text-gray-600 text-sm font-medium uppercase tracking-wide mb-4">Pesanan Saya</p>
                    <p class="text-4xl font-light text-gray-900 group-hover:text-bloom-primary transition">{{ $ordersCount }}</p>
                    <p class="text-gray-500 text-sm mt-3 font-light">
                        @if($ordersCount == 0)
                            Belum ada pesanan
                        @else
                            {{ $ordersCount }} pesanan
                        @endif
                    </p>
                </div>
            </a>

            <!-- Keranjang Saya -->
            <a href="{{ route('cart.index') }}" class="group">
                <div class="bg-white rounded-lg p-6 border border-gray-200 hover:shadow-lg hover:border-bloom-primary transition">
                    <p class="text-gray-600 text-sm font-medium uppercase tracking-wide mb-4">Keranjang Saya</p>
                    <p class="text-4xl font-light text-gray-900 group-hover:text-bloom-primary transition">{{ $cartItemsCount }}</p>
                    <p class="text-gray-500 text-sm mt-3 font-light">
                        @if($cartItemsCount == 0)
                            Keranjang kosong
                        @else
                            Item dalam keranjang
                        @endif
                    </p>
                </div>
            </a>

            <!-- Total Belanja -->
            <div class="bg-white rounded-lg p-6 border border-gray-200 hover:shadow-lg transition">
                <p class="text-gray-600 text-sm font-medium uppercase tracking-wide mb-4">Total Belanja</p>
                <p class="text-4xl font-light text-gray-900">Rp {{ number_format($totalSpending, 0, ',', '.') }}</p>
                <p class="text-gray-500 text-sm mt-3 font-light">Tahun {{ date('Y') }}</p>
            </div>
        </div>

        <!-- Recent Orders Section -->
        @if($recentOrders->count() > 0)
            <div class="mb-16" id="pesanan">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-light text-gray-900">Pesanan Terbaru</h2>
                    <a href="{{ route('products.index') }}" class="text-bloom-primary hover:text-bloom-coral font-medium transition">
                        Lanjutkan Belanja
                    </a>
                </div>

                <div class="space-y-4">
                    @foreach($recentOrders as $order)
                        <a href="{{ route('order.show', $order) }}" class="group block">
                            <div class="bg-white rounded-lg p-6 border border-gray-200 hover:shadow-md hover:border-bloom-primary transition">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900 group-hover:text-bloom-primary transition">
                                            Pesanan #{{ $order->order_number }}
                                        </h3>
                                        <p class="text-sm text-gray-500 mt-1">
                                            {{ $order->created_at->format('d M Y H:i') }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xl font-medium text-gray-900">
                                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                        </p>
                                        <span class="inline-block mt-2 px-3 py-1 rounded-full text-xs font-medium 
                                            @if($order->status === 'pending')
                                                bg-yellow-100 text-yellow-800
                                            @elseif($order->status === 'confirmed')
                                                bg-blue-100 text-blue-800
                                            @elseif($order->status === 'shipped')
                                                bg-purple-100 text-purple-800
                                            @elseif($order->status === 'delivered')
                                                bg-green-100 text-green-800
                                            @else
                                                bg-red-100 text-red-800
                                            @endif
                                        ">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>
                                <p class="text-gray-600 text-sm">
                                    {{ $order->items->count() }} item • 
                                    @if($order->shipping_address)
                                        {{ Str::limit($order->shipping_address, 40) }}
                                    @else
                                        Alamat pengiriman
                                    @endif
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Featured Products -->
        <div class="mb-16">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-light text-gray-900">Produk Rekomendasi</h2>
                <a href="{{ route('products.index') }}" class="text-bloom-primary hover:text-bloom-coral font-medium transition">
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
                        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-md transition duration-300">
                            <div class="relative overflow-hidden h-48 bg-gray-50">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-bloom-primary text-4xl font-light">🌸</div>
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

        <!-- Address & Profile Section -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-white to-gray-50">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-light text-gray-900">Informasi Profil & Pengiriman</h2>
                    <a href="{{ route('profile.edit') }}" class="text-bloom-primary hover:text-bloom-coral font-medium transition">
                        Edit
                    </a>
                </div>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <!-- Profile Info -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Informasi Pribadi</h3>
                        <div class="space-y-5">
                            <div>
                                <p class="text-gray-600 text-xs font-semibold uppercase mb-2">Nama</p>
                                <p class="text-lg font-light text-gray-900">{{ Auth::user()->name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-xs font-semibold uppercase mb-2">Email</p>
                                <p class="text-lg font-light text-gray-900">{{ Auth::user()->email }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 text-xs font-semibold uppercase mb-2">Nomor Telepon</p>
                                <p class="text-lg font-light text-gray-900">
                                    @if(Auth::user()->phone)
                                        {{ Auth::user()->phone }}
                                    @else
                                        <span class="text-gray-400">Belum diatur</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Address Info -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Alamat Pengiriman</h3>
                        <div class="space-y-5">
                            <div>
                                <p class="text-gray-600 text-xs font-semibold uppercase mb-2">Alamat</p>
                                <p class="text-lg font-light text-gray-900">
                                    @if(Auth::user()->address)
                                        {{ Auth::user()->address }}
                                    @else
                                        <span class="text-gray-400">Belum diatur</span>
                                    @endif
                                </p>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-gray-600 text-xs font-semibold uppercase mb-2">Kota</p>
                                    <p class="text-base font-light text-gray-900">
                                        @if(Auth::user()->city)
                                            {{ Auth::user()->city }}
                                        @else
                                            <span class="text-gray-400 text-sm">Belum diatur</span>
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <p class="text-gray-600 text-xs font-semibold uppercase mb-2">Provinsi</p>
                                    <p class="text-base font-light text-gray-900">
                                        @if(Auth::user()->province)
                                            {{ Auth::user()->province }}
                                        @else
                                            <span class="text-gray-400 text-sm">Belum diatur</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div>
                                <p class="text-gray-600 text-xs font-semibold uppercase mb-2">Kode Pos</p>
                                <p class="text-lg font-light text-gray-900">
                                    @if(Auth::user()->postal_code)
                                        {{ Auth::user()->postal_code }}
                                    @else
                                        <span class="text-gray-400">Belum diatur</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

