<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Artisan extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'village_id',
        'kader_user_id',
        'name',
        'craft_type',
        'story',
        'photo_path',
        'wa_number',
        'consent_at',
        'status',
    ];

    protected $casts = [
        'consent_at' => 'datetime',
    ];

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function verifications(): MorphMany
    {
        return $this->morphMany(Verification::class, 'verifiable');
    }

    /**
     * Cek apakah nomor WhatsApp boleh ditampilkan ke publik (harus ada consent).
     */
    public function canShowContact(): bool
    {
        return !empty($this->consent_at) && !empty($this->wa_number);
    }
}
