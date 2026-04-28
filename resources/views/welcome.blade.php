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

    <!-- Hero Section Carousel -->
    <div class="relative w-full bg-stone-50 py-8">
        <div class="max-w-6xl mx-auto px-6">
            <!-- Carousel Container -->
            <div class="relative w-full bg-white rounded-lg overflow-hidden shadow-lg cursor-pointer" style="aspect-ratio: 16 / 9;" onclick="window.location.href='{{ route('products.index') }}'">
                <div id="carousel" class="flex transition-transform duration-500 ease-out h-full pointer-events-none" style="transform: translateX(0%);">
                    <!-- Slide 1 -->
                    <div class="w-full h-full flex-shrink-0">
                        <img src="{{ asset('images/hero/premium-flowers.png') }}" alt="Premium Flowers 1" class="w-full h-full object-cover">
                    </div>
                    <!-- Slide 2 -->
                    <div class="w-full h-full flex-shrink-0">
                        <img src="{{ asset('images/hero/premium-flowers-2.png') }}" alt="Premium Flowers 2" class="w-full h-full object-cover">
                    </div>
                    <!-- Slide 3 -->
                    <div class="w-full h-full flex-shrink-0">
                        <img src="{{ asset('images/hero/premium-flowers-3.png') }}" alt="Premium Flowers 3" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>

            <!-- Previous Button -->
            <button id="prevBtn" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white text-stone-900 p-3 rounded-full shadow-lg transition z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <!-- Next Button -->
            <button id="nextBtn" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white text-stone-900 p-3 rounded-full shadow-lg transition z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <!-- Dots Indicator -->
            <div class="flex gap-2 justify-center mt-4">
                <button class="indicator-dot active w-2 h-2 bg-stone-400 rounded-full transition" data-index="0"></button>
                <button class="indicator-dot w-2 h-2 bg-stone-200 rounded-full transition" data-index="1"></button>
                <button class="indicator-dot w-2 h-2 bg-stone-200 rounded-full transition" data-index="2"></button>
            </div>
        </div>
    </div>

    <script>
        const carousel = document.getElementById('carousel');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const dots = document.querySelectorAll('.indicator-dot');
        let currentSlide = 0;
        const totalSlides = 3;

        function goToSlide(n) {
            currentSlide = (n + totalSlides) % totalSlides;
            carousel.style.transform = `translateX(-${currentSlide * 100}%)`;
            updateDots();
        }

        function updateDots() {
            dots.forEach((dot, index) => {
                if (index === currentSlide) {
                    dot.classList.add('bg-stone-400');
                    dot.classList.remove('bg-stone-200');
                } else {
                    dot.classList.remove('bg-stone-400');
                    dot.classList.add('bg-stone-200');
                }
            });
        }

        prevBtn.addEventListener('click', () => goToSlide(currentSlide - 1));
        nextBtn.addEventListener('click', () => goToSlide(currentSlide + 1));

        dots.forEach(dot => {
            dot.addEventListener('click', () => goToSlide(parseInt(dot.dataset.index)));
        });
    </script>

    <!-- Featured Products Section -->
    <section class="py-16 bg-stone-50">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-12">
                <p class="text-rose-600 text-sm font-medium uppercase tracking-widest mb-4">Koleksi Terbaru</p>
                <h2 class="text-4xl font-light text-stone-900 mb-3">Produk Pilihan</h2>
                <p class="text-stone-600 font-light">Temukan buket bunga indah untuk setiap momen spesial Anda</p>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                @forelse($featuredProducts ?? [] as $product)
                    <a href="{{ route('products.show', $product->slug) }}" class="group">
                        <div class="bg-white border border-stone-200 rounded-lg overflow-hidden hover:shadow-lg transition h-full flex flex-col">
                            <!-- Product Image -->
                            <div class="relative overflow-hidden h-48 bg-stone-100">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-stone-400">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div class="p-4 flex flex-col flex-grow">
                                <h3 class="font-medium text-stone-900 mb-1 line-clamp-2 text-sm">{{ $product->name }}</h3>
                                @if($product->category)
                                    <p class="text-xs text-stone-500 mb-2">{{ $product->category->name }}</p>
                                @endif
                                <p class="text-xs text-stone-600 font-light mb-3 line-clamp-2 flex-grow">{{ $product->description }}</p>
                                
                                <div class="border-t border-stone-100 pt-3">
                                    <div class="flex justify-between items-center">
                                        <span class="font-light text-stone-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        <span class="text-xs font-medium px-2 py-1 rounded-full {{ $product->stock > 0 ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-red-50 text-red-700 border border-red-200' }}">
                                            {{ $product->stock > 0 ? 'Tersedia' : 'Habis' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-stone-500 font-light">Belum ada produk</p>
                    </div>
                @endforelse
            </div>

            <!-- View All Button -->
            <div class="text-center">
                <a href="{{ route('products.index') }}" class="inline-block bg-rose-600 hover:bg-rose-700 text-white font-medium py-3 px-12 rounded-lg transition duration-300">
                    Lihat Semua Produk →
                </a>
            </div>
        </div>
    </section>

    <script>
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