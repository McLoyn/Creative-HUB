<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verifications', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('verifiable_type');   // polymorphic: 'artisan' atau 'product'
            $table->string('verifiable_id');      // ULID dari artisan atau product
            $table->string('reviewer_user_id')->nullable();  // user_id admin
            $table->enum('action', ['submitted', 'approved', 'rejected', 'revoked']);
            $table->text('reason')->nullable();   // alasan jika ditolak / dicabut
            $table->timestamp('created_at')->useCurrent();

            $table->index(['verifiable_type', 'verifiable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verifications');
    }
};
