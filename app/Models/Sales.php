<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sales extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'tgl',
        'customer_id',
        'user_id',
        'jumlah_barang',
        'subtotal',
        'diskon',
        'ongkir',
        'total_bayar',
    ];

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItems::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
