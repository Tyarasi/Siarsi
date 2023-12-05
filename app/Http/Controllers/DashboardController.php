<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function Index(Request $request)
    {
        $search = $request->search;
        if (isset($search) && !empty($search)) {
            $kategori = Kategori::where('nama_kategori', 'like', '%' . $search . '%')->get();
        } else {
            $kategori = Kategori::paginate(4);
        }

        $count = Kategori::where('nama_kategori', $search)->first();
        if ($count) {
            $count->views += 1;
            $count->save();
        }
        
        return view('user.home', compact('kategori'));
    }
    
    public function kategori(Request $request, $id){
        $kategori = Kategori::find($id);
        $kategoris = Kategori::all();
        $filter = $request->filter;
        $tanggal = $request->tanggal;
        
        $idfx = (int)$id;
        if($filter === $id){
            $query = "SELECT merged_data.id, merged_data.nama, merged_data.kategori_id, GROUP_CONCAT(DISTINCT merged_data.keterangan) AS keterangan,
            GROUP_CONCAT(DISTINCT merged_data.kode) AS kode, GROUP_CONCAT(DISTINCT merged_data.nama_admin) AS nama_admin,
            GROUP_CONCAT(DISTINCT merged_data.tanggal) AS tanggal, GROUP_CONCAT(DISTINCT merged_data.foto_dokumentasi) AS foto_dokumentasi,
            GROUP_CONCAT(DISTINCT merged_data.video_dokumentasi) AS video_dokumentasi
                    FROM
                    ( SELECT f.id, f.nama_foto AS nama, f.kategori_id, f.keterangan_foto AS keterangan,
                            f.kode, f.nama_admin, f.tanggal_foto AS tanggal,
                            f.foto_dokumentasi, NULL AS video_dokumentasi
                    FROM fotos AS f WHERE f.kategori_id = $id GROUP BY f.id, f.nama_foto, f.kategori_id, f.keterangan_foto, f.kode, f.nama_admin, f.tanggal_foto
                    UNION
                    SELECT v.id, v.nama_video AS nama, v.kategori_id, v.keterangan_video AS keterangan, v.kode,
                        v.nama_admin, v.tanggal_video AS tanggal, NULL AS foto_dokumentasi, v.video_dokumentasi
                    FROM videos AS v WHERE v.kategori_id = $id GROUP BY v.id, v.nama_video, v.kategori_id, v.keterangan_video, v.kode, v.nama_admin, v.tanggal_video) 
                    AS merged_data
                    GROUP BY merged_data.id, merged_data.nama, merged_data.kategori_id";
        } elseif($filter !== $id && $filter !== null){
            $tampung = $request->filter;
            $moreId = (int)$tampung;
            $query = "SELECT merged_data.id, merged_data.nama, merged_data.kategori_id, GROUP_CONCAT(DISTINCT merged_data.keterangan) AS keterangan,
            GROUP_CONCAT(DISTINCT merged_data.kode) AS kode, GROUP_CONCAT(DISTINCT merged_data.nama_admin) AS nama_admin,
            GROUP_CONCAT(DISTINCT merged_data.tanggal) AS tanggal, GROUP_CONCAT(DISTINCT merged_data.foto_dokumentasi) AS foto_dokumentasi,
            GROUP_CONCAT(DISTINCT merged_data.video_dokumentasi) AS video_dokumentasi
                    FROM
                    ( SELECT f.id, f.nama_foto AS nama, f.kategori_id, f.keterangan_foto AS keterangan,
                            f.kode, f.nama_admin, f.tanggal_foto AS tanggal,
                            f.foto_dokumentasi, NULL AS video_dokumentasi
                    FROM fotos AS f WHERE f.kategori_id = $moreId GROUP BY f.id, f.nama_foto, f.kategori_id, f.keterangan_foto, f.kode, f.nama_admin, f.tanggal_foto
                    UNION
                    SELECT v.id, v.nama_video AS nama, v.kategori_id, v.keterangan_video AS keterangan, v.kode,
                        v.nama_admin, v.tanggal_video AS tanggal, NULL AS foto_dokumentasi, v.video_dokumentasi
                    FROM videos AS v WHERE v.kategori_id = $moreId GROUP BY v.id, v.nama_video, v.kategori_id, v.keterangan_video, v.kode, v.nama_admin, v.tanggal_video) 
                    AS merged_data
                    GROUP BY merged_data.id, merged_data.nama, merged_data.kategori_id";
            
        } else {
            $query = "SELECT merged_data.id, merged_data.nama, merged_data.kategori_id, GROUP_CONCAT(DISTINCT merged_data.keterangan) AS keterangan,
            GROUP_CONCAT(DISTINCT merged_data.kode) AS kode, GROUP_CONCAT(DISTINCT merged_data.nama_admin) AS nama_admin,
            GROUP_CONCAT(DISTINCT merged_data.tanggal) AS tanggal, GROUP_CONCAT(DISTINCT merged_data.foto_dokumentasi) AS foto_dokumentasi,
            GROUP_CONCAT(DISTINCT merged_data.video_dokumentasi) AS video_dokumentasi
                    FROM
                    ( SELECT f.id, f.nama_foto AS nama, f.kategori_id, f.keterangan_foto AS keterangan,
                            f.kode, f.nama_admin, f.tanggal_foto AS tanggal,
                            f.foto_dokumentasi, NULL AS video_dokumentasi
                    FROM fotos AS f WHERE f.kategori_id = $idfx GROUP BY f.id, f.nama_foto, f.kategori_id, f.keterangan_foto, f.kode, f.nama_admin, f.tanggal_foto
                    UNION
                    SELECT v.id, v.nama_video AS nama, v.kategori_id, v.keterangan_video AS keterangan, v.kode,
                        v.nama_admin, v.tanggal_video AS tanggal, NULL AS foto_dokumentasi, v.video_dokumentasi
                    FROM videos AS v WHERE v.kategori_id = $idfx GROUP BY v.id, v.nama_video, v.kategori_id, v.keterangan_video, v.kode, v.nama_admin, v.tanggal_video) 
                    AS merged_data
                    GROUP BY merged_data.id, merged_data.nama, merged_data.kategori_id";
        }
        $dataFilter = DB::select($query);
        if($tanggal !== null){
            $data = array_filter($dataFilter, function ($item) use ($tanggal){
                return $item->tanggal === $tanggal;
            }); 
        } else {
            $data = DB::select($query);
        }
        $kategori = Kategori::find($id);
        if ($kategori) {
            $kategori->incrementClickCount();
        }
        
        return view('user.kategori.index', compact('kategoris', 'kategori', 'data', 'id'));
    }

    public function detail($id){
        // $foto = DB::select("SELECT foto_dokumentasi FROM fotos WHERE id='$id'");
        $fotos = []; 
        $videos = [];
        $nama_kategori = "Apel Pagi";
        // if ($nama_kategori !== null){
            $kon1 = "SELECT videos.video_dokumentasi, NULL AS foto_dokumentasi, videos.kode AS kode_video,
                    NULL AS kode_foto, videos.nama_video AS nama_video, NULL AS nama_foto, videos.keterangan_video AS keterangan_video,
                    NULL AS keterangan_foto,videos.tanggal_video AS tanggal_video, NULL AS tanggal_foto FROM videos WHERE
                        videos.id = $id
                UNION SELECT
                    NULL AS video_dokumentasi, fotos.foto_dokumentasi, NULL AS kode_video, fotos.kode AS kode_foto,
                    NULL AS nama_video, fotos.nama_foto AS nama_foto, NULL AS keterangan_video, fotos.keterangan_foto AS keterangan_foto,
                    NULL AS tanggal_video,
                    fotos.tanggal_foto AS tanggal_foto
                FROM
                    fotos
                WHERE
                    fotos.id = $id;";
        $mysql = DB::select($kon1);
       
        $kon2 = "SELECT videos.video_dokumentasi, fotos.foto_dokumentasi, videos.kode AS kode_video,
                    fotos.kode AS kode_foto, videos.nama_video AS nama_video, fotos.nama_foto AS nama_foto, videos.keterangan_video AS keterangan_video, fotos.keterangan_foto AS keterangan_foto,
                    videos.tanggal_video AS tanggal_video, fotos.tanggal_foto AS tanggal_foto FROM videos LEFT JOIN fotos ON videos.id = fotos.id
                    WHERE videos.id = $id OR fotos.id = $id GROUP BY videos.video_dokumentasi, fotos.foto_dokumentasi, videos.kode, fotos.kode,
                        videos.nama_video, fotos.nama_foto, videos.keterangan_video, fotos.keterangan_foto, videos.tanggal_video, fotos.tanggal_foto
                    HAVING video_dokumentasi IS NOT NULL OR foto_dokumentasi IS NOT NULL;";
        $mysql1 = DB::select($kon2);
        
                $value = $mysql[0];
                $nilai_foto = $value->foto_dokumentasi;
                $nilai_video = $value->video_dokumentasi;
                if (!empty($mysql1)) {
                    $value1 = $mysql1[0];
                    $nilai_foto1 = $value1->foto_dokumentasi;
                    $nilai_video1 = $value1->video_dokumentasi;
                } else {
                    $nilai_foto1 = null;
                    $nilai_video1 = null;
                }
                
                switch (true) {
                    case ($nilai_foto == null && $nilai_video !== null):
                        $data = DB::select($kon2);
                        break;
                    case ($nilai_foto1 == null || $nilai_video1 == null):
                        $data = DB::select($kon1);
                        break;
                    default:
                        // Tindakan default jika tidak ada kondisi yang cocok
                        break;
                }
        
        // }
            if ($data) {
                foreach ($data as $value) {
                    $fotos = json_decode($value->foto_dokumentasi, true);
                    if (is_array($fotos)) {
                        foreach ($fotos as $foto) {
                            $foto['id'] = 1;
                        }
                    } else {
                        $fotos = $value->foto_dokumentasi;
                    }
                    
                    $videos = json_decode($value->video_dokumentasi, true);
                    if (is_array($videos)) {
                        foreach ($videos as $video) {
                            $video['id'] = 1;
                            // Lakukan pengolahan data lebih lanjut...
                        }
                    } else {
                        $videos = $value->video_dokumentasi;
                    }
                    
                }
            }
        return view('user.kategori.detail', compact('data', 'fotos', 'videos', 'id'));
    }

    public function view($id, $kode, $key)
    {
        if($kode === 'F'){
            $dokumentasi = DB::table('fotos')->where('id', $id)->value('foto_dokumentasi');
            $data = DB::select("SELECT * From fotos where id='$id'");
            $dataArray = json_decode($dokumentasi, true); // true parameter untuk mengubah menjadi array asosiatif
            $index = count($dataArray);
        } elseif($kode === 'V'){
            $dokumentasi = DB::table('videos')->where('id', $id)->value('video_dokumentasi');
            $data = DB::select("SELECT * From videos where id='$id'");
            
            $dataArray = json_decode($dokumentasi, true); // true parameter untuk mengubah menjadi array asosiatif
            $index = count($dataArray);
        }
        return view('user.kategori.view', compact('data', 'kode', 'key', 'index', 'dokumentasi'));
    }
    
    public function about(){
        return view('user.about.index');
    }
}  