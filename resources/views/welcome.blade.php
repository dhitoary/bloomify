<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloomify - Toko Bunga Online</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>
</head>
<body class="bg-bloom-ivory text-gray-900 font-sans antialiased">

    @include('layouts.navigation')

    <!-- Hero Section Carousel -->
    <div class="relative w-full bg-bloom-cream py-8">
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
            <button id="prevBtn" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white text-gray-900 p-3 rounded-full shadow-lg transition z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <!-- Next Button -->
            <button id="nextBtn" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white text-gray-900 p-3 rounded-full shadow-lg transition z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <!-- Dots Indicator -->
            <div class="flex gap-2 justify-center mt-4">
                <button class="indicator-dot active w-2 h-2 bg-bloom-teal rounded-full transition" data-index="0"></button>
                <button class="indicator-dot w-2 h-2 bg-bloom-mint-light rounded-full transition" data-index="1"></button>
                <button class="indicator-dot w-2 h-2 bg-bloom-mint-light rounded-full transition" data-index="2"></button>
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
                    dot.classList.add('bg-bloom-teal');
                    dot.classList.remove('bg-bloom-mint-light');
                } else {
                    dot.classList.remove('bg-bloom-teal');
                    dot.classList.add('bg-bloom-mint-light');
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
    <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-12">
                <p class="text-bloom-teal text-sm font-medium uppercase tracking-widest mb-4">Koleksi Terbaru</p>
                <h2 class="text-4xl font-light text-gray-900 mb-3">Produk Pilihan</h2>
                <p class="text-gray-600 font-light">Temukan buket bunga indah untuk setiap momen spesial Anda</p>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                @forelse($featuredProducts ?? [] as $product)
                    <a href="{{ route('products.show', $product->slug) }}" class="group">
                        <div class="bg-white border border-bloom-mint-light rounded-lg overflow-hidden hover:shadow-lg transition h-full flex flex-col">
                            <!-- Product Image -->
                            <div class="relative overflow-hidden h-48 bg-bloom-cream">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-bloom-mint">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div class="p-4 flex flex-col flex-grow">
                                <h3 class="font-medium text-gray-900 mb-1 line-clamp-2 text-sm">{{ $product->name }}</h3>
                                @if($product->category)
                                    <p class="text-xs text-gray-500 mb-2">{{ $product->category->name }}</p>
                                @endif
                                <p class="text-xs text-gray-600 font-light mb-3 line-clamp-2 flex-grow">{{ $product->description }}</p>
                                
                                <div class="border-t border-bloom-mint-light pt-3">
                                    <div class="flex justify-between items-center">
                                        <span class="font-light text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        <span class="text-xs font-medium px-2 py-1 rounded-full {{ $product->stock > 0 ? 'bg-bloom-mint/10 text-bloom-mint border border-bloom-mint' : 'bg-red-50 text-red-700 border border-red-200' }}">
                                            {{ $product->stock > 0 ? 'Tersedia' : 'Habis' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 font-light">Belum ada produk</p>
                    </div>
                @endforelse
            </div>

            <!-- View All Button -->
            <div class="text-center">
                <a href="{{ route('products.index') }}" class="inline-block bg-bloom-coral hover:bg-bloom-coral/90 text-white font-medium py-3 px-12 rounded-lg transition duration-300">
                    Lihat Semua Produk →
                </a>
            </div>
        </div>
    </section>

    <!-- Tentang Kami Section -->
    <section id="tentang" class="py-24 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16">
                <p class="text-bloom-teal text-sm font-medium uppercase tracking-widest mb-4">Mengapa Memilih Kami</p>
                <h2 class="text-5xl font-light text-gray-900">Kualitas Terbaik untuk Anda</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Feature 1 -->
                <div class="text-center">
                    <div class="mb-6 h-16 w-16 bg-bloom-cream rounded-full flex items-center justify-center mx-auto">
                        <iconify-icon icon="mdi:flower" width="40" height="40" style="color: #0D9488;"></iconify-icon>
                    </div>
                    <h3 class="text-xl font-medium text-gray-900 mb-3">Bunga Premium</h3>
                    <p class="text-gray-600 font-light leading-relaxed">
                        Dipilih langsung dari kebun terbaik untuk memastikan kesegaran dan kualitas maksimal setiap saat.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="text-center">
                    <div class="mb-6 h-16 w-16 bg-bloom-mint-light/20 rounded-full flex items-center justify-center mx-auto">
                        <iconify-icon icon="mdi:truck-fast" width="40" height="40" style="color: #14B8A6;"></iconify-icon>
                    </div>
                    <h3 class="text-xl font-medium text-gray-900 mb-3">Pengiriman Cepat</h3>
                    <p class="text-gray-600 font-light leading-relaxed">
                        Layanan same-day delivery untuk area tertentu. Kami memastikan bunga tiba dengan sempurna.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="text-center">
                    <div class="mb-6 h-16 w-16 bg-bloom-coral/10 rounded-full flex items-center justify-center mx-auto">
                        <iconify-icon icon="mdi:headset" width="40" height="40" style="color: #FF6B6B;"></iconify-icon>
                    </div>
                    <h3 class="text-xl font-medium text-gray-900 mb-3">Support 24/7</h3>
                    <p class="text-gray-600 font-light leading-relaxed">
                        Tim customer service kami siap membantu Anda kapan pun dibutuhkan, setiap hari.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-bloom-cream">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <p class="text-bloom-teal text-sm font-medium uppercase tracking-widest mb-4">Siap Memulai</p>
            <h2 class="text-5xl font-light text-gray-900 mb-8">
                Jelajahi Koleksi Kami
            </h2>
            <p class="text-lg text-gray-600 font-light mb-10 max-w-2xl mx-auto">
                Temukan buket bunga yang sempurna untuk setiap kesempatan. Dari romantis hingga profesional, kami punya semuanya.
            </p>
            <a href="{{ route('products.index') }}" class="inline-block bg-bloom-coral hover:bg-bloom-coral/90 text-white font-medium py-4 px-12 rounded transition duration-300">
                Lihat Semua Produk
            </a>
        </div>
    </section>

    <!-- Footer -->
    @include('components.footer')

</body>
</html>