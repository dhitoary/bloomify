<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-bloom-teal leading-tight">
                {{ __('Dashboard Pengguna') }}
            </h2>
            <p class="text-gray-600 text-sm mt-1">Selamat datang kembali, {{ Auth::user()->name }}!</p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-gradient-to-r from-bloom-teal to-bloom-teal-light rounded-lg shadow-md overflow-hidden mb-8">
                <div class="p-8 text-white">
                    <h3 class="text-2xl font-bold mb-2">Selamat Datang di Bloomify</h3>
                    <p class="text-bloom-cream">Jelajahi koleksi bunga premium kami dan temukan yang sempurna untuk orang terkasih Anda.</p>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-bloom-teal">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Pesanan Saya</p>
                            <p class="text-3xl font-bold text-bloom-teal">0</p>
                        </div>
                        <div class="w-12 h-12 bg-bloom-mint-light rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-bloom-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-bloom-coral">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Keranjang Saya</p>
                            <p class="text-3xl font-bold text-bloom-coral">0</p>
                        </div>
                        <div class="w-12 h-12 bg-bloom-cream rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-bloom-coral" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-bloom-mint">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Total Belanja</p>
                            <p class="text-3xl font-bold text-bloom-mint">Rp 0</p>
                        </div>
                        <div class="w-12 h-12 bg-bloom-mint-light rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-bloom-mint" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Section -->
            <div class="mb-12">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-bloom-teal">Produk Terbaru</h3>
                    <a href="{{ route('products.index') }}" class="text-bloom-teal hover:text-bloom-coral font-semibold transition">
                        Lihat Semua →
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
                            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 transform hover:scale-105">
                                <div class="relative overflow-hidden h-48 bg-bloom-cream">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h4 class="font-semibold text-gray-900 mb-1 line-clamp-2">{{ $product->name }}</h4>
                                    <p class="text-2xl font-bold text-bloom-coral">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    <span class="text-xs text-gray-500">Stok: {{ $product->stock }}</span>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full text-center py-8">
                            <p class="text-gray-500">Belum ada produk tersedia</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Account Section -->
            <div class="bg-white rounded-lg shadow-md p-8">
                <h3 class="text-2xl font-bold text-bloom-teal mb-6">Akun Saya</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-3">Informasi Profil</h4>
                        <p class="text-gray-700 mb-2"><strong>Nama:</strong> {{ Auth::user()->name }}</p>
                        <p class="text-gray-700 mb-4"><strong>Email:</strong> {{ Auth::user()->email }}</p>
                        <a href="{{ route('profile.edit') }}" class="inline-block bg-bloom-teal text-white px-6 py-2 rounded-lg hover:bg-bloom-teal-light transition">
                            Edit Profil
                        </a>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-3">Bantuan & Dukungan</h4>
                        <ul class="space-y-2 text-gray-700">
                            <li><a href="#" class="text-bloom-teal hover:underline">Pertanyaan Umum</a></li>
                            <li><a href="#" class="text-bloom-teal hover:underline">Kebijakan Pengiriman</a></li>
                            <li><a href="#" class="text-bloom-teal hover:underline">Hubungi Customer Service</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
