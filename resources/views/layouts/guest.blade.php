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
                        <img 
                            src="{{ asset('images/login-illustration.jpg') }}" 
                            alt="Bloomify Login" 
                            class="w-full h-auto object-contain drop-shadow-2xl rounded-2xl"
                        />
                </div>
            </div>
        </div>
    </body>
</html>

