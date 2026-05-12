<footer class="bg-gradient-to-r from-bloom-primary via-bloom-fuchsia to-bloom-fuchsia-light text-bloom-text-light mt-20">
  <!-- Main Footer Content -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
      <!-- Company Info -->
      <div class="space-y-4">
        <h3 class="text-2xl font-display font-semibold text-bloom-text-light">Bloomify</h3>
        <p class="text-bloom-text-light/90 text-sm leading-relaxed font-light">
          Toko bunga online premium yang menyediakan buket bunga berkualitas terbaik untuk setiap momen spesial Anda.
        </p>
        <div class="flex space-x-4 pt-2">
          <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-bloom-accent hover:bg-bloom-accent-dark text-white rounded-full flex items-center justify-center transition-all duration-300 hover:shadow-soft hover:scale-110" title="Facebook">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
            </svg>
          </a>
          <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-bloom-accent hover:bg-bloom-accent-dark text-white rounded-full flex items-center justify-center transition-all duration-300 hover:shadow-soft hover:scale-110" title="Twitter">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2s9 5 20 5a9.5 9.5 0 00-9-5.5c4.75 2.25 7-7 7-7a10.6 10.6 0 01-10 5.5"/>
            </svg>
          </a>
          <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-bloom-accent hover:bg-bloom-accent-dark text-white rounded-full flex items-center justify-center transition-all duration-300 hover:shadow-soft hover:scale-110" title="Instagram">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <rect x="2" y="2" width="20" height="20" rx="5" ry="5" stroke="currentColor" stroke-width="2" fill="none"/>
              <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37Z" fill="currentColor"/>
              <circle cx="17.5" cy="6.5" r="1.5" fill="currentColor"/>
            </svg>
          </a>
        </div>
        <!-- Team -->
        <div class="pt-4 border-t border-bloom-text-light/30">
          <p class="text-xs text-bloom-text-light/80 font-light mb-2">Tim:</p>
          <p class="text-sm text-bloom-text-light font-light">
            <span class="font-bold text-bloom-fuchsia drop-shadow-lg" style="text-shadow: 0 0 10px rgba(231, 30, 99, 0.8), 0 0 20px rgba(231, 30, 99, 0.5);">Dhito</span> • <span class="font-bold text-bloom-fuchsia drop-shadow-lg" style="text-shadow: 0 0 10px rgba(231, 30, 99, 0.8), 0 0 20px rgba(231, 30, 99, 0.5);">Cindy</span> • <span class="font-bold text-bloom-fuchsia drop-shadow-lg" style="text-shadow: 0 0 10px rgba(231, 30, 99, 0.8), 0 0 20px rgba(231, 30, 99, 0.5);">Surya</span>
          </p>
        </div>
      </div>

      <!-- Quick Links -->
      <div class="space-y-4">
        <h4 class="text-lg font-semibold text-bloom-accent">Navigasi</h4>
        <ul class="space-y-2 text-sm">
          <li>
            <a href="{{ route('welcome') }}" class="text-bloom-text-light/90 hover:text-bloom-accent transition-colors duration-300 font-light hover:translate-x-1">
              Beranda
            </a>
          </li>
          <li>
            <a href="{{ route('products.index') }}" class="text-bloom-text-light/90 hover:text-bloom-accent transition-colors duration-300 font-light hover:translate-x-1">
              Katalog Produk
            </a>
          </li>
          @auth
          <li>
            <a href="{{ route('dashboard') }}" class="text-bloom-text-light/90 hover:text-bloom-accent transition-colors duration-300 font-light hover:translate-x-1">
              Dashboard
            </a>
          </li>
          @endauth
          <li>
            <a href="{{ route('about') }}" class="text-bloom-text-light/90 hover:text-bloom-accent transition-colors duration-300 font-light hover:translate-x-1">
              Tentang Kami
            </a>
          </li>
        </ul>
      </div>

      <!-- Categories -->
      <div class="space-y-4">
        <h4 class="text-lg font-semibold text-bloom-accent">Koleksi</h4>
        <ul class="space-y-2 text-sm">
          <li>
            <a href="{{ route('products.index') }}" class="text-bloom-text-light/90 hover:text-bloom-accent transition-colors duration-300 font-light hover:translate-x-1">
              Semua Produk
            </a>
          </li>
          <li>
            <a href="{{ route('products.index') }}" class="text-bloom-text-light/90 hover:text-bloom-accent transition-colors duration-300 font-light hover:translate-x-1">
              Buket Mawar
            </a>
          </li>
          <li>
            <a href="{{ route('products.index') }}" class="text-white hover:text-bloom-accent transition-colors font-light hover:translate-x-1">
              Buket Matahari
            </a>
          </li>
          <li>
            <a href="{{ route('products.index') }}" class="text-white hover:text-bloom-accent transition-colors font-light hover:translate-x-1">
              Rangkaian Spesial
            </a>
          </li>
        </ul>
      </div>

      <!-- Contact Info -->
      <div class="space-y-4">
        <h4 class="text-lg font-semibold text-white">Hubungi Kami</h4>
        <div class="space-y-3 text-sm">
          <div>
            <p class="text-white font-medium">Alamat:</p>
            <p class="text-white/90 text-xs font-light">
              Perum Permata Asri, Blok i4 No 30<br>
              Lampung Selatan, Indonesia
            </p>
          </div>
          <div>
            <p class="text-white font-medium">Email:</p>
            <a href="mailto:bloomify@gmail.com" class="text-white hover:text-bloom-accent transition-colors font-light">
              bloomify@gmail.com
            </a>
          </div>
          <div>
            <p class="text-white font-medium">Telepon:</p>
            <a href="tel:+628123456789" class="text-white hover:text-bloom-accent transition-colors font-light">
              +62 812 345 6789
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Divider -->
    <div class="border-t border-gray-300 my-8"></div>

    <!-- Bottom Footer -->
    <div class="bg-white/80 py-8 px-4 sm:px-6 lg:px-8 rounded-t-xl">
      <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 items-center text-center md:text-left">
      <!-- Payment Methods -->
      <div class="space-y-3">
        <p class="text-sm font-semibold text-bloom-accent">Metode Pembayaran</p>
        <div class="flex items-center space-x-3 justify-center md:justify-start">
          <!-- Visa -->
          <div class="w-12 h-8 bg-white rounded flex items-center justify-center hover:scale-110 transition-transform cursor-pointer shadow-sm" title="Visa">
            <svg class="w-8 h-5" viewBox="0 0 48 32" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect width="48" height="32" rx="4" fill="#1435CB"/>
              <text x="24" y="20" font-size="10" font-weight="bold" fill="white" text-anchor="middle">VISA</text>
            </svg>
          </div>
          <!-- Mastercard -->
          <div class="w-12 h-8 bg-white rounded flex items-center justify-center hover:scale-110 transition-transform cursor-pointer shadow-sm" title="Mastercard">
            <svg class="w-8 h-5" viewBox="0 0 48 32" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect width="48" height="32" rx="4" fill="white" stroke="#EB001B" stroke-width="1"/>
              <circle cx="18" cy="16" r="7" fill="#EB001B"/>
              <circle cx="30" cy="16" r="7" fill="#F79E1B"/>
              <circle cx="24" cy="16" r="7" fill="url(#grad1)"/>
            </svg>
          </div>
          <!-- Bank Transfer -->
          <div class="w-12 h-8 bg-white rounded flex items-center justify-center hover:scale-110 transition-transform cursor-pointer shadow-sm" title="Bank Transfer">
            <svg class="w-6 h-5 text-bloom-primary" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 1L2 6v3h20V6L12 1z"/>
              <path d="M2 9v10c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V9H2z"/>
              <path d="M12 13c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z"/>
            </svg>
          </div>
          <!-- E-Wallet / QRIS -->
          <div class="w-12 h-8 bg-white rounded flex items-center justify-center hover:scale-110 transition-transform cursor-pointer shadow-sm" title="QRIS/E-Wallet">
            <svg class="w-6 h-5 text-bloom-primary" fill="currentColor" viewBox="0 0 24 24">
              <path d="M3 11h8V3H3v8zm0 8h8v-8H3v8zm10 0h8v-8h-8v8zm0-18v8h8V3h-8z"/>
            </svg>
          </div>
        </div>
      </div>

      <!-- Copyright -->
      <div class="text-center">
        <p class="text-sm text-bloom-accent font-light">
          Copyright &copy; 2026 Bloomify. Semua hak dilindungi.
        </p>
      </div>

      <!-- Legal Links -->
      <div class="flex justify-center md:justify-end space-x-4">
        <a href="{{ route('privacy') }}" class="text-sm text-bloom-accent hover:text-white transition-colors font-light">
          Privasi
        </a>
        <span class="text-bloom-accent/60">•</span>
        <a href="{{ route('terms') }}" class="text-sm text-bloom-accent hover:text-white transition-colors font-light">
          Syarat
        </a>
      </div>
    </div>
    </div>
  </div>
</footer>

