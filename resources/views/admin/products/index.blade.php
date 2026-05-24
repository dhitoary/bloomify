@extends('layouts.app')

@section('content')
<div class="bg-bloom-admin-bg min-h-screen">
    <!-- Header Section -->
    <div class="bg-white border-b border-bloom-accent-light py-12 mb-12">
        <div class="max-w-6xl mx-auto px-6">
            <a href="{{ route('admin.dashboard') }}" class="text-bloom-primary hover:text-bloom-secondary mb-4 inline-block">← Kembali</a>
            <h1 class="text-4xl font-light text-gray-900 mb-3">Daftar Produk</h1>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-6 pb-20">
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-lg border border-bloom-accent-light overflow-hidden">
            <div class="px-8 py-6 border-b border-bloom-accent-light flex justify-between items-center">
                <h2 class="text-xl font-light text-gray-900">Daftar Produk</h2>
                <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-bloom-secondary hover:bg-bloom-secondary/90 text-white font-medium rounded-lg transition">
                    + Tambah Produk
                </a>
            </div>

            <!-- Simple Search & Filter Bar -->
            <form method="GET" action="{{ route('admin.products.index') }}" class="px-8 py-4 border-b border-bloom-accent-light bg-bloom-admin-bg/50">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end">
                    <!-- Search -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-2 uppercase">Cari Produk</label>
                        <input type="text" name="search" placeholder="Nama produk..." 
                            value="{{ request('search') }}" 
                            class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-bloom-primary">
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-2 uppercase">Kategori</label>
                        <select name="category" class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-bloom-primary">
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
                        <label class="block text-xs font-semibold text-gray-600 mb-2 uppercase">Status Stok</label>
                        <select name="stock_status" class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-bloom-primary">
                            <option value="">Semua</option>
                            <option value="available" {{ request('stock_status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                            <option value="limited" {{ request('stock_status') == 'limited' ? 'selected' : '' }}>Terbatas</option>
                            <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Habis</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 px-3 py-2 bg-bloom-primary hover:bg-bloom-primary/90 text-white text-sm font-medium rounded transition">
                            Cari
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="flex-1 px-3 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 text-sm font-medium rounded transition text-center">
                            Reset
                        </a>
                    </div>
                </div>

                <!-- Active Filters Info -->
                @php
                    $hasFilters = request('search') || request('category') || request('stock_status');
                @endphp
                @if($hasFilters)
                    <div class="mt-3 pt-3 border-t border-gray-300 text-xs text-gray-600">
                        Filter aktif:
                        @if(request('search')) <span class="ml-2 px-2 py-1 bg-bloom-primary/10 text-bloom-primary rounded">🔍 {{ request('search') }}</span> @endif
                        @if(request('category')) <span class="ml-2 px-2 py-1 bg-bloom-primary/10 text-bloom-primary rounded">📁 {{ $categories->find(request('category'))?->name }}</span> @endif
                        @if(request('stock_status')) <span class="ml-2 px-2 py-1 bg-bloom-primary/10 text-bloom-primary rounded">📊 {{ request('stock_status') === 'available' ? 'Tersedia' : (request('stock_status') === 'limited' ? 'Terbatas' : 'Habis') }}</span> @endif
                    </div>
                @endif
            </form>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-bloom-accent/10 border-b border-bloom-accent-light">
                        <tr>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Gambar</th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Nama Produk</th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Kategori</th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Harga</th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Stok</th>
                            <th class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr class="border-b border-bloom-accent-light hover:bg-bloom-admin-bg transition">
                                <td class="px-8 py-4">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded">
                                    @else
                                        <div class="w-12 h-12 bg-bloom-admin-bg rounded flex items-center justify-center">
                                            <span class="text-bloom-accent-light">No Image</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-8 py-4 text-sm font-medium text-gray-900">{{ $product->name }}</td>
                                <td class="px-8 py-4 text-sm text-gray-600">{{ $product->category->name ?? 'N/A' }}</td>
                                <td class="px-8 py-4 text-sm font-medium text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="px-8 py-4 text-sm">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium 
                                        {{ $product->stock > 5 ? 'bg-green-50 text-green-700' : 
                                           ($product->stock > 0 ? 'bg-yellow-50 text-yellow-700' : 
                                           'bg-red-50 text-red-700') }}">
                                        {{ $product->stock }} unit
                                    </span>
                                </td>
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
                                <td colspan="6" class="px-8 py-12 text-center text-gray-500 font-light">Tidak ada produk yang sesuai dengan filter</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($products->hasPages())
            <div class="px-8 py-4 border-t border-bloom-accent-light bg-white">
                {{ $products->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection



