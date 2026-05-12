<x-guest-layout>
    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-4xl font-light text-bloom-text-primary">Create Account</h2>
        <p class="text-bloom-text-secondary mt-2 font-light">Join us to start shopping premium flowers</p>
    </div>

    <!-- Register Form -->
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name Input -->
        <div>
            <x-text-input 
                id="name" 
                class="block w-full border-2 border-bloom-border bg-bloom-bg-card focus:border-bloom-primary focus:ring-0 rounded-xl px-5 py-3 text-bloom-text-primary placeholder-bloom-text-secondary/50 transition" 
                type="text" 
                name="name" 
                :value="old('name')" 
                placeholder="Full Name"
                required 
                autofocus 
                autocomplete="name"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

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
                autocomplete="username"
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
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password Input -->
        <div>
            <x-text-input 
                id="password_confirmation" 
                class="block w-full border-2 border-bloom-border bg-bloom-bg-card focus:border-bloom-primary focus:ring-0 rounded-xl px-5 py-3 text-bloom-text-primary placeholder-bloom-text-secondary/50 transition" 
                type="password" 
                name="password_confirmation"
                placeholder="Confirm Password"
                required 
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Sign Up Button -->
        <button type="submit" class="w-full bg-bloom-primary hover:bg-bloom-primary-dark text-white font-bold py-3 px-4 rounded-xl shadow-lg transition duration-300 transform hover:scale-[1.02] mt-6">
            Sign Up
        </button>
    </form>

    <!-- Login Link -->
    <p class="text-center text-sm text-bloom-text-secondary mt-8 font-light">
        Already have an account? 
        <a href="{{ route('login') }}" class="text-bloom-primary hover:text-bloom-primary-dark font-semibold underline transition">
            Sign In
        </a>
    </p>
</x-guest-layout>
