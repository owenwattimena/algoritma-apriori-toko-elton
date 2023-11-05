<?php

namespace App\Models;

use App\Models\DetailTransaksi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = "transaksi";
    public $timestamps = false;
    protected $fillable = [
        "id_transaksi",
        "nomor_faktur",
        "penyedia",
        "pelanggan",
        "tanggal",
        "jam",
        "sub_total",
        "diskon",
        "total",
        "bayar",
        "jenis",
        "created_at",
        "final_at",
        "id_user",
    ];

    /**
     * Get all of the detail for the Transaksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detail(): HasMany
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi', 'id');
    }
}
