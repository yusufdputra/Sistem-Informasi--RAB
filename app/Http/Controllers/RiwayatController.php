<?php

namespace App\Http\Controllers;

use App\Models\Rab;
use App\Models\RabTemp;
use App\Models\User;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $title = "Kelola Rancangan Anggaran Biaya (RAB)";
        $users = User::with('roles')->get();
        $pegawai = $users->reject(function ($admin, $key) {
            return $admin->hasRole('admin');
        });
        $rab = Rab::where('status',  2)->get();
        // hitung total harga
        $harga_total = array();
        foreach ($rab as $key => $value) {
            $harga_total_rab = 0;
            $id_rab_temps = unserialize($value['id_rab_temp']);
            foreach ($id_rab_temps as $k => $id_temp) {
                $rabTemp = RabTemp::with('barang')->where('id', $id_temp)->first();
                $harga_total_rab = $harga_total_rab + ($rabTemp->barang[0]['harga'] * $rabTemp['kuantitas']);
            }
            $harga_total[$key] = $harga_total_rab;
        }

        return view('admin.riwayat.index', compact('pegawai', 'title', 'rab', 'harga_total'));
    }
}
