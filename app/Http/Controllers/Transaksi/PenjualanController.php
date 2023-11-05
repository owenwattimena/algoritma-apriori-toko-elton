<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function index()
    {
        $data['transaksi'] = Transaksi::where('jenis', 'penjualan')->get();
        $data['idTransaksi'] = date('YmdHis');
        return view('transaksi.penjualan.index', $data);
    }
    public function show(Request $request, int $id)
    {
        $data['transaksi'] = Transaksi::findOrFail($id);
        if($data['transaksi']->jenis == 'pembelian')
        {
            return abort(404);
        }
        return view('transaksi.penjualan.detail', $data);
    }
}
