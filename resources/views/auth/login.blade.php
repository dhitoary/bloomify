<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-bloom-teal">Selamat Datang Kembali!</h2>
        <p class="text-gray-700 mt-2">Silakan login untuk melanjutkan pesanan bunga Anda.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div>
            <x-input-label for="email" value="Email Address" class="text-bloom-teal font-semibold" />
            <x-text-input id="email" class="block mt-1 w-full border-bloom-mint-light focus:border-bloom-teal focus:ring-bloom-teal rounded-xl text-gray-900" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Password" class="text-bloom-teal font-semibold" />
            <x-text-input id="password" class="block mt-1 w-full border-bloom-mint-light focus:border-bloom-teal focus:ring-bloom-teal rounded-xl text-gray-900" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-bloom-mint-light text-bloom-teal shadow-sm focus:ring-bloom-teal" name="remember">
                <span class="ms-2 text-sm text-gray-700">Ingat saya</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm text-bloom-teal hover:text-bloom-coral underline transition font-medium" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif
        </div>

        <div class="mt-6">
            <button class="w-full bg-bloom-teal hover:bg-bloom-teal/90 text-white font-bold py-3 px-4 rounded-xl shadow-lg transition duration-300 transform hover:scale-[1.02]">
                MASUK SEKARANG
            </button>
        </div>
    </form>
</x-guest-layout>