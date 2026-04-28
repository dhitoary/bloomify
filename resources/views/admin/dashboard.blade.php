<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Bloomify</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-stone-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-stone-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-5">
            <a href="/" class="text-2xl font-semibold text-stone-900">Bloomify</a>
            <ul class="flex space-x-8 font-medium text-stone-700 items-center">
                <li><a href="/" class="hover:text-rose-600 transition">Beranda</a></li>
                
                <!-- Profile Dropdown -->
                <li class="relative group">
                    <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-3 hover:text-rose-600 transition py-2 px-3 rounded-lg hover:bg-stone-50">
                        <div class="w-9 h-9 bg-gradient-to-br from-rose-500 to-rose-600 rounded-full flex items-center justify-center text-white font-semibold text-sm overflow-hidden">
                            @if(Auth::user()->profile_picture)
                                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile" class="w-full h-full object-cover">
                            @else
                                {{ substr(Auth::user()->name, 0, 1) }}
                            @endif
                        </div>
                        <span class="text-sm">{{ Auth::user()->name }}</span>
                    </a>
                </li>

                <li>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-rose-600 transition">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto py-16 px-6">
        <!-- Header -->
        <div class="mb-16">
            <h1 class="text-5xl font-light text-stone-900 mb-3">Dashboard Admin</h1>
            <p class="text-stone-600 text-lg font-light">Selamat datang, <span class="text-rose-600">{{ Auth::user()->name }}</span></p>
        </div>

        <!-- Tab Navigation -->
        <div class="mb-12 flex space-x-8 border-b border-stone-300">
            <button onclick="showTab(event, 'overview')" class="tab-btn active pb-4 font-medium text-stone-900 border-b-2 border-rose-600 hover:text-rose-600 transition">Overview</button>
            <button onclick="showTab(event, 'products')" class="tab-btn pb-4 font-medium text-stone-500 hover:text-stone-700 transition">Produk</button>
            <button onclick="showTab(event, 'categories')" class="tab-btn pb-4 font-medium text-stone-500 hover:text-stone-700 transition">Kategori</button>
            <button onclick="showTab(event, 'orders')" class="tab-btn pb-4 font-medium text-stone-500 hover:text-stone-700 transition">Pesanan</button>
            <button onclick="showTab(event, 'users')" class="tab-btn pb-4 font-medium text-stone-500 hover:text-stone-700 transition">Pengguna</button>
        </div>

        <!-- Overview Tab -->
        <div id="overview" class="tab-content">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <!-- Total Pesanan -->
                <div class="bg-white rounded-lg p-6 border border-stone-200 hover:shadow-lg transition">
                    <p class="text-stone-600 text-sm font-medium uppercase tracking-wide mb-4">Total Pesanan</p>
                    <p class="text-4xl font-light text-stone-900">{{ $totalOrders ?? 0 }}</p>
                    <p class="text-rose-600 text-sm mt-3 font-light">{{ $ordersThisMonth ?? 0 }} bulan ini</p>
                </div>

                <!-- Total Penjualan -->
                <div class="bg-white rounded-lg p-6 border border-stone-200 hover:shadow-lg transition">
                    <p class="text-stone-600 text-sm font-medium uppercase tracking-wide mb-4">Total Penjualan</p>
                    <p class="text-3xl font-light text-stone-900">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>
                    <p class="text-rose-600 text-sm mt-3 font-light">Bulan ini</p>
                </div>

                <!-- Total Produk -->
                <div class="bg-white rounded-lg p-6 border border-stone-200 hover:shadow-lg transition">
                    <p class="text-stone-600 text-sm font-medium uppercase tracking-wide mb-4">Total Produk</p>
                    <p class="text-4xl font-light text-stone-900">{{ $totalProducts ?? 0 }}</p>
                    <p class="text-rose-600 text-sm mt-3 font-light">Aktif tersedia</p>
                </div>

                <!-- Total Pengguna -->
                <div class="bg-white rounded-lg p-6 border border-stone-200 hover:shadow-lg transition">
                    <p class="text-stone-600 text-sm font-medium uppercase tracking-wide mb-4">Total Pengguna</p>
                    <p class="text-4xl font-light text-stone-900">{{ $totalUsers ?? 0 }}</p>
                    <p class="text-rose-600 text-sm mt-3 font-light">+ {{ $newUsersThisMonth ?? 0 }} baru</p>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 gap-8 mb-12">
                <!-- Sales Chart -->
                <div class="bg-white rounded-lg p-8 border border-stone-200">
                    <h2 class="text-xl font-light text-stone-900 mb-6">Penjualan 7 Hari Terakhir</h2>
                    <canvas id="salesChart" height="70"></canvas>
                </div>

                <!-- Category Chart -->
                <div class="bg-white rounded-lg p-8 border border-stone-200">
                    <h2 class="text-xl font-light text-stone-900 mb-6">Kategori Terlaris</h2>
                    <canvas id="categoryChart" height="70"></canvas>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white rounded-lg border border-stone-200 overflow-hidden">
                <div class="px-8 py-6 border-b border-stone-200">
                    <h2 class="text-xl font-light text-stone-900">Pesanan Terbaru</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-stone-50 border-b border-stone-200">
                            <tr>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-stone-700 uppercase">No. Pesanan</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-stone-700 uppercase">Pelanggan</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-stone-700 uppercase">Total</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-stone-700 uppercase">Status</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-stone-700 uppercase">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders ?? [] as $order)
                                <tr class="border-b border-stone-200 hover:bg-stone-50 transition">
                                    <td class="px-8 py-4 text-sm font-medium text-rose-600">#{{ $order->order_number }}</td>
                                    <td class="px-8 py-4 text-sm text-stone-900">{{ $order->user->name ?? 'N/A' }}</td>
                                    <td class="px-8 py-4 text-sm font-medium text-stone-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td class="px-8 py-4 text-sm">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium 
                                            {{ $order->status === 'completed' ? 'bg-green-50 text-green-700' : 
                                               ($order->status === 'pending' ? 'bg-yellow-50 text-yellow-700' : 
                                               'bg-red-50 text-red-700') }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-4 text-sm text-stone-600">{{ $order->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-8 text-center text-stone-500 font-light">Belum ada pesanan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Products Tab -->
        <div id="products" class="tab-content hidden">
            <div class="bg-white rounded-lg border border-stone-200 overflow-hidden">
                <div class="px-8 py-6 border-b border-stone-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-light text-stone-900">Daftar Produk</h2>
                        <a href="/admin-panel/products/create" class="text-rose-600 hover:text-rose-700 font-medium transition">+ Tambah Produk</a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-stone-50 border-b border-stone-200">
                            <tr>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-stone-700 uppercase">Nama Produk</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-stone-700 uppercase">Kategori</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-stone-700 uppercase">Harga</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-stone-700 uppercase">Stok</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-stone-700 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products ?? [] as $product)
                                <tr class="border-b border-stone-200 hover:bg-stone-50 transition">
                                    <td class="px-8 py-4 text-sm font-medium text-stone-900">{{ $product->name }}</td>
                                    <td class="px-8 py-4 text-sm text-stone-600">{{ $product->category->name ?? 'N/A' }}</td>
                                    <td class="px-8 py-4 text-sm font-medium text-stone-900">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td class="px-8 py-4 text-sm text-stone-600">{{ $product->stock }} unit</td>
                                    <td class="px-8 py-4 text-sm space-x-2">
                                        <a href="/admin-panel/products/{{ $product->id }}/edit" class="text-rose-600 hover:text-rose-700 font-medium">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-8 text-center text-stone-500 font-light">Belum ada produk</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($products && $products->hasPages())
                <div class="px-8 py-4 border-t border-stone-200">
                    {{ $products->links() }}
                </div>
                @endif
            </div>
        </div>

        <!-- Categories Tab -->
        <div id="categories" class="tab-content hidden">
            <div class="bg-white rounded-lg border border-stone-200 overflow-hidden">
                <div class="px-8 py-6 border-b border-stone-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-light text-stone-900">Daftar Kategori</h2>
                        <a href="/admin-panel/categories/create" class="text-rose-600 hover:text-rose-700 font-medium transition">+ Tambah Kategori</a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-stone-50 border-b border-stone-200">
                            <tr>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-stone-700 uppercase">Nama Kategori</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-stone-700 uppercase">Deskripsi</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-stone-700 uppercase">Jumlah Produk</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-stone-700 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories ?? [] as $category)
                                <tr class="border-b border-stone-200 hover:bg-stone-50 transition">
                                    <td class="px-8 py-4 text-sm font-medium text-stone-900">{{ $category->name }}</td>
                                    <td class="px-8 py-4 text-sm text-stone-600">{{ Str::limit($category->description, 50) }}</td>
                                    <td class="px-8 py-4 text-sm text-stone-900 font-medium">{{ $category->products_count ?? 0 }}</td>
                                    <td class="px-8 py-4 text-sm space-x-2">
                                        <a href="/admin-panel/categories/{{ $category->id }}/edit" class="text-rose-600 hover:text-rose-700 font-medium">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-8 text-center text-stone-500 font-light">Belum ada kategori</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($categories && $categories->hasPages())
                <div class="px-8 py-4 border-t border-stone-200">
                    {{ $categories->links() }}
                </div>
                @endif
            </div>
        </div>

        <!-- Orders Tab -->
        <div id="orders" class="tab-content hidden">
            <div class="bg-white rounded-lg border border-stone-200 overflow-hidden">
                <div class="px-8 py-6 border-b border-stone-200">
                    <h2 class="text-xl font-light text-stone-900">Daftar Pesanan</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-stone-50 border-b border-stone-200">
                            <tr>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-stone-700 uppercase">No. Pesanan</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-stone-700 uppercase">Pelanggan</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-stone-700 uppercase">Total</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-stone-700 uppercase">Status</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-stone-700 uppercase">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders ?? [] as $order)
                                <tr class="border-b border-stone-200 hover:bg-stone-50 transition">
                                    <td class="px-8 py-4 text-sm font-medium text-rose-600">#{{ $order->order_number }}</td>
                                    <td class="px-8 py-4 text-sm text-stone-900">{{ $order->user->name ?? 'N/A' }}</td>
                                    <td class="px-8 py-4 text-sm font-medium text-stone-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td class="px-8 py-4 text-sm">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium 
                                            {{ $order->status === 'completed' ? 'bg-green-50 text-green-700' : 
                                               ($order->status === 'pending' ? 'bg-yellow-50 text-yellow-700' : 
                                               'bg-red-50 text-red-700') }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-4 text-sm text-stone-600">{{ $order->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-8 text-center text-stone-500 font-light">Belum ada pesanan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($orders && $orders->hasPages())
                <div class="px-8 py-4 border-t border-stone-200">
                    {{ $orders->links() }}
                </div>
                @endif
            </div>
        </div>

        <!-- Users Tab -->
        <div id="users" class="tab-content hidden">
            <div class="bg-white rounded-lg border border-stone-200 overflow-hidden">
                <div class="px-8 py-6 border-b border-stone-200">
                    <h2 class="text-xl font-light text-stone-900">Daftar Pengguna</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-stone-50 border-b border-stone-200">
                            <tr>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-stone-700 uppercase">Nama</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-stone-700 uppercase">Email</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-stone-700 uppercase">Bergabung</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold text-stone-700 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users ?? [] as $user)
                                <tr class="border-b border-stone-200 hover:bg-stone-50 transition">
                                    <td class="px-8 py-4 text-sm font-medium text-stone-900">{{ $user->name }}</td>
                                    <td class="px-8 py-4 text-sm text-stone-600">{{ $user->email }}</td>
                                    <td class="px-8 py-4 text-sm text-stone-600">{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="px-8 py-4 text-sm">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium 
                                            {{ $user->email_verified_at ? 'bg-green-50 text-green-700' : 'bg-yellow-50 text-yellow-700' }}">
                                            {{ $user->email_verified_at ? 'Verifikasi' : 'Pending' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-8 text-center text-stone-500 font-light">Belum ada pengguna</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($users && $users->hasPages())
                <div class="px-8 py-4 border-t border-stone-200">
                    {{ $users->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Tab functionality - Fixed version
        function showTab(event, tabName) {
            event.preventDefault();
            
            // Hide all tabs
            const tabs = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => tab.classList.add('hidden'));
            
            // Reset all buttons
            const buttons = document.querySelectorAll('.tab-btn');
            buttons.forEach(btn => {
                btn.classList.remove('border-b-2', 'border-rose-600', 'text-stone-900');
                btn.classList.add('text-stone-500');
            });
            
            // Show selected tab
            const selectedTab = document.getElementById(tabName);
            if (selectedTab) {
                selectedTab.classList.remove('hidden');
            }
            
            // Highlight selected button
            const button = event.currentTarget;
            if (button) {
                button.classList.remove('text-stone-500');
                button.classList.add('text-stone-900', 'border-b-2', 'border-rose-600');
            }
        }

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
                        borderColor: '#E11D48',
                        backgroundColor: 'rgba(225, 29, 72, 0.08)',
                        tension: 0.3,
                        fill: true,
                        pointRadius: 5,
                        pointBackgroundColor: '#E11D48',
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
                        backgroundColor: ['#E11D48', '#F43F5E', '#FBBF24', '#DDD6FE', '#C084FC', '#A78BFA'],
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
</body>
</html>
