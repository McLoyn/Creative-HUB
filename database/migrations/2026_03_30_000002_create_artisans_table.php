<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artisans', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('village_id')->constrained()->cascadeOnDelete();
            $table->string('kader_user_id')->index();         // referensi ID kader dari Main App
            $table->string('name');
            $table->enum('craft_type', ['batik_tulis', 'batik_cap', 'tenun_gedog', 'campuran']);
            $table->text('story')->nullable();
            $table->string('photo_path')->nullable();
            $table->string('wa_number')->nullable();          // nomor kontak WA
            $table->timestamp('consent_at')->nullable();      // persetujuan pengrajin (consent checkbox saat input)
            $table->enum('status', ['draft', 'pending', 'verified', 'rejected', 'inactive'])
                  ->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artisans');
    }
};
