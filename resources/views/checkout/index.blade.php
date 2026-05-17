<x-app-layout>
    <!-- Tambahkan CSS TomSelect untuk dropdown interaktif -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap4.min.css" rel="stylesheet">
    
    <style>
        /* Penyesuaian style agar sesuai dengan desain Tailwind kita */
        .ts-control {
            border: 2px solid #cc93a2 !important;
            padding: 0.75rem 1rem !important;
            border-radius: 0.75rem !important;
            font-size: 1rem !important;
            box-shadow: none !important;
            background-color: #d6acad !important;
            color: #ffffff !important;
        }
        .ts-control.focus {
            border-color: #aa6778 !important;
            box-shadow: 0 0 0 2px rgba(170, 103, 120, 0.3) !important;
        }
        .ts-dropdown {
            border-color: #cc93a2 !important;
            background-color: #e2d0d0 !important;
        }
        .ts-dropdown-content {
            background-color: #e2d0d0 !important;
        }
        .ts-dropdown-content .option {
            color: #b78493 !important;
        }
        .ts-dropdown-content .option.selected {
            background-color: #aa6778 !important;
            color: white !important;
        }
        .ts-dropdown-content .option:hover {
            background-color: #d6acad !important;
            color: #ffffff !important;
        }
    </style>

    <div style="background: linear-gradient(to bottom right, #e2d0d0, #e2d0d0); background-attachment: fixed;" class="py-12 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-12">
                <h1 style="color: #aa6778;" class="text-5xl font-light mb-2">Checkout</h1>
                <p style="color: #b78493;" class="font-light text-lg">Selesaikan pembelian Anda dengan aman</p>
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
                        <div style="background: #DA9CA3; border-color: #DA9CA3;" class="rounded-2xl border-2 shadow-soft p-8">
                            <h2 style="color: #7A7A7A;" class="text-2xl font-semibold mb-6 flex items-center gap-3">
                                <svg style="color: #7A7A7A;" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                Ringkasan Pesanan
                            </h2>
                            <div class="space-y-4">
                                @foreach($cartItems as $item)
                                    <div style="background: #E9B7BD; border-color: #E9B7BD;" class="flex items-start justify-between p-4 rounded-xl border-2 hover:opacity-90 transition">
                                        <div class="flex-1">
                                            <p style="color: #7A7A7A;" class="font-semibold">{{ $item->product->name }}</p>
                                            <p style="color: #5A5A5A;" class="text-sm mt-1">
                                                {{ $item->quantity }}x Ã— Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                        <p style="color: #7A7A7A;" class="font-bold text-lg">
                                            Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Shipping Information Card -->
                        <div style="background: #DA9CA3; border-color: #DA9CA3;" class="rounded-2xl border-2 shadow-soft p-8">
                            <h2 style="color: #7A7A7A;" class="text-2xl font-semibold mb-6 flex items-center gap-3">
                                <svg style="color: #7A7A7A;" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Alamat Pengiriman
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <label for="shipping_address" style="color: #7A7A7A;" class="block text-sm font-semibold mb-3">Alamat Lengkap</label>
                                    <textarea id="shipping_address" name="shipping_address" rows="3" 
                                        style="border-color: #E8B8C1; background-color: #E9B7BD; color: #7A7A7A;" class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:ring-2" 
                                        placeholder="Contoh: Jl. Merdeka No. 123, Blok A" required>{{ old('shipping_address', $user->address ?? '') }}</textarea>
                                    @error('shipping_address')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="phone" style="color: #7A7A7A;" class="block text-sm font-semibold mb-3">Nomor Telepon</label>
                                    <input type="tel" id="phone" name="phone" 
                                        style="border-color: #E8B8C1; background-color: #E9B7BD; color: #7A7A7A;" class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:ring-2" 
                                        placeholder="+62 812 3456 7890" required value="{{ old('phone', $user->phone ?? '') }}">
                                    @error('phone')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="city" style="color: #7A7A7A;" class="block text-sm font-semibold mb-3">Kota / Kabupaten</label>
                                    <select id="city" name="city" placeholder="Ketik nama kota... (Cth: Lampung)" style="border-color: #E8B8C1; background-color: #E9B7BD; color: #7A7A7A;">
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
                                    <label for="postal_code" class="block text-sm font-semibold text-white mb-3">Kode Pos</label>
                                    <input type="text" id="postal_code" name="postal_code" 
                                        class="w-full px-4 py-3 border-2 border-bloom-fuchsia/50 rounded-xl focus:outline-none focus:ring-2 focus:ring-bloom-fuchsia/50 focus:border-bloom-fuchsia text-white placeholder-white/60 bg-bloom-fuchsia/20" 
                                        placeholder="12345" value="{{ old('postal_code', $user->postal_code ?? '') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Shipping Method Card -->
                        <div style="background: #DA9CA3; border-color: #DA9CA3;" class="rounded-2xl border-2 shadow-soft p-8">
                            <h2 style="color: #7A7A7A;" class="text-2xl font-semibold mb-6 flex items-center gap-3">
                                <svg style="color: #7A7A7A;" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                </svg>
                                Pilih Kurir & Layanan
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div>
                                    <label for="courier" style="color: #7A7A7A;" class="block text-sm font-semibold mb-3">Kurir Pengiriman</label>
                                    <select id="courier" name="courier" 
                                        style="border-color: #E8B8C1; background-color: #E9B7BD; color: #7A7A7A;" class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:ring-2" required>
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
                                    <label for="service" style="color: #7A7A7A;" class="block text-sm font-semibold mb-3">Tipe Layanan</label>
                                    <select id="service" name="service" 
                                        style="border-color: #E8B8C1; background-color: #E9B7BD; color: #7A7A7A;" class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:ring-2" required disabled>
                                        <option value="">Pilih Kurir terlebih dahulu</option>
                                    </select>
                                    @error('service')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Shipping Info Display -->
                            <div id="shippingInfo" class="hidden p-4 bg-bloom-fuchsia/20 rounded-xl border-2 border-bloom-fuchsia/50">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-white font-semibold mb-1">Estimasi Tiba</p>
                                        <p id="shippingEstimate" class="text-lg font-semibold text-white">-</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-white font-semibold mb-1">Biaya Pengiriman</p>
                                        <p id="shippingCostDisplay" class="text-lg font-semibold text-white">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notes Card -->
                        <div style="background: #DA9CA3; border-color: #DA9CA3;" class="rounded-2xl border-2 shadow-soft p-8">
                            <label for="notes" style="color: #7A7A7A;" class="block text-sm font-semibold mb-3">Catatan Tambahan (Opsional)</label>
                            <textarea id="notes" name="notes" rows="3" 
                                style="border-color: #E8B8C1; background-color: #E9B7BD; color: #7A7A7A;" class="w-full px-4 py-3 border-2 rounded-xl focus:outline-none focus:ring-2" 
                                placeholder="Contoh: Tolong bungkus kado, jangan sampai basah, dll">{{ old('notes') }}</textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" style="background-color: #7A7A7A; color: white;" class="w-full font-bold py-4 rounded-xl transition duration-300 transform hover:scale-105 active:scale-95 shadow-lg">
                            Lanjutkan ke Pembayaran
                        </button>
                    </form>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="lg:col-span-1">
                    <div style="background: #E9B7BD; border-color: #E9B7BD;" class="rounded-2xl border-2 shadow-soft p-8 sticky top-24 h-fit">
                        <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Total Pesanan
                        </h2>

                        <div class="space-y-4 mb-8 pb-8 border-b border-white/30">
                            <div class="flex justify-between text-white/90 font-light">
                                <span>Subtotal Barang</span>
                                <span id="subtotalDisplay" class="font-semibold text-white">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-white/90 font-light">
                                <span>Biaya Pengiriman</span>
                                <span id="shippingCostSidebar" class="font-semibold text-white">Rp 0</span>
                            </div>
                        </div>

                        <div class="mb-6">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-white">Total Bayar</span>
                                <span id="totalDisplay" class="text-3xl font-black text-white">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <div class="p-4 bg-white/20 rounded-xl border border-white/30">
                            <p class="text-xs text-white leading-relaxed">
                                <strong>âœ“ Aman & Terpercaya</strong><br>
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









