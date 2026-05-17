@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-br from-bloom-bg-main to-bloom-primary/5 min-h-screen">
    <!-- Header Section -->
    <div style="background: linear-gradient(to bottom, #DA4582, #EC91C3, #FECEEE, #FFF5FA); border-bottom: 3px solid #EC91C3;" class="py-16 mb-12">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h1 class="text-6xl font-display font-light italic text-bloom-text-primary mb-4" style="letter-spacing: -1px; color: #9F254F;">Dashboard User</h1>
            <p class="font-light text-lg" style="color: #DA4582;">Selamat datang, <span class="font-semibold" style="color: #9F254F;">{{ Auth::user()->name }}</span></p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6 pb-20">
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <!-- Pesanan Saya -->
            <a href="#pesanan" class="group">
                <div style="background: #ffffff; border: 2px solid #EC91C3;" class="rounded-2xl p-6 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <p style="color: #9F254F;" class="text-xs font-bold uppercase tracking-widest">Pesanan Saya</p>
                        <div style="background: rgba(170, 103, 120, 0.15); border: 1px solid #EC91C3;" class="w-10 h-10 rounded-xl flex items-center justify-center">
                            <svg style="color: #9F254F;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                    </div>
                    <p style="color: #9F254F;" class="text-4xl font-bold mb-1">{{ $ordersCount }}</p>
                    <p style="color: #DA4582;" class="text-sm font-medium">
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
                <div style="background: #ffffff; border: 2px solid #D4B06A;" class="rounded-2xl p-6 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <p style="color: #9F254F;" class="text-xs font-bold uppercase tracking-widest">Keranjang Saya</p>
                        <div style="background: rgba(159,37,79,0.15); border: 1px solid #D4B06A;" class="w-10 h-10 rounded-xl flex items-center justify-center">
                            <svg style="color: #9F254F;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                    </div>
                    <p style="color: #9F254F;" class="text-4xl font-bold mb-1">{{ $cartItemsCount }}</p>
                    <p style="color: #DA4582;" class="text-sm font-medium">
                        @if($cartItemsCount == 0)
                            Keranjang kosong
                        @else
                            Item dalam keranjang
                        @endif
                    </p>
                </div>
            </a>

            <!-- Total Belanja -->
            <div style="background: #ffffff; border: 2px solid #EC91C3;" class="rounded-2xl p-6 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <p style="color: #9F254F;" class="text-xs font-bold uppercase tracking-widest">Total Belanja</p>
                    <div style="background: rgba(170, 103, 120, 0.15); border: 1px solid #EC91C3;" class="w-10 h-10 rounded-xl flex items-center justify-center">
                        <svg style="color: #9F254F;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <p style="color: #9F254F;" class="text-3xl font-bold mb-1">Rp {{ number_format($totalSpending, 0, ',', '.') }}</p>
                <p style="color: #DA4582;" class="text-sm font-medium">Tahun {{ date('Y') }}</p>
            </div>
        </div>

        <!-- Recent Orders Section -->
        @if($recentOrders->count() > 0)
            <div class="mb-16" id="pesanan">
                <div class="flex justify-between items-center mb-8">
                    <h2 style="color: #9F254F;" class="text-3xl font-light">Pesanan Terbaru</h2>
                    <a href="{{ route('products.index') }}" style="color: #EC91C3;" class="hover:opacity-80 font-medium transition text-sm">
                        Lanjutkan Belanja &rarr;
                    </a>
                </div>

                <!-- Orders Table -->
                <div style="background: #ffffff; border: 2px solid #EC91C3;" class="rounded-2xl overflow-hidden shadow-sm">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr style="background: linear-gradient(to right, #DA4582, #EC91C3);">
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">No. Pesanan</th>
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Tanggal</th>
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Alamat</th>
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Total</th>
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Status</th>
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $index => $order)
                                <tr style="background: {{ $index % 2 === 0 ? '#FFF5FA' : '#ffffff' }};" class="hover:brightness-95 transition duration-200">
                                    <td style="border-bottom: 1px solid #EC91C3;" class="px-6 py-4">
                                        <p style="color: #9F254F;" class="text-sm font-bold">#{{ $order->order_number }}</p>
                                        <p style="color: #DA4582;" class="text-xs mt-0.5">{{ $order->items->count() }} item</p>
                                    </td>
                                    <td style="border-bottom: 1px solid #EC91C3;" class="px-6 py-4">
                                        <p style="color: #7A7A7A;" class="text-sm">{{ $order->created_at->format('d M Y') }}</p>
                                        <p style="color: #B0A0A0;" class="text-xs">{{ $order->created_at->format('H:i') }}</p>
                                    </td>
                                    <td style="border-bottom: 1px solid #EC91C3;" class="px-6 py-4">
                                        <p style="color: #7A7A7A;" class="text-sm">
                                            @if($order->shipping_address)
                                                {{ Str::limit($order->shipping_address, 30) }}
                                            @else
                                                <span style="color: #B0A0A0;">Belum diatur</span>
                                            @endif
                                        </p>
                                    </td>
                                    <td style="border-bottom: 1px solid #EC91C3;" class="px-6 py-4">
                                        <p style="color: #9F254F;" class="text-sm font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                    </td>
                                    <td style="border-bottom: 1px solid #EC91C3;" class="px-6 py-4">
                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                            @if($order->status === 'pending')
                                                bg-yellow-100 text-yellow-800
                                            @elseif($order->status === 'confirmed')
                                                bg-blue-100 text-blue-800
                                            @elseif($order->status === 'shipped')
                                                bg-purple-100 text-purple-800
                                            @elseif($order->status === 'delivered' || $order->status === 'completed')
                                                bg-green-100 text-green-800
                                            @else
                                                bg-red-100 text-red-800
                                            @endif
                                        ">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td style="border-bottom: 1px solid #EC91C3;" class="px-6 py-4 text-center">
                                        <a href="{{ route('order.show', $order) }}" style="background: linear-gradient(135deg, #DA4582, #9F254F); color: #ffffff;" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-xs font-semibold hover:opacity-90 transition shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Featured Products -->
        <div class="mb-16">
            <div class="flex justify-between items-center mb-8">
                <h2 style="color: #9F254F;" class="text-3xl font-light">Produk Rekomendasi</h2>
                <a href="{{ route('products.index') }}" style="color: #DA4582;" class="hover:opacity-80 font-medium transition">
                    Lihat Semua
                </a>
            </div>

            @php
                $products = \App\Models\Product::where('stock', '>', 0)
                    ->orderBy('created_at', 'desc')
                    ->limit(4)
                    ->get();
            @endphp

            <div style="background: #ffffff; border: 2px solid #EC91C3;" class="rounded-2xl overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr style="background: linear-gradient(to right, #DA4582, #EC91C3);">
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Gambar</th>
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Nama Produk</th>
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Harga</th>
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Stok</th>
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $index => $product)
                                <tr style="background: {{ $index % 2 === 0 ? '#FFF5FA' : '#ffffff' }}; border-bottom: 1px solid #EC91C3;" class="hover:brightness-95 transition duration-200">
                                    <!-- Image -->
                                    <td style="border-bottom: 1px solid #EC91C3;" class="px-6 py-4">
                                        <div style="border: 2px solid #EC91C3;" class="w-14 h-14 rounded-xl overflow-hidden shadow-sm">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div style="background: linear-gradient(to bottom right, #FFF5FA, #FECEEE); color: #DA4582;" class="w-full h-full flex items-center justify-center text-xl">🌸</div>
                                            @endif
                                        </div>
                                    </td>
                                    <!-- Name -->
                                    <td style="border-bottom: 1px solid #E8B8C1;" class="px-6 py-4">
                                        <p style="color: #7A7A7A;" class="text-sm font-semibold">{{ $product->name }}</p>
                                        @if($product->category)
                                            <p style="color: #B0A0A0;" class="text-xs mt-0.5">{{ $product->category->name }}</p>
                                        @endif
                                    </td>
                                    <!-- Price -->
                                    <td style="border-bottom: 1px solid #E8B8C1;" class="px-6 py-4">
                                        <p style="color: #7A7A7A;" class="text-sm font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    </td>
                                    <!-- Stock -->
                                    <td style="border-bottom: 1px solid #E8B8C1;" class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold
                                            {{ $product->stock > 10 ? 'bg-green-50 text-green-700' : ($product->stock > 0 ? 'bg-yellow-50 text-yellow-700' : 'bg-red-50 text-red-700') }}" style="border: 1px solid {{ $product->stock > 10 ? '#bbf7d0' : ($product->stock > 0 ? '#fef08a' : '#fecaca') }};">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $product->stock > 10 ? 'bg-green-500' : ($product->stock > 0 ? 'bg-yellow-500' : 'bg-red-500') }}"></span>
                                            {{ $product->stock }} unit
                                        </span>
                                    </td>
                                    <!-- Action -->
                                    <td style="border-bottom: 1px solid #EC91C3;" class="px-6 py-4 text-center">
                                        <a href="{{ route('products.show', $product->slug) }}" style="background: linear-gradient(135deg, #DA4582, #9F254F); color: #ffffff;" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-xs font-semibold hover:opacity-90 transition shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Lihat
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="background: #FFF5FA;" class="px-8 py-12 text-center">
                                        <p style="color: #DA4582;" class="text-lg font-light">Belum ada produk tersedia</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Table Footer -->
                @if($products->count() > 0)
                <div style="background: linear-gradient(to right, #DA4582, #EC91C3); border-top: 1px solid #9F254F;" class="px-6 py-3">
                    <p style="color: #ffffff;" class="text-xs font-medium">Menampilkan {{ $products->count() }} produk rekomendasi</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Address & Profile Section -->
        <div style="background: #ffffff; border-color: #EC91C3;" class="rounded-2xl border-2 overflow-hidden shadow-sm">
            <div style="border-bottom-color: #EC91C3; background: #ffffff;" class="px-8 py-6 border-b-2">
                <div class="flex justify-between items-center">
                    <h2 style="color: #9F254F;" class="text-2xl font-light">Informasi Profil & Pengiriman</h2>
                    <a href="{{ route('profile.edit') }}" style="color: #DA4582;" class="hover:opacity-80 font-medium transition">
                        Edit
                    </a>
                </div>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <!-- Profile Info -->
                    <div>
                        <h3 style="color: #9F254F;" class="text-lg font-semibold mb-6">Informasi Pribadi</h3>
                        <div class="space-y-5">
                            <div>
                                <p style="color: #DA4582;" class="text-xs font-bold uppercase mb-2">Nama</p>
                                <p style="color: #9F254F;" class="text-lg font-light">{{ Auth::user()->name }}</p>
                            </div>
                            <div>
                                <p style="color: #DA4582;" class="text-xs font-bold uppercase mb-2">Email</p>
                                <p style="color: #9F254F;" class="text-lg font-light">{{ Auth::user()->email }}</p>
                            </div>
                            <div>
                                <p style="color: #DA4582;" class="text-xs font-bold uppercase mb-2">Nomor Telepon</p>
                                <p style="color: #9F254F;" class="text-lg font-light">
                                    @if(Auth::user()->phone)
                                        {{ Auth::user()->phone }}
                                    @else
                                        <span style="color: #DA4582;">Belum diatur</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Address Info -->
                    <div>
                        <h3 style="color: #9F254F;" class="text-lg font-semibold mb-6">Alamat Pengiriman</h3>
                        <div class="space-y-5">
                            <div>
                                <p style="color: #DA4582;" class="text-xs font-bold uppercase mb-2">Alamat</p>
                                <p style="color: #9F254F;" class="text-lg font-light">
                                    @if(Auth::user()->address)
                                        {{ Auth::user()->address }}
                                    @else
                                        <span style="color: #DA4582;">Belum diatur</span>
                                    @endif
                                </p>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p style="color: #DA4582;" class="text-xs font-bold uppercase mb-2">Kota</p>
                                    <p style="color: #9F254F;" class="text-base font-light">
                                        @if(Auth::user()->city)
                                            {{ Auth::user()->city }}
                                        @else
                                            <span style="color: #DA4582;" class="text-sm">Belum diatur</span>
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <p style="color: #DA4582;" class="text-xs font-bold uppercase mb-2">Provinsi</p>
                                    <p style="color: #9F254F;" class="text-base font-light">
                                        @if(Auth::user()->province)
                                            {{ Auth::user()->province }}
                                        @else
                                            <span style="color: #DA4582;" class="text-sm">Belum diatur</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div>
                                <p style="color: #DA4582;" class="text-xs font-bold uppercase mb-2">Kode Pos</p>
                                <p style="color: #9F254F;" class="text-lg font-light">
                                    @if(Auth::user()->postal_code)
                                        {{ Auth::user()->postal_code }}
                                    @else
                                        <span style="color: #DA4582;">Belum diatur</span>
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


