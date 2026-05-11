<x-app-layout>
    <div class="py-12 bg-bloom-bg-light min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl border border-green-100 shadow-sm overflow-hidden">
                {{-- Header --}}
                <div class="bg-gradient-to-r from-green-500 to-emerald-500 px-8 py-10 text-center">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-white">Pembayaran Berhasil!</h1>
                    <p class="text-green-100 mt-2 text-sm">Terima kasih! Pembayaran Anda telah kami terima.</p>
                </div>

                {{-- Body --}}
                <div class="p-8">
                    <div class="bg-green-50 rounded-xl border border-green-100 p-5 mb-6">
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">No. Pesanan</span>
                                <span class="font-semibold text-gray-900">{{ $order->order_number }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Total Dibayar</span>
                                <span class="font-semibold text-green-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Status</span>
                                <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-medium">Pembayaran Diterima</span>
                            </div>
                        </div>
                    </div>

                    <p class="text-sm text-gray-600 text-center mb-6">
                        Tim Bloomify akan segera memproses pesanan Anda dan menghubungi Anda untuk konfirmasi pengiriman.
                    </p>

                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('order.show', $order->id) }}"
                           class="bg-bloom-primary hover:bg-bloom-primary/90 text-white font-semibold py-3 rounded-xl text-center text-sm transition-all">
                            Lihat Pesanan
                        </a>
                        <a href="{{ route('products.index') }}"
                           class="border-2 border-bloom-primary text-bloom-primary hover:bg-bloom-bg-cream font-semibold py-3 rounded-xl text-center text-sm transition-all">
                            Belanja Lagi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

