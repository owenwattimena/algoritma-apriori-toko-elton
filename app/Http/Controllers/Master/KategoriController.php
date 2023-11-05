<?php

namespace App\Http\Controllers\Master;

use App\Helpers\AlertFormatter;
use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index()
    {
        $data['kategori'] = Kategori::all();
        return view('master.kategori.index', $data);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'nama_kategori' => 'required'
        ]);

        $data['slug'] = Str::slug($request->nama_kategori);
        if(Kategori::create($data))
        {
            return redirect()->back()->with(AlertFormatter::success('Berhasil menambahkan kategori'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Gagal menambahkan kategori'));
    }
    public function update(Request $request, String $slug)
    {
        $data = $request->validate([
            'nama_kategori' => 'required'
        ]);

        $data['slug'] = Str::slug($request->nama_kategori);
        if(Kategori::where('slug', $slug)->update($data))
        {
            return redirect()->back()->with(AlertFormatter::success('Berhasil mengubah kategori'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Gagal mengubah kategori'));
    }

    public function delete(Request $request , String $slug)
    {
        try{
            if(Kategori::where('slug', $slug)->delete())
            {
                return redirect()->back()->with(AlertFormatter::success('Berhasil menghapus kategori'));
            }
            return redirect()->back()->with(AlertFormatter::danger('Gagal menghapus kategori'));
        }catch(\Exception $e)
        {
            return redirect()->back()->with(AlertFormatter::danger('Gagal menghapus kategori. ' . $e->getMessage()));
        }

    }
}
