<x-app-layout>
    <div class="py-12 bg-bloom-ivory min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Flash Messages --}}
            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-red-700 text-sm">{{ session('error') }}</p>
                </div>
            @endif

            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Pembayaran Pesanan</h1>
                <p class="text-gray-600 text-sm mt-1">Selesaikan pembayaran untuk pesanan <span class="font-semibold text-bloom-teal">{{ $order->order_number }}</span></p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Order Summary --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl border border-bloom-mint-light shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-bloom-mint-light bg-bloom-cream/40">
                            <h2 class="text-lg font-semibold text-gray-900">Ringkasan Pesanan</h2>
                        </div>
                        <div class="p-6 space-y-4">
                            @foreach($order->items as $item)
                                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                                    <div class="flex items-center gap-4">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}"
                                                 alt="{{ $item->product->name }}"
                                                 class="w-14 h-14 rounded-lg object-cover border border-bloom-mint-light">
                                        @else
                                            <div class="w-14 h-14 rounded-lg bg-bloom-cream flex items-center justify-center border border-bloom-mint-light">
                                                <svg class="w-6 h-6 text-bloom-teal/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-medium text-gray-900 text-sm">{{ $item->product->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    <p class="font-semibold text-gray-900 text-sm">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                                </div>
                            @endforeach
                        </div>
                        <div class="px-6 py-4 bg-bloom-cream/30 border-t border-bloom-mint-light">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-700">Total Pembayaran</span>
                                <span class="text-xl font-bold text-bloom-teal">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Shipping Info --}}
                    <div class="bg-white rounded-2xl border border-bloom-mint-light shadow-sm p-6 mt-4">
                        <h2 class="text-base font-semibold text-gray-900 mb-3">Alamat Pengiriman</h2>
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $order->shipping_address }}</p>
                        @if($order->notes)
                            <p class="text-xs text-gray-500 mt-2">Catatan: {{ $order->notes }}</p>
                        @endif
                    </div>
                </div>

                {{-- Payment Panel --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl border border-bloom-mint-light shadow-sm overflow-hidden sticky top-6">
                        <div class="px-6 py-4 border-b border-bloom-mint-light bg-gradient-to-r from-bloom-teal/10 to-bloom-mint/10">
                            <h2 class="text-base font-semibold text-gray-900">Detail Pembayaran</h2>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">No. Pesanan</span>
                                    <span class="font-medium text-gray-900">{{ $order->order_number }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Status</span>
                                    <span class="px-2 py-0.5 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">Menunggu Pembayaran</span>
                                </div>
                            </div>

                            <div class="border-t border-bloom-mint-light pt-4">
                                <div class="flex justify-between text-base font-semibold">
                                    <span>Total</span>
                                    <span class="text-bloom-teal">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            {{-- Pay Button --}}
                            <button id="pay-button"
                                    onclick="startPayment()"
                                    class="w-full bg-bloom-teal hover:bg-bloom-teal/90 active:scale-95 text-white font-semibold py-3.5 rounded-xl transition-all duration-200 flex items-center justify-center gap-2 shadow-md hover:shadow-lg mt-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                <span id="pay-button-text">Bayar Sekarang</span>
                            </button>

                            <div id="pay-loading" class="hidden w-full bg-gray-100 text-gray-500 font-medium py-3.5 rounded-xl text-center text-sm">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                                    </svg>
                                    Memuat pembayaran...
                                </div>
                            </div>

                            <p class="text-xs text-gray-400 text-center leading-relaxed">
                                Pembayaran diproses secara aman oleh <span class="font-medium text-gray-600">Midtrans</span>. Anda dapat menggunakan kartu kredit, transfer bank, atau dompet digital.
                            </p>
                        </div>
                    </div>

                    {{-- Security Badge --}}
                    <div class="mt-4 bg-green-50 rounded-xl border border-green-100 p-4 flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <div>
                            <p class="text-xs font-semibold text-green-800">Transaksi Aman & Terenkripsi</p>
                            <p class="text-xs text-green-600 mt-0.5">Data pembayaran Anda dilindungi enkripsi SSL 256-bit</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Midtrans Snap JS --}}
    @if(config('midtrans.is_production'))
        <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    @else
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    @endif

    <script>
        const ORDER_ID = {{ $order->id }};
        const TOKEN_URL = "{{ route('payment.token', $order->id) }}";
        const FINISH_URL = "{{ route('payment.finish', $order->id) }}";
        const ERROR_URL  = "{{ route('payment.error', $order->id) }}";
        const PENDING_URL = "{{ route('payment.pending', $order->id) }}";
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;

        async function startPayment() {
            const btn = document.getElementById('pay-button');
            const loading = document.getElementById('pay-loading');

            btn.disabled = true;
            btn.classList.add('hidden');
            loading.classList.remove('hidden');

            try {
                const response = await fetch(TOKEN_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                    },
                });

                const data = await response.json();

                if (!data.success) {
                    throw new Error(data.message || 'Gagal mendapatkan token pembayaran');
                }

                // Open Midtrans Snap popup
                snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        window.location.href = FINISH_URL + '?order_id=' + result.order_id + '&transaction_status=' + result.transaction_status;
                    },
                    onPending: function(result) {
                        window.location.href = PENDING_URL + '?order_id=' + result.order_id + '&transaction_status=' + result.transaction_status;
                    },
                    onError: function(result) {
                        window.location.href = ERROR_URL + '?order_id=' + result.order_id;
                    },
                    onClose: function() {
                        // User closed the popup, re-enable button
                        btn.disabled = false;
                        btn.classList.remove('hidden');
                        loading.classList.add('hidden');
                    }
                });

            } catch (error) {
                console.error('Payment error:', error);
                btn.disabled = false;
                btn.classList.remove('hidden');
                loading.classList.add('hidden');

                // Show error message
                const errorDiv = document.createElement('div');
                errorDiv.className = 'mt-3 p-3 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm';
                errorDiv.textContent = error.message || 'Terjadi kesalahan. Silakan coba lagi.';
                btn.parentNode.insertBefore(errorDiv, btn.nextSibling);
                setTimeout(() => errorDiv.remove(), 5000);
            }
        }
    </script>
</x-app-layout>
