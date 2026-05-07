<footer class="bg-bloom-teal text-bloom-ivory mt-20">
  <!-- Main Footer Content -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
      <!-- Company Info -->
      <div class="space-y-4">
        <h3 class="text-xl font-semibold text-bloom-cream">Bloomify</h3>
        <p class="text-bloom-ivory text-sm leading-relaxed font-light">
          Toko bunga online premium yang menyediakan buket bunga berkualitas terbaik untuk setiap momen spesial Anda.
        </p>
        <div class="flex space-x-4 pt-2">
          <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-bloom-teal-light hover:bg-bloom-mint text-white rounded-full flex items-center justify-center transition-colors" title="Facebook">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
            </svg>
          </a>
          <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-bloom-teal-light hover:bg-bloom-mint text-white rounded-full flex items-center justify-center transition-colors" title="Twitter">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2s9 5 20 5a9.5 9.5 0 00-9-5.5c4.75 2.25 7-7 7-7a10.6 10.6 0 01-10 5.5"/>
            </svg>
          </a>
          <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="w-10 h-10 bg-bloom-teal-light hover:bg-bloom-mint text-white rounded-full flex items-center justify-center transition-colors" title="Instagram">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <rect x="2" y="2" width="20" height="20" rx="5" ry="5" stroke="currentColor" stroke-width="2" fill="none"/>
              <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37Z" fill="currentColor"/>
              <circle cx="17.5" cy="6.5" r="1.5" fill="currentColor"/>
            </svg>
          </a>
        </div>
        <!-- Team -->
        <div class="pt-4 border-t border-bloom-teal-light">
          <p class="text-xs text-bloom-ivory/70 font-light mb-2">Tim:</p>
          <p class="text-sm text-bloom-ivory font-light">
            <span class="text-bloom-mint font-semibold">Dhito</span> • <span class="text-bloom-mint font-semibold">Cindy</span> • <span class="text-bloom-mint font-semibold">Surya</span>
          </p>
        </div>
      </div>

      <!-- Quick Links -->
      <div class="space-y-4">
        <h4 class="text-lg font-semibold text-bloom-cream">Navigasi</h4>
        <ul class="space-y-2 text-sm">
          <li>
            <a href="{{ route('welcome') }}" class="text-bloom-ivory hover:text-bloom-mint transition-colors font-light">
              Beranda
            </a>
          </li>
          <li>
            <a href="{{ route('products.index') }}" class="text-bloom-ivory hover:text-bloom-mint transition-colors font-light">
              Katalog Produk
            </a>
          </li>
          @auth
          <li>
            <a href="{{ route('dashboard') }}" class="text-bloom-ivory hover:text-bloom-mint transition-colors font-light">
              Dashboard
            </a>
          </li>
          @endauth
          <li>
            <a href="{{ route('about') }}" class="text-bloom-ivory hover:text-bloom-mint transition-colors font-light">
              Tentang Kami
            </a>
          </li>
        </ul>
      </div>

      <!-- Categories -->
      <div class="space-y-4">
        <h4 class="text-lg font-semibold text-bloom-cream">Koleksi</h4>
        <ul class="space-y-2 text-sm">
          <li>
            <a href="{{ route('products.index') }}" class="text-bloom-ivory hover:text-bloom-mint transition-colors font-light">
              Semua Produk
            </a>
          </li>
          <li>
            <a href="{{ route('products.index') }}" class="text-bloom-ivory hover:text-bloom-mint transition-colors font-light">
              Buket Mawar
            </a>
          </li>
          <li>
            <a href="{{ route('products.index') }}" class="text-bloom-ivory hover:text-bloom-mint transition-colors font-light">
              Buket Matahari
            </a>
          </li>
          <li>
            <a href="{{ route('products.index') }}" class="text-bloom-ivory hover:text-bloom-mint transition-colors font-light">
              Rangkaian Spesial
            </a>
          </li>
        </ul>
      </div>

      <!-- Contact Info -->
      <div class="space-y-4">
        <h4 class="text-lg font-semibold text-bloom-cream">Hubungi Kami</h4>
        <div class="space-y-3 text-sm">
          <div>
            <p class="text-bloom-ivory font-medium">Alamat:</p>
            <p class="text-bloom-ivory text-xs font-light">
              Perum Permata Asri, Blok i4 No 30<br>
              Lampung Selatan, Indonesia
            </p>
          </div>
          <div>
            <p class="text-bloom-ivory font-medium">Email:</p>
            <a href="mailto:bloomify@gmail.com" class="text-bloom-mint hover:text-bloom-cream transition-colors font-light">
              bloomify@gmail.com
            </a>
          </div>
          <div>
            <p class="text-bloom-ivory font-medium">Telepon:</p>
            <a href="tel:+628123456789" class="text-bloom-mint hover:text-bloom-cream transition-colors font-light">
              +62 812 345 6789
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Divider -->
    <div class="border-t border-bloom-teal-light my-8"></div>

    <!-- Bottom Footer -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center text-center md:text-left">
      <!-- Payment Methods -->
      <div class="space-y-3">
        <p class="text-sm font-semibold text-bloom-cream">Metode Pembayaran</p>
        <div class="flex items-center space-x-3 justify-center md:justify-start">
          <!-- Visa -->
          <div class="w-12 h-8 bg-bloom-cream rounded flex items-center justify-center hover:scale-110 transition-transform cursor-pointer" title="Visa">
            <svg class="w-8 h-5" viewBox="0 0 48 32" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect width="48" height="32" rx="4" fill="#1435CB"/>
              <text x="24" y="20" font-size="10" font-weight="bold" fill="white" text-anchor="middle">VISA</text>
            </svg>
          </div>
          <!-- Mastercard -->
          <div class="w-12 h-8 bg-bloom-cream rounded flex items-center justify-center hover:scale-110 transition-transform cursor-pointer" title="Mastercard">
            <svg class="w-8 h-5" viewBox="0 0 48 32" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect width="48" height="32" rx="4" fill="white" stroke="#EB001B" stroke-width="1"/>
              <circle cx="18" cy="16" r="7" fill="#EB001B"/>
              <circle cx="30" cy="16" r="7" fill="#F79E1B"/>
              <circle cx="24" cy="16" r="7" fill="url(#grad1)"/>
            </svg>
          </div>
          <!-- Bank Transfer -->
          <div class="w-12 h-8 bg-bloom-cream rounded flex items-center justify-center hover:scale-110 transition-transform cursor-pointer" title="Bank Transfer">
            <svg class="w-6 h-5 text-bloom-teal" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 1L2 6v3h20V6L12 1z"/>
              <path d="M2 9v10c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V9H2z"/>
              <path d="M12 13c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z"/>
            </svg>
          </div>
          <!-- E-Wallet / QRIS -->
          <div class="w-12 h-8 bg-bloom-cream rounded flex items-center justify-center hover:scale-110 transition-transform cursor-pointer" title="QRIS/E-Wallet">
            <svg class="w-6 h-5 text-bloom-teal" fill="currentColor" viewBox="0 0 24 24">
              <path d="M3 11h8V3H3v8zm0 8h8v-8H3v8zm10 0h8v-8h-8v8zm0-18v8h8V3h-8z"/>
            </svg>
          </div>
        </div>
      </div>

      <!-- Copyright -->
      <div class="text-center">
        <p class="text-sm text-bloom-ivory font-light">
          Copyright &copy; 2026 Bloomify. Semua hak dilindungi.
        </p>
      </div>

      <!-- Legal Links -->
      <div class="flex justify-center md:justify-end space-x-4">
        <a href="{{ route('privacy') }}" class="text-sm text-bloom-ivory hover:text-bloom-mint transition-colors font-light">
          Privasi
        </a>
        <span class="text-bloom-ivory text-opacity-50">•</span>
        <a href="{{ route('terms') }}" class="text-sm text-bloom-ivory hover:text-bloom-mint transition-colors font-light">
          Syarat
        </a>
      </div>
    </div>
  </div>
</footer>
