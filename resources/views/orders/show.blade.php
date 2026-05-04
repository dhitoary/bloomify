<x-app-layout>
    <div class="py-12 bg-bloom-ivory">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            <div class="mb-8 bg-green-50 border border-green-200 rounded-lg p-6">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-lg font-semibold text-green-800">Pesanan Berhasil Dibuat!</h3>
                        <p class="text-green-700 text-sm mt-1">Terima kasih telah berbelanja di Bloomify. Tim kami akan segera memproses pesanan Anda.</p>
                    </div>
                </div>
            </div>

            <!-- Order Details Card -->
            <div class="bg-white rounded-lg border border-bloom-mint-light shadow-sm p-8 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 pb-8 border-b border-bloom-mint-light">
                    <!-- Order Info -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Pesanan</h2>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-600">No. Pesanan</p>
                                <p class="text-lg font-semibold text-bloom-teal">{{ $order->order_number }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Tanggal Pesanan</p>
                                <p class="font-medium text-gray-900">{{ $order->created_at->format('d M Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Status Pesanan</p>
                                <span class="inline-block px-3 py-1 bg-bloom-mint text-white text-sm font-medium rounded-full">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Alamat Pengiriman</h2>
                        <div class="bg-bloom-cream rounded-lg p-4 border border-bloom-mint-light">
                            <p class="text-gray-900 font-medium mb-2">{{ Auth::user()->name }}</p>
                            <p class="text-gray-700 text-sm mb-2">{{ $order->shipping_address }}</p>
                            @if($order->notes)
                                <div class="mt-3 pt-3 border-t border-bloom-mint-light">
                                    <p class="text-xs text-gray-600 font-medium">Catatan:</p>
                                    <p class="text-sm text-gray-700">{{ $order->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="mb-8 pb-8 border-b border-bloom-mint-light">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Produk yang Dipesan</h2>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ $item->product->name }}</h3>
                                    <p class="text-sm text-gray-600">Qty: {{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <p class="font-semibold text-bloom-teal text-lg">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Total -->
                <div class="space-y-3">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Ongkos Kirim</span>
                        <span class="text-bloom-coral">Akan dikonfirmasi</span>
                    </div>
                    <div class="border-t border-bloom-mint-light pt-3 flex justify-between text-xl font-semibold">
                        <span>Total Pesanan</span>
                        <span class="text-bloom-teal">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="bg-white rounded-lg border border-bloom-mint-light shadow-sm p-6">
                    <div class="flex items-start gap-3 mb-3">
                        <svg class="w-6 h-6 text-bloom-teal flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="font-semibold text-gray-900">Langkah Selanjutnya</h3>
                    </div>
                    <ol class="text-sm text-gray-700 space-y-2 ml-9">
                        <li>1. Tim kami akan menghubungi untuk konfirmasi pengiriman</li>
                        <li>2. Pastikan alamat dan nomor telepon Anda benar</li>
                        <li>3. Kami akan memproses pesanan dalam 1-2 jam kerja</li>
                    </ol>
                </div>

                <div class="bg-white rounded-lg border border-bloom-mint-light shadow-sm p-6">
                    <div class="flex items-start gap-3 mb-3">
                        <svg class="w-6 h-6 text-bloom-coral flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="font-semibold text-gray-900">Hubungi Kami</h3>
                    </div>
                    <p class="text-sm text-gray-700 ml-9">Jika ada pertanyaan, hubungi kami di:</p>
                    <p class="text-sm font-medium text-bloom-teal ml-9 mt-2">WhatsApp: +62 812 345 678</p>
                    <p class="text-sm font-medium text-bloom-teal ml-9">Email: bloomify@gmail.com</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4">
                <a href="{{ route('dashboard') }}" class="flex-1 bg-bloom-teal hover:bg-bloom-teal/90 text-white font-semibold py-3 rounded-lg transition text-center">
                    Lihat Dashboard
                </a>
                <a href="{{ route('products.index') }}" class="flex-1 border-2 border-bloom-teal text-bloom-teal hover:bg-bloom-cream font-semibold py-3 rounded-lg transition text-center">
                    Belanja Lagi
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
