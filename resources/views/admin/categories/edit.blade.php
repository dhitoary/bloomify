@extends('layouts.app')

@section('content')
<div class="bg-bloom-admin-bg min-h-screen">
    <!-- Header Section -->
    <div class="bg-white border-b border-bloom-accent-light py-12 mb-12">
        <div class="max-w-4xl mx-auto px-6">
            <a href="{{ route('admin.dashboard') }}" class="text-bloom-primary hover:text-bloom-secondary mb-4 inline-block">← Kembali</a>
            <h1 class="text-4xl font-light text-gray-900 mb-3">Edit Kategori: {{ $category->name }}</h1>
        </div>
    </div>

    <!-- Form Section -->
    <div class="max-w-4xl mx-auto px-6 pb-20">
        <div class="bg-white rounded-lg border border-bloom-accent-light p-8">
            <form method="POST" action="{{ route('admin.categories.update', $category->id) }}" class="space-y-8">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required class="w-full px-4 py-2 border border-bloom-accent-light rounded-lg focus:ring-2 focus:ring-bloom-primary focus:border-transparent">
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug', $category->slug) }}" required class="w-full px-4 py-2 border border-bloom-accent-light rounded-lg focus:ring-2 focus:ring-bloom-primary focus:border-transparent">
                    @error('slug')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi (Opsional)</label>
                    <textarea id="description" name="description" rows="4" class="w-full px-4 py-2 border border-bloom-accent-light rounded-lg focus:ring-2 focus:ring-bloom-primary focus:border-transparent">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 pt-6 border-t border-bloom-accent-light">
                    <button type="submit" class="px-6 py-2 bg-bloom-secondary hover:bg-bloom-secondary/90 text-white font-medium rounded-lg transition">
                        Update Kategori
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



