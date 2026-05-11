@extends('layouts.app')

@section('content')
<div class="bg-bloom-admin-bg min-h-screen">
    <!-- Header Section -->
    <div class="bg-white border-b border-bloom-accent-light py-12 mb-12">
        <div class="max-w-4xl mx-auto px-6">
            <a href="{{ route('admin.dashboard') }}" class="text-bloom-primary hover:text-bloom-secondary mb-4 inline-block">← Kembali</a>
            <h1 class="text-4xl font-light text-gray-900 mb-3">Edit Produk: {{ $product->name }}</h1>
        </div>
    </div>

    <!-- Form Section -->
    <div class="max-w-4xl mx-auto px-6 pb-20">
        <div class="bg-white rounded-lg border border-bloom-accent-light p-8">
            <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Informasi Produk -->
                <div>
                    <h2 class="text-xl font-light text-gray-900 mb-6">Informasi Produk</h2>
                    
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Produk</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required class="w-full px-4 py-2 border border-bloom-accent-light rounded-lg focus:ring-2 focus:ring-bloom-primary focus:border-transparent">
                            @error('name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                            <input type="text" id="slug" name="slug" value="{{ old('slug', $product->slug) }}" required class="w-full px-4 py-2 border border-bloom-accent-light rounded-lg focus:ring-2 focus:ring-bloom-primary focus:border-transparent">
                            @error('slug')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                            <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 border border-bloom-accent-light rounded-lg focus:ring-2 focus:ring-bloom-primary focus:border-transparent">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                            <select id="category_id" name="category_id" required class="w-full px-4 py-2 border border-bloom-accent-light rounded-lg focus:ring-2 focus:ring-bloom-primary focus:border-transparent">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Harga & Stok -->
                <div>
                    <h2 class="text-xl font-light text-gray-900 mb-6">Harga & Stok</h2>
                    
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Harga (Rp)</label>
                            <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" required min="0" class="w-full px-4 py-2 border border-bloom-accent-light rounded-lg focus:ring-2 focus:ring-bloom-primary focus:border-transparent">
                            @error('price')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">Stok</label>
                            <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required min="0" class="w-full px-4 py-2 border border-bloom-accent-light rounded-lg focus:ring-2 focus:ring-bloom-primary focus:border-transparent">
                            @error('stock')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Gambar Produk -->
                <div>
                    <h2 class="text-xl font-light text-gray-900 mb-6">Gambar Produk</h2>
                    
                    <div class="space-y-4">
                        @if($product->image)
                            <div>
                                <p class="text-sm text-gray-600 mb-2">Gambar Saat Ini:</p>
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-40 h-40 object-cover rounded-lg border border-bloom-accent-light">
                            </div>
                        @endif
                        
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Ganti Gambar (Opsional)</label>
                            <input type="file" id="image" name="image" accept="image/*" class="w-full px-4 py-2 border border-bloom-accent-light rounded-lg focus:ring-2 focus:ring-bloom-primary focus:border-transparent">
                            @error('image')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, WebP (Max 5MB)</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 pt-6 border-t border-bloom-accent-light">
                    <button type="submit" class="px-6 py-2 bg-bloom-secondary hover:bg-bloom-secondary/90 text-white font-medium rounded-lg transition">
                        Update Produk
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-900 font-medium rounded-lg transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection



