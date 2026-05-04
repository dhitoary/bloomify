<x-app-layout>
    <div class="py-12 bg-bloom-ivory min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-yellow-100 shadow-sm overflow-hidden">
                {{-- Header --}}
                <div class="bg-gradient-to-r from-yellow-400 to-amber-500 px-8 py-10 text-center">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-white">Pembayaran Menunggu</h1>
                    <p class="text-yellow-100 mt-2 text-sm">Pembayaran Anda sedang dalam proses verifikasi.</p>
                </div>

                {{-- Body --}}
                <div class="p-8">
                    <div class="bg-yellow-50 rounded-xl border border-yellow-100 p-5 mb-6">
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">No. Pesanan</span>
                                <span class="font-semibold text-gray-900">{{ $order->order_number }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Total Tagihan</span>
                                <span class="font-semibold text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Status</span>
                                <span class="px-2 py-0.5 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">Menunggu Konfirmasi</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-50 rounded-xl border border-blue-100 p-4 mb-6">
                        <p class="text-sm text-blue-700 leading-relaxed">
                            <span class="font-semibold">Apa selanjutnya?</span><br>
                            Selesaikan pembayaran sesuai instruksi yang dikirimkan. Status pesanan akan diperbarui otomatis setelah pembayaran dikonfirmasi oleh bank/penyedia layanan.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('payment.show', $order->id) }}"
                           class="bg-bloom-teal hover:bg-bloom-teal/90 text-white font-semibold py-3 rounded-xl text-center text-sm transition-all">
                            Cek Status Bayar
                        </a>
                        <a href="{{ route('products.index') }}"
                           class="border-2 border-bloom-teal text-bloom-teal hover:bg-bloom-cream font-semibold py-3 rounded-xl text-center text-sm transition-all">
                            Belanja Lagi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
