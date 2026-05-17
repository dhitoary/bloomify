@extends('layouts.app')

@section('content')
<div style="background: linear-gradient(to bottom right, #e2d0d0, #F5E6E6); background-attachment: fixed;" class="min-h-screen">
    <!-- Header Section -->
    <div style="background: #aa6778; border-bottom: 2px solid #aa6778;" class="py-12 mb-12">
        <div class="max-w-7xl mx-auto px-6">
            <h1 class="text-5xl font-light text-white mb-3">Dashboard</h1>
            <p class="font-light text-lg text-white">Selamat datang, <span class="font-semibold">{{ Auth::user()->name }}</span></p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6 pb-20">
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <!-- Pesanan Saya -->
            <a href="#pesanan" class="group">
                <div style="background: #d6acad; border-color: #d6acad;" class="rounded-2xl p-6 border-2 hover:shadow-soft-lg transition">
                    <p style="color: #b78493;" class="text-sm font-bold uppercase tracking-wide mb-4">Pesanan Saya</p>
                    <p style="color: #aa6778;" class="text-4xl font-light group-hover:text-opacity-80 transition">{{ $ordersCount }}</p>
                    <p style="color: #5A5A5A;" class="text-sm mt-3 font-light">
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
                <div style="background: #cc93a2; border-color: #cc93a2;" class="rounded-2xl p-6 border-2 hover:shadow-soft-lg transition">
                    <p style="color: #ffffff;" class="text-sm font-bold uppercase tracking-wide mb-4">Keranjang Saya</p>
                    <p style="color: #ffffff;" class="text-4xl font-light group-hover:text-opacity-80 transition">{{ $cartItemsCount }}</p>
                    <p style="color: #5A5A5A;" class="text-sm mt-3 font-light">
                        @if($cartItemsCount == 0)
                            Keranjang kosong
                        @else
                            Item dalam keranjang
                        @endif
                    </p>
                </div>
            </a>

            <!-- Total Belanja -->
            <div style="background: #d6acad; border-color: #d6acad;" class="rounded-2xl p-6 border-2 hover:shadow-soft-lg transition">
                <p style="color: #b78493;" class="text-sm font-bold uppercase tracking-wide mb-4">Total Belanja</p>
                <p style="color: #aa6778;" class="text-4xl font-light">Rp {{ number_format($totalSpending, 0, ',', '.') }}</p>
                <p style="color: #5A5A5A;" class="text-sm mt-3 font-light">Tahun {{ date('Y') }}</p>
            </div>
        </div>

        <!-- Recent Orders Section -->
        @if($recentOrders->count() > 0)
            <div class="mb-16" id="pesanan">
                <div class="flex justify-between items-center mb-8">
                    <h2 style="color: #7A7A7A;" class="text-3xl font-light">Pesanan Terbaru</h2>
                    <a href="{{ route('products.index') }}" style="color: #7A7A7A;" class="hover:opacity-80 font-medium transition">
                        Lanjutkan Belanja
                    </a>
                </div>

                <div class="space-y-4">
                    @foreach($recentOrders as $order)
                        <a href="{{ route('order.show', $order) }}" class="group block">
                            <div style="background: #DFACAF; border-color: #DA9CA3;" class="rounded-2xl p-6 border-2 hover:shadow-md transition">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h3 style="color: #7A7A7A;" class="text-lg font-medium group-hover:opacity-80 transition">
                                            Pesanan #{{ $order->order_number }}
                                        </h3>
                                        <p style="color: #5A5A5A;" class="text-sm mt-1">
                                            {{ $order->created_at->format('d M Y H:i') }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p style="color: #7A7A7A;" class="text-xl font-medium">
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
                                <p style="color: #5A5A5A;" class="text-sm">
                                    {{ $order->items->count() }} item â€¢ 
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
                <h2 style="color: #7A7A7A;" class="text-3xl font-light">Produk Rekomendasi</h2>
                <a href="{{ route('products.index') }}" style="color: #7A7A7A;" class="hover:opacity-80 font-medium transition">
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
                        <div style="background: #EDD4DD; border-color: #E8B8C1;" class="rounded-2xl border-2 overflow-hidden hover:shadow-md transition duration-300">
                            <div style="background: linear-gradient(to bottom right, #E8B8C1, #EDD4DD);" class="relative overflow-hidden h-48">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-4xl font-light" style="color: #DA9CA3;">ðŸŒ¸</div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h4 style="color: #7A7A7A;" class="font-medium mb-3 line-clamp-2 group-hover:opacity-80 transition text-sm">{{ $product->name }}</h4>
                                <p style="color: #7A7A7A;" class="font-semibold text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <p style="color: #5A5A5A;" class="text-xs mt-2 font-light">Stok: {{ $product->stock }} unit</p>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p style="color: #5A5A5A;" class="text-lg font-light">Belum ada produk tersedia</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Address & Profile Section -->
            <div style="background: #EDD4DD; border-color: #E8B8C1;" class="rounded-2xl border-2 overflow-hidden">
            <div style="border-bottom-color: #E8B8C1; background: #EDD4DD;" class="px-8 py-6 border-b-2">
                <div class="flex justify-between items-center">
                    <h2 style="color: #7A7A7A;" class="text-2xl font-light">Informasi Profil & Pengiriman</h2>
                    <a href="{{ route('profile.edit') }}" style="color: #7A7A7A;" class="hover:opacity-80 font-medium transition">
                        Edit
                    </a>
                </div>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <!-- Profile Info -->
                    <div>
                        <h3 style="color: #7A7A7A;" class="text-lg font-semibold mb-6">Informasi Pribadi</h3>
                        <div class="space-y-5">
                            <div>
                                <p style="color: #7A7A7A;" class="text-xs font-bold uppercase mb-2">Nama</p>
                                <p style="color: #7A7A7A;" class="text-lg font-light">{{ Auth::user()->name }}</p>
                            </div>
                            <div>
                                <p style="color: #7A7A7A;" class="text-xs font-bold uppercase mb-2">Email</p>
                                <p style="color: #7A7A7A;" class="text-lg font-light">{{ Auth::user()->email }}</p>
                            </div>
                            <div>
                                <p style="color: #7A7A7A;" class="text-xs font-bold uppercase mb-2">Nomor Telepon</p>
                                <p style="color: #7A7A7A;" class="text-lg font-light">
                                    @if(Auth::user()->phone)
                                        {{ Auth::user()->phone }}
                                    @else
                                        <span style="color: #A0A0A0;">Belum diatur</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Address Info -->
                    <div>
                        <h3 style="color: #7A7A7A;" class="text-lg font-semibold mb-6">Alamat Pengiriman</h3>
                        <div class="space-y-5">
                            <div>
                                <p style="color: #7A7A7A;" class="text-xs font-bold uppercase mb-2">Alamat</p>
                                <p style="color: #7A7A7A;" class="text-lg font-light">
                                    @if(Auth::user()->address)
                                        {{ Auth::user()->address }}
                                    @else
                                        <span style="color: #A0A0A0;">Belum diatur</span>
                                    @endif
                                </p>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p style="color: #7A7A7A;" class="text-xs font-bold uppercase mb-2">Kota</p>
                                    <p style="color: #7A7A7A;" class="text-base font-light">
                                        @if(Auth::user()->city)
                                            {{ Auth::user()->city }}
                                        @else
                                            <span style="color: #A0A0A0;" class="text-sm">Belum diatur</span>
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <p style="color: #7A7A7A;" class="text-xs font-bold uppercase mb-2">Provinsi</p>
                                    <p style="color: #7A7A7A;" class="text-base font-light">
                                        @if(Auth::user()->province)
                                            {{ Auth::user()->province }}
                                        @else
                                            <span style="color: #A0A0A0;" class="text-sm">Belum diatur</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div>
                                <p style="color: #7A7A7A;" class="text-xs font-bold uppercase mb-2">Kode Pos</p>
                                <p style="color: #7A7A7A;" class="text-lg font-light">
                                    @if(Auth::user()->postal_code)
                                        {{ Auth::user()->postal_code }}
                                    @else
                                        <span style="color: #A0A0A0;">Belum diatur</span>
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


