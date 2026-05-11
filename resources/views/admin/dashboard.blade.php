@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="bg-bloom-bg-main min-h-screen" x-data="{ activeTab: 'overview' }">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-bloom-fuchsia via-bloom-primary to-bloom-primary-light border-b-4 border-bloom-fuchsia py-12 mb-8 shadow-soft">
        <div class="max-w-7xl mx-auto px-6">
            <h1 class="text-5xl font-display font-light text-bloom-text-light mb-3">Dashboard Admin</h1>
            <p class="text-bloom-text-light/90 font-light text-lg">Selamat datang, <span class="text-bloom-accent font-semibold">{{ Auth::user()->name }}</span></p>
        </div>
    </div>

    @if(session('success'))
        <div class="max-w-7xl mx-auto px-6 mb-8">
            <div class="bg-bloom-success/10 border-2 border-bloom-success text-bloom-success px-6 py-4 rounded-xl flex items-center gap-3 shadow-soft">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6 pb-20">
        <!-- Tab Navigation -->
        <div class="mb-12 flex space-x-8 border-b-2 border-bloom-border pb-4">
            <button @click="activeTab = 'overview'" :class="activeTab === 'overview' ? 'text-bloom-accent border-b-4 border-bloom-accent font-semibold' : 'text-bloom-text-secondary hover:text-bloom-text-primary'" class="pb-2 font-medium transition duration-300">Overview</button>
            <button @click="activeTab = 'products'" :class="activeTab === 'products' ? 'text-bloom-accent border-b-4 border-bloom-accent font-semibold' : 'text-bloom-text-secondary hover:text-bloom-text-primary'" class="pb-2 font-medium transition duration-300">Produk</button>
            <button @click="activeTab = 'categories'" :class="activeTab === 'categories' ? 'text-bloom-accent border-b-4 border-bloom-accent font-semibold' : 'text-bloom-text-secondary hover:text-bloom-text-primary'" class="pb-2 font-medium transition duration-300">Kategori</button>
            <button @click="activeTab = 'orders'" :class="activeTab === 'orders' ? 'text-bloom-accent border-b-4 border-bloom-accent font-semibold' : 'text-bloom-text-secondary hover:text-bloom-text-primary'" class="pb-2 font-medium transition duration-300">Pesanan</button>
            <button @click="activeTab = 'users'" :class="activeTab === 'users' ? 'text-bloom-accent border-b-4 border-bloom-accent font-semibold' : 'text-bloom-text-secondary hover:text-bloom-text-primary'" class="pb-2 font-medium transition duration-300">Pengguna</button>
        </div>

        <!-- Overview Tab -->
        <div x-show="activeTab === 'overview'" class="tab-content">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <!-- Total Pesanan -->
                <div class="bg-gradient-to-br from-bloom-bg-card to-bloom-bg-cream rounded-2xl p-6 border-2 border-bloom-border hover:shadow-soft-lg hover:-translate-y-1 transition-all duration-300">
                    <p class="text-bloom-text-secondary text-sm font-semibold uppercase tracking-widest mb-4">Total Pesanan</p>
                    <p class="text-4xl font-light text-bloom-accent">{{ $totalOrders ?? 0 }}</p>
                    <p class="text-bloom-text-secondary text-sm mt-3 font-light">{{ $ordersThisMonth ?? 0 }} bulan ini</p>
                </div>

                <!-- Total Penjualan -->
                <div class="bg-gradient-to-br from-bloom-bg-card to-bloom-bg-cream rounded-2xl p-6 border-2 border-bloom-border hover:shadow-soft-lg hover:-translate-y-1 transition-all duration-300">
                    <p class="text-bloom-text-secondary text-sm font-semibold uppercase tracking-widest mb-4">Total Penjualan</p>
                    <p class="text-3xl font-light text-bloom-accent">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>
                    <p class="text-bloom-text-secondary text-sm mt-3 font-light">Bulan ini</p>
                </div>

                <!-- Total Produk -->
                <div class="bg-gradient-to-br from-bloom-bg-card to-bloom-bg-cream rounded-2xl p-6 border-2 border-bloom-border hover:shadow-soft-lg hover:-translate-y-1 transition-all duration-300">
                    <p class="text-bloom-text-secondary text-sm font-semibold uppercase tracking-widest mb-4">Total Produk</p>
                    <p class="text-4xl font-light text-bloom-accent">{{ $totalProducts ?? 0 }}</p>
                    <p class="text-bloom-text-secondary text-sm mt-3 font-light">Aktif tersedia</p>
                </div>

                <!-- Total Pengguna -->
                <div class="bg-white rounded-lg p-6 border border-bloom-accent-light hover:shadow-lg transition">
                    <p class="text-gray-600 text-sm font-medium uppercase tracking-wide mb-4">Total Pengguna</p>
                    <p class="text-4xl font-light text-gray-900">{{ $totalUsers ?? 0 }}</p>
                    <p class="text-bloom-secondary text-sm mt-3 font-light">+ {{ $newUsersThisMonth ?? 0 }} baru</p>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 gap-8 mb-12">
                <!-- Sales Chart -->
                <div class="bg-white rounded-lg p-8 border border-bloom-accent-light">
                    <h2 class="text-xl font-light text-gray-900 mb-6">Penjualan 7 Hari Terakhir</h2>
                    <div class="relative h-72 w-full">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>

                <!-- Category Chart -->
                <div class="bg-white rounded-lg p-8 border border-bloom-accent-light">
                    <h2 class="text-xl font-light text-gray-900 mb-6">Kategori Terlaris</h2>
                    <div class="relative h-72 w-full">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white rounded-lg border border-bloom-accent-light overflow-hidden">
                <div class="px-8 py-6 border-b border-bloom-accent-light">
                    <h2 class="text-xl font-light text-gray-900">Pesanan Terbaru</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-bloom-admin-bg border-b border-bloom-accent-light">
                            <tr>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">No. Pesanan</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Pelanggan</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Total</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Status</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Tanggal</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders ?? [] as $order)
                                <tr class="border-b border-bloom-accent-light hover:bg-bloom-admin-bg transition">
                                    <td class="px-8 py-4 text-sm font-medium text-bloom-secondary">#{{ $order->order_number }}</td>
                                    <td class="px-8 py-4 text-sm text-gray-900">{{ $order->user->name ?? 'N/A' }}</td>
                                    <td class="px-8 py-4 text-sm font-medium text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td class="px-8 py-4 text-sm">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium 
                                            {{ in_array($order->status, ['completed', 'delivered']) ? 'bg-green-50 text-green-700' : 
                                               (in_array($order->status, ['pending', 'shipped']) ? 'bg-yellow-50 text-yellow-700' : 
                                               (in_array($order->status, ['confirmed']) ? 'bg-blue-50 text-blue-700' : 'bg-red-50 text-red-700')) }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-4 text-sm text-gray-600">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="px-8 py-4 text-sm">
                                        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="text-sm border-gray-300 rounded-lg focus:ring-bloom-primary focus:border-bloom-primary" onchange="this.form.submit()">
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
                                    <td colspan="6" class="px-8 py-8 text-center text-gray-500 font-light">Belum ada pesanan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Products Tab -->
        <div x-show="activeTab === 'products'" class="tab-content">
            <div class="bg-white rounded-lg border border-bloom-accent-light overflow-hidden">
                <div class="px-8 py-6 border-b border-bloom-accent-light">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-light text-gray-900">Daftar Produk</h2>
                        <a href="{{ route('admin.products.create') }}" class="text-bloom-secondary hover:text-bloom-primary font-medium transition">+ Tambah Produk</a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-bloom-admin-bg border-b border-bloom-accent-light">
                            <tr>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Nama Produk</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Kategori</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Harga</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Stok</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products ?? [] as $product)
                                <tr class="border-b border-bloom-accent-light hover:bg-bloom-admin-bg transition">
                                    <td class="px-8 py-4 text-sm font-medium text-gray-900">{{ $product->name }}</td>
                                    <td class="px-8 py-4 text-sm text-gray-600">{{ $product->category->name ?? 'N/A' }}</td>
                                    <td class="px-8 py-4 text-sm font-medium text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td class="px-8 py-4 text-sm text-gray-600">{{ $product->stock }} unit</td>
                                    <td class="px-8 py-4 text-sm space-x-2">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="text-bloom-secondary hover:text-bloom-primary font-medium">Edit</a>
                                        <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium" onclick="return confirm('Yakin hapus produk ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-8 text-center text-gray-500 font-light">Belum ada produk</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($products && $products->hasPages())
                <div class="px-8 py-4 border-t border-bloom-accent-light">
                    {{ $products->links() }}
                </div>
                @endif
            </div>
        </div>

        <!-- Categories Tab -->
        <div x-show="activeTab === 'categories'" class="tab-content">
            <div class="bg-white rounded-lg border border-bloom-accent-light overflow-hidden">
                <div class="px-8 py-6 border-b border-bloom-accent-light">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-light text-gray-900">Daftar Kategori</h2>
                        <a href="{{ route('admin.categories.create') }}" class="text-bloom-secondary hover:text-bloom-primary font-medium transition">+ Tambah Kategori</a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-bloom-admin-bg border-b border-bloom-accent-light">
                            <tr>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Nama Kategori</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Deskripsi</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Jumlah Produk</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories ?? [] as $category)
                                <tr class="border-b border-bloom-accent-light hover:bg-bloom-admin-bg transition">
                                    <td class="px-8 py-4 text-sm font-medium text-gray-900">{{ $category->name }}</td>
                                    <td class="px-8 py-4 text-sm text-gray-600">{{ Str::limit($category->description, 50) }}</td>
                                    <td class="px-8 py-4 text-sm text-gray-900 font-medium">{{ $category->products_count ?? 0 }}</td>
                                    <td class="px-8 py-4 text-sm space-x-2">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-bloom-secondary hover:text-bloom-primary font-medium">Edit</a>
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category->id) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium" onclick="return confirm('Yakin hapus kategori ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-8 text-center text-gray-500 font-light">Belum ada kategori</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($categories && $categories->hasPages())
                <div class="px-8 py-4 border-t border-bloom-accent-light">
                    {{ $categories->links() }}
                </div>
                @endif
            </div>
        </div>

        <!-- Orders Tab -->
        <div x-show="activeTab === 'orders'" class="tab-content">
            <div class="bg-white rounded-lg border border-bloom-accent-light overflow-hidden">
                <div class="px-8 py-6 border-b border-bloom-accent-light">
                    <h2 class="text-xl font-light text-gray-900">Daftar Pesanan</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-bloom-admin-bg border-b border-bloom-accent-light">
                            <tr>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">No. Pesanan</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Pelanggan</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Total</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Status</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Tanggal</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders ?? [] as $order)
                                <tr class="border-b border-bloom-accent-light hover:bg-bloom-admin-bg transition">
                                    <td class="px-8 py-4 text-sm font-medium text-bloom-secondary">#{{ $order->order_number }}</td>
                                    <td class="px-8 py-4 text-sm text-gray-900">{{ $order->user->name ?? 'N/A' }}</td>
                                    <td class="px-8 py-4 text-sm font-medium text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td class="px-8 py-4 text-sm">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium 
                                            {{ in_array($order->status, ['completed', 'delivered']) ? 'bg-green-50 text-green-700' : 
                                               (in_array($order->status, ['pending', 'shipped']) ? 'bg-yellow-50 text-yellow-700' : 
                                               (in_array($order->status, ['confirmed']) ? 'bg-blue-50 text-blue-700' : 'bg-red-50 text-red-700')) }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-4 text-sm text-gray-600">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="px-8 py-4 text-sm">
                                        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="text-sm border-gray-300 rounded-lg focus:ring-bloom-primary focus:border-bloom-primary" onchange="this.form.submit()">
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
                                    <td colspan="6" class="px-8 py-8 text-center text-gray-500 font-light">Belum ada pesanan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($orders && $orders->hasPages())
                <div class="px-8 py-4 border-t border-bloom-accent-light">
                    {{ $orders->links() }}
                </div>
                @endif
            </div>
        </div>

        <!-- Users Tab -->
        <div x-show="activeTab === 'users'" class="tab-content">
            <div class="bg-white rounded-lg border border-bloom-accent-light overflow-hidden">
                <div class="px-8 py-6 border-b border-bloom-accent-light">
                    <h2 class="text-xl font-light text-gray-900">Daftar Pengguna</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-bloom-admin-bg border-b border-bloom-accent-light">
                            <tr>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Nama</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Email</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Bergabung</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users ?? [] as $user)
                                <tr class="border-b border-bloom-accent-light hover:bg-bloom-admin-bg transition">
                                    <td class="px-8 py-4 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                    <td class="px-8 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                                    <td class="px-8 py-4 text-sm text-gray-600">{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="px-8 py-4 text-sm">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium 
                                            {{ $user->email_verified_at ? 'bg-green-50 text-green-700' : 'bg-yellow-50 text-yellow-700' }}">
                                            {{ $user->email_verified_at ? 'Verifikasi' : 'Pending' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-8 text-center text-gray-500 font-light">Belum ada pengguna</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($users && $users->hasPages())
                <div class="px-8 py-4 border-t border-bloom-accent-light">
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


