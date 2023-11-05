<?php

namespace App\Http\Controllers\Master;

use App\Helpers\AlertFormatter;
use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SatuanController extends Controller
{
    public function index()
    {
        $data['satuan'] = Satuan::all();
        return view('master.satuan.index', $data);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'kode' => 'required',
            'nama_satuan' => 'required'
        ]);

        $data['slug'] = Str::slug($request->kode);
        if(Satuan::create($data))
        {
            return redirect()->back()->with(AlertFormatter::success('Berhasil menambahkan satuan'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Gagal menambahkan satuan'));
    }

    public function update(Request $request, String $slug)
    {
        $data = $request->validate([
            'kode' => 'required',
            'nama_satuan' => 'required'
        ]);

        $data['slug'] = Str::slug($request->kode);
        if(Satuan::where('slug', $slug)->update($data))
        {
            return redirect()->back()->with(AlertFormatter::success('Berhasil mengubah satuan'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Gagal mengubah satuan'));
    }

    public function delete(Request $request , String $slug)
    {
        try{
            if(Satuan::where('slug', $slug)->delete())
            {
                return redirect()->back()->with(AlertFormatter::success('Berhasil menghapus satuan'));
            }
            return redirect()->back()->with(AlertFormatter::danger('Gagal menghapus satuan'));
        }catch(\Exception $e)
        {
            return redirect()->back()->with(AlertFormatter::danger('Gagal menghapus satuan. ' . $e->getMessage()));
        }

    }
}
