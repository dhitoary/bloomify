@extends('layouts.app')

@section('content')
<div style="background: linear-gradient(135deg, rgba(236, 145, 195, 0.1) 0%, rgba(218, 69, 130, 0.05) 100%); min-height: 100vh;">
    <!-- Header Section -->
    <div style="background: #ffffff; border-bottom: 2px solid #EC91C3;" class="py-12 mb-12">
        <div class="max-w-4xl mx-auto px-6">
            <a href="{{ route('admin.dashboard') }}" style="color: #DA4582;" class="hover:opacity-80 mb-4 inline-block font-medium transition">← Kembali</a>
            <h1 style="color: #9F254F;" class="text-4xl font-light mb-2">Tambah Produk Baru</h1>
            <p style="color: #7A7A7A;" class="text-sm">Isi formulir di bawah untuk menambahkan produk baru ke toko Anda</p>
        </div>
    </div>

    <!-- Form Section -->
    <div class="max-w-4xl mx-auto px-6 pb-20">
        <div style="background: #ffffff; border: 2px solid #EC91C3;" class="rounded-2xl overflow-hidden shadow-sm">
            <div style="background: linear-gradient(to right, #DA4582, #EC91C3); border-bottom: 2px solid #9F254F;" class="px-8 py-4">
                <h2 style="color: #ffffff;" class="text-lg font-semibold">Detail Produk</h2>
            </div>
            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-8 p-8">
                @csrf

                <!-- Informasi Produk -->
                <div>
                    <div style="border-bottom: 2px solid #EC91C3;" class="pb-6 mb-6">
                        <h3 style="color: #9F254F;" class="text-lg font-semibold">Informasi Produk</h3>
                    </div>
                    
                    <div class="space-y-6">
                        <div>
                            <label for="name" style="color: #9F254F;" class="block text-sm font-semibold mb-2 uppercase tracking-wide">Nama Produk</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama produk" required 
                                class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition"
                                style="focus:border-color: #EC91C3; focus:ring-color: #EC91C3;">
                            @error('name')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="slug" style="color: #9F254F;" class="block text-sm font-semibold mb-2 uppercase tracking-wide">Slug (URL)</label>
                            <input type="text" id="slug" name="slug" value="{{ old('slug') }}" placeholder="produk-slug-url" required 
                                class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition"
                                style="focus:border-color: #EC91C3; focus:ring-color: #EC91C3;">
                            @error('slug')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" style="color: #9F254F;" class="block text-sm font-semibold mb-2 uppercase tracking-wide">Deskripsi</label>
                            <textarea id="description" name="description" rows="5" placeholder="Tulis deskripsi produk..." 
                                class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition"
                                style="focus:border-color: #EC91C3; focus:ring-color: #EC91C3;">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category_id" style="color: #9F254F;" class="block text-sm font-semibold mb-2 uppercase tracking-wide">Kategori</label>
                            <select id="category_id" name="category_id" required 
                                class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition"
                                style="focus:border-color: #EC91C3; focus:ring-color: #EC91C3;">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Harga & Stok -->
                <div>
                    <div style="border-bottom: 2px solid #EC91C3;" class="pb-6 mb-6">
                        <h3 style="color: #9F254F;" class="text-lg font-semibold">Harga & Stok</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="price" style="color: #9F254F;" class="block text-sm font-semibold mb-2 uppercase tracking-wide">Harga (Rp)</label>
                            <input type="number" id="price" name="price" value="{{ old('price') }}" placeholder="0" required min="0" 
                                class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition"
                                style="focus:border-color: #EC91C3; focus:ring-color: #EC91C3;">
                            @error('price')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="stock" style="color: #9F254F;" class="block text-sm font-semibold mb-2 uppercase tracking-wide">Stok (unit)</label>
                            <input type="number" id="stock" name="stock" value="{{ old('stock', 0) }}" placeholder="0" required min="0" 
                                class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition"
                                style="focus:border-color: #EC91C3; focus:ring-color: #EC91C3;">
                            @error('stock')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Gambar Produk -->
                <div>
                    <div style="border-bottom: 2px solid #EC91C3;" class="pb-6 mb-6">
                        <h3 style="color: #9F254F;" class="text-lg font-semibold">Gambar Produk</h3>
                    </div>
                    
                    <div>
                        <label for="image" style="color: #9F254F;" class="block text-sm font-semibold mb-2 uppercase tracking-wide">Upload Gambar</label>
                        <input type="file" id="image" name="image" accept="image/*" 
                            class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition cursor-pointer hover:border-pink-400"
                            style="focus:border-color: #EC91C3; focus:ring-color: #EC91C3;">
                        @error('image')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                        <p style="color: #7A7A7A;" class="text-xs mt-2">📎 Format: JPG, PNG, WebP (Max 5MB)</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div style="border-top: 2px solid #EC91C3;" class="flex gap-4 pt-8">
                    <button type="submit" style="background: #DA4582; color: #ffffff;" class="px-6 py-3 font-semibold rounded-lg transition hover:opacity-90 shadow-sm">
                        ✓ Simpan Produk
                    </button>
                    <a href="{{ route('admin.dashboard') }}" style="background: #EC91C3; color: #ffffff;" class="px-6 py-3 font-semibold rounded-lg transition hover:opacity-90 shadow-sm inline-block">
                        ✕ Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection



