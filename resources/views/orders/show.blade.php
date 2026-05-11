<x-app-layout>
    <div class="py-12 bg-bloom-bg-light">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
            <div class="mb-8 bg-green-50 border border-green-200 rounded-lg p-6">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-lg font-semibold text-green-800">Pesanan Berhasil Dibuat!</h3>
                        <p class="text-green-700 text-sm mt-1">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            @if(session('info'))
            <div class="mb-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-blue-700 text-sm">{{ session('info') }}</p>
            </div>
            @endif

            <!-- Order Details Card -->
            <div class="bg-white rounded-lg border border-bloom-accent-light shadow-sm p-8 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 pb-8 border-b border-bloom-accent-light">
                    <!-- Order Info -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Pesanan</h2>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-600">No. Pesanan</p>
                                <p class="text-lg font-semibold text-bloom-primary">{{ $order->order_number }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Tanggal Pesanan</p>
                                <p class="font-medium text-gray-900">{{ $order->created_at->format('d M Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Status Pesanan</p>
                                <span class="inline-block px-3 py-1 bg-bloom-accent text-white text-sm font-medium rounded-full">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>

                            {{-- Payment Status Badge --}}
                            @if($order->payment)
                            <div>
                                <p class="text-sm text-gray-600">Status Pembayaran</p>
                                @php
                                    $paymentStatus = $order->payment->status;
                                    $badgeClass = match($paymentStatus) {
                                        'success'  => 'bg-green-100 text-green-700',
                                        'pending'  => 'bg-yellow-100 text-yellow-700',
                                        'failed'   => 'bg-red-100 text-red-700',
                                        'expired'  => 'bg-gray-100 text-gray-600',
                                        default    => 'bg-gray-100 text-gray-600',
                                    };
                                    $paymentLabel = match($paymentStatus) {
                                        'success'  => 'Lunas',
                                        'pending'  => 'Menunggu Pembayaran',
                                        'failed'   => 'Gagal',
                                        'expired'  => 'Kedaluwarsa',
                                        default    => ucfirst($paymentStatus),
                                    };
                                @endphp
                                <span class="inline-block px-3 py-1 text-sm font-medium rounded-full {{ $badgeClass }}">
                                    {{ $paymentLabel }}
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Alamat Pengiriman</h2>
                        <div class="bg-bloom-bg-cream rounded-lg p-4 border border-bloom-accent-light">
                            <p class="text-gray-900 font-medium mb-2">{{ Auth::user()->name }}</p>
                            <p class="text-gray-700 text-sm mb-2">{{ $order->shipping_address }}</p>
                            @if($order->notes)
                                <div class="mt-3 pt-3 border-t border-bloom-accent-light">
                                    <p class="text-xs text-gray-600 font-medium">Catatan:</p>
                                    <p class="text-sm text-gray-700">{{ $order->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="mb-8 pb-8 border-b border-bloom-accent-light">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Produk yang Dipesan</h2>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                            <div class="p-6 bg-gray-50 rounded-2xl border border-gray-100 hover:border-bloom-primary/30 transition-all duration-300">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex gap-4">
                                        <div class="w-16 h-16 bg-white rounded-xl border border-gray-100 overflow-hidden flex-shrink-0">
                                            @if($item->product->image_url)
                                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center bg-bloom-bg-cream text-bloom-primary">
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-gray-900 text-lg">{{ $item->product->name }}</h3>
                                            <p class="text-sm text-gray-500 font-medium">Qty: {{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    <p class="font-bold text-bloom-primary text-xl">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                                </div>

                                {{-- Review Section --}}
                                @if($order->status === 'completed' || $order->status === 'delivered')
                                    @php
                                        $hasReview = \App\Models\Review::where('order_id', $order->id)
                                            ->where('product_id', $item->product_id)
                                            ->first();
                                    @endphp

                                    <div class="mt-4 pt-4 border-t border-gray-200">
                                        @if(!$hasReview)
                                            <div x-data="{ rating: 0, hover: 0 }" class="bg-white p-4 rounded-xl border border-bloom-accent-light shadow-sm">
                                                <h4 class="text-sm font-bold text-gray-900 mb-3 flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                                    Bagikan Pengalaman Anda
                                                </h4>
                                                <form action="{{ route('reviews.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                    <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                                    <input type="hidden" name="rating" :value="rating">
                                                    
                                                    <div class="flex items-center gap-1 mb-4">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <button type="button" 
                                                                @click="rating = {{ $i }}" 
                                                                @mouseenter="hover = {{ $i }}" 
                                                                @mouseleave="hover = 0"
                                                                class="focus:outline-none transition-transform active:scale-125">
                                                                <svg class="w-8 h-8 transition-colors" 
                                                                    :class="(hover || rating) >= {{ $i }} ? 'text-yellow-400' : 'text-gray-200'"
                                                                    fill="currentColor" viewBox="0 0 20 20">
                                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            </button>
                                                        @endfor
                                                        <span class="ml-2 text-sm font-medium text-gray-500" x-text="rating > 0 ? rating + '/5' : 'Pilih rating'"></span>
                                                    </div>

                                                    <textarea name="comment" 
                                                        class="w-full text-sm border-gray-200 rounded-xl p-3 focus:ring-bloom-primary focus:border-bloom-primary transition-all mb-4" 
                                                        placeholder="Ceritakan kualitas produk ini..."
                                                        rows="2"></textarea>
                                                    
                                                    <button type="submit" 
                                                        ::disabled="rating === 0"
                                                        class="w-full bg-bloom-primary text-white font-bold py-2 rounded-xl text-sm hover:bg-bloom-primary/90 disabled:opacity-50 disabled:cursor-not-allowed transition-all shadow-sm">
                                                        Kirim Ulasan
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <div class="bg-green-50 p-4 rounded-xl border border-green-100">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <div class="flex text-yellow-400">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <svg class="w-4 h-4 {{ $i <= $hasReview->rating ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                                        @endfor
                                                    </div>
                                                    <span class="text-xs font-bold text-green-700">✓ Ulasan Terkirim</span>
                                                </div>
                                                <p class="text-sm text-gray-600 italic">"{{ $hasReview->comment }}"</p>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Total -->
                <div class="space-y-3">
                    <div class="border-t border-bloom-accent-light pt-3 flex justify-between text-xl font-semibold">
                        <span>Total Pesanan</span>
                        <span class="text-bloom-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Payment Action Card --}}
            @php
                $isPaid = $order->payment && $order->payment->status === 'success';
                $canPay = $order->status === 'pending' && !$isPaid;
            @endphp

            @if($canPay)
            <div class="bg-gradient-to-r from-bloom-primary/10 to-bloom-accent/10 rounded-xl border border-bloom-accent-light p-6 mb-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Selesaikan Pembayaran</h3>
                        <p class="text-sm text-gray-600 mt-1">Bayar pesanan Anda dengan aman melalui Midtrans — kartu kredit, transfer bank, atau dompet digital.</p>
                    </div>
                    <a href="{{ route('payment.show', $order->id) }}"
                       class="flex items-center gap-2 bg-bloom-primary hover:bg-bloom-primary/90 text-white font-semibold px-6 py-3 rounded-xl transition-all shadow-md hover:shadow-lg whitespace-nowrap">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        Bayar Sekarang
                    </a>
                </div>
            </div>
            @elseif($isPaid)
            <div class="bg-green-50 rounded-xl border border-green-100 p-6 mb-8 flex items-center gap-4">
                <svg class="w-8 h-8 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="font-semibold text-green-800">Pembayaran Lunas</p>
                    <p class="text-sm text-green-600">Pesanan Anda sedang diproses oleh tim Bloomify.</p>
                </div>
            </div>
            @endif

            <!-- Next Steps -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="bg-white rounded-lg border border-bloom-accent-light shadow-sm p-6">
                    <div class="flex items-start gap-3 mb-3">
                        <svg class="w-6 h-6 text-bloom-primary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="font-semibold text-gray-900">Langkah Selanjutnya</h3>
                    </div>
                    <ol class="text-sm text-gray-700 space-y-2 ml-9">
                        <li>1. Selesaikan pembayaran melalui tombol "Bayar Sekarang"</li>
                        <li>2. Tim kami akan menghubungi untuk konfirmasi pengiriman</li>
                        <li>3. Pesanan akan diproses dalam 1-2 jam kerja</li>
                    </ol>
                </div>

                <div class="bg-white rounded-lg border border-bloom-accent-light shadow-sm p-6">
                    <div class="flex items-start gap-3 mb-3">
                        <svg class="w-6 h-6 text-bloom-secondary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="font-semibold text-gray-900">Hubungi Kami</h3>
                    </div>
                    <p class="text-sm text-gray-700 ml-9">Jika ada pertanyaan, hubungi kami di:</p>
                    <p class="text-sm font-medium text-bloom-primary ml-9 mt-2">WhatsApp: +62 812 345 678</p>
                    <p class="text-sm font-medium text-bloom-primary ml-9">Email: bloomify@gmail.com</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4">
                <a href="{{ route('dashboard') }}" class="flex-1 bg-bloom-primary hover:bg-bloom-primary/90 text-white font-semibold py-3 rounded-lg transition text-center">
                    Lihat Dashboard
                </a>
                <a href="{{ route('products.index') }}" class="flex-1 border-2 border-bloom-primary text-bloom-primary hover:bg-bloom-bg-cream font-semibold py-3 rounded-lg transition text-center">
                    Belanja Lagi
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

