<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\Transaksi;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function buatTransaksi(Request $request)
    {

        $validator = \Validator::make($request->input(), [
            "transaksi"=> "required",
            "detail_transaksi"=> "required",
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        $data = $validator->getData();
        try{
            DB::transaction(function() use ($data){
                $data['transaksi']['jenis'] = 'penjualan';
                $data['transaksi']['created_at'] = now();
                $data['transaksi']['final_at'] = now();
                $data['transaksi']['id_user'] = Auth::user()->id;
                $transaksi = Transaksi::create($data['transaksi']);

                for($i = 0; $i < count($data['detail_transaksi']); $i++){
                    $data['detail_transaksi'][$i]['id_transaksi'] = $transaksi->id;

                    $idProduk = $data['detail_transaksi'][$i]['id_produk'];
                    $jumlah = $data['detail_transaksi'][$i]['jumlah'];


                    DetailTransaksi::create($data['detail_transaksi'][$i]);

                    $produk = Produk::findOrFail($idProduk);
                    $produk->stok = $produk->stok - $jumlah;

                    $produk->save();
                }
            });

            return response()->json('berhasil',200);
        }catch(\Exception $e)
        {
            return response()->json('gagal. ' . $e->getMessage(), 400);
        }

    }
}
