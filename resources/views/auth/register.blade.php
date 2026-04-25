<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-bloom-teal">Bergabunglah dengan Bloomify</h2>
        <p class="text-gray-700 mt-2">Daftar untuk mulai berbelanja bunga premium</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-bloom-teal font-semibold" />
            <x-text-input id="name" class="block mt-1 w-full border-bloom-mint-light focus:border-bloom-teal focus:ring-bloom-teal rounded-xl text-gray-900" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-bloom-teal font-semibold" />
            <x-text-input id="email" class="block mt-1 w-full border-bloom-mint-light focus:border-bloom-teal focus:ring-bloom-teal rounded-xl text-gray-900" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-bloom-teal font-semibold" />

            <x-text-input id="password" class="block mt-1 w-full border-bloom-mint-light focus:border-bloom-teal focus:ring-bloom-teal rounded-xl text-gray-900"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-bloom-teal font-semibold" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full border-bloom-mint-light focus:border-bloom-teal focus:ring-bloom-teal rounded-xl text-gray-900"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-sm text-bloom-teal hover:text-bloom-coral underline transition font-medium" href="{{ route('login') }}">
                Sudah punya akun?
            </a>

            <x-primary-button class="ms-4 bg-bloom-teal hover:bg-bloom-teal/90 text-white">
                {{ __('Daftar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
