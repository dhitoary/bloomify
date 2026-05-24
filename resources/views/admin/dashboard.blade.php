@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div style="background: linear-gradient(to bottom right, #FFF5FA, #ffffff); background-attachment: fixed;" class="min-h-screen" x-data="{ activeTab: '{{ request('tab', 'overview') }}' }">
    <!-- Header Section -->
    <div style="background: linear-gradient(to bottom, #DA4582, #EC91C3, #FECEEE, #FFF5FA); border-bottom: 3px solid #EC91C3;" class="py-16 mb-12">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h1 class="text-6xl font-display font-light italic text-bloom-text-primary mb-4" style="letter-spacing: -1px; color: #9F254F;">Dashboard Admin</h1>
            <p class="font-light text-lg" style="color: #DA4582;">Selamat datang, <span class="font-semibold" style="color: #9F254F;">{{ Auth::user()->name }}</span></p>
        </div>
    </div>

    @if(session('success'))
        <div class="max-w-7xl mx-auto px-6 mb-8">
            <div style="background: rgba(34,197,94,0.1); border: 2px solid #22c55e; color: #16a34a;" class="px-6 py-4 rounded-xl flex items-center gap-3 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6 pb-20">
        <!-- Tab Navigation -->
        <div style="border-bottom: 2px solid #EC91C3;" class="mb-12 flex space-x-8 pb-4">
            <button @click="activeTab = 'overview'" :class="activeTab === 'overview' ? 'font-semibold' : ''" :style="activeTab === 'overview' ? 'color: #9F254F; border-bottom: 4px solid #9F254F;' : 'color: #DA4582;'" class="pb-2 font-medium transition duration-300 hover:opacity-80">Overview</button>
            <button @click="activeTab = 'products'" :class="activeTab === 'products' ? 'font-semibold' : ''" :style="activeTab === 'products' ? 'color: #9F254F; border-bottom: 4px solid #9F254F;' : 'color: #DA4582;'" class="pb-2 font-medium transition duration-300 hover:opacity-80">Produk</button>
            <button @click="activeTab = 'categories'" :class="activeTab === 'categories' ? 'font-semibold' : ''" :style="activeTab === 'categories' ? 'color: #9F254F; border-bottom: 4px solid #9F254F;' : 'color: #DA4582;'" class="pb-2 font-medium transition duration-300 hover:opacity-80">Kategori</button>
            <button @click="activeTab = 'orders'" :class="activeTab === 'orders' ? 'font-semibold' : ''" :style="activeTab === 'orders' ? 'color: #9F254F; border-bottom: 4px solid #9F254F;' : 'color: #DA4582;'" class="pb-2 font-medium transition duration-300 hover:opacity-80">Pesanan</button>
            <button @click="activeTab = 'users'" :class="activeTab === 'users' ? 'font-semibold' : ''" :style="activeTab === 'users' ? 'color: #9F254F; border-bottom: 4px solid #9F254F;' : 'color: #DA4582;'" class="pb-2 font-medium transition duration-300 hover:opacity-80">Pengguna</button>
        </div>

        <!-- Overview Tab -->
        <div x-show="activeTab === 'overview'" class="tab-content">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <!-- Total Pesanan -->
                <div style="background: #ffffff; border: 2px solid #EC91C3;" class="rounded-2xl p-6 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <p style="color: #9F254F;" class="text-xs font-bold uppercase tracking-widest">Total Pesanan</p>
                        <div style="background: rgba(170, 103, 120, 0.15); border: 1px solid #EC91C3;" class="w-10 h-10 rounded-xl flex items-center justify-center">
                            <svg style="color: #9F254F;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                    </div>
                    <p style="color: #9F254F;" class="text-4xl font-bold mb-1">{{ $totalOrders ?? 0 }}</p>
                    <p style="color: #DA4582;" class="text-sm font-medium">{{ $ordersThisMonth ?? 0 }} bulan ini</p>
                </div>

                <!-- Total Penjualan -->
                <div style="background: linear-gradient(135deg, #F0CD87, #F5DCA6); border: 2px solid #D4B06A;" class="rounded-2xl p-6 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <p style="color: #9F254F;" class="text-xs font-bold uppercase tracking-widest">Total Penjualan</p>
                        <div style="background: rgba(159, 37, 79, 0.15); border: 1px solid #D4B06A;" class="w-10 h-10 rounded-xl flex items-center justify-center">
                            <svg style="color: #9F254F;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <p style="color: #9F254F;" class="text-3xl font-bold mb-1">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>
                    <p style="color: #DA4582;" class="text-sm font-medium">Bulan ini</p>
                </div>

                <!-- Total Produk -->
                <div style="background: #ffffff; border: 2px solid #EC91C3;" class="rounded-2xl p-6 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <p style="color: #9F254F;" class="text-xs font-bold uppercase tracking-widest">Total Produk</p>
                        <div style="background: rgba(170, 103, 120, 0.15); border: 1px solid #EC91C3;" class="w-10 h-10 rounded-xl flex items-center justify-center">
                            <svg style="color: #9F254F;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                    </div>
                    <p style="color: #9F254F;" class="text-4xl font-bold mb-1">{{ $totalProducts ?? 0 }}</p>
                    <p style="color: #DA4582;" class="text-sm font-medium">Aktif tersedia</p>
                </div>

                <!-- Total Pengguna -->
                <div style="background: #ffffff; border: 2px solid #EC91C3;" class="rounded-2xl p-6 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <p style="color: #9F254F;" class="text-xs font-bold uppercase tracking-widest">Total Pengguna</p>
                        <div style="background: rgba(170, 103, 120, 0.15); border: 1px solid #EC91C3;" class="w-10 h-10 rounded-xl flex items-center justify-center">
                            <svg style="color: #9F254F;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                    </div>
                    <p style="color: #9F254F;" class="text-4xl font-bold mb-1">{{ $totalUsers ?? 0 }}</p>
                    <p style="color: #DA4582;" class="text-sm font-medium">+ {{ $newUsersThisMonth ?? 0 }} baru</p>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 gap-8 mb-12">
                <!-- Sales Chart -->
                <div style="background: #ffffff; border: 2px solid #EC91C3;" class="rounded-2xl p-8 shadow-sm">
                    <h2 style="color: #9F254F;" class="text-xl font-light mb-6">Penjualan 7 Hari Terakhir</h2>
                    <div class="relative h-72 w-full">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>

                <!-- Category Chart -->
                <div style="background: #ffffff; border: 2px solid #EC91C3;" class="rounded-2xl p-8 shadow-sm">
                    <h2 style="color: #9F254F;" class="text-xl font-light mb-6">Kategori Terlaris</h2>
                    <div class="relative h-72 w-full">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div style="background: #ffffff; border: 2px solid #EC91C3;" class="rounded-2xl overflow-hidden shadow-sm">
                <div style="border-bottom: 2px solid #EC91C3;" class="px-8 py-6">
                    <h2 style="color: #9F254F;" class="text-xl font-light">Pesanan Terbaru</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr style="background: linear-gradient(to right, #DA4582, #EC91C3);">
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">No. Pesanan</th>
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Pelanggan</th>
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Total</th>
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Status</th>
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Tanggal</th>
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders ?? [] as $index => $order)
                                <tr style="background: {{ $index % 2 === 0 ? 'rgba(255,255,255,0.5)' : 'rgba(255,255,255,0.2)' }};" class="hover:brightness-95 transition duration-200">
                                    <td style="border-bottom: 1px solid #EC91C3; color: #9F254F;" class="px-6 py-4 text-sm font-bold">#{{ $order->order_number }}</td>
                                    <td style="border-bottom: 1px solid #EC91C3; color: #7A7A7A;" class="px-6 py-4 text-sm">{{ $order->user->name ?? 'N/A' }}</td>
                                    <td style="border-bottom: 1px solid #EC91C3; color: #9F254F;" class="px-6 py-4 text-sm font-semibold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td style="border-bottom: 1px solid #EC91C3;" class="px-6 py-4 text-sm">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold 
                                            {{ in_array($order->status, ['completed', 'delivered']) ? 'bg-green-50 text-green-700 border border-green-200' : 
                                               (in_array($order->status, ['pending', 'shipped']) ? 'bg-yellow-50 text-yellow-700 border border-yellow-200' : 
                                               (in_array($order->status, ['confirmed']) ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-red-50 text-red-700 border border-red-200')) }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td style="border-bottom: 1px solid #EC91C3; color: #DA4582;" class="px-6 py-4 text-sm">{{ $order->created_at->format('d M Y') }}</td>
                                    <td style="border-bottom: 1px solid #EC91C3;" class="px-6 py-4 text-sm">
                                        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" style="border-color: #EC91C3; color: #9F254F;" class="text-sm rounded-lg focus:ring-1 focus:outline-none" onchange="this.form.submit()">
                                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="color: #DA4582;" class="px-6 py-12 text-center font-light">Belum ada pesanan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Products Tab -->
        <div x-show="activeTab === 'products'" class="tab-content">
            <div style="background: #ffffff; border: 2px solid #EC91C3;" class="rounded-2xl overflow-hidden shadow-sm">
                <div style="border-bottom: 2px solid #EC91C3;" class="px-8 py-6">
                    <div class="flex justify-between items-center">
                        <h2 style="color: #9F254F;" class="text-xl font-light">Daftar Produk</h2>
                        <a href="{{ route('admin.products.create') }}" style="color: #EC91C3;" class="hover:opacity-80 font-medium transition">+ Tambah Produk</a>
                    </div>
                </div>

                <!-- Simple Search & Filter Bar -->
                <form method="GET" action="{{ route('admin.dashboard') }}" class="px-8 py-4 border-b-2 border-bloom-accent-light bg-blue-50" style="background: rgba(255,255,255,0.5);">
                    <input type="hidden" name="tab" value="products">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end">
                        <!-- Search -->
                        <div>
                            <label class="block text-xs font-semibold" style="color: #9F254F; margin-bottom: 0.5rem;">CARI PRODUK</label>
                            <input type="text" name="search" placeholder="Nama produk..." 
                                value="{{ request('search') }}" 
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:outline-none focus:ring-2" style="focus:ring-color: #EC91C3;">
                        </div>

                        <!-- Category Filter -->
                        <div>
                            <label class="block text-xs font-semibold" style="color: #9F254F; margin-bottom: 0.5rem;">KATEGORI</label>
                            <select name="category" class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:outline-none focus:ring-2" style="focus:ring-color: #EC91C3;">
                                <option value="">Semua</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Stock Status Filter -->
                        <div>
                            <label class="block text-xs font-semibold" style="color: #9F254F; margin-bottom: 0.5rem;">STATUS STOK</label>
                            <select name="stock_status" class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:outline-none focus:ring-2" style="focus:ring-color: #EC91C3;">
                                <option value="">Semua</option>
                                <option value="available" {{ request('stock_status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                                <option value="limited" {{ request('stock_status') == 'limited' ? 'selected' : '' }}>Terbatas</option>
                                <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Habis</option>
                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <button type="submit" class="flex-1 px-3 py-2 text-white text-sm font-medium rounded transition" style="background: #DA4582; hover:background: #9F254F;">
                                Cari
                            </button>
                            <a href="{{ route('admin.dashboard') }}?tab=products" class="flex-1 px-3 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 text-sm font-medium rounded transition text-center">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr style="background: linear-gradient(to right, #DA4582, #EC91C3);">
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Nama Produk</th>
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Kategori</th>
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Harga</th>
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Stok</th>
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products ?? [] as $index => $product)
                                <tr style="background: {{ $index % 2 === 0 ? 'rgba(255,255,255,0.5)' : 'rgba(255,255,255,0.2)' }};" class="hover:brightness-95 transition duration-200">
                                    <td style="border-bottom: 1px solid #EC91C3; color: #9F254F;" class="px-6 py-4 text-sm font-semibold">{{ $product->name }}</td>
                                    <td style="border-bottom: 1px solid #EC91C3; color: #7A7A7A;" class="px-6 py-4 text-sm">{{ $product->category->name ?? 'N/A' }}</td>
                                    <td style="border-bottom: 1px solid #EC91C3; color: #9F254F;" class="px-6 py-4 text-sm font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td style="border-bottom: 1px solid #EC91C3; color: #DA4582;" class="px-6 py-4 text-sm">{{ $product->stock }} unit</td>
                                    <td style="border-bottom: 1px solid #EC91C3;" class="px-6 py-4 text-sm space-x-2">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" style="color: #EC91C3;" class="hover:opacity-80 font-medium">Edit</a>
                                        <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium" onclick="return confirm('Yakin hapus produk ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="color: #DA4582;" class="px-6 py-12 text-center font-light">Belum ada produk</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($products && $products->hasPages())
                <div style="border-top: 1px solid #EC91C3;" class="px-8 py-4">
                    {{ $products->links() }}
                </div>
                @endif
            </div>
        </div>

        <!-- Categories Tab -->
        <div x-show="activeTab === 'categories'" class="tab-content">
            <div style="background: #ffffff; border: 2px solid #EC91C3;" class="rounded-2xl overflow-hidden shadow-sm">
                <div style="border-bottom: 2px solid #EC91C3;" class="px-8 py-6">
                    <div class="flex justify-between items-center">
                        <h2 style="color: #9F254F;" class="text-xl font-light">Daftar Kategori</h2>
                        <a href="{{ route('admin.categories.create') }}" style="color: #EC91C3;" class="hover:opacity-80 font-medium transition">+ Tambah Kategori</a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr style="background: linear-gradient(to right, #DA4582, #EC91C3);">
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Nama Kategori</th>
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Deskripsi</th>
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Jumlah Produk</th>
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories ?? [] as $index => $category)
                                <tr style="background: {{ $index % 2 === 0 ? 'rgba(255,255,255,0.5)' : 'rgba(255,255,255,0.2)' }};" class="hover:brightness-95 transition duration-200">
                                    <td style="border-bottom: 1px solid #EC91C3; color: #9F254F;" class="px-6 py-4 text-sm font-semibold">{{ $category->name }}</td>
                                    <td style="border-bottom: 1px solid #EC91C3; color: #7A7A7A;" class="px-6 py-4 text-sm">{{ Str::limit($category->description, 50) }}</td>
                                    <td style="border-bottom: 1px solid #EC91C3; color: #9F254F;" class="px-6 py-4 text-sm font-semibold">{{ $category->products_count ?? 0 }}</td>
                                    <td style="border-bottom: 1px solid #EC91C3;" class="px-6 py-4 text-sm space-x-2">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" style="color: #EC91C3;" class="hover:opacity-80 font-medium">Edit</a>
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category->id) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium" onclick="return confirm('Yakin hapus kategori ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="color: #DA4582;" class="px-6 py-12 text-center font-light">Belum ada kategori</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($categories && $categories->hasPages())
                <div style="border-top: 1px solid #EC91C3;" class="px-8 py-4">
                    {{ $categories->links() }}
                </div>
                @endif
            </div>
        </div>

        <!-- Orders Tab -->
        <div x-show="activeTab === 'orders'" class="tab-content">
            <div style="background: #ffffff; border: 2px solid #EC91C3;" class="rounded-2xl overflow-hidden shadow-sm">
                <div style="border-bottom: 2px solid #EC91C3;" class="px-8 py-6">
                    <h2 style="color: #9F254F;" class="text-xl font-light">Daftar Pesanan</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr style="background: linear-gradient(to right, #DA4582, #EC91C3);">
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">No. Pesanan</th>
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Pelanggan</th>
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Total</th>
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Status</th>
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Tanggal</th>
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders ?? [] as $index => $order)
                                <tr style="background: {{ $index % 2 === 0 ? 'rgba(255,255,255,0.5)' : 'rgba(255,255,255,0.2)' }};" class="hover:brightness-95 transition duration-200">
                                    <td style="border-bottom: 1px solid #EC91C3; color: #9F254F;" class="px-6 py-4 text-sm font-bold">#{{ $order->order_number }}</td>
                                    <td style="border-bottom: 1px solid #EC91C3; color: #7A7A7A;" class="px-6 py-4 text-sm">{{ $order->user->name ?? 'N/A' }}</td>
                                    <td style="border-bottom: 1px solid #EC91C3; color: #9F254F;" class="px-6 py-4 text-sm font-semibold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td style="border-bottom: 1px solid #EC91C3;" class="px-6 py-4 text-sm">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold 
                                            {{ in_array($order->status, ['completed', 'delivered']) ? 'bg-green-50 text-green-700 border border-green-200' : 
                                               (in_array($order->status, ['pending', 'shipped']) ? 'bg-yellow-50 text-yellow-700 border border-yellow-200' : 
                                               (in_array($order->status, ['confirmed']) ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-red-50 text-red-700 border border-red-200')) }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td style="border-bottom: 1px solid #EC91C3; color: #DA4582;" class="px-6 py-4 text-sm">{{ $order->created_at->format('d M Y') }}</td>
                                    <td style="border-bottom: 1px solid #EC91C3;" class="px-6 py-4 text-sm">
                                        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" style="border-color: #EC91C3; color: #9F254F;" class="text-sm rounded-lg focus:ring-1 focus:outline-none" onchange="this.form.submit()">
                                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="color: #DA4582;" class="px-6 py-12 text-center font-light">Belum ada pesanan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($orders && $orders->hasPages())
                <div style="border-top: 1px solid #EC91C3;" class="px-8 py-4">
                    {{ $orders->links() }}
                </div>
                @endif
            </div>
        </div>

        <!-- Users Tab -->
        <div x-show="activeTab === 'users'" class="tab-content">
            <div style="background: #ffffff; border: 2px solid #EC91C3;" class="rounded-2xl overflow-hidden shadow-sm">
                <div style="border-bottom: 2px solid #EC91C3;" class="px-8 py-6">
                    <h2 style="color: #9F254F;" class="text-xl font-light">Daftar Pengguna</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr style="background: linear-gradient(to right, #DA4582, #EC91C3);">
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Nama</th>
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Email</th>
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Bergabung</th>
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Status</th>
                                <th style="border-bottom: 2px solid #9F254F; color: #ffffff;" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users ?? [] as $index => $user)
                                <tr style="background: {{ $index % 2 === 0 ? 'rgba(255,255,255,0.5)' : 'rgba(255,255,255,0.2)' }};" class="hover:brightness-95 transition duration-200">
                                    <td style="border-bottom: 1px solid #EC91C3; color: #9F254F;" class="px-6 py-4 text-sm font-semibold">{{ $user->name }}</td>
                                    <td style="border-bottom: 1px solid #EC91C3; color: #7A7A7A;" class="px-6 py-4 text-sm">{{ $user->email }}</td>
                                    <td style="border-bottom: 1px solid #EC91C3; color: #DA4582;" class="px-6 py-4 text-sm">{{ $user->created_at->format('d M Y') }}</td>
                                    <td style="border-bottom: 1px solid #EC91C3;" class="px-6 py-4 text-sm">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold 
                                            {{ $user->email_verified_at ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-yellow-50 text-yellow-700 border border-yellow-200' }}">
                                            {{ $user->email_verified_at ? 'Terverifikasi' : 'Pending' }}
                                        </span>
                                    </td>
                                    <td style="border-bottom: 1px solid #EC91C3;" class="px-6 py-4 text-sm">
                                        <form action="{{ route('admin.users.update-verification', ['user' => $user->id, 'page' => $users->currentPage()]) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="verification_status" style="border-color: #EC91C3; color: #9F254F;" class="text-sm rounded-lg focus:ring-1 focus:outline-none" onchange="this.form.submit()">
                                                <option value="pending" {{ !$user->email_verified_at ? 'selected' : '' }}>Pending</option>
                                                <option value="verified" {{ $user->email_verified_at ? 'selected' : '' }}>Terverifikasi</option>
                                                <option value="unverified">Batalkan Verifikasi</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="color: #DA4582;" class="px-6 py-12 text-center font-light">Belum ada pengguna</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($users && $users->hasPages())
                <div style="border-top: 1px solid #EC91C3;" class="px-8 py-4">
                    {{ $users->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sales Chart
        const salesCtx = document.getElementById('salesChart');
        if (salesCtx) {
            new Chart(salesCtx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($salesLabels ?? ['Hari 1', 'Hari 2', 'Hari 3', 'Hari 4', 'Hari 5', 'Hari 6', 'Hari 7']) !!},
                    datasets: [{
                        label: 'Penjualan (Rp)',
                        data: {{ json_encode($salesData ?? []) }},
                        borderColor: '#E89B94',
                        backgroundColor: 'rgba(232, 155, 148, 0.08)',
                        tension: 0.3,
                        fill: true,
                        pointRadius: 5,
                        pointBackgroundColor: '#E89B94',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        borderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Penting agar chart bisa menyesuaikan dengan tinggi container
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { 
                                color: '#999', 
                                font: { size: 11 },
                                callback: function(value) {
                                    return 'Rp ' + (value / 1000) + 'k'; // Format lebih ringkas
                                }
                            },
                            border: { display: false }
                        },
                        x: {
                            ticks: { color: '#999', font: { size: 11 } },
                            border: { display: false }
                        }
                    }
                }
            });
        }

        // Category Chart
        const categoryCtx = document.getElementById('categoryChart');
        if (categoryCtx) {
            const catSalesData = {!! json_encode($categorySales ?? []) !!};
            if (catSalesData.length > 0) {
                new Chart(categoryCtx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: catSalesData.map(cat => cat.name),
                        datasets: [{
                            data: catSalesData.map(cat => cat.count),
                            backgroundColor: ['#E89B94', '#6B9A94', '#8FCB9E', '#FBBF24', '#DDD6FE', '#C084FC'],
                            borderColor: '#fff',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { color: '#666', font: { size: 12, weight: '500' }, padding: 15 }
                            }
                        }
                    }
                });
            } else {
                // Tampilkan pesan kosong jika tidak ada produk
                categoryCtx.style.display = 'none';
                const parent = categoryCtx.parentElement;
                const p = document.createElement('p');
                p.className = "text-center text-gray-500 font-light mt-4";
                p.innerText = "Belum ada data kategori";
                parent.appendChild(p);
            }
        }
    });
</script>
@endsection


