<?php

namespace App\Models;

use App\Models\Kategori;
use App\Models\Satuan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $fillable = [
        'sku',
        'nama_produk',
        'id_satuan',
        'id_kategori',
        'harga',
    ];

    /**
     * Get the satuan associated with the Produk
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function satuan(): HasOne
    {
        return $this->hasOne(Satuan::class, 'id', 'id_satuan');
    }
    /**
     * Get the kategori associated with the Produk
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function kategori(): HasOne
    {
        return $this->hasOne(Kategori::class, 'id', 'id_kategori');
    }
}
