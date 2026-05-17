<x-app-layout>
    <div style="background: linear-gradient(to bottom right, #FFF5FA, #FECEEE); background-attachment: fixed;" class="py-12 min-h-screen">
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
                <h1 style="color: #9F254F;" class="text-4xl font-light">Keranjang Belanja</h1>
                <p style="color: #DA4582;" class="font-light">Tinjau produk yang akan Anda pesan</p>
            </div>

            @if($cartItems->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2 space-y-4">
                        <!-- Select All Header -->
                        <div style="background: linear-gradient(to right, #DA4582, #EC91C3); border: 2px solid #9F254F;" class="rounded-xl p-4 flex items-center gap-3">
                            <input type="checkbox" id="selectAll" style="accent-color: #9F254F;" class="w-5 h-5 rounded border cursor-pointer" onchange="selectAllItems()">
                            <label for="selectAll" style="color: #ffffff;" class="text-sm font-semibold cursor-pointer">Pilih Semua</label>
                        </div>

                        <form id="checkoutForm">
                            @csrf
                            @foreach($cartItems as $item)
                                <div style="background: #ffffff; border: 2px solid #EC91C3;" class="rounded-xl p-6 flex gap-4 items-start shadow-sm">
                                    <!-- Checkbox -->
                                    <div class="flex-shrink-0 pt-2">
                                        <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" style="accent-color: #9F254F;" class="cart-checkbox w-5 h-5 rounded cursor-pointer" onchange="updateTotal(); updateSelectAllState();">
                                    </div>

                                    <!-- Product Image -->
                                    <div class="w-24 h-24 flex-shrink-0">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded-lg">
                                        @else
                                            <div style="background: linear-gradient(to bottom right, #FECEEE, #EC91C3); color: #EC91C3;" class="w-full h-full rounded-lg flex items-center justify-center">
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
                                                <h3 style="color: #9F254F;" class="text-lg font-semibold">{{ $item->product->name }}</h3>
                                                <p style="color: #DA4582;" class="text-sm font-light">{{ $item->product->category->name ?? 'Kategori tidak tersedia' }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between mt-4">
                                            <!-- Quantity -->
                                            <div class="flex items-center gap-2">
                                                <form action="{{ route('cart.update', $item) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div style="border: 2px solid #EC91C3;" class="flex items-center rounded-lg overflow-hidden">
                                                        <button type="button" onclick="decreaseQty(this)" style="color: #9F254F;" class="px-3 py-1.5 hover:bg-white/50 transition text-sm font-bold">−</button>
                                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" style="border-left: 1px solid #EC91C3; border-right: 1px solid #EC91C3; color: #9F254F;" class="w-12 text-center border-0 py-1.5 bg-white/50 text-sm font-semibold" onchange="this.form.submit()">
                                                        <button type="button" onclick="increaseQty(this)" style="color: #9F254F;" class="px-3 py-1.5 hover:bg-white/50 transition text-sm font-bold">+</button>
                                                    </div>
                                                </form>
                                            </div>

                                            <!-- Price -->
                                            <div class="text-right">
                                                <p style="color: #DA4582;" class="text-sm font-light item-unit-price" data-price="{{ $item->product->price }}">Rp {{ number_format($item->product->price, 0, ',', '.') }} x <span class="item-qty-display">{{ $item->quantity }}</span></p>
                                                <p style="color: #9F254F;" class="text-lg font-bold item-total" data-price="{{ $item->product->price }}" data-qty="{{ $item->quantity }}">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p>
                                            </div>

                                            <!-- Remove -->
                                            <form action="{{ route('cart.remove', $item) }}" method="POST" class="ml-4">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="color: #EC91C3;" class="hover:opacity-70 transition" title="Hapus dari keranjang">
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
                        <div style="background: #ffffff; border: 2px solid #EC91C3;" class="rounded-xl p-6 sticky top-20 h-fit shadow-sm">
                            <h2 style="color: #9F254F;" class="text-xl font-semibold mb-4">Ringkasan Pesanan</h2>

                            <div style="border-bottom: 1px solid #EC91C3;" class="space-y-4 mb-6 pb-6">
                                <div class="flex justify-between">
                                    <span style="color: #DA4582;" class="font-light">Subtotal</span>
                                    <span id="subtotal" style="color: #9F254F;" class="font-semibold">Rp 0</span>
                                </div>
                                <div class="flex justify-between">
                                    <span style="color: #DA4582;" class="font-light">Ongkir</span>
                                    <span style="color: #DA4582;" class="font-light text-sm">Dihitung saat checkout</span>
                                </div>
                            </div>

                            <div style="border-bottom: 1px solid #EC91C3;" class="mb-6 pb-6">
                                <div class="flex justify-between text-lg font-bold">
                                    <span style="color: #9F254F;">Total</span>
                                    <span style="color: #9F254F;" id="total">Rp 0</span>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <button onclick="checkoutSelected()" type="button" style="background: linear-gradient(135deg, #DA4582, #9F254F); color: #ffffff;" class="w-full font-bold py-3 rounded-lg hover:opacity-90 transition duration-300 text-sm">
                                    Lanjut ke Checkout
                                </button>

                                <a href="{{ route('products.index') }}" style="border: 2px solid #ffffff; color: #ffffff;" class="block text-center font-medium py-3 rounded-lg transition hover:bg-white/10 text-sm">
                                    Lanjut Belanja
                                </a>
                            </div>

                            <p style="color: rgba(255,255,255,0.6);" class="text-xs font-light mt-4 text-center">Pilih produk yang ingin di checkout</p>
                        </div>
                    </div>
                </div>
            @else
                <div style="background: linear-gradient(135deg, #FECEEE, #FECEEE); border: 2px solid #EC91C3;" class="rounded-xl p-12 text-center shadow-sm">
                    <div style="background: rgba(170, 103, 120, 0.15); border: 1px solid #EC91C3;" class="inline-block rounded-full p-4 mb-4">
                        <svg style="color: #EC91C3;" class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m10 0l2 9m-9-9h6m-6 0a1 1 0 100-2 1 1 0 000 2zm6 0a1 1 0 100-2 1 1 0 000 2z" />
                        </svg>
                    </div>
                    <h2 style="color: #9F254F;" class="text-2xl font-semibold mb-2">Keranjang Anda Kosong</h2>
                    <p style="color: #DA4582;" class="font-light mb-6">Mulai belanja sekarang dan temukan buket bunga impian Anda</p>
                    <a href="{{ route('products.index') }}" style="background: #EC91C3; color: #ffffff;" class="inline-block font-semibold py-3 px-8 rounded-lg hover:opacity-90 transition duration-300">
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





