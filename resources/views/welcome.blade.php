<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloomify - Toko Bunga Online</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-bloom-ivory text-gray-900 font-sans antialiased">

    <nav class="bg-white shadow-sm border-b border-bloom-mint-light sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-4 py-4">
            <a href="/" class="text-2xl font-bold text-bloom-teal">Bloomify</a>
            <ul class="flex space-x-6 font-medium text-gray-700 items-center">
                <li><a href="/" class="hover:text-bloom-teal transition">Beranda</a></li>
                <li><a href="{{ route('products.index') }}" class="hover:text-bloom-teal transition">Katalog</a></li>

                @auth
                    <li><a href="{{ url('/dashboard') }}" class="font-bold text-bloom-teal hover:text-bloom-coral transition">Dashboard</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-bloom-coral transition">Logout</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}" class="hover:text-bloom-teal transition">Login</a></li>
                    <li><a href="{{ route('register') }}" class="bg-bloom-mint-light text-bloom-teal px-4 py-2 rounded-full hover:bg-bloom-mint transition font-medium">Daftar</a></li>
                @endauth
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-bloom-teal via-bloom-teal-light to-bloom-mint min-h-screen flex items-center justify-center relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-10 w-32 h-32 bg-white rounded-full"></div>
            <div class="absolute bottom-20 right-20 w-40 h-40 bg-white rounded-full"></div>
        </div>

        <div class="container mx-auto relative z-10 text-center px-4 py-20">
            <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 tracking-tight">
                Sampaikan Perasaanmu <br> dengan Bunga
            </h1>
            <p class="text-lg md:text-xl text-bloom-cream mb-10 max-w-2xl mx-auto">
                Koleksi buket bunga premium untuk setiap momen spesial. Pesan sekarang dan ciptakan kesan indah untuk orang terkasih.
            </p>
            <div class="flex flex-col md:flex-row gap-4 justify-center">
                <a href="{{ route('products.index') }}" class="bg-bloom-coral hover:bg-bloom-coral/90 text-white font-bold py-3 px-8 rounded-full shadow-lg transition duration-300 transform hover:scale-105 inline-block">
                    Mulai Belanja
                </a>
                <a href="#tentang" class="bg-white text-bloom-teal font-bold py-3 px-8 rounded-full shadow-lg hover:bg-bloom-cream transition duration-300 inline-block">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <section id="tentang" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-bloom-teal mb-16">Mengapa Memilih Bloomify?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="text-center">
                    <div class="mb-4 flex justify-center">
                        <div class="w-20 h-20 bg-bloom-mint-light rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-bloom-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Bunga Segar Premium</h3>
                    <p class="text-gray-700">Dipilih langsung dari kebun terbaik untuk memastikan kesegaran maksimal.</p>
                </div>

                <!-- Feature 2 -->
                <div class="text-center">
                    <div class="mb-4 flex justify-center">
                        <div class="w-20 h-20 bg-bloom-mint-light rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-bloom-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Pengiriman Cepat</h3>
                    <p class="text-gray-700">Layanan pengiriman same-day untuk area tertentu. Tepat waktu, setiap kali.</p>
                </div>

                <!-- Feature 3 -->
                <div class="text-center">
                    <div class="mb-4 flex justify-center">
                        <div class="w-20 h-20 bg-bloom-mint-light rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-bloom-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5-4a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Customer Support 24/7</h3>
                    <p class="text-gray-700">Tim kami siap membantu menjawab pertanyaan kapan pun Anda membutuhkannya.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-bloom-teal to-bloom-teal-light">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold text-white mb-6">Siap Membuat Momen Spesial?</h2>
            <p class="text-bloom-cream text-lg mb-8 max-w-2xl mx-auto">Jelajahi koleksi bunga kami yang indah dan temukan yang sempurna untuk orang terkasih Anda.</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-bloom-coral hover:bg-bloom-coral/90 text-white font-bold py-4 px-10 rounded-full shadow-lg transition duration-300 transform hover:scale-105">
                Lihat Semua Produk
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-white text-lg font-bold mb-4">Bloomify</h3>
                    <p>Toko bunga online terpercaya untuk setiap momen istimewa Anda.</p>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Produk</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('products.index') }}" class="hover:text-white transition">Katalog</a></li>
                        <li><a href="#" class="hover:text-white transition">Promo</a></li>
                        <li><a href="#" class="hover:text-white transition">Terbaru</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Perusahaan</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition">Karir</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4">Hubungi Kami</h4>
                    <ul class="space-y-2">
                        <li><a href="tel:+628123456789" class="hover:text-white transition">+62 812 3456 789</a></li>
                        <li><a href="mailto:info@bloomify.com" class="hover:text-white transition">info@bloomify.com</a></li>
                        <li>Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-8 text-center">
                <p>&copy; 2026 Bloomify. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

</body>
</html>