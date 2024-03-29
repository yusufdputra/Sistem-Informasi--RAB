<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\RabTemp;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function GetBarangByKategori($id_kategori)
    {
        return Barang::groupBy('nama')
            ->where('id_kategori', $id_kategori)
            ->orderBy('harga', 'ASC')
            ->get();
    }

    public function GetSuplierByNamaBarang($id_barang)
    {
        return Barang::with('suplier')
            ->where('id', $id_barang)
            ->get();
    }
    public function GetBarangById($id)
    {
        return Barang::find($id);
    }
}
