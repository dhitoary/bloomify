<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloomify - Toko Bunga Online</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-bloom-ivory text-gray-900 font-sans antialiased">

    <nav class="bg-white shadow-sm p-4 border-b border-bloom-mint-light">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-2xl font-bold text-bloom-teal">Bloomify</a>
            <ul class="flex space-x-6 font-medium text-gray-700 items-center">
                <li><a href="/" class="hover:text-bloom-teal transition">Beranda</a></li>
                <li><a href="#" class="hover:text-bloom-teal transition">Katalog</a></li>

                @auth
                    <li><a href="{{ url('/dashboard') }}" class="font-bold text-bloom-teal hover:text-bloom-coral transition">Dashboard</a></li>
                @else
                    <li><a href="{{ route('login') }}" class="hover:text-bloom-teal transition">Login</a></li>
                    <li><a href="{{ route('register') }}" class="bg-bloom-mint-light text-bloom-teal px-4 py-2 rounded-full hover:bg-bloom-mint transition font-medium">Daftar</a></li>
                @endauth
            </ul>
        </div>
    </nav>

    <div class="container mx-auto mt-20 text-center px-4">
        <h1 class="text-5xl md:text-6xl font-extrabold text-bloom-teal mb-6 tracking-tight">
            Sampaikan Perasaanmu <br> dengan Bunga
        </h1>
        <p class="text-lg text-gray-700 mb-10 max-w-2xl mx-auto">
            Koleksi buket bunga premium untuk setiap momen spesial. Pesan sekarang dan ciptakan kesan indah untuk orang terkasih.
        </p>
        <button class="bg-bloom-coral hover:bg-bloom-coral/90 text-white font-bold py-3 px-8 rounded-full shadow-lg transition duration-300 transform hover:scale-105">
            Mulai Belanja
        </button>
    </div>

</body>
</html>