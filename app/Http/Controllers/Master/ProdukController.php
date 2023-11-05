<?php

namespace App\Http\Controllers\Master;

use App\Helpers\AlertFormatter;
use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Satuan;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $data['satuan'] = Satuan::all();
        $data['kategori'] = Kategori::all();
        $data['produk'] = Produk::all();
        return view('master.produk.index', $data);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'sku' => 'required|unique:produk,sku',
            'nama_produk' => 'required',
            'id_satuan' => 'required',
            'id_kategori' => 'required',
            'harga' => 'required',
        ]);

        if(Produk::create($data))
        {
            return redirect()->back()->with(AlertFormatter::success('Berhasil menambahkan kategori'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Gagal menambahkan kategori'));
    }

    public function update(Request $request, int $id)
    {
        $produk = Produk::findOrFail($id);
        $data = $request->validate([
            'sku' => 'required|unique:produk,sku,' . $produk->id,
            'nama_produk' => 'required',
            'id_satuan' => 'required',
            'id_kategori' => 'required',
            'harga' => 'required',
        ]);

        if($produk->update($data))
        {
            return redirect()->back()->with(AlertFormatter::success('Berhasil mengubah produk'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Gagal mengubah produk'));
    }

    public function delete(Request $request , int $id)
    {
        try{
            if(Produk::findOrFail($id)->delete())
            {
                return redirect()->back()->with(AlertFormatter::success('Berhasil menghapus produk'));
            }
            return redirect()->back()->with(AlertFormatter::danger('Gagal menghapus produk'));
        }catch(\Exception $e)
        {
            return redirect()->back()->with(AlertFormatter::danger('Gagal menghapus produk. ' . $e->getMessage()));
        }

    }
}
