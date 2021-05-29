<?php

namespace App\Http\Controllers;

use App\Models\Suplier;
use App\Models\User;
use Illuminate\Http\Request;

class SuplierController extends Controller
{ 
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = "Kelola Data Suplier";
        $users = User::with('roles')->get();
        $pegawai = $users->reject(function ($admin, $key) {
            return $admin->hasRole('admin');
        });
        $supliers = Suplier::all();
        return view('admin.suplier.index', compact('pegawai', 'title', 'supliers'));
    }

    public function store(Request $request)
    {
        $query = Suplier::insert([
            'nama'=> $request->nama,
            'nomor_hp'=> $request->nomor_hp,
            'alamat'=> $request->alamat,
        ]);
        if ($query) {
            return redirect()->back()->with('success', 'Suplier berhasil ditambah');
        }else{
            return redirect()->back()->with('alert', 'Suplier gagal ditambah');
        }
    }

    public function edit($id)
    {
        return Suplier::find($id);
    }

    public function update(Request $request)
    {
        Suplier::where('id', $request->id)
        ->update([
            'nama'=> $request->nama,
            'nomor_hp'=> $request->nomor_hp,
            'alamat'=> $request->alamat,
        ]);

        return redirect()->back()->with('success', 'Suplier berhasil diubah');
    }

    public function hapus(Request $request)
    {
        $query = Suplier::where('id', $request->id)->delete();

        if($query){
            return redirect()->back()->with('success', 'Berhasil menghapus Suplier');
        }else{
            return redirect()->back()->with('alert', 'Gagal menghapus Suplier');
        }
    }
}
