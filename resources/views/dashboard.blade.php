<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-bloom-teal leading-tight">
            {{ __('Dashboard Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-bloom-mint-light">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold text-bloom-teal mb-4">Selamat datang di Bloomify</h3>
                    <p class="text-gray-700">Kelola profil Anda, lihat riwayat pesanan, dan temukan buket bunga pilihan kami.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
