<?php

namespace App\Imports;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Suplier;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class BarangImport implements ToCollection, WithStartRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {

        try {
            DB::beginTransaction();
            foreach ($rows as $i => $row) {
                $suplier = Suplier::where(DB::raw('lower(nama)'), 'like', '%' . strtolower($row[1]) . '%')->first();
                if (empty($suplier)) {
                    // batalkan query import dan berikan notif ke user
                    throw new \Exception("Suplier ".$row[0]. " tidak ditemukan. Baris ke-".$i+1);
                }
                $kategori = Kategori::where(DB::raw('lower(nama)'), 'like', '%' . strtolower($row[4]) . '%')->first();
                if (empty($kategori)) {
                    // batalkan query import dan berikan notif ke user
                    throw new \Exception("Suplier ".$row[4]. " tidak ditemukan. Baris ke-".$i+1);
                }
                $query = Barang::insert([
                    'nama'=> strtoupper($row[0]),
                    'id_suplier' => $suplier->id,
                    'harga' => $row[2],
                    'tanggal' => $this->parseDate($row[3]),
                    'id_kategori' => $kategori->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
        
                ]);
            }
            DB::commit();
            
            return redirect()->back()->with('success', 'Berhasil import data barang');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('alert', 'Gagal import data barang. '.$th->getMessage());
        }
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    public function parseDate($date)
    {
        if ($date) {
            if (is_float($date) || is_int($date)) {
                // Konversi nilai float ke objek Carbon
                $carbonDate = Carbon::createFromTimestampUTC(($date - 25569) * 86400);

                // Format tanggal sesuai kebutuhan
                $formattedDate = $carbonDate->format('Y-m-d');
                # code...
            } else {
                $formattedDate = $date;
            }

            return $formattedDate;
        }
        return null;
    }
}
