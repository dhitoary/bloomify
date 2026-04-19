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
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('order_id')->unique(); // ID unik untuk dikirim ke Midtrans (misal: INV-001)
        $table->string('customer_name');
        $table->string('customer_phone');
        $table->integer('total_price'); // Menyimpan total harga belanjaan
        $table->string('status')->default('Unpaid'); // Status default sebelum dibayar
        $table->string('snap_token')->nullable(); // Untuk menyimpan token dari Midtrans
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
