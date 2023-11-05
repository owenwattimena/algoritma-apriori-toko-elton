<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    public function index()
    {
        $data['transaksi'] = Transaksi::where('jenis', 'pembelian')->get();
        $data['idTransaksi'] = date('YmdHis');
        return view('transaksi.pembelian.index', $data);
    }

    public function show(Request $request, int $id)
    {
        $data['transaksi'] = Transaksi::findOrFail($id);
        if($data['transaksi']->jenis == 'penjualan')
        {
            return abort(404);
        }
        return view('transaksi.pembelian.detail', $data);
    }
}
