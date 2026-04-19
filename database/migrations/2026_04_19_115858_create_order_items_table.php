<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('order_items', function (Blueprint $table) {
        $table->id();
        // Karena tabel order sudah kita buat sebelumnya, pastikan relasinya mengarah ke sana
        $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete(); 
        $table->foreignId('product_id')->constrained()->cascadeOnDelete();
        $table->integer('quantity');
        $table->integer('price'); // Harga saat dibeli (jaga-jaga kalau harga produk berubah di masa depan)
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
