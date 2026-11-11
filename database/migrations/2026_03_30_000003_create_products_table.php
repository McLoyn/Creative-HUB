<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('artisan_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->enum('category', ['batik_tulis', 'batik_cap', 'tenun_gedog', 'produk_jadi']);
            $table->string('motif')->nullable();
            $table->string('material');
            $table->enum('dye_type', ['alami', 'sintetis', 'campuran']);
            $table->string('size')->nullable();
            $table->unsignedBigInteger('price');              // harga dalam rupiah
            $table->enum('stock_status', ['tersedia', 'habis', 'pre_order'])->default('tersedia');
            $table->text('description');
            $table->text('process_story')->nullable();
            $table->enum('status', ['draft', 'pending', 'verified', 'rejected', 'inactive'])
                  ->default('draft');
            $table->unsignedInteger('wa_click_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
