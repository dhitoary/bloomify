<x-app-layout>
    <div class="py-12 bg-bloom-ivory">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            @if(session('info'))
            <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4 flex items-center gap-3">
                <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-blue-700 text-sm">{{ session('info') }}</p>
            </div>
            @endif
            @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4 flex items-center gap-3">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-red-700 text-sm">{{ session('error') }}</p>
            </div>
            @endif

            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-light text-gray-900">Keranjang Belanja</h1>
                <p class="text-gray-600 font-light">Tinjau produk yang akan Anda pesan</p>
            </div>

            @if($cartItems->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2 space-y-4">
                        <!-- Select All Header -->
                        <div class="bg-white rounded-lg border border-bloom-mint-light shadow-sm p-4 flex items-center gap-3">
                            <input type="checkbox" id="selectAll" class="w-5 h-5 text-bloom-coral rounded border-bloom-mint-light cursor-pointer" onchange="selectAllItems()">
                            <label for="selectAll" class="text-sm font-medium text-gray-700 cursor-pointer">Pilih Semua</label>
                        </div>

                        <form id="checkoutForm">
                            @csrf
                            @foreach($cartItems as $item)
                                <div class="bg-white rounded-lg border border-bloom-mint-light shadow-sm p-6 flex gap-4 items-start">
                                    <!-- Checkbox -->
                                    <div class="flex-shrink-0 pt-2">
                                        <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" class="cart-checkbox w-5 h-5 text-bloom-coral rounded border-bloom-mint-light cursor-pointer" onchange="updateTotal(); updateSelectAllState();">
                                    </div>

                                    <!-- Product Image -->
                                    <div class="w-24 h-24 flex-shrink-0">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded-lg">
                                        @else
                                            <div class="w-full h-full bg-bloom-cream rounded-lg flex items-center justify-center text-bloom-mint">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Info -->
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-900">{{ $item->product->name }}</h3>
                                                <p class="text-sm text-gray-600 font-light">{{ $item->product->category->name ?? 'Kategori tidak tersedia' }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between mt-4">
                                            <!-- Quantity -->
                                            <div class="flex items-center gap-2">
                                                <form action="{{ route('cart.update', $item) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="flex items-center border border-bloom-mint-light rounded-lg">
                                                        <button type="button" onclick="decreaseQty(this)" class="px-2 py-1 text-gray-600 hover:text-bloom-primary transition">−</button>
                                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-12 text-center border-0 border-l border-r border-bloom-mint-light py-1" onchange="this.form.submit()">
                                                        <button type="button" onclick="increaseQty(this)" class="px-2 py-1 text-gray-600 hover:text-bloom-primary transition">+</button>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Price -->
                                            <div class="text-right">
                                                <p class="text-sm text-gray-600 font-light item-unit-price" data-price="{{ $item->product->price }}">Rp {{ number_format($item->product->price, 0, ',', '.') }} x <span class="item-qty-display">{{ $item->quantity }}</span></p>
                                                <p class="text-lg font-semibold text-bloom-primary item-total" data-price="{{ $item->product->price }}" data-qty="{{ $item->quantity }}">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p>
                                            </div>

                                            <!-- Remove -->
                                            <form action="{{ route('cart.remove', $item) }}" method="POST" class="ml-4">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-bloom-coral hover:text-bloom-coral/80 transition" title="Hapus dari keranjang">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </form>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg border border-bloom-mint-light shadow-sm p-6 sticky top-20 h-fit">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h2>

                            <div class="space-y-4 mb-6 pb-6 border-b border-bloom-mint-light">
                                <div class="flex justify-between text-gray-600 font-light">
                                    <span>Subtotal</span>
                                    <span id="subtotal" class="font-medium text-gray-900">Rp 0</span>
                                </div>
                                <div class="flex justify-between text-gray-600 font-light">
                                    <span>Ongkir</span>
                                    <span class="text-bloom-coral font-light">Dihitung saat checkout</span>
                                </div>
                            </div>

                            <div class="mb-6 pb-6 border-b border-bloom-mint-light">
                                <div class="flex justify-between text-lg font-semibold text-gray-900">
                                    <span>Total</span>
                                    <span class="text-bloom-primary" id="total">Rp 0</span>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <button onclick="checkoutSelected()" type="button" class="w-full bg-bloom-coral hover:bg-bloom-coral/90 text-white font-semibold py-3 rounded-lg transition duration-300">
                                    Lanjut ke Checkout
                                </button>

                                <a href="{{ route('products.index') }}" class="block text-center text-bloom-primary hover:text-bloom-coral font-medium py-3 border border-bloom-primary rounded-lg transition bg-white hover:bg-bloom-cream">
                                    Lanjut Belanja
                                </a>
                            </div>

                            <p class="text-xs text-gray-500 font-light mt-4 text-center">Pilih produk yang ingin di checkout</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-lg border border-bloom-mint-light shadow-sm p-12 text-center">
                    <div class="inline-block bg-bloom-cream rounded-full p-4 mb-4">
                        <svg class="w-12 h-12 text-bloom-mint" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m10 0l2 9m-9-9h6m-6 0a1 1 0 100-2 1 1 0 000 2zm6 0a1 1 0 100-2 1 1 0 000 2z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-semibold text-gray-900 mb-2">Keranjang Anda Kosong</h2>
                    <p class="text-gray-600 font-light mb-6">Mulai belanja sekarang dan temukan buket bunga impian Anda</p>
                    <a href="{{ route('products.index') }}" class="inline-block bg-bloom-coral hover:bg-bloom-coral/90 text-white font-semibold py-3 px-8 rounded-lg transition duration-300">
                        Belanja Sekarang
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        function decreaseQty(btn) {
            const input = btn.parentElement.querySelector('input[name="quantity"]');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                syncItemTotal(input);
                updateTotal();
            }
        }

        function increaseQty(btn) {
            const input = btn.parentElement.querySelector('input[name="quantity"]');
            input.value = parseInt(input.value) + 1;
            syncItemTotal(input);
            updateTotal();
        }

        // Sinkronkan item-total dan display qty berdasarkan input qty terbaru
        function syncItemTotal(input) {
            // Naik ke card item (.p-6)
            const card = input.closest('.p-6');
            if (!card) return;

            const itemTotal = card.querySelector('.item-total');
            const unitPriceEl = card.querySelector('[data-price]');
            const qtyDisplay = card.querySelector('.item-qty-display');

            if (!itemTotal || !unitPriceEl) return;

            const price = parseInt(unitPriceEl.dataset.price) || 0;
            const qty   = parseInt(input.value) || 1;
            const total = price * qty;

            // Update data-qty agar updateTotal() bisa membacanya
            itemTotal.dataset.qty = qty;

            // Update tampilan harga per item
            itemTotal.textContent = 'Rp ' + total.toLocaleString('id-ID');

            // Update teks qty di samping harga satuan
            if (qtyDisplay) qtyDisplay.textContent = qty;
        }

        function updateTotal() {
            let total = 0;
            document.querySelectorAll('.cart-checkbox:checked').forEach(checkbox => {
                const card = checkbox.closest('.p-6');
                if (!card) return;

                const itemTotal = card.querySelector('.item-total');
                if (!itemTotal) return;

                const price = parseInt(itemTotal.dataset.price) || 0;
                // Cek qty dari input quantity (sudah diubah user) atau dari data-qty awal
                const qtyInput = card.querySelector('input[name="quantity"]');
                const qty = qtyInput ? (parseInt(qtyInput.value) || 1) : (parseInt(itemTotal.dataset.qty) || 1);

                total += price * qty;
            });

            document.getElementById('subtotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('total').textContent = 'Rp ' + total.toLocaleString('id-ID');

            // Update select all checkbox state
            updateSelectAllState();
        }

        function selectAllItems() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const allCheckboxes = document.querySelectorAll('.cart-checkbox');
            
            allCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });

            updateTotal();
        }

        function updateSelectAllState() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const allCheckboxes = document.querySelectorAll('.cart-checkbox');
            const checkedCheckboxes = document.querySelectorAll('.cart-checkbox:checked');

            if (checkedCheckboxes.length === allCheckboxes.length) {
                selectAllCheckbox.checked = true;
                selectAllCheckbox.indeterminate = false;
            } else if (checkedCheckboxes.length > 0) {
                selectAllCheckbox.indeterminate = true;
                selectAllCheckbox.checked = false;
            } else {
                selectAllCheckbox.checked = false;
                selectAllCheckbox.indeterminate = false;
            }
        }

        function checkoutSelected() {
            const selected = document.querySelectorAll('.cart-checkbox:checked');
            
            if (selected.length === 0) {
                alert('Pilih minimal satu produk untuk checkout');
                return;
            }

            const selectedIds = Array.from(selected).map(cb => cb.value);
            
            // Simpan ke session atau pass ke checkout page
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("checkout.create") }}';
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);

            selectedIds.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'cart_ids[]';
                input.value = id;
                form.appendChild(input);
            });

            document.body.appendChild(form);
            form.submit();
        }

        // Initialize total on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateTotal();
            updateSelectAllState();
        });
    </script>
</x-app-layout>

