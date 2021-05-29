<?php

namespace App\Http\Controllers;

use App\Models\Rab;
use App\Models\RabTemp;
use Illuminate\Http\Request;
use PDF;

class CetakController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function cetakItemRab($id_rab)
    {
        $rab = Rab::find($id_rab);


        $rab_temp = array();
        foreach (unserialize($rab['id_rab_temp']) as $key => $value) {
            // get data
            $rab_temp[$key] = RabTemp::with('barang')->where('id', $value)->get();
        }
        $pdf = PDF::loadview('admin.cetak.rab', compact('rab_temp', 'rab'))->setPaper('a4', 'potrait');
        return $pdf->stream();
    }

    public function cetakPO()
    {
        $rabs = Rab::where('status', 1)->get();
        if (!$rabs->isEmpty()) {
            $rab_temp = array();
            foreach ($rabs as $rkey => $rab) {
                foreach (unserialize($rab->id_rab_temp) as $key => $value) {
                    // get data
                    $rab_temp[$rkey][$key] = RabTemp::with('barang')
                        ->where('id', $value)
                        ->first();
                }
            }
            $pdf = PDF::loadview('admin.cetak.rabpo', compact('rab_temp', 'rab', 'rabs'))->setPaper('a4', 'landscape');
            return $pdf->stream();
        } else {
            return redirect()->back()->with('alert', 'Tidak Ada Data');
        }
    }

    public function cetakDO($id)
    {
        $rab = Rab::find($id);

        $rab_temp = array();
        foreach (unserialize($rab['id_rab_temp']) as $key => $value) {
            // get data
            $rab_temp[$key] = RabTemp::with('barang')->where('id', $value)->get();
        }

        $pdf = PDF::loadview('admin.cetak.rabdo', compact('rab_temp', 'rab'))->setPaper('a4', 'potrait');
        return $pdf->stream();
    }
}
