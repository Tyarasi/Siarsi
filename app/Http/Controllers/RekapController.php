<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekapController extends Controller
{
    public function rekap()
    {
        $rekap = DB::select("
        SELECT k.id, MAX(k.nama_kategori) AS nama_kategori, 
        MONTH(IFNULL(f.tanggal_foto, v.tanggal_video)) AS bulan, 
        YEAR(IFNULL(f.tanggal_foto, v.tanggal_video)) AS tahun, 
        COUNT(DISTINCT IFNULL(f.id, v.id)) AS total_data FROM kategoris k 
        LEFT JOIN fotos f ON k.id = f.kategori_id 
        LEFT JOIN videos v ON k.id = v.kategori_id GROUP BY k.id, bulan, tahun;
        ");

        $totalPerBulan = [];

        foreach ($rekap as $data){
            $namaKategori = $data->nama_kategori;
            $bulan = $data->bulan;
            $totalData = $data->total_data;

            $totalPerBulan[$namaKategori] ??= [];
            $totalPerBulan[$namaKategori][$bulan] = ($totalPerBulan[$namaKategori][$bulan] ?? 0) + $totalData;
        }

        foreach ($rekap as $data) {
            $tahun = $data->tahun;
            $totalData = $data->total_data;
        
            if (!isset($totalPerTahun[$tahun])) {
                $totalPerTahun[$tahun] = $totalData;
            } else {
                $totalPerTahun[$tahun] += $totalData;
            }
        }

        return view('admin.views.rekap', [
            'rekap' => $rekap,
            'totalPerBulan' => $totalPerBulan,
            'totalPerTahun' => $totalPerTahun
        ]);
    }
    
    
}