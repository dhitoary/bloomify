<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloomify - Toko Bunga Online</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-white text-stone-900 font-sans antialiased">

    <nav class="bg-white border-b border-stone-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-5">
            <a href="/" class="text-2xl font-semibold text-stone-900">Bloomify</a>
            <ul class="flex space-x-8 font-medium text-stone-700 items-center">
                <li><a href="/" class="hover:text-rose-600 transition">Beranda</a></li>
                <li><a href="{{ route('products.index') }}" class="hover:text-rose-600 transition">Katalog</a></li>

                @auth
                    <li><a href="{{ url('/dashboard') }}" class="text-rose-600 hover:text-rose-700 transition">Dashboard</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-stone-700 hover:text-rose-600 transition">Logout</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}" class="hover:text-rose-600 transition">Login</a></li>
                    <li><a href="{{ route('register') }}" class="text-rose-600 hover:text-rose-700 font-medium transition">Daftar</a></li>
                @endauth
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-stone-50 min-h-screen flex items-center justify-center relative overflow-hidden">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 px-6 py-20">
            <!-- Left Content -->
            <div class="flex flex-col justify-center">
                <p class="text-rose-600 text-sm font-medium uppercase tracking-widest mb-6">Bunga Premium</p>
                <h1 class="text-6xl lg:text-7xl font-light text-stone-900 mb-6 leading-tight">
                    Sampaikan Perasaanmu dengan Bunga
                </h1>
                <p class="text-lg text-stone-600 font-light mb-10 max-w-md">
                    Koleksi buket bunga premium untuk setiap momen spesial. Dibuat dengan cinta untuk orang terkasih Anda.
                </p>
                <div class="flex gap-4">
                    <a href="{{ route('products.index') }}" class="bg-rose-600 hover:bg-rose-700 text-white font-medium py-3 px-8 rounded transition duration-300">
                        Mulai Belanja
                    </a>
                    <a href="#tentang" class="border border-stone-300 hover:border-rose-600 text-stone-900 hover:text-rose-600 font-medium py-3 px-8 rounded transition duration-300">
                        Pelajari Lebih
                    </a>
                </div>
            </div>

            <!-- Right Image -->
            <div class="hidden lg:flex items-center justify-center">
                <div class="w-full h-96 bg-stone-100 rounded-lg flex items-center justify-center text-stone-400 text-6xl font-light">
                    🌸
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <section id="tentang" class="py-24 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16">
                <p class="text-rose-600 text-sm font-medium uppercase tracking-widest mb-4">Mengapa Memilih Kami</p>
                <h2 class="text-5xl font-light text-stone-900">Kualitas Terbaik untuk Anda</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Feature 1 -->
                <div class="text-center">
                    <div class="mb-6 h-16 w-16 bg-rose-100 rounded-full flex items-center justify-center mx-auto">
                        <span class="text-2xl text-rose-600 font-light">B</span>
                    </div>
                    <h3 class="text-xl font-medium text-stone-900 mb-3">Bunga Premium</h3>
                    <p class="text-stone-600 font-light leading-relaxed">
                        Dipilih langsung dari kebun terbaik untuk memastikan kesegaran dan kualitas maksimal setiap saat.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="text-center">
                    <div class="mb-6 h-16 w-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto">
                        <span class="text-2xl text-amber-600 font-light">C</span>
                    </div>
                    <h3 class="text-xl font-medium text-stone-900 mb-3">Pengiriman Cepat</h3>
                    <p class="text-stone-600 font-light leading-relaxed">
                        Layanan same-day delivery untuk area tertentu. Kami memastikan bunga tiba dengan sempurna.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="text-center">
                    <div class="mb-6 h-16 w-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto">
                        <span class="text-2xl text-indigo-600 font-light">S</span>
                    </div>
                    <h3 class="text-xl font-medium text-stone-900 mb-3">Support 24/7</h3>
                    <p class="text-stone-600 font-light leading-relaxed">
                        Tim customer service kami siap membantu Anda kapan pun dibutuhkan, setiap hari.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-stone-50">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <p class="text-rose-600 text-sm font-medium uppercase tracking-widest mb-4">Siap Memulai</p>
            <h2 class="text-5xl font-light text-stone-900 mb-8">
                Jelajahi Koleksi Kami
            </h2>
            <p class="text-lg text-stone-600 font-light mb-10 max-w-2xl mx-auto">
                Temukan buket bunga yang sempurna untuk setiap kesempatan. Dari romantis hingga profesional, kami punya semuanya.
            </p>
            <a href="{{ route('products.index') }}" class="inline-block bg-rose-600 hover:bg-rose-700 text-white font-medium py-4 px-12 rounded transition duration-300">
                Lihat Semua Produk
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-stone-900 text-stone-400 py-16">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div>
                    <h3 class="text-white text-lg font-semibold mb-4">Bloomify</h3>
                    <p class="font-light leading-relaxed">Toko bunga online premium untuk setiap momen istimewa Anda.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Produk</h4>
                    <ul class="space-y-2 font-light">
                        <li><a href="{{ route('products.index') }}" class="hover:text-white transition">Katalog</a></li>
                        <li><a href="#" class="hover:text-white transition">Promo</a></li>
                        <li><a href="#" class="hover:text-white transition">Terbaru</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Perusahaan</h4>
                    <ul class="space-y-2 font-light">
                        <li><a href="#" class="hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition">Karir</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Hubungi Kami</h4>
                    <ul class="space-y-2 font-light">
                        <li><a href="tel:+628123456789" class="hover:text-white transition">+62 812 3456 789</a></li>
                        <li><a href="mailto:info@bloomify.com" class="hover:text-white transition">info@bloomify.com</a></li>
                        <li>Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-stone-800 pt-8 text-center font-light">
                <p>&copy; 2026 Bloomify. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

</body>
</html>
            <div class="border-t border-gray-700 pt-8 text-center">
                <p>&copy; 2026 Bloomify. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

</body>
</html>