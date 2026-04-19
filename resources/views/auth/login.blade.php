<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-pink-700">Selamat Datang Kembali!</h2>
        <p class="text-gray-500">Silakan login untuk melanjutkan pesanan bungamu.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div>
            <x-input-label for="email" value="Email Address" class="text-pink-600" />
            <x-text-input id="email" class="block mt-1 w-full border-pink-200 focus:border-pink-500 focus:ring-pink-500 rounded-xl" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Password" class="text-pink-600" />
            <x-text-input id="password" class="block mt-1 w-full border-pink-200 focus:border-pink-500 focus:ring-pink-500 rounded-xl" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-pink-300 text-pink-600 shadow-sm focus:ring-pink-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">Ingat saya</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm text-pink-600 hover:text-pink-800 underline transition" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif
        </div>

        <div class="mt-6">
            <button class="w-full bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg transition duration-300 transform hover:scale-[1.02]">
                MASUK SEKARANG
            </button>
        </div>
    </form>
</x-guest-layout>