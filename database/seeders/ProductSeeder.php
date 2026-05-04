<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database with 26 Bloomify products
     */
    public function run(): void
    {
        $products = [
            // Kategori 1: Bunga Satuan (Single Stem)
            [
                'category_id' => 1, 'name' => 'Mawar Merah/Putih (1 Tangkai)', 'slug' => 'mawar-merah-putih-1-tangkai', 
                'description' => 'Cocok untuk dibagikan saat acara himpunan atau apresiasi ringan.', 'price' => 15000, 'stock' => 50
            ],
            [
                'category_id' => 1, 'name' => 'Mawar Premium Semi-Holland (1 Tangkai)', 'slug' => 'mawar-premium-semi-holland-1-tangkai', 
                'description' => 'Ukuran kelopak lebih besar dan tangkai lebih kokoh.', 'price' => 25000, 'stock' => 30
            ],
            [
                'category_id' => 1, 'name' => 'Daisy Chamomile (Per Tangkai)', 'slug' => 'daisy-chamomile-per-tangkai', 
                'description' => 'Bunga kecil-kecil estetik ala Korea.', 'price' => 20000, 'stock' => 40
            ],
            [
                'category_id' => 1, 'name' => 'Bunga Matahari (1 Tangkai)', 'slug' => 'bunga-matahari-1-tangkai', 
                'description' => 'Hadiah sidang skripsi yang sederhana namun bermakna.', 'price' => 35000, 'stock' => 25
            ],
            [
                'category_id' => 1, 'name' => 'Lily Satuan (1 Kuntum)', 'slug' => 'lily-satuan-1-kuntum', 
                'description' => 'Pilihan bunga beraroma wangi untuk anggaran terbatas.', 'price' => 50000, 'stock' => 15
            ],
            [
                'category_id' => 1, 'name' => 'Tulip Import (1 Tangkai)', 'slug' => 'tulip-import-1-tangkai', 
                'description' => 'Bunga premium yang dijual satuan agar harganya tetap terjangkau.', 'price' => 65000, 'stock' => 10
            ],

            // Kategori 2: Buket Bunga Segar
            [
                'category_id' => 2, 'name' => 'Buket Mawar Ekonomis (3 Tangkai)', 'slug' => 'buket-mawar-ekonomis-3-tangkai', 
                'description' => 'Buket ukuran kecil dengan tambahan daun pelengkap.', 'price' => 85000, 'stock' => 20
            ],
            [
                'category_id' => 2, 'name' => 'Buket Bunga Matahari (Double)', 'slug' => 'buket-bunga-matahari-double', 
                'description' => 'Dua tangkai bunga matahari dengan wrapping premium.', 'price' => 125000, 'stock' => 15
            ],
            [
                'category_id' => 2, 'name' => 'Buket Mix Mawar & Baby\'s Breath', 'slug' => 'buket-mix-mawar-babys-breath', 
                'description' => 'Kombinasi klasik yang selalu laku di pasaran.', 'price' => 150000, 'stock' => 12
            ],
            [
                'category_id' => 2, 'name' => 'Buket Daisy Chamomile (Full)', 'slug' => 'buket-daisy-chamomile-full', 
                'description' => 'Buket padat dengan bunga-bunga kecil yang ceria.', 'price' => 175000, 'stock' => 10
            ],
            [
                'category_id' => 2, 'name' => 'Buket Mawar Standar (10 Tangkai)', 'slug' => 'buket-mawar-standar-10-tangkai', 
                'description' => 'Buket ukuran sedang untuk momen perayaan.', 'price' => 200000, 'stock' => 8
            ],
            [
                'category_id' => 2, 'name' => 'Buket Tulip Eksklusif (3 Tangkai)', 'slug' => 'buket-tulip-eksklusif-3-tangkai', 
                'description' => 'Pilihan paling premium di kategori buket bunga segar.', 'price' => 250000, 'stock' => 5
            ],

            // Kategori 3: Bunga Meja & Vas
            [
                'category_id' => 3, 'name' => 'Mini Succulent (Set 3)', 'slug' => 'mini-succulent-set-3', 
                'description' => 'Tanaman hias meja yang perawatannya sangat mudah.', 'price' => 120000, 'stock' => 15
            ],
            [
                'category_id' => 3, 'name' => 'Vas Kaca Mawar Mini (5 Tangkai)', 'slug' => 'vas-kaca-mawar-mini-5-tangkai', 
                'description' => 'Dekorasi estetik untuk diletakkan di meja belajar atau kerja.', 'price' => 150000, 'stock' => 10
            ],
            [
                'category_id' => 3, 'name' => 'Vas Bunga Lily Meja (2 Kuntum)', 'slug' => 'vas-bunga-lily-meja-2-kuntum', 
                'description' => 'Memberikan aroma terapi alami untuk ruangan.', 'price' => 180000, 'stock' => 8
            ],
            [
                'category_id' => 3, 'name' => 'Rangkaian Meja Anggrek Artifisial', 'slug' => 'rangkaian-meja-anggrek-artifisial', 
                'description' => 'Anggrek tiruan berkualitas tinggi beserta pot keramik.', 'price' => 250000, 'stock' => 5
            ],

            // Kategori 4: Bunga Kering & Artificial
            [
                'category_id' => 4, 'name' => 'Buket Pampas & Edelweiss (Rustic Mini)', 'slug' => 'buket-pampas-edelweiss-rustic-mini', 
                'description' => 'Buket tahan lama yang aman dikirim lewat ekspedisi.', 'price' => 85000, 'stock' => 25
            ],
            [
                'category_id' => 4, 'name' => 'Buket Artificial Premium', 'slug' => 'buket-artificial-premium', 
                'description' => 'Bunga tiruan yang terlihat persis seperti aslinya.', 'price' => 120000, 'stock' => 20
            ],
            [
                'category_id' => 4, 'name' => 'Buket Cotton Flower (Kapas)', 'slug' => 'buket-cotton-flower-kapas', 
                'description' => 'Nuansa minimalis dan estetik, awet bertahun-tahun.', 'price' => 135000, 'stock' => 15
            ],
            [
                'category_id' => 4, 'name' => 'Frame 3D Bunga Kering', 'slug' => 'frame-3d-bunga-kering', 
                'description' => 'Bingkai pigura berisi bunga kering untuk kado perpisahan.', 'price' => 200000, 'stock' => 8
            ],
            [
                'category_id' => 4, 'name' => 'Glass Dome Bunga Kering Mini', 'slug' => 'glass-dome-bunga-kering-mini', 
                'description' => 'Kado estetik yang diletakkan dalam kubah kaca kecil.', 'price' => 250000, 'stock' => 5
            ],

            // Kategori 5: Hampers & Spesial
            [
                'category_id' => 5, 'name' => 'Buket Snack / Jajanan Mahasiswa', 'slug' => 'buket-snack-jajanan-mahasiswa', 
                'description' => 'Alternatif hemat yang sangat diminati.', 'price' => 75000, 'stock' => 30
            ],
            [
                'category_id' => 5, 'name' => 'Buket Uang (Jasa & Bunga Artificial)', 'slug' => 'buket-uang-jasa-bunga-artificial', 
                'description' => 'Harga jasa merangkai, belum termasuk nominal uang tunai di dalamnya.', 'price' => 100000, 'stock' => 20
            ],
            [
                'category_id' => 5, 'name' => 'Buket Bunga + Boneka Wisuda', 'slug' => 'buket-bunga-boneka-wisuda', 
                'description' => 'Paket kado lengkap untuk merayakan kelulusan.', 'price' => 150000, 'stock' => 15
            ],
            [
                'category_id' => 5, 'name' => 'Bloom Box Mini + Balon Custom', 'slug' => 'bloom-box-mini-balon-custom', 
                'description' => 'Kotak bunga dengan balon transparan berisi tulisan.', 'price' => 185000, 'stock' => 10
            ],
            [
                'category_id' => 5, 'name' => 'Box Bunga Mawar + Cokelat Bar', 'slug' => 'box-bunga-mawar-cokelat-bar', 
                'description' => 'Kotak bunga yang dipadukan dengan cokelat untuk momen spesial.', 'price' => 200000, 'stock' => 8
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}