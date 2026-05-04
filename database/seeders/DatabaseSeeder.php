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
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        // Create regular user
        User::factory()->create([
            'name' => 'Dhito',
            'email' => 'Dhito@gmail.com',
            'password' => bcrypt('pe'),
            'is_admin' => false,
        ]);

        // Create categories
        $categories = [
            [
                'name' => 'Bunga Tunggal (Single Stem)',
                'slug' => 'bunga-tunggal',
                'description' => 'Keindahan elegan dalam kesederhanaan. Pilihan bunga segar per tangkai yang terjangkau namun bermakna, sangat ideal untuk momen apresiasi kasual atau hadiah penyemangat yang manis.',
            ],
            [
                'name' => 'Buket Bunga Segar',
                'slug' => 'buket-bunga-segar',
                'description' => 'Rangkaian bunga potong segar pilihan yang dirangkai apik untuk merayakan berbagai momen berharga. Pilihan klasik yang sempurna untuk hari wisuda, ulang tahun, hingga perayaan istimewa lainnya.',
            ],
            [
                'name' => 'Bunga Meja & Vas',
                'slug' => 'bunga-meja-vas',
                'description' => 'Dekorasi estetik untuk menyegarkan suasana ruangan. Rangkaian bunga menawan dalam pot keramik atau vas kaca yang ideal untuk mempercantik meja kerja, area resepsionis, maupun ruang tamu.',
            ],
            [
                'name' => 'Bunga Kering & Artificial',
                'slug' => 'bunga-kering-artificial',
                'description' => 'Koleksi bunga abadi bernuansa estetik yang bebas perawatan. Hadir dalam desain minimalis yang tahan lama bertahun-tahun serta sangat aman untuk dikirim ke luar kota melalui ekspedisi.',
            ],
            [
                'name' => 'Hampers & Spesial',
                'slug' => 'hampers-spesial',
                'description' => 'Paket kado eksklusif yang memadukan keindahan rangkaian bunga dengan bingkisan menarik lainnya. Solusi kado lengkap dengan tambahan boneka, cokelat, atau camilan untuk orang tersayang.',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Call ProductSeeder to create 26 Bloomify products
        $this->call(ProductSeeder::class);
    }
}