<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin Bloomify',
            'email' => 'admin@bloomify.com',
            'password' => bcrypt('password'),
        ]);

        // Create test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create categories
        $categories = [
            [
                'name' => 'Bunga Segar',
                'slug' => 'bunga-segar',
                'description' => 'Koleksi bunga segar pilihan untuk berbagai acara',
            ],
            [
                'name' => 'Buket Premium',
                'slug' => 'buket-premium',
                'description' => 'Buket bunga premium dengan desain eksklusif',
            ],
            [
                'name' => 'Rangkaian Meja',
                'slug' => 'rangkaian-meja',
                'description' => 'Rangkaian bunga untuk dekorasi meja dan acara',
            ],
            [
                'name' => 'Bunga Kering',
                'slug' => 'bunga-kering',
                'description' => 'Koleksi bunga kering yang tahan lama',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create sample products
        $products = [
            [
                'category_id' => 1,
                'name' => 'Buket Mawar Merah Premium',
                'slug' => 'buket-mawar-merah-premium',
                'description' => 'Buket indah terdiri dari 24 batang mawar merah segar berkualitas premium. Sempurna untuk mengungkapkan perasaan cinta dan kasih sayang.',
                'price' => 350000,
                'stock' => 15,
            ],
            [
                'category_id' => 1,
                'name' => 'Buket Bunga Musim Semi',
                'slug' => 'buket-bunga-musim-semi',
                'description' => 'Kombinasi bunga tulip, lili, dan dahlia dalam harmoni warna yang indah. Sempurna untuk mengucapkan selamat atau ucapan terima kasih.',
                'price' => 425000,
                'stock' => 10,
            ],
            [
                'category_id' => 2,
                'name' => 'Buket Eksklusif Putih Emas',
                'slug' => 'buket-eksklusif-putih-emas',
                'description' => 'Buket premium dengan kombinasi bunga putih, lavender, dan aksesoris emas. Terbatas hanya 5 buket per hari.',
                'price' => 650000,
                'stock' => 5,
            ],
            [
                'category_id' => 2,
                'name' => 'Buket Pelangi Lengkap',
                'slug' => 'buket-pelangi-lengkap',
                'description' => 'Buket spektakuler dengan bunga-bunga berwarna yang melambangkan keberagaman dan keindahan. Cocok untuk apresiasi dan perayaan spesial.',
                'price' => 550000,
                'stock' => 8,
            ],
            [
                'category_id' => 3,
                'name' => 'Rangkaian Meja Pernikahan',
                'slug' => 'rangkaian-meja-pernikahan',
                'description' => 'Rangkaian bunga mewah untuk dekorasi meja undangan pernikahan Anda. Desain elegan dan tahan lama sepanjang acara.',
                'price' => 750000,
                'stock' => 3,
            ],
            [
                'category_id' => 3,
                'name' => 'Dekorasi Meja Seremonial',
                'slug' => 'dekorasi-meja-seremonial',
                'description' => 'Rangkaian bunga seremonial yang kokoh dan indah. Cocok untuk acara peresmian, launching produk, atau acara korporat.',
                'price' => 500000,
                'stock' => 6,
            ],
            [
                'category_id' => 4,
                'name' => 'Bunga Kering Lavender Pack',
                'slug' => 'bunga-kering-lavender-pack',
                'description' => 'Paket bunga kering lavender premium yang dapat bertahan hingga 1 tahun. Sempurna untuk dekorasi rumah dan aroma terapi.',
                'price' => 150000,
                'stock' => 20,
            ],
            [
                'category_id' => 4,
                'name' => 'Rangkaian Bunga Kering Romantis',
                'slug' => 'rangkaian-bunga-kering-romantis',
                'description' => 'Rangkaian cantik bunga kering dengan sentuhan vintage. Cocok untuk hadiah yang bermakna dan tahan selamanya.',
                'price' => 275000,
                'stock' => 12,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

