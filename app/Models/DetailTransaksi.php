<?php

namespace App\Models;

use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailTransaksi extends Model
{
    use HasFactory;
    protected $table = 'detail_transaksi';
    public $timestamps = false;

    protected $fillable = [
        'id_transaksi',
        'id_produk',
        'jumlah',
        'harga',
        'diskon',
        'total',
    ];

    /**
     * Get the produk that owns the DetailTransaksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id');
    }
}
