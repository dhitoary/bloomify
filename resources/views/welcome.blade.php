<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloomify - Toko Bunga Online</title>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>
</head>
<body class="bg-gradient-to-br from-bloom-bg-main via-bloom-primary/20 to-bloom-fuchsia/10 text-bloom-text-primary font-sans antialiased">

    @include('layouts.navigation')

    <!-- Hero Section Carousel -->
    <div class="relative w-full bg-gradient-to-b from-bloom-fuchsia-light/20 to-bloom-bg-cream py-12">
        <div class="max-w-6xl mx-auto px-6">
            <!-- Carousel Container -->
            <div class="relative w-full bg-white rounded-3xl overflow-hidden shadow-soft-lg cursor-pointer" style="aspect-ratio: 16 / 9;" onclick="window.location.href='{{ route('products.index') }}'">
                <div id="carousel" class="flex transition-transform duration-500 ease-out h-full pointer-events-none" style="transform: translateX(0%);">
                    <!-- Slide 1 -->
                    <div class="w-full h-full flex-shrink-0">
                        <img src="{{ asset('images/hero/premium-flowers.png') }}?v=" alt="Premium Flowers 1" class="w-full h-full object-cover">
                    </div>
                    <!-- Slide 2 -->
                    <div class="w-full h-full flex-shrink-0">
                        <img src="{{ asset('images/hero/premium-flowers-2.png') }}?v=" alt="Premium Flowers 2" class="w-full h-full object-cover">
                    </div>
                    <!-- Slide 3 -->
                    <div class="w-full h-full flex-shrink-0">
                        <img src="{{ asset('images/hero/premium-flowers-3.png') }}?v=" alt="Premium Flowers 3" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>

            <!-- Previous Button -->
            <button id="prevBtn" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-white/90 hover:bg-white text-bloom-text-primary p-3 rounded-full shadow-soft transition duration-300 z-10 hover:shadow-soft-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <!-- Next Button -->
            <button id="nextBtn" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white/90 hover:bg-white text-bloom-text-primary p-3 rounded-full shadow-soft transition duration-300 z-10 hover:shadow-soft-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <!-- Dots Indicator -->
            <div class="flex gap-2 justify-center mt-6">
                <button class="indicator-dot active w-3 h-3 bg-bloom-primary rounded-full transition duration-300 hover:scale-110" data-index="0"></button>
                <button class="indicator-dot w-3 h-3 bg-bloom-primary-lighter rounded-full transition duration-300 hover:scale-110" data-index="1"></button>
                <button class="indicator-dot w-3 h-3 bg-bloom-primary-lighter rounded-full transition duration-300 hover:scale-110" data-index="2"></button>
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
                    dot.classList.add('bg-bloom-primary', 'scale-125');
                    dot.classList.remove('bg-bloom-primary-lighter', 'scale-100');
                } else {
                    dot.classList.remove('bg-bloom-primary', 'scale-125');
                    dot.classList.add('bg-bloom-primary-lighter', 'scale-100');
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
    <section class="py-section bg-gradient-to-b from-bloom-fuchsia/10 to-bloom-bg-card">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-12">
                <p class="text-bloom-accent text-sm font-semibold uppercase tracking-widest mb-4">Koleksi Terbaru</p>
                <h2 class="text-5xl font-display font-light text-bloom-text-primary mb-3 letter-spacing">Produk Pilihan Kami</h2>
                <p class="text-bloom-text-secondary font-light text-lg">Temukan buket bunga indah untuk setiap momen spesial Anda</p>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                @forelse($featuredProducts ?? [] as $product)
                    <a href="{{ route('products.show', $product->slug) }}" class="group">
                        <div class="bg-bloom-bg-card border-2 border-bloom-border rounded-2xl overflow-hidden hover:shadow-soft-hover transition-all duration-300 h-full flex flex-col hover:-translate-y-1 hover:border-bloom-primary">
                            <!-- Product Image -->
                            <div class="relative overflow-hidden h-48 bg-gradient-to-br from-bloom-bg-cream to-bloom-primary-lighter">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-bloom-text-secondary">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div class="p-5 flex flex-col flex-grow">
                                <h3 class="font-medium text-bloom-text-primary mb-1 line-clamp-2 text-sm group-hover:text-bloom-accent transition duration-300">{{ $product->name }}</h3>
                                @if($product->category)
                                    <p class="text-xs text-bloom-text-secondary mb-3">{{ $product->category->name }}</p>
                                @endif
                                <p class="text-xs text-bloom-text-secondary font-light mb-4 line-clamp-2 flex-grow">{{ $product->description }}</p>
                                
                                <div class="border-t border-bloom-border pt-4">
                                    <div class="flex justify-between items-center">
                                        <span class="font-semibold text-bloom-accent text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $product->stock > 0 ? 'bg-bloom-accent/10 text-bloom-accent border border-bloom-accent' : 'bg-bloom-error/10 text-bloom-error border border-bloom-error' }}">
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
                <a href="{{ route('products.index') }}" class="inline-block bg-bloom-accent hover:bg-bloom-accent-dark text-white font-semibold py-4 px-12 rounded-xl transition-all duration-300 shadow-soft-lg hover:shadow-soft-hover hover:scale-105">
                    Lihat Semua Produk →
                </a>
            </div>
        </div>
    </section>

    <!-- Tentang Kami Section -->
    <section id="tentang" class="py-section bg-gradient-to-b from-bloom-bg-main to-bloom-primary/10">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16">
                <p class="text-bloom-accent text-sm font-semibold uppercase tracking-widest mb-4">Mengapa Memilih Kami</p>
                <h2 class="text-5xl font-display font-light text-bloom-text-primary">Kualitas Terbaik untuk Anda</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Feature 1 -->
                <div class="text-center p-8 rounded-2xl bg-bloom-bg-card border-2 border-bloom-border hover:border-bloom-primary hover:shadow-soft-lg transition-all duration-300 hover:-translate-y-1">
                    <div class="mb-6 h-20 w-20 bg-bloom-primary/10 rounded-full flex items-center justify-center mx-auto border-2 border-bloom-primary">
                        <iconify-icon icon="mdi:flower" width="40" height="40" style="color: #DDB1B7;"></iconify-icon>
                    </div>
                    <h3 class="text-xl font-medium text-bloom-text-primary mb-3">Bunga Premium</h3>
                    <p class="text-bloom-text-secondary font-light leading-relaxed">
                        Dipilih langsung dari kebun terbaik untuk memastikan kesegaran dan kualitas maksimal setiap saat.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="text-center p-8 rounded-2xl bg-bloom-bg-card border-2 border-bloom-border hover:border-bloom-primary hover:shadow-soft-lg transition-all duration-300 hover:-translate-y-1">
                    <div class="mb-6 h-20 w-20 bg-bloom-accent/10 rounded-full flex items-center justify-center mx-auto border-2 border-bloom-accent">
                        <iconify-icon icon="mdi:truck-fast" width="40" height="40" style="color: #DFA54A;"></iconify-icon>
                    </div>
                    <h3 class="text-xl font-medium text-bloom-text-primary mb-3">Pengiriman Cepat</h3>
                    <p class="text-bloom-text-secondary font-light leading-relaxed">
                        Layanan same-day delivery untuk area tertentu. Kami memastikan bunga tiba dengan sempurna.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="text-center p-8 rounded-2xl bg-bloom-bg-card border-2 border-bloom-border hover:border-bloom-primary hover:shadow-soft-lg transition-all duration-300 hover:-translate-y-1">
                    <div class="mb-6 h-20 w-20 bg-bloom-secondary/10 rounded-full flex items-center justify-center mx-auto border-2 border-bloom-secondary">
                        <iconify-icon icon="mdi:headset" width="40" height="40" style="color: #E8C5CC;"></iconify-icon>
                    </div>
                    <h3 class="text-xl font-medium text-bloom-text-primary mb-3">Support 24/7</h3>
                    <p class="text-bloom-text-secondary font-light leading-relaxed">
                        Tim customer service kami siap membantu Anda kapan pun dibutuhkan, setiap hari.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('components.footer')

</body>
</html>