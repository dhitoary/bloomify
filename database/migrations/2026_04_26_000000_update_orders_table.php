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
        Schema::table('orders', function (Blueprint $table) {
            // Tambahkan kolom user_id jika belum ada
            if (!Schema::hasColumn('orders', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->cascadeOnDelete();
            }

            // Tambahkan kolom order_number jika belum ada
            if (!Schema::hasColumn('orders', 'order_number')) {
                $table->string('order_number')->unique()->nullable()->after('user_id');
            }

            // Tambahkan kolom shipping_address jika belum ada
            if (!Schema::hasColumn('orders', 'shipping_address')) {
                $table->text('shipping_address')->nullable()->after('total_price');
            }

            // Tambahkan kolom notes jika belum ada
            if (!Schema::hasColumn('orders', 'notes')) {
                $table->text('notes')->nullable()->after('shipping_address');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'user_id')) {
                $table->dropForeignIdFor('users');
                $table->dropColumn('user_id');
            }
            if (Schema::hasColumn('orders', 'order_number')) {
                $table->dropColumn('order_number');
            }
            if (Schema::hasColumn('orders', 'shipping_address')) {
                $table->dropColumn('shipping_address');
            }
            if (Schema::hasColumn('orders', 'notes')) {
                $table->dropColumn('notes');
            }
        });
    }
};

