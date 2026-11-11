<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QRCode extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'qr_codes';

    protected $fillable = [
        'product_id',
        'token',
        'revoked_at',
        'revoked_by',
    ];

    protected $casts = [
        'revoked_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function isRevoked(): bool
    {
        return !is_null($this->revoked_at);
    }
}
