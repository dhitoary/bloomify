@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="bg-bloom-ivory min-h-screen" x-data="{ activeTab: 'overview' }">
    <!-- Header Section -->
    <div class="bg-white border-b border-bloom-mint-light py-12 mb-12">
        <div class="max-w-7xl mx-auto px-6">
            <h1 class="text-5xl font-light text-gray-900 mb-3">Dashboard Admin</h1>
            <p class="text-gray-600 font-light text-lg">Selamat datang, <span class="text-bloom-teal">{{ Auth::user()->name }}</span></p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-6 pb-20">
        <!-- Tab Navigation -->
        <div class="mb-12 flex space-x-8 border-b border-bloom-mint-light">
            <button @click="activeTab = 'overview'" :class="activeTab === 'overview' ? 'text-gray-900 border-b-2 border-bloom-teal' : 'text-gray-500 hover:text-gray-700'" class="pb-4 font-medium transition">Overview</button>
            <button @click="activeTab = 'products'" :class="activeTab === 'products' ? 'text-gray-900 border-b-2 border-bloom-teal' : 'text-gray-500 hover:text-gray-700'" class="pb-4 font-medium transition">Produk</button>
            <button @click="activeTab = 'categories'" :class="activeTab === 'categories' ? 'text-gray-900 border-b-2 border-bloom-teal' : 'text-gray-500 hover:text-gray-700'" class="pb-4 font-medium transition">Kategori</button>
            <button @click="activeTab = 'orders'" :class="activeTab === 'orders' ? 'text-gray-900 border-b-2 border-bloom-teal' : 'text-gray-500 hover:text-gray-700'" class="pb-4 font-medium transition">Pesanan</button>
            <button @click="activeTab = 'users'" :class="activeTab === 'users' ? 'text-gray-900 border-b-2 border-bloom-teal' : 'text-gray-500 hover:text-gray-700'" class="pb-4 font-medium transition">Pengguna</button>
        </div>

        <!-- Overview Tab -->
        <div x-show="activeTab === 'overview'" class="tab-content">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <!-- Total Pesanan -->
                <div class="bg-white rounded-lg p-6 border border-bloom-mint-light hover:shadow-lg transition">
                    <p class="text-gray-600 text-sm font-medium uppercase tracking-wide mb-4">Total Pesanan</p>
                    <p class="text-4xl font-light text-gray-900">{{ $totalOrders ?? 0 }}</p>
                    <p class="text-bloom-coral text-sm mt-3 font-light">{{ $ordersThisMonth ?? 0 }} bulan ini</p>
                </div>

                <!-- Total Penjualan -->
                <div class="bg-white rounded-lg p-6 border border-bloom-mint-light hover:shadow-lg transition">
                    <p class="text-gray-600 text-sm font-medium uppercase tracking-wide mb-4">Total Penjualan</p>
                    <p class="text-3xl font-light text-gray-900">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>
                    <p class="text-bloom-coral text-sm mt-3 font-light">Bulan ini</p>
                </div>

                <!-- Total Produk -->
                <div class="bg-white rounded-lg p-6 border border-bloom-mint-light hover:shadow-lg transition">
                    <p class="text-gray-600 text-sm font-medium uppercase tracking-wide mb-4">Total Produk</p>
                    <p class="text-4xl font-light text-gray-900">{{ $totalProducts ?? 0 }}</p>
                    <p class="text-bloom-coral text-sm mt-3 font-light">Aktif tersedia</p>
                </div>

                <!-- Total Pengguna -->
                <div class="bg-white rounded-lg p-6 border border-bloom-mint-light hover:shadow-lg transition">
                    <p class="text-gray-600 text-sm font-medium uppercase tracking-wide mb-4">Total Pengguna</p>
                    <p class="text-4xl font-light text-gray-900">{{ $totalUsers ?? 0 }}</p>
                    <p class="text-bloom-coral text-sm mt-3 font-light">+ {{ $newUsersThisMonth ?? 0 }} baru</p>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 gap-8 mb-12">
                <!-- Sales Chart -->
                <div class="bg-white rounded-lg p-8 border border-bloom-mint-light">
                    <h2 class="text-xl font-light text-gray-900 mb-6">Penjualan 7 Hari Terakhir</h2>
                    <canvas id="salesChart" height="70"></canvas>
                </div>

                <!-- Category Chart -->
                <div class="bg-white rounded-lg p-8 border border-bloom-mint-light">
                    <h2 class="text-xl font-light text-gray-900 mb-6">Kategori Terlaris</h2>
                    <canvas id="categoryChart" height="70"></canvas>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white rounded-lg border border-bloom-mint-light overflow-hidden">
                <div class="px-8 py-6 border-b border-bloom-mint-light">
                    <h2 class="text-xl font-light text-gray-900">Pesanan Terbaru</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-bloom-cream border-b border-bloom-mint-light">
                            <tr>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">No. Pesanan</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Pelanggan</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Total</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Status</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders ?? [] as $order)
                                <tr class="border-b border-bloom-mint-light hover:bg-bloom-cream transition">
                                    <td class="px-8 py-4 text-sm font-medium text-bloom-coral">#{{ $order->order_number }}</td>
                                    <td class="px-8 py-4 text-sm text-gray-900">{{ $order->user->name ?? 'N/A' }}</td>
                                    <td class="px-8 py-4 text-sm font-medium text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td class="px-8 py-4 text-sm">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium 
                                            {{ $order->status === 'completed' ? 'bg-green-50 text-green-700' : 
                                               ($order->status === 'pending' ? 'bg-yellow-50 text-yellow-700' : 
                                               'bg-red-50 text-red-700') }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-4 text-sm text-gray-600">{{ $order->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-8 text-center text-gray-500 font-light">Belum ada pesanan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Products Tab -->
        <div x-show="activeTab === 'products'" class="tab-content">
            <div class="bg-white rounded-lg border border-bloom-mint-light overflow-hidden">
                <div class="px-8 py-6 border-b border-bloom-mint-light">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-light text-gray-900">Daftar Produk</h2>
                        <a href="{{ route('admin.products.create') }}" class="text-bloom-coral hover:text-bloom-teal font-medium transition">+ Tambah Produk</a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-bloom-cream border-b border-bloom-mint-light">
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
                                <tr class="border-b border-bloom-mint-light hover:bg-bloom-cream transition">
                                    <td class="px-8 py-4 text-sm font-medium text-gray-900">{{ $product->name }}</td>
                                    <td class="px-8 py-4 text-sm text-gray-600">{{ $product->category->name ?? 'N/A' }}</td>
                                    <td class="px-8 py-4 text-sm font-medium text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td class="px-8 py-4 text-sm text-gray-600">{{ $product->stock }} unit</td>
                                    <td class="px-8 py-4 text-sm space-x-2">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="text-bloom-coral hover:text-bloom-teal font-medium">Edit</a>
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
                <div class="px-8 py-4 border-t border-bloom-mint-light">
                    {{ $products->links() }}
                </div>
                @endif
            </div>
        </div>

        <!-- Categories Tab -->
        <div x-show="activeTab === 'categories'" class="tab-content">
            <div class="bg-white rounded-lg border border-bloom-mint-light overflow-hidden">
                <div class="px-8 py-6 border-b border-bloom-mint-light">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-light text-gray-900">Daftar Kategori</h2>
                        <a href="{{ route('admin.categories.create') }}" class="text-bloom-coral hover:text-bloom-teal font-medium transition">+ Tambah Kategori</a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-bloom-cream border-b border-bloom-mint-light">
                            <tr>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Nama Kategori</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Deskripsi</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Jumlah Produk</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories ?? [] as $category)
                                <tr class="border-b border-bloom-mint-light hover:bg-bloom-cream transition">
                                    <td class="px-8 py-4 text-sm font-medium text-gray-900">{{ $category->name }}</td>
                                    <td class="px-8 py-4 text-sm text-gray-600">{{ Str::limit($category->description, 50) }}</td>
                                    <td class="px-8 py-4 text-sm text-gray-900 font-medium">{{ $category->products_count ?? 0 }}</td>
                                    <td class="px-8 py-4 text-sm space-x-2">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-bloom-coral hover:text-bloom-teal font-medium">Edit</a>
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
                <div class="px-8 py-4 border-t border-bloom-mint-light">
                    {{ $categories->links() }}
                </div>
                @endif
            </div>
        </div>

        <!-- Orders Tab -->
        <div x-show="activeTab === 'orders'" class="tab-content">
            <div class="bg-white rounded-lg border border-bloom-mint-light overflow-hidden">
                <div class="px-8 py-6 border-b border-bloom-mint-light">
                    <h2 class="text-xl font-light text-gray-900">Daftar Pesanan</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-bloom-cream border-b border-bloom-mint-light">
                            <tr>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">No. Pesanan</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Pelanggan</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Total</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Status</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders ?? [] as $order)
                                <tr class="border-b border-bloom-mint-light hover:bg-bloom-cream transition">
                                    <td class="px-8 py-4 text-sm font-medium text-bloom-coral">#{{ $order->order_number }}</td>
                                    <td class="px-8 py-4 text-sm text-gray-900">{{ $order->user->name ?? 'N/A' }}</td>
                                    <td class="px-8 py-4 text-sm font-medium text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td class="px-8 py-4 text-sm">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium 
                                            {{ $order->status === 'completed' ? 'bg-green-50 text-green-700' : 
                                               ($order->status === 'pending' ? 'bg-yellow-50 text-yellow-700' : 
                                               'bg-red-50 text-red-700') }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-4 text-sm text-gray-600">{{ $order->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-8 text-center text-gray-500 font-light">Belum ada pesanan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($orders && $orders->hasPages())
                <div class="px-8 py-4 border-t border-bloom-mint-light">
                    {{ $orders->links() }}
                </div>
                @endif
            </div>
        </div>

        <!-- Users Tab -->
        <div x-show="activeTab === 'users'" class="tab-content">
            <div class="bg-white rounded-lg border border-bloom-mint-light overflow-hidden">
                <div class="px-8 py-6 border-b border-bloom-mint-light">
                    <h2 class="text-xl font-light text-gray-900">Daftar Pengguna</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-bloom-cream border-b border-bloom-mint-light">
                            <tr>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Nama</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Email</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Bergabung</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users ?? [] as $user)
                                <tr class="border-b border-bloom-mint-light hover:bg-bloom-cream transition">
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
                <div class="px-8 py-4 border-t border-bloom-mint-light">
                    {{ $users->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    // Sales Chart
    const salesCtx = document.getElementById('salesChart');
    if (salesCtx) {
        new Chart(salesCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: ['Hari 1', 'Hari 2', 'Hari 3', 'Hari 4', 'Hari 5', 'Hari 6', 'Hari 7'],
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
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#999', font: { size: 11 } },
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
        const catSalesData = {{ json_encode($categorySales ?? []) }};
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
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: '#666', font: { size: 12, weight: '500' }, padding: 15 }
                    }
                }
            }
        });
    }
</script>
@endsection
