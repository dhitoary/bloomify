<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Bloomify</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-stone-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-stone-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-5">
            <a href="/" class="text-2xl font-semibold text-stone-900">Bloomify</a>
            <ul class="flex space-x-8 font-medium text-stone-700 items-center">
                <li><a href="/" class="hover:text-rose-600 transition">Beranda</a></li>
                <li><a href="{{ route('products.index') }}" class="hover:text-rose-600 transition">Katalog</a></li>
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
            <h1 class="text-5xl font-light text-stone-900 mb-3">Dashboard</h1>
            <p class="text-stone-600 text-lg font-light">Selamat datang, <span class="text-rose-600">{{ Auth::user()->name }}</span></p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <!-- Pesanan Saya -->
            <div class="bg-white rounded-lg p-6 border border-stone-200 hover:shadow-lg transition">
                <p class="text-stone-600 text-sm font-medium uppercase tracking-wide mb-4">Pesanan Saya</p>
                <p class="text-4xl font-light text-stone-900">0</p>
                <p class="text-stone-500 text-sm mt-3 font-light">Belum ada pesanan</p>
            </div>

            <!-- Keranjang Saya -->
            <div class="bg-white rounded-lg p-6 border border-stone-200 hover:shadow-lg transition">
                <p class="text-stone-600 text-sm font-medium uppercase tracking-wide mb-4">Keranjang Saya</p>
                <p class="text-4xl font-light text-stone-900">0</p>
                <p class="text-stone-500 text-sm mt-3 font-light">Item dalam keranjang</p>
            </div>

            <!-- Total Belanja -->
            <div class="bg-white rounded-lg p-6 border border-stone-200 hover:shadow-lg transition">
                <p class="text-stone-600 text-sm font-medium uppercase tracking-wide mb-4">Total Belanja</p>
                <p class="text-4xl font-light text-stone-900">Rp 0</p>
                <p class="text-stone-500 text-sm mt-3 font-light">Tahun ini</p>
            </div>
        </div>

        <!-- Featured Products -->
        <div class="mb-16">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-light text-stone-900">Produk Rekomendasi</h2>
                <a href="{{ route('products.index') }}" class="text-rose-600 hover:text-rose-700 font-medium transition">
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
                        <div class="bg-white rounded-lg border border-stone-200 overflow-hidden hover:shadow-md transition duration-300">
                            <div class="relative overflow-hidden h-48 bg-stone-100">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-stone-300 text-4xl font-light">🌸</div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h4 class="font-medium text-stone-900 mb-3 line-clamp-2 group-hover:text-rose-600 transition text-sm">{{ $product->name }}</h4>
                                <p class="text-rose-600 font-medium text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <p class="text-stone-500 text-xs mt-2 font-light">Stok: {{ $product->stock }} unit</p>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-stone-500 text-lg font-light">Belum ada produk tersedia</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Profile Section -->
        <div class="bg-white rounded-lg border border-stone-200 overflow-hidden">
            <div class="px-8 py-6 border-b border-stone-200">
                <h2 class="text-2xl font-light text-stone-900">Profil Saya</h2>
            </div>
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <p class="text-stone-600 text-xs font-semibold uppercase mb-3">Nama</p>
                        <p class="text-2xl font-light text-stone-900">{{ Auth::user()->name }}</p>
                    </div>
                    <div>
                        <p class="text-stone-600 text-xs font-semibold uppercase mb-3">Email</p>
                        <p class="text-2xl font-light text-stone-900">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="text-rose-600 hover:text-rose-700 font-medium transition">
                    Edit Profil
                </a>
            </div>
        </div>
    </div>
</body>
</html>
