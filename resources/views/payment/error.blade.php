<x-app-layout>
    <div class="py-12 bg-bloom-ivory min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-red-100 shadow-sm overflow-hidden">
                {{-- Header --}}
                <div class="bg-gradient-to-r from-red-500 to-rose-500 px-8 py-10 text-center">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-white">Pembayaran Gagal</h1>
                    <p class="text-red-100 mt-2 text-sm">Transaksi tidak dapat diproses. Silakan coba kembali.</p>
                </div>

                {{-- Body --}}
                <div class="p-8">
                    <div class="bg-red-50 rounded-xl border border-red-100 p-5 mb-6">
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
                                <span class="px-2 py-0.5 bg-red-100 text-red-700 rounded-full text-xs font-medium">Gagal / Ditolak</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl border border-gray-100 p-4 mb-6">
                        <p class="text-sm text-gray-600 leading-relaxed">
                            Pembayaran gagal karena dibatalkan atau terjadi kesalahan. Pesanan Anda masih tersimpan dan Anda dapat mencoba membayar kembali.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('payment.show', $order->id) }}"
                           class="bg-bloom-teal hover:bg-bloom-teal/90 text-white font-semibold py-3 rounded-xl text-center text-sm transition-all">
                            Coba Bayar Lagi
                        </a>
                        <a href="{{ route('dashboard') }}"
                           class="border-2 border-bloom-teal text-bloom-teal hover:bg-bloom-cream font-semibold py-3 rounded-xl text-center text-sm transition-all">
                            Ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
