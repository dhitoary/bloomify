<x-app-layout>
    <div class="py-12 bg-white">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-light text-gray-900">Checkout</h1>
                <p class="text-gray-600 font-light">Selesaikan pembelian Anda</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Checkout Form -->
                <div class="lg:col-span-2">
                    <form action="{{ route('checkout.submit') }}" method="POST" class="bg-white rounded-lg border border-gray-200 shadow-sm p-8">
                        @csrf

                        <!-- Order Items Summary -->
                        <div class="mb-8 pb-8 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h2>
                            <div class="space-y-3">
                                @foreach($cartItems as $item)
                                    <div class="flex justify-between text-gray-700">
                                        <div>
                                            <p class="font-medium">{{ $item->product->name }}</p>
                                            <p class="text-sm text-gray-600">Qty: {{ $item->quantity }}</p>
                                        </div>
                                        <p class="font-semibold text-bloom-teal">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Shipping Information -->
                        <div class="mb-8 pb-8 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Pengiriman</h2>

                            <div class="mb-4">
                                <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-2">Alamat Pengiriman</label>
                                <textarea id="shipping_address" name="shipping_address" rows="4" 
                                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-bloom-teal text-gray-900" 
                                    placeholder="Jalan, No. Rumah, RT/RW, Kota, Provinsi, Kode Pos" required>{{ old('shipping_address', $user->address ?? '') }}</textarea>
                                @error('shipping_address')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                @if(!$user->address)
                                    <p class="text-xs text-amber-600 mt-2">💡 Anda dapat mengatur alamat default di <a href="{{ route('profile.edit') }}" class="font-medium hover:underline">profil</a></p>
                                @endif
                            </div>

                            <div class="mb-4">
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                                <input type="tel" id="phone" name="phone" 
                                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-bloom-teal text-gray-900" 
                                    placeholder="+62 812 XXXX XXXX" required value="{{ old('phone', $user->phone ?? '') }}">
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700 mb-2">Kota</label>
                                    <input type="text" id="city" name="city" 
                                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-bloom-teal text-gray-900" 
                                        placeholder="Jakarta, Bandung, dll" value="{{ old('city', $user->city ?? '') }}">
                                </div>
                                <div>
                                    <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">Kode Pos</label>
                                    <input type="text" id="postal_code" name="postal_code" 
                                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-bloom-teal text-gray-900" 
                                        placeholder="12345" value="{{ old('postal_code', $user->postal_code ?? '') }}">
                                </div>
                            </div>

                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                                <textarea id="notes" name="notes" rows="3" 
                                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-bloom-teal text-gray-900" 
                                    placeholder="Contoh: Tolong bungkus kado, beri kartu ucapan, dll">{{ old('notes') }}</textarea>
                            </div>
                        </div>

                        <!-- Payment Information -->
                        <div class="mb-8">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Metode Pembayaran</h2>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <p class="text-sm text-gray-700 mb-3">Metode pembayaran akan ditampilkan setelah konfirmasi pesanan.</p>
                                <p class="text-xs text-gray-600">Pembayaran melalui: Transfer Bank, E-Wallet, atau COD (Sesuai kesepakatan)</p>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-bloom-coral hover:bg-bloom-coral/90 text-white font-semibold py-3 rounded-lg transition duration-300">
                            Konfirmasi Pesanan
                        </button>
                    </form>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 sticky top-20">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Total Pesanan</h2>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-gray-600 font-light">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600 font-light">
                                <span>Ongkos Kirim</span>
                                <span class="text-bloom-coral">Hubungi kami</span>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex justify-between text-lg font-semibold text-gray-900">
                                <span>Total</span>
                                <span class="text-bloom-teal">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <p class="text-xs text-gray-600">
                                <strong>Catatan:</strong> Ongkos kirim akan dikonfirmasi oleh tim kami setelah menerima pesanan Anda.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
