<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Suplier;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = "Data Barang";
        $users = User::with('roles')->get();
        $pegawai = $users->reject(function ($admin, $key) {
            return $admin->hasRole('admin');
        });
        $barang = Barang::with('kategori', 'suplier')
            ->orderBy('nama')
            ->orderBy('harga')
            ->get();
        $kategori = Kategori::all();
        $suplier = Suplier::all();
        return view('admin.barang.index', compact('pegawai', 'title', 'barang', 'kategori', 'suplier'));
    }

    public function store(Request $request)
    {
        $query = Barang::insert([
            'nama'=> strtoupper($request->nama),
            'id_suplier' => $request->suplier,
            'harga' => $request->harga,
            'tanggal' => $request->tanggal,
            'id_kategori' => $request->kategori,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);
        if ($query) {
            return redirect()->back()->with('success', 'Barang berhasil ditambah');
        }else{
            return redirect()->back()->with('alert', 'Barang gagal ditambah');
        }
    }

    public function edit($id)
    {
        return Barang::find($id);
    }

    public function update(Request $request)
    {
        Barang::where('id', $request->id)
        ->update([
            'nama'=> strtoupper($request->nama),
            'id_suplier' => $request->suplier,
            'harga' => $request->harga,
            'tanggal' => $request->tanggal,
            'id_kategori' => $request->kategori
        ]);

        return redirect()->back()->with('success', 'Barang berhasil diubah');
    }

    public function hapus(Request $request)
    {
        $query = Barang::where('id', $request->id)->delete();

        if($query){
            return redirect()->back()->with('success', 'Berhasil menghapus Barang');
        }else{
            return redirect()->back()->with('alert', 'Gagal menghapus Barang');
        }
    }
}
