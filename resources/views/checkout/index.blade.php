<x-app-layout>
    <!-- Tambahkan CSS TomSelect untuk dropdown interaktif -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap4.min.css" rel="stylesheet">
    
    <style>
        /* Penyesuaian style agar sesuai dengan desain Tailwind kita */
        .ts-control {
            border: 1px solid #e5e7eb !important;
            padding: 0.75rem 1rem !important;
            border-radius: 0.75rem !important;
            font-size: 1rem !important;
            box-shadow: none !important;
        }
        .ts-control.focus {
            border-color: #5eead4 !important; /* bloom-primary/50 */
            box-shadow: 0 0 0 2px rgba(94, 234, 212, 0.5) !important;
        }
    </style>

    <div class="py-12 bg-gradient-to-b from-white to-gray-50">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-12">
                <h1 class="text-5xl font-light text-gray-900 mb-2">Checkout</h1>
                <p class="text-gray-600 font-light text-lg">Selesaikan pembelian Anda dengan aman</p>
            </div>

            {{-- Flash Messages --}}
            @if(session('error'))
                <div class="mb-8 bg-red-50 border border-red-200 rounded-xl p-4 flex items-start gap-3 shadow-sm">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-red-700 text-sm font-medium">{{ session('error') }}</p>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-8 bg-green-50 border border-green-200 rounded-xl p-4 flex items-start gap-3 shadow-sm">
                    <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-green-700 text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Checkout Form -->
                <div class="lg:col-span-2 space-y-6">
                    <form id="checkoutForm" action="{{ route('checkout.submit') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Order Items Summary Card -->
                        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
                            <h2 class="text-2xl font-semibold text-gray-900 mb-6 flex items-center gap-3">
                                <svg class="w-6 h-6 text-bloom-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                Ringkasan Pesanan
                            </h2>
                            <div class="space-y-4">
                                @foreach($cartItems as $item)
                                    <div class="flex items-start justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                                        <div class="flex-1">
                                            <p class="font-semibold text-gray-900">{{ $item->product->name }}</p>
                                            <p class="text-sm text-gray-600 mt-1">
                                                {{ $item->quantity }}x × Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                        <p class="font-bold text-bloom-primary text-lg">
                                            Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Shipping Information Card -->
                        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
                            <h2 class="text-2xl font-semibold text-gray-900 mb-6 flex items-center gap-3">
                                <svg class="w-6 h-6 text-bloom-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Alamat Pengiriman
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <label for="shipping_address" class="block text-sm font-semibold text-gray-700 mb-3">Alamat Lengkap</label>
                                    <textarea id="shipping_address" name="shipping_address" rows="3" 
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-bloom-primary/50 focus:border-bloom-primary text-gray-900 placeholder-gray-500" 
                                        placeholder="Contoh: Jl. Merdeka No. 123, Blok A" required>{{ old('shipping_address', $user->address ?? '') }}</textarea>
                                    @error('shipping_address')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-3">Nomor Telepon</label>
                                    <input type="tel" id="phone" name="phone" 
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-bloom-primary/50 focus:border-bloom-primary text-gray-900 placeholder-gray-500" 
                                        placeholder="+62 812 3456 7890" required value="{{ old('phone', $user->phone ?? '') }}">
                                    @error('phone')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="city" class="block text-sm font-semibold text-gray-700 mb-3">Kota / Kabupaten</label>
                                    <select id="city" name="city" placeholder="Ketik nama kota... (Cth: Lampung)">
                                        <option value="">Pilih Kota...</option>
                                        @php
                                            $zones = config('shipping.zones');
                                            // Urutkan kota sesuai abjad agar lebih mudah dicari
                                            ksort($zones);
                                        @endphp
                                        @foreach($zones as $cityName => $details)
                                            <option value="{{ $cityName }}" {{ old('city', $user->city ?? '') === $cityName ? 'selected' : '' }}>
                                                {{ $cityName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('city')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="postal_code" class="block text-sm font-semibold text-gray-700 mb-3">Kode Pos</label>
                                    <input type="text" id="postal_code" name="postal_code" 
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-bloom-primary/50 focus:border-bloom-primary text-gray-900 placeholder-gray-500" 
                                        placeholder="12345" value="{{ old('postal_code', $user->postal_code ?? '') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Method Card -->
                        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
                            <h2 class="text-2xl font-semibold text-gray-900 mb-6 flex items-center gap-3">
                                <svg class="w-6 h-6 text-bloom-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                </svg>
                                Pilih Kurir & Layanan
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div>
                                    <label for="courier" class="block text-sm font-semibold text-gray-700 mb-3">Kurir Pengiriman</label>
                                    <select id="courier" name="courier" 
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-bloom-primary/50 focus:border-bloom-primary text-gray-900" required>
                                        <option value="">Pilih Kurir...</option>
                                        @foreach($couriers as $courierCode => $courierData)
                                            <option value="{{ $courierCode }}">
                                                {{ $courierData['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('courier')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="service" class="block text-sm font-semibold text-gray-700 mb-3">Tipe Layanan</label>
                                    <select id="service" name="service" 
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-bloom-primary/50 focus:border-bloom-primary text-gray-900" required disabled>
                                        <option value="">Pilih Kurir terlebih dahulu</option>
                                    </select>
                                    @error('service')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Shipping Info Display -->
                            <div id="shippingInfo" class="hidden p-4 bg-gradient-to-r from-bloom-primary/10 to-bloom-accent/10 rounded-xl border border-bloom-primary/20">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-gray-600 font-semibold mb-1">Estimasi Tiba</p>
                                        <p id="shippingEstimate" class="text-lg font-semibold text-bloom-primary">-</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-600 font-semibold mb-1">Biaya Pengiriman</p>
                                        <p id="shippingCostDisplay" class="text-lg font-semibold text-bloom-secondary">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notes Card -->
                        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
                            <label for="notes" class="block text-sm font-semibold text-gray-700 mb-3">Catatan Tambahan (Opsional)</label>
                            <textarea id="notes" name="notes" rows="3" 
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-bloom-primary/50 focus:border-bloom-primary text-gray-900 placeholder-gray-500" 
                                placeholder="Contoh: Tolong bungkus kado, jangan sampai basah, dll">{{ old('notes') }}</textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-gradient-to-r from-bloom-primary to-bloom-accent hover:from-bloom-primary/90 hover:to-bloom-accent/90 text-white font-bold py-4 rounded-xl transition duration-300 transform hover:scale-105 active:scale-95 shadow-lg">
                            Lanjutkan ke Pembayaran
                        </button>
                    </form>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 sticky top-24 h-fit">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-bloom-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Total Pesanan
                        </h2>

                        <div class="space-y-4 mb-8 pb-8 border-b border-gray-200">
                            <div class="flex justify-between text-gray-600 font-light">
                                <span>Subtotal Barang</span>
                                <span id="subtotalDisplay" class="font-semibold text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600 font-light">
                                <span>Biaya Pengiriman</span>
                                <span id="shippingCostSidebar" class="font-semibold text-bloom-secondary">Rp 0</span>
                            </div>
                        </div>

                        <div class="mb-6">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-900">Total Bayar</span>
                                <span id="totalDisplay" class="text-3xl font-black bg-gradient-to-r from-bloom-primary to-bloom-accent bg-clip-text text-transparent">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <div class="p-4 bg-gradient-to-br from-bloom-primary/5 to-bloom-accent/5 rounded-xl border border-bloom-primary/20">
                            <p class="text-xs text-gray-700 leading-relaxed">
                                <strong>✓ Aman & Terpercaya</strong><br>
                                Pembayaran terenkripsi dan data Anda aman
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS TomSelect -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <!-- JavaScript for Dynamic Shipping -->
    <script>
        // Inisialisasi TomSelect pada dropdown kota
        document.addEventListener('DOMContentLoaded', function() {
            new TomSelect("#city", {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                maxOptions: 15, // Membatasi maksimal 15 tampilan sesuai permintaan
                placeholder: "Ketik nama kota... (Cth: Lampung)"
            });
        });

        const couriers = @json($couriers);
        let subtotal = {{ $total }};
        let currentShippingCost = 0;

        // Update service dropdown when courier changes
        document.getElementById('courier').addEventListener('change', function() {
            const serviceSelect = document.getElementById('service');
            serviceSelect.innerHTML = '<option value="">Pilih Layanan...</option>';
            
            if (this.value && couriers[this.value]) {
                const services = couriers[this.value].services;
                Object.keys(services).forEach(serviceCode => {
                    const option = document.createElement('option');
                    option.value = serviceCode;
                    option.textContent = services[serviceCode].name;
                    serviceSelect.appendChild(option);
                });
                serviceSelect.disabled = false;
            } else {
                serviceSelect.disabled = true;
            }
            
            // Reset shipping info
            document.getElementById('shippingInfo').classList.add('hidden');
            updateTotal();
        });

        // Calculate shipping cost when city or service changes
        document.getElementById('service').addEventListener('change', calculateShipping);
        document.getElementById('city').addEventListener('change', calculateShipping);

        function calculateShipping() {
            const city = document.getElementById('city').value;
            const courier = document.getElementById('courier').value;
            const service = document.getElementById('service').value;

            if (!city || !courier || !service) {
                document.getElementById('shippingInfo').classList.add('hidden');
                currentShippingCost = 0;
                updateTotal();
                return;
            }

            // Fetch shipping cost
            fetch(`{{ route('checkout.shipping-cost') }}?city=${city}&courier=${courier}&service=${service}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        currentShippingCost = data.cost;
                        document.getElementById('shippingEstimate').textContent = data.estimate;
                        document.getElementById('shippingCostDisplay').textContent = data.formatted_cost;
                        document.getElementById('shippingCostSidebar').textContent = data.formatted_cost;
                        document.getElementById('shippingInfo').classList.remove('hidden');
                        updateTotal();
                    } else {
                        alert(data.message);
                        document.getElementById('shippingInfo').classList.add('hidden');
                        currentShippingCost = 0;
                        updateTotal();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal menghitung ongkos kirim. Silakan coba lagi.');
                });
        }

        function updateTotal() {
            const total = subtotal + currentShippingCost;
            document.getElementById('totalDisplay').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        }
    </script>
</x-app-layout>

