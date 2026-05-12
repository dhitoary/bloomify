<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-bloom-primary/20 via-bloom-secondary/15 to-bloom-accent/20 min-h-screen">
        <div class="min-h-screen flex items-center justify-center px-4 py-8">
            <div class="w-full max-w-6xl">
                <!-- Main Container with Two Columns -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                    <!-- Left Side: Form -->
                    <div class="bg-white rounded-3xl shadow-xl p-8 lg:p-10">
                        <!-- Logo -->
                        <a href="/" class="inline-block mb-8">
                            <div class="text-4xl italic text-transparent bg-gradient-to-r from-bloom-fuchsia via-bloom-primary to-bloom-accent bg-clip-text hover:from-bloom-fuchsia-light hover:via-bloom-primary hover:to-bloom-fuchsia transition duration-300" style="font-family: 'Great Vibes', cursive; font-weight: 400; letter-spacing: 1px;">
                                Bloomify
                            </div>
                        </a>

                        {{ $slot }}
                    </div>

                    <!-- Right Side: Illustration Image -->
                    <div class="hidden lg:flex items-center justify-center h-full">
                        @if(file_exists(public_path('images/login-illustration.png')))
                            <img 
                                src="{{ asset('images/login-illustration.png') }}" 
                                alt="Bloomify" 
                                class="w-full h-auto object-contain drop-shadow-2xl rounded-2xl"
                            />
                        @elseif(file_exists(public_path('images/login-illustration.jpg')))
                            <img 
                                src="{{ asset('images/login-illustration.jpg') }}" 
                                alt="Bloomify" 
                                class="w-full h-auto object-contain drop-shadow-2xl rounded-2xl"
                            />
                        @elseif(file_exists(public_path('images/login-illustration.jpeg')))
                            <img 
                                src="{{ asset('images/login-illustration.jpeg') }}" 
                                alt="Bloomify" 
                                class="w-full h-auto object-contain drop-shadow-2xl rounded-2xl"
                            />
                        @else
                            <!-- Placeholder jika gambar belum diupload -->
                            <div class="w-full h-full bg-gradient-to-br from-bloom-primary/10 to-bloom-accent/10 rounded-2xl flex items-center justify-center border-2 border-dashed border-bloom-border">
                                <div class="text-center">
                                    <svg class="w-24 h-24 text-bloom-primary/30 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-bloom-text-secondary font-light text-sm">Upload gambar ke public/images/login-illustration.png</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

