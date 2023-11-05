<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function getProductBy(Request $request)
    {
        $pencarian = 'sku';
        if($request->query('pencarian'))  $pencarian = $request->query('pencarian');
        $sku = Produk::select(["$pencarian as text", 'id']);
        if($request->query('q'))
        {
            $sku = $sku->where("$pencarian", 'LIKE', "%{$request->query('q')}%");
        }
        if($request->input('id'))
        {
            $sku = $sku->where('id', $request->input('id'));
        }
        $sku = $sku->get();
        return response()->json(["results" => $sku]);
    }
    public function getProduct(Request $request, int $id)
    {
        $produk = Produk::select(['sku', 'nama_produk', 'harga', 'stok'])->where('id', $id)->get();
        if($produk)
        {
            return response()->json($produk->first());
        }
        return response()->json([], status:404);
    }
}
