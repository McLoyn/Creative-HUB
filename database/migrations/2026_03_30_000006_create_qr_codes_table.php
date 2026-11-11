<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qr_codes', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('product_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('token', 26)->unique();   // ULID unik untuk URL verifikasi publik (/verifikasi/{token})
            $table->timestamp('revoked_at')->nullable();
            $table->string('revoked_by')->nullable(); // user_id admin yang mencabut
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qr_codes');
    }
};
