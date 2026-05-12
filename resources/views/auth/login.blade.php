<x-guest-layout>
    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-4xl font-light text-bloom-text-primary">Hello Again!</h2>
        <p class="text-bloom-text-secondary mt-2 font-light">Let's get started with your 30 days trial</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Input -->
        <div>
            <x-text-input 
                id="email" 
                class="block w-full border-2 border-bloom-border bg-bloom-bg-card focus:border-bloom-primary focus:ring-0 rounded-xl px-5 py-3 text-bloom-text-primary placeholder-bloom-text-secondary/50 transition" 
                type="email" 
                name="email" 
                :value="old('email')" 
                placeholder="Email"
                required 
                autofocus 
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password Input -->
        <div>
            <x-text-input 
                id="password" 
                class="block w-full border-2 border-bloom-border bg-bloom-bg-card focus:border-bloom-primary focus:ring-0 rounded-xl px-5 py-3 text-bloom-text-primary placeholder-bloom-text-secondary/50 transition" 
                type="password" 
                name="password"
                placeholder="Password"
                required 
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-bloom-border text-bloom-primary focus:ring-bloom-primary shadow-sm" name="remember">
                <span class="text-sm text-bloom-text-secondary font-light">Remember me</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm text-bloom-text-secondary hover:text-bloom-primary underline transition font-light" href="{{ route('password.request') }}">
                    Recovery Password
                </a>
            @endif
        </div>

        <!-- Sign In Button -->
        <button type="submit" class="w-full bg-bloom-primary hover:bg-bloom-primary-dark text-white font-bold py-3 px-4 rounded-xl shadow-lg transition duration-300 transform hover:scale-[1.02] mt-6">
            Sign In
        </button>
    </form>

    <!-- Register Link -->
    <p class="text-center text-sm text-bloom-text-secondary mt-8 font-light">
        Don't have an account? 
        <a href="{{ route('register') }}" class="text-bloom-primary hover:text-bloom-primary-dark font-semibold underline transition">
            Sign Up
        </a>
    </p>
</x-guest-layout>