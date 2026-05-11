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
                <h2 class="text-xl font-light text-gray-900">Produk</h2>
                <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-bloom-secondary hover:bg-bloom-secondary/90 text-white font-medium rounded-lg transition">
                    + Tambah Produk
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-bloom-admin-bg border-b border-bloom-accent-light">
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
                                <td colspan="6" class="px-8 py-12 text-center text-gray-500 font-light">Belum ada produk</td>
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



