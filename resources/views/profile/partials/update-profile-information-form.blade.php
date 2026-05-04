<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Profile Picture Section -->
        <div class="pb-6 border-b border-gray-200">
            <h3 class="text-base font-medium text-gray-900 mb-4">{{ __('Profile Picture') }}</h3>
            
            <div class="flex items-center gap-6">
                <!-- Current Profile Picture -->
                <div class="flex-shrink-0">
                    @if($user->profile_picture)
                        <img 
                            src="{{ asset('storage/' . $user->profile_picture) }}?t={{ time() }}" 
                            alt="{{ $user->name }}'s profile picture"
                            class="w-24 h-24 rounded-xl object-cover border-2 border-bloom-mint-light shadow-md"
                        />
                    @else
                        <div class="w-24 h-24 rounded-xl flex items-center justify-center text-white font-semibold text-3xl overflow-hidden border-2 border-bloom-mint-light shadow-md bg-gradient-to-br from-bloom-teal to-bloom-coral">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <p class="text-xs text-gray-500 mt-2 text-center">Current Photo</p>
                </div>

                <!-- Upload Section -->
                <div class="flex-grow">
                    <x-input-label for="profile_picture" :value="__('Upload Photo')" />
                    <input 
                        type="file" 
                        id="profile_picture" 
                        name="profile_picture" 
                        accept="image/*" 
                        class="mt-1 block w-full text-sm text-gray-600
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-medium
                        file:bg-bloom-cream file:text-bloom-teal
                        hover:file:bg-bloom-mint-light file:cursor-pointer"
                    >
                    <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
                    <p class="text-xs text-gray-500 mt-2">{{ __('Format: JPG, PNG, WebP (Max 5MB)') }}</p>
                </div>
            </div>
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Delivery Address Section -->
        <div class="pb-6 border-t border-b border-gray-200">
            <h3 class="text-base font-medium text-gray-900 mb-4">{{ __('Delivery Address') }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="phone" :value="__('Phone Number')" />
                    <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full" :value="old('phone', $user->phone)" autocomplete="tel" placeholder="+62 812 3456 7890" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>

                <div>
                    <x-input-label for="postal_code" :value="__('Postal Code')" />
                    <x-text-input id="postal_code" name="postal_code" type="text" class="mt-1 block w-full" :value="old('postal_code', $user->postal_code)" autocomplete="postal-code" placeholder="12345" />
                    <x-input-error class="mt-2" :messages="$errors->get('postal_code')" />
                </div>
            </div>

            <div class="mt-6">
                <x-input-label for="address" :value="__('Street Address')" />
                <textarea id="address" name="address" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-bloom-teal focus:ring-bloom-teal" rows="3" placeholder="Jalan, Nomor, Kompleks, etc." autocomplete="street-address">{{ old('address', $user->address) }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('address')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <x-input-label for="city" :value="__('City')" />
                    <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $user->city)" autocomplete="address-level2" placeholder="Jakarta, Bandung, etc." />
                    <x-input-error class="mt-2" :messages="$errors->get('city')" />
                </div>

                <div>
                    <x-input-label for="province" :value="__('Province')" />
                    <x-text-input id="province" name="province" type="text" class="mt-1 block w-full" :value="old('province', $user->province)" autocomplete="address-level1" placeholder="DKI Jakarta, Jawa Barat, etc." />
                    <x-input-error class="mt-2" :messages="$errors->get('province')" />
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
