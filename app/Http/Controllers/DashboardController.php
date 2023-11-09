<?php


namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data['total_produk'] = Produk::where('status', 1)->count();
        $data['total_kategori'] = Kategori::count();
        $data['total_pembelian'] = Transaksi::where('jenis', 'pembelian')->count();
        $data['total_penjualan'] = Transaksi::where('jenis', 'penjualan')->count();
        return view('dashboard.index', $data);
    }
}
