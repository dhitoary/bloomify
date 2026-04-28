<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Bloomify</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-stone-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-stone-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-5">
            <a href="/" class="text-2xl font-semibold text-stone-900">Bloomify</a>
            <ul class="flex space-x-8 font-medium text-stone-700 items-center">
                <li><a href="{{ route('admin.dashboard') }}" class="hover:text-rose-600 transition">Dashboard</a></li>
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
    <div class="max-w-2xl mx-auto py-16 px-6">
        <!-- Header -->
        <div class="mb-12">
            <h1 class="text-5xl font-light text-stone-900 mb-3">Edit Profil</h1>
            <p class="text-stone-600 font-light">Kelola informasi profil Anda</p>
        </div>

        <!-- Profile Edit Form -->
        <div class="bg-white rounded-lg border border-stone-200 p-8">
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <p class="text-red-700 font-medium mb-2">Terjadi kesalahan:</p>
                    <ul class="text-red-600 text-sm space-y-1">
                        @foreach($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Profile Picture Section -->
                <div>
                    <h3 class="text-lg font-medium text-stone-900 mb-6">Foto Profil</h3>
                    
                    <div class="flex items-center gap-8">
                        <!-- Current Profile Picture -->
                        <div>
                            <div class="w-24 h-24 bg-gradient-to-br from-rose-500 to-rose-600 rounded-lg flex items-center justify-center text-white font-semibold text-3xl overflow-hidden border-2 border-stone-200">
                                @if(auth()->user()->profile_picture)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profile" class="w-full h-full object-cover">
                                @else
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                @endif
                            </div>
                            <p class="text-sm text-stone-600 mt-2">Foto Saat Ini</p>
                        </div>

                        <!-- Upload Section -->
                        <div class="flex-grow">
                            <label for="profile_picture" class="block text-sm font-medium text-stone-700 mb-3">
                                Upload Foto Profil
                            </label>
                            <input 
                                type="file" 
                                id="profile_picture" 
                                name="profile_picture" 
                                accept="image/*" 
                                class="block w-full text-sm text-stone-600
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-lg file:border-0
                                file:text-sm file:font-medium
                                file:bg-rose-50 file:text-rose-700
                                hover:file:bg-rose-100 file:cursor-pointer"
                            >
                            <p class="text-xs text-stone-500 mt-2">Format: JPG, PNG, WebP (Max 5MB)</p>
                        </div>
                    </div>
                </div>

                <hr class="border-stone-200">

                <!-- Name Section -->
                <div>
                    <h3 class="text-lg font-medium text-stone-900 mb-6">Informasi Dasar</h3>
                    
                    <div class="space-y-5">
                        <div>
                            <label for="name" class="block text-sm font-medium text-stone-700 mb-2">Nama Lengkap</label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name', auth()->user()->name) }}"
                                class="w-full px-4 py-2 border border-stone-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-600 text-stone-900"
                                required
                            >
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-stone-700 mb-2">Email</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email', auth()->user()->email) }}"
                                class="w-full px-4 py-2 border border-stone-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-600 text-stone-900"
                                required
                            >
                        </div>
                    </div>
                </div>

                <hr class="border-stone-200">

                <!-- Password Section -->
                <div>
                    <h3 class="text-lg font-medium text-stone-900 mb-6">Ubah Kata Sandi</h3>
                    <p class="text-sm text-stone-600 mb-5">Kosongkan jika tidak ingin mengubah kata sandi</p>
                    
                    <div class="space-y-5">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-stone-700 mb-2">Kata Sandi Saat Ini</label>
                            <input 
                                type="password" 
                                id="current_password" 
                                name="current_password" 
                                class="w-full px-4 py-2 border border-stone-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-600"
                            >
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-stone-700 mb-2">Kata Sandi Baru</label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="w-full px-4 py-2 border border-stone-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-600"
                            >
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-stone-700 mb-2">Konfirmasi Kata Sandi Baru</label>
                            <input 
                                type="password" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                class="w-full px-4 py-2 border border-stone-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-600"
                            >
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 pt-8 border-t border-stone-200">
                    <a href="{{ route('admin.dashboard') }}" class="px-8 py-3 border border-stone-300 text-stone-700 rounded-lg hover:bg-stone-50 transition font-medium">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-3 bg-rose-600 hover:bg-rose-700 text-white rounded-lg transition font-medium ml-auto">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
