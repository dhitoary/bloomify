<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['id' => 1, 'name' => 'Bunga Satuan', 'slug' => 'bunga-satuan', 'description' => 'Bunga yang dijual per tangkai.'],
            ['id' => 2, 'name' => 'Buket Bunga Segar', 'slug' => 'buket-bunga-segar', 'description' => 'Buket bunga segar untuk berbagai acara.'],
            ['id' => 3, 'name' => 'Bunga Meja & Vas', 'slug' => 'bunga-meja-vas', 'description' => 'Dekorasi bunga untuk meja dan ruangan.'],
        ]);
    }
}
