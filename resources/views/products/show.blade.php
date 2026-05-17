@extends('layouts.app')

@section('content')
<div style="background: linear-gradient(to bottom right, #e2d0d0, #F5E6E6); background-attachment: fixed;" class="min-h-screen">
    <div class="max-w-7xl mx-auto px-6 py-8">
        <!-- Breadcrumb Navigation -->
        <div class="mb-12 flex items-center text-sm">
            <a href="{{ route('products.index') }}" style="color: #b78493;" class="hover:opacity-80 transition font-bold">Katalog</a>
            <svg style="color: #cc93a2;" class="w-4 h-4 mx-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('products.category', $product->category->slug) }}" style="color: #b78493;" class="hover:opacity-80 transition font-bold">{{ $product->category->name }}</a>
            <svg style="color: #cc93a2;" class="w-4 h-4 mx-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span style="color: #aa6778;" class="font-bold line-clamp-1">{{ $product->name }}</span>
        </div>

        <!-- Product Details Section -->
        <div style="background: linear-gradient(to bottom right, #d6acad, #cc93a2); border-color: #aa6778;" class="border-2 rounded-2xl shadow-soft overflow-hidden mb-20">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-0">
                <!-- Product Image -->
                <div style="background: linear-gradient(to bottom right, #e2d0d0, #d6acad); border-right-color: #aa6778;" class="lg:col-span-1 border-r-2 lg:border-r h-96 p-6 flex items-center justify-center">
                    <div style="background: linear-gradient(to bottom right, #e2d0d0, #F5E6E6); border-color: #cc93a2;" class="w-full h-full border-2 rounded-xl overflow-hidden flex items-center justify-center shadow-soft">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="flex flex-col items-center justify-center text-gray-400 p-4 text-center">
                                <svg class="w-20 h-20 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-xs">Tidak ada gambar</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Information Box -->
                <div style="background: linear-gradient(to bottom right, #cc93a2, #d6acad); border-left-color: #aa6778;" class="lg:col-span-2 p-8 border-l-2">
                    <!-- Category Badge -->
                    <div class="mb-4">
                        <span style="background: #d6acad; border-color: #aa6778; color: #ffffff;" class="inline-block px-3 py-1 rounded-full border text-xs font-semibold uppercase tracking-wider">
                            {{ $product->category->name }}
                        </span>
                    </div>

                    <!-- Product Title -->
                    <h1 style="color: #ffffff;" class="text-3xl font-semibold mb-2 leading-tight">
                        {{ $product->name }}
                    </h1>

                    <!-- Rating Summary -->
                    <div class="flex items-center gap-2 mb-6">
                        <div class="flex style="color: #cc93a2;"">
                            @php $avg = $product->averageRating(); @endphp
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= round($avg) ? 'fill-current' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                        <span class="text-sm font-bold style="color: #aa6778;"">{{ number_format($avg, 1) }}</span>
                        <span class="style="color: #b78493;"">|</span>
                        <a href="#ulasan" class="text-sm style="color: #b78493;" hover:text-bloom-primary transition font-medium">{{ $product->totalReviews() }} Ulasan</a>
                    </div>

                    <!-- Price & Stock Section -->
                    <div class="mb-6 pb-6 border-b-2 style="border-color: #aa6778;"/40">
                        <div class="mb-4">
                            <p class="text-4xl font-semibold style="color: #aa6778;"">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                        </div>

                        <!-- Stock Status -->
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full {{ $product->stock > 0 ? 'bg-bloom-accent' : 'bg-red-500' }}"></div>
                            <span class="text-sm font-medium style="color: #aa6778;"">
                                @if($product->stock > 0)
                                    <span class="text-bloom-primary font-bold">Tersedia</span> • <span class="style="color: #b78493;" font-medium">{{ $product->stock }} unit</span>
                                @else
                                    <span class="text-red-600 font-semibold">Habis Terjual</span>
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <p class="text-white font-light leading-relaxed text-sm">
                            {{ $product->description ?? 'Tidak ada deskripsi tambahan untuk produk ini.' }}
                        </p>
                    </div>

                    <!-- Add to Cart Section -->
                    @auth
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                
                                <!-- Quantity Selector -->
                                <div class="mb-6">
                                    <label for="quantity" class="block text-xs font-bold style="color: #aa6778;" mb-2 uppercase tracking-wider">Jumlah</label>
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-center border-2 style="border-color: #aa6778;"/50 rounded-lg overflow-hidden bg-rgba(170, 103, 120, 0.15) hover:style="border-color: #aa6778;" hover:bg-rgba(170, 103, 120, 0.25) transition">
                                            <button type="button" class="px-3 py-2 style="color: #aa6778;" hover:bg-bloom-primary hover:text-white transition" onclick="document.getElementById('quantity').value = Math.max(1, parseInt(document.getElementById('quantity').value) - 1)">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                                </svg>
                                            </button>
                                            <input type="number" id="quantity" name="quantity" min="1" max="{{ $product->stock }}" value="1" class="w-16 px-2 py-2 text-center border-l-2 border-r-2 style="border-color: #aa6778;"/50 focus:outline-none focus:ring-2 focus:ring-bloom-primary focus:ring-offset-1 font-medium text-sm bg-white" required>
                                            <button type="button" class="px-3 py-2 style="color: #aa6778;" hover:bg-bloom-primary hover:text-white transition" onclick="document.getElementById('quantity').value = Math.min({{ $product->stock }}, parseInt(document.getElementById('quantity').value) + 1)">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                        </div>
                                    <p class="text-xs style="color: #b78493;"\">Maks {{ $product->stock }}</p>
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <div class="space-y-3">
                                    <button type="submit" class="w-full bg-bloom-primary hover:bg-bloom-primary/90 text-white font-bold py-3 rounded-lg transition duration-300 flex items-center justify-center gap-2 text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Tambah ke Keranjang
                                    </button>

                                    <a href="{{ route('products.index') }}" class="block text-center w-full border-2 border-bloom-border style="color: #aa6778;" font-semibold py-2 rounded-lg hover:style="border-color: #aa6778;" hover:bg-bloom-bg-cream transition duration-300 text-sm">
                                        Lanjut Belanja
                                    </a>
                                </div>
                            </form>
                        @else
                            <div class="p-4 bg-red-50 text-red-700 rounded-lg border border-red-200 text-sm">
                                <p class="font-semibold mb-3">Produk sedang tidak tersedia</p>
                                <a href="{{ route('products.index') }}" class="inline-block text-xs font-medium underline hover:no-underline">
                                    Lihat produk lainnya →
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="p-4 bg-gradient-to-br from-bloom-bg-cream to-white border border-bloom-accent/20 rounded-lg mb-4">
                            <p class="font-semibold text-gray-900 mb-3 text-sm">Daftar untuk berbelanja</p>
                            <div class="flex gap-2 flex-col sm:flex-row">
                                <a href="{{ route('login') }}" class="flex-1 bg-bloom-primary hover:bg-bloom-primary/90 text-white font-semibold py-2 rounded-lg transition text-center text-xs">
                                    Login
                                </a>
                                <a href="{{ route('register') }}" class="flex-1 border style="border-color: #aa6778;" text-bloom-primary hover:bg-bloom-bg-cream font-semibold py-2 rounded-lg transition text-center text-xs">
                                    Daftar
                                </a>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div id="ulasan" class="mb-20">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <p class="text-sm font-semibold text-bloom-primary mb-2 uppercase tracking-widest">Suara Pelanggan</p>
                    <h2 class="text-4xl font-light style="color: #aa6778;"">Ulasan Pembeli</h2>
                </div>
            </div>

            @if($product->reviews->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    <!-- Rating Snapshot -->
                    <div class="lg:col-span-1">
                        <div class="bg-gradient-to-br from-rgba(170, 103, 120, 0.20) to-bloom-fuchsia/15 border-2 style="border-color: #aa6778;"/40 rounded-2xl p-8 sticky top-8 shadow-soft">
                            <p class="style="color: #b78493;" text-sm mb-2">Rating Rata-rata</p>
                            <div class="flex items-end gap-3 mb-6">
                                <span class="text-6xl font-light style="color: #aa6778;" leading-none">{{ number_format($product->averageRating(), 1) }}</span>
                                <div class="flex flex-col">
                                    <div class="flex style="color: #cc93a2;" mb-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= round($product->averageRating()) ? 'fill-current' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                        @endfor
                                    </div>
                                    <span class="text-sm style="color: #b78493;" font-medium">Dari {{ $product->totalReviews() }} Ulasan</span>
                                </div>
                            </div>

                            <!-- Rating Bars -->
                            <div class="space-y-3">
                                @for($i = 5; $i >= 1; $i--)
                                    @php 
                                        $count = $product->reviews->where('rating', $i)->count();
                                        $percent = $product->totalReviews() > 0 ? ($count / $product->totalReviews()) * 100 : 0;
                                    @endphp
                                    <div class="flex items-center gap-3">
                                        <span class="text-xs font-bold style="color: #aa6778;" w-2">{{ $i }}</span>
                                        <div class="flex-1 h-2 bg-rgba(170, 103, 120, 0.25) rounded-full overflow-hidden">
                                            <div class=\"h-full bg-bloom-fuchsia rounded-full\" style=\"width: {{ $percent }}%\"></div>
                                        </div>
                                        <span class="text-xs style="color: #b78493;" w-8">{{ $count }}</span>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <!-- Review List -->
                    <div class="lg:col-span-2 space-y-8">
                        @foreach($product->reviews()->latest()->get() as $review)
                            <div class="pb-8 border-b-2 style="border-color: #aa6778;"/40 last:border-0">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-rgba(170, 103, 120, 0.20) rounded-full flex items-center justify-center text-bloom-primary font-bold text-sm border style="border-color: #aa6778;"/30">
                                            {{ substr($review->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold style="color: #aa6778;"">{{ $review->user->name }}</h4>
                                            <p class="text-xs style="color: #b78493;"">{{ $review->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="flex style="color: #cc93a2;"">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                        @endfor
                                    </div>
                                </div>
                                <p class="style="color: #b78493;" font-light leading-relaxed">
                                    {{ $review->comment }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-3xl p-12 text-center">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Belum Ada Ulasan</h3>
                    <p class="text-gray-500 font-light">Jadilah yang pertama memberikan ulasan untuk produk ini!</p>
                </div>
            @endif
        </div>

        <!-- Related Products Section -->
        @if($relatedProducts->count() > 0)
            <div class="border-t style="border-color: #aa6778;"/40 pt-20 pb-12">
                <div class="mb-12">
                    <p class="text-sm font-semibold text-bloom-primary mb-3 uppercase tracking-widest">Pilihan Lainnya</p>
                    <h2 class="text-4xl font-light style="color: #aa6778;"">Produk Serupa</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($relatedProducts as $related)
                        <a href="{{ route('products.show', $related->slug) }}" class="group">
                            <div class="style="background: #d6acad;" border-2 border-bloom-border rounded-2xl overflow-hidden hover:shadow-soft-hover transition-all duration-300 h-full flex flex-col hover:-translate-y-1 hover:style="border-color: #aa6778;"">
                                <!-- Product Image -->
                                <div class="relative overflow-hidden h-48 bg-gradient-to-br from-bloom-bg-cream to-bloom-primary-lighter">
                                    @if($related->image)
                                        <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center style="color: #b78493;"">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Product Info -->
                                <div class="p-5 flex flex-col flex-grow">
                                    <h3 class="font-medium style="color: #aa6778;" mb-1 line-clamp-2 text-sm group-hover:text-bloom-accent transition duration-300">{{ $related->name }}</h3>
                                    @if($related->category)
                                        <p class="text-xs style="color: #b78493;" mb-3">{{ $related->category->name }}</p>
                                    @endif
                                    <p class="text-xs style="color: #b78493;" font-light mb-4 line-clamp-2 flex-grow">{{ $related->description }}</p>
                                    
                                    <div class="border-t border-bloom-border pt-4">
                                        <div class="flex justify-between items-center">
                                            <span class="font-semibold text-bloom-accent text-lg">Rp {{ number_format($related->price, 0, ',', '.') }}</span>
                                            <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $related->stock > 0 ? 'style="background: rgba(170, 103, 120, 0.1);" text-bloom-accent border border-bloom-accent' : 'bg-red-100 text-red-600 border border-red-200' }}">
                                                {{ $related->stock > 0 ? 'Tersedia' : 'Habis' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection





