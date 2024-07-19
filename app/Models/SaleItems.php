<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'barang_id',
        'harga_bandrol',
        'qty',
        'diskon_persen',
        'diskon_nilai',
        'harga_diskon',
        'total',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sales::class);
    }
}
