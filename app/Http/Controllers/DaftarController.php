<?php

namespace App\Http\Controllers;

use App\Models\Af;
use App\Models\Av;
use App\Models\Foto;
use App\Models\HistoryAdmin;
use App\Models\Kategori;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Image;

use function PHPUnit\Framework\fileExists;

class DaftarController extends Controller
{
    //Store Jangan Ganggu    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'id_kategori' => 'required', 
            'keterangan' => 'required',
            'tanggal' => 'required',
            'dokumentasi' => 'required|array|min:1',
            'dokumentasi.*' => 'required|file|mimes:jpeg,jpg,png,mp4,mov|max:102400'
            
        ], [
            'nama.required' => 'Bagian ini harus diisi',
            'id_kategori.required' => 'Id Kategori harus diisi',
            'keterangan.required' => 'Bagian ini harus diisi',
            'tanggal.required' => 'Bagian ini harus diisi',
            'dokumentasi.required' => 'File harus diunggah',
            'dokumentasi.*.file' => 'File harus berupa Foto atau Video',
            'dokumentasi.*.mimes' => 'File harus berformat jpeg, jpg, atau png',
            'dokumentasi.*.max' => 'File tidak boleh lebih dari 100 MB'
        ]);
        
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        ////dibawah ini jangan diganggu gugat !
        if ($request->hasFile('dokumentasi')) {
            $dokumentasiFiles = $request->file('dokumentasi');
            $nama = $request->input('nama');
            $nama_admin = $request->input('nama_admin');
            $admin_id = $request->input('admin_id');
            $tanggal = $request->input('tanggal');
            $kategori_id = $request->input('id_kategori');
            $keterangan = $request->input('keterangan');
            
            $fotoData = [];
            $videoData = [];
            
            foreach ($dokumentasiFiles as $dokumentasiFile) {
                $extension = $dokumentasiFile->getClientOriginalExtension();
                
                if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'gif') {
                    $name_gen = hexdec(uniqid()) . '.' . $dokumentasiFile->getClientOriginalExtension();
                    Image::make($dokumentasiFile)->save('dokumentasi/FotoDokumentasi/' . $name_gen);
                    $lastImg = 'dokumentasi/FotoDokumentasi/' . $name_gen;
                    
                    $fotoData[] = [
                        'foto_dokumentasi' => $lastImg,
                    ];
                } elseif ($extension == 'mp4' || $extension == 'mov' || $extension == 'avi') {
                    $path = 'dokumentasi/VideoDokumentasi/';
                    $name_gen = hexdec(uniqid()) . '.' . $dokumentasiFile->getClientOriginalExtension();
                    $dokumentasiFile->move($path, $name_gen);
                    $lastVideo = $path . $name_gen;
                    
                    $videoData[] = [
                        'video_dokumentasi' => $lastVideo,
                    ];
                }
            }
            
            if (!empty($fotoData)) {
                $dataFoto = Foto::create([
                    'nama_foto' => $nama,
                    'keterangan_foto' => $keterangan,
                    'nama_admin' => $nama_admin,
                    'admin_id' => $admin_id,
                    'kategori_id' => $kategori_id,
                    'tanggal_foto' => $tanggal,
                    'foto_dokumentasi' => json_encode($fotoData),
                    'created_at' => Carbon::now(),
                ]);
            }
            
            if (!empty($videoData)) {
                $dataVideo = Video::create([
                    'nama_video' => $nama,
                    'keterangan_video' => $keterangan,
                    'nama_admin' => $nama_admin,
                    'admin_id' => $admin_id,
                    'kategori_id' => $kategori_id,
                    'tanggal_video' => $tanggal,
                    'video_dokumentasi' => json_encode($videoData),
                    'created_at' => Carbon::now(),
                ]);
            }
            $fotoId = !empty($dataFoto) ? $dataFoto->id : null;
            $videoId = !empty($dataVideo) ? $dataVideo->id : null;

            if(!empty($dataFoto)){
                $fotoId = $dataFoto->id;
            }
            if(!empty($dataVideo)){
                $videoId = $dataVideo->id;
            }
            $admin_id = Auth::guard('admin')->user()->id;
            $historyAdmin = HistoryAdmin::where('admin_id', $admin_id)->first();

            if ($historyAdmin) {
                // Jika history admin sudah ada, lakukan pembaruan data
                $historyAdmin->foto_id = $fotoId;
                $historyAdmin->video_id = $videoId;
                $historyAdmin->save();
            } else {
                // Jika history admin belum ada, buat data baru
                $historyAdmin = HistoryAdmin::create([
                    'admin_id' => $admin_id,
                    'foto_id' => $fotoId,
                    'video_id' => $videoId,
                ]);
            }
            
            Av::create([
                'admin_id' => $admin_id,
                'video_id' => $videoId,
                'created_at' => Carbon::now(),
            ]);
            Af::create([
                'admin_id' => $admin_id,
                'foto_id' => $fotoId,
                'created_at' => Carbon::now(),
            ]);
        }

        return redirect()->route('index.daftar');
    }

    public function index(Request $request){
        Paginator::useBootstrap(); 
        $filter = $request->filter; 
        // if ($filter == 'today') {
        //     $allData = DB::select("SELECT GROUP_CONCAT(DISTINCT id) AS id, COALESCE(nama_foto, nama_video) AS nama, 
        //                 kategori_id, GROUP_CONCAT(DISTINCT keterangan_foto) AS keterangan, GROUP_CONCAT(DISTINCT kode) AS kode, 
        //                 nama_admin, tanggal_foto 
        //                 FROM (SELECT f.id, f.nama_foto, NULL AS nama_video, f.kategori_id, f.keterangan_foto, 
        //                     f.kode, f.nama_admin, f.tanggal_foto 
        //             FROM fotos f WHERE EXISTS (SELECT 1 FROM videos v WHERE v.id = f.id)
        //             AND DATE(f.tanggal_foto) = CURDATE() -- Filter berdasarkan hari ini
        //             UNION ALL
        //             SELECT v.id, NULL AS nama_foto, v.nama_video, v.kategori_id, v.keterangan_video, 
        //                     v.kode, v.nama_admin, v.tanggal_video 
        //             FROM videos v 
        //             WHERE EXISTS (SELECT 1 FROM fotos f WHERE f.id = v.id)
        //             AND DATE(v.tanggal_video) = CURDATE() -- Filter berdasarkan hari ini
        //             ) AS merged_data 
        //             GROUP BY COALESCE(nama_foto, nama_video), kategori_id, nama_admin, tanggal_foto;");
        //     } else if ($filter == 'this_month'){
        //         $allData = DB::select("SELECT GROUP_CONCAT(DISTINCT id) AS id, COALESCE(nama_foto, nama_video) AS nama, 
        //                     kategori_id, GROUP_CONCAT(DISTINCT keterangan_foto) AS keterangan, 
        //                     GROUP_CONCAT(DISTINCT kode) AS kode, nama_admin, tanggal_foto 
        //                     FROM (SELECT f.id, f.nama_foto, NULL AS nama_video, f.kategori_id, f.keterangan_foto, 
        //                             f.kode, f.nama_admin, f.tanggal_foto 
        //                     FROM fotos f WHERE EXISTS (SELECT 1 FROM videos v WHERE v.id = f.id)
        //                     AND MONTH(f.tanggal_foto) = MONTH(CURDATE()) -- Filter berdasarkan bulan ini
        //                     UNION ALL SELECT v.id, NULL AS nama_foto, v.nama_video, v.kategori_id, v.keterangan_video, 
        //                             v.kode, v.nama_admin, v.tanggal_video 
        //                     FROM videos v WHERE EXISTS (SELECT 1 FROM fotos f WHERE f.id = v.id)
        //                     AND MONTH(v.tanggal_video) = MONTH(CURDATE()) -- Filter berdasarkan bulan ini
        //                 ) AS merged_data 
        //                 GROUP BY COALESCE(nama_foto, nama_video), kategori_id, nama_admin, tanggal_foto;
        //                 ");
        //     } else if ($filter == 'this_year'){
        //         $allData = DB::select("SELECT GROUP_CONCAT(DISTINCT id) AS id, 
        //                         COALESCE(nama_foto, nama_video) AS nama, 
        //                         kategori_id, GROUP_CONCAT(DISTINCT keterangan_foto) AS keterangan, 
        //                         GROUP_CONCAT(DISTINCT kode) AS kode, nama_admin, tanggal_foto 
        //                     FROM (
        //                     SELECT f.id, f.nama_foto, NULL AS nama_video, f.kategori_id, f.keterangan_foto, 
        //                             f.kode, f.nama_admin, f.tanggal_foto 
        //                     FROM fotos f WHERE EXISTS (SELECT 1 FROM videos v WHERE v.id = f.id)
        //                     AND YEAR(f.tanggal_foto) = YEAR(CURDATE()) -- Filter berdasarkan tahun ini
        //                     UNION ALL
        //                     SELECT v.id, NULL AS nama_foto, v.nama_video, v.kategori_id, v.keterangan_video, 
        //                             v.kode, v.nama_admin, v.tanggal_video 
        //                     FROM videos v WHERE EXISTS (SELECT 1 FROM fotos f WHERE f.id = v.id)
        //                     AND YEAR(v.tanggal_video) = YEAR(CURDATE()) -- Filter berdasarkan tahun ini
        //                     ) AS merged_data 
        //                     GROUP BY COALESCE(nama_foto, nama_video), kategori_id, nama_admin, tanggal_foto;");
        //     } else {
        //         $allData = DB::select("SELECT GROUP_CONCAT(DISTINCT id) AS id, 
        //         COALESCE(nama_foto, nama_video) AS nama, kategori_id, 
        //         GROUP_CONCAT(DISTINCT keterangan_foto) AS keterangan, 
        //         GROUP_CONCAT(DISTINCT kode) AS kode, nama_admin, tanggal_foto 
        //         FROM ( SELECT f.id, f.nama_foto, NULL AS nama_video, 
        //         f.kategori_id, f.keterangan_foto, f.kode, f.nama_admin, f.tanggal_foto 
        //         FROM fotos f WHERE EXISTS ( SELECT 1 FROM videos v WHERE v.id = f.id )
        //         UNION ALL SELECT v.id, NULL AS nama_foto, 
        //         v.nama_video, v.kategori_id, v.keterangan_video, v.kode, 
        //         v.nama_admin, v.tanggal_video 
        //         FROM videos v 
        //         WHERE EXISTS 
        //         ( SELECT 1 FROM fotos f WHERE f.id = v.id ) ) AS merged_data 
        //         GROUP BY COALESCE(nama_foto, nama_video), kategori_id, nama_admin, tanggal_foto;"); 
        // //     }
        // dd($filter);
        if ($filter == 'today') {
            $query = "SELECT 
            merged_data.id,
            merged_data.nama,
            merged_data.kategori_id,
            GROUP_CONCAT(DISTINCT merged_data.keterangan) AS keterangan,
            GROUP_CONCAT(DISTINCT merged_data.kode) AS kode,
            GROUP_CONCAT(DISTINCT merged_data.nama_admin) AS nama_admin,
            GROUP_CONCAT(DISTINCT merged_data.tanggal) AS tanggal
        FROM
            (
                SELECT 
                    f.id,
                    f.nama_foto AS nama,
                    f.kategori_id,
                    f.keterangan_foto AS keterangan,
                    f.kode,
                    f.nama_admin,
                    f.tanggal_foto AS tanggal
                FROM 
                    fotos AS f
                WHERE
                    DATE(f.tanggal_foto) = CURDATE()  -- Menyaring berdasarkan tanggal saat ini
                GROUP BY 
                    f.id, f.nama_foto, f.kategori_id, f.keterangan_foto, f.kode, f.nama_admin, f.tanggal_foto
        
                UNION 
        
                SELECT 
                    v.id,
                    v.nama_video AS nama,
                    v.kategori_id,
                    v.keterangan_video AS keterangan,
                    v.kode,
                    v.nama_admin,
                    v.tanggal_video AS tanggal
                FROM 
                    videos AS v
                WHERE
                    DATE(v.tanggal_video) = CURDATE()  -- Menyaring berdasarkan tanggal saat ini
                GROUP BY 
                    v.id, v.nama_video, v.kategori_id, v.keterangan_video, v.kode, v.nama_admin, v.tanggal_video
            ) AS merged_data
        GROUP BY 
            merged_data.id, merged_data.nama, merged_data.kategori_id";
        } else if ($filter == 'this_month'){
            $query = "SELECT 
            merged_data.id,
            merged_data.nama,
            merged_data.kategori_id,
            GROUP_CONCAT(DISTINCT merged_data.keterangan) AS keterangan,
            GROUP_CONCAT(DISTINCT merged_data.kode) AS kode,
            GROUP_CONCAT(DISTINCT merged_data.nama_admin) AS nama_admin,
            GROUP_CONCAT(DISTINCT merged_data.tanggal) AS tanggal
        FROM
            (
                SELECT 
                    f.id,
                    f.nama_foto AS nama,
                    f.kategori_id,
                    f.keterangan_foto AS keterangan,
                    f.kode,
                    f.nama_admin,
                    f.tanggal_foto AS tanggal
                FROM 
                    fotos AS f
                WHERE
                    MONTH(f.tanggal_foto) = MONTH(CURDATE())  -- Menyaring berdasarkan bulan saat ini
                GROUP BY 
                    f.id, f.nama_foto, f.kategori_id, f.keterangan_foto, f.kode, f.nama_admin, f.tanggal_foto
        
                UNION 
        
                SELECT 
                    v.id,
                    v.nama_video AS nama,
                    v.kategori_id,
                    v.keterangan_video AS keterangan,
                    v.kode,
                    v.nama_admin,
                    v.tanggal_video AS tanggal
                FROM 
                    videos AS v
                WHERE
                    MONTH(v.tanggal_video) = MONTH(CURDATE())  -- Menyaring berdasarkan bulan saat ini
                GROUP BY 
                    v.id, v.nama_video, v.kategori_id, v.keterangan_video, v.kode, v.nama_admin, v.tanggal_video
            ) AS merged_data
        GROUP BY 
            merged_data.id, merged_data.nama, merged_data.kategori_id;";
        } else if ($filter == 'this_year'){
            $query = "SELECT 
            merged_data.id,
            merged_data.nama,
            merged_data.kategori_id,
            GROUP_CONCAT(DISTINCT merged_data.keterangan) AS keterangan,
            GROUP_CONCAT(DISTINCT merged_data.kode) AS kode,
            GROUP_CONCAT(DISTINCT merged_data.nama_admin) AS nama_admin,
            GROUP_CONCAT(DISTINCT merged_data.tanggal) AS tanggal
        FROM
            (
                SELECT 
                    f.id,
                    f.nama_foto AS nama,
                    f.kategori_id,
                    f.keterangan_foto AS keterangan,
                    f.kode,
                    f.nama_admin,
                    f.tanggal_foto AS tanggal
                FROM 
                    fotos AS f
                WHERE
                    YEAR(f.tanggal_foto) = YEAR(CURDATE())  -- Menyaring berdasarkan tahun saat ini
                GROUP BY 
                    f.id, f.nama_foto, f.kategori_id, f.keterangan_foto, f.kode, f.nama_admin, f.tanggal_foto
        
                UNION 
        
                SELECT 
                    v.id,
                    v.nama_video AS nama,
                    v.kategori_id,
                    v.keterangan_video AS keterangan,
                    v.kode,
                    v.nama_admin,
                    v.tanggal_video AS tanggal
                FROM 
                    videos AS v
                WHERE
                    YEAR(v.tanggal_video) = YEAR(CURDATE())  -- Menyaring berdasarkan tahun saat ini
                GROUP BY 
                    v.id, v.nama_video, v.kategori_id, v.keterangan_video, v.kode, v.nama_admin, v.tanggal_video
            ) AS merged_data
        GROUP BY 
            merged_data.id, merged_data.nama, merged_data.kategori_id;
        ";
        } else {
            $query = "SELECT 
                merged_data.id,
                merged_data.nama,
                merged_data.kategori_id,
                GROUP_CONCAT(DISTINCT merged_data.keterangan) AS keterangan,
                GROUP_CONCAT(DISTINCT merged_data.kode) AS kode,
                GROUP_CONCAT(DISTINCT merged_data.nama_admin) AS nama_admin,
                GROUP_CONCAT(DISTINCT merged_data.tanggal) AS tanggal
            FROM
                (
                    SELECT 
                        f.id,
                        f.nama_foto AS nama,
                        f.kategori_id,
                        f.keterangan_foto AS keterangan,
                        f.kode,
                        f.nama_admin,
                        f.tanggal_foto AS tanggal
                    FROM 
                        fotos AS f
                    GROUP BY 
                        f.id, f.nama_foto, f.kategori_id, f.keterangan_foto, f.kode, f.nama_admin, f.tanggal_foto
        
                    UNION 
        
                    SELECT 
                        v.id,
                        v.nama_video AS nama,
                        v.kategori_id,
                        v.keterangan_video AS keterangan,
                        v.kode,
                        v.nama_admin,
                        v.tanggal_video AS tanggal
                    FROM 
                        videos AS v
                    GROUP BY 
                        v.id, v.nama_video, v.kategori_id, v.keterangan_video, v.kode, v.nama_admin, v.tanggal_video
                ) AS merged_data
            GROUP BY 
                merged_data.id, merged_data.nama, merged_data.kategori_id";
        }
        
        
        $perPage = 5; // Jumlah data per halaman
        $currentPage = request()->query('page', 1); // Halaman saat ini, default: 1

        $allData = DB::select($query);
        $totalData = count($allData);

        $offset = ($currentPage - 1) * $perPage;
        $data = array_slice($allData, $offset, $perPage);

        $paginatedData = new LengthAwarePaginator($data, $totalData, $perPage, $currentPage);

        // Set path URL untuk pagination
        $paginatedData->withPath(route('index.daftar'));
       
        return view('admin.views.daftar', compact('allData', 'paginatedData'));
    }

    public function tambahData(){
        $kategori = Kategori::all();
        return view('admin.views.tambah', compact('kategori'));
    }

    public function editData($id){
        $kategori = Kategori::all();
        $allData = DB::select("SELECT COALESCE(nama_foto, nama_video) AS nama, kategori_id, 
                            GROUP_CONCAT(DISTINCT keterangan_foto) AS keterangan, nama_admin, tanggal_foto 
                            FROM ( SELECT kode, nama_foto, NULL AS nama_video, kategori_id, keterangan_foto, nama_admin, 
                            tanggal_foto FROM fotos WHERE id = $id 
                            UNION ALL 
                            SELECT kode, NULL AS nama_foto, nama_video, kategori_id, keterangan_video, nama_admin, tanggal_video 
                            FROM videos WHERE id = $id ) AS merged_data 
                            GROUP BY COALESCE(nama_foto, nama_video), kategori_id, nama_admin, tanggal_foto;");
       
        return view('admin.views.edit', compact('allData', 'id', 'kategori'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required',
                'id_kategori' => 'required',
                'keterangan' => 'required',
                'tanggal' => 'required',
                'dokumentasi' => 'required|array|min:1',
                'dokumentasi.*' => 'required|file|mimes:jpeg,jpg,png,mp4,mov|max:102400',
            ],
            [
                'nama.required' => 'Bagian ini harus diisi',
                'id_kategori.required' => 'Id Kategori harus diisi',
                'keterangan.required' => 'Bagian ini harus diisi',
                'tanggal.required' => 'Bagian ini harus diisi',
                'dokumentasi.required' => 'File harus diunggah',
                'dokumentasi.*.file' => 'File harus berupa Foto atau Video',
                'dokumentasi.*.mimes' => 'File harus berformat jpeg, jpg, atau png',
                'dokumentasi.*.max' => 'File tidak boleh lebih dari 100 MB',
            ]
        );
    
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        $id = $request->input('id');
        $foto = Foto::find($id);
        $video = Video::find($id);
    
        if (!empty($foto)) {
            $oldFotoData = json_decode($foto->foto_dokumentasi, true);
            foreach ($oldFotoData as $index => $oldFoto) {
                $path = $oldFoto['foto_dokumentasi'];
                if (file_exists($path)) {
                    unlink($path);
                }
                unset($oldFotoData[$index]);
            }
            $foto->foto_dokumentasi = json_encode($oldFotoData);
            $foto->save();
        }
    
        if (!empty($video)) {
            $oldVideoData = json_decode($video->video_dokumentasi, true);
            foreach ($oldVideoData as $index => $oldVideo) {
                $path = $oldVideo['video_dokumentasi'];
                if (file_exists($path)) {
                    unlink($path);
                }
                unset($oldVideoData[$index]);
            }
            $video->video_dokumentasi = json_encode($oldVideoData);
            $video->save();
        }
    
        $fotoData = [];
        $videoData = [];
    
        if ($request->hasFile('dokumentasi')) {
            $dokumentasiFiles = $request->file('dokumentasi');
            $nama = $request->input('nama');
            $nama_admin = $request->input('nama_admin');
            $admin_id = $request->input('admin_id');
            $tanggal = $request->input('tanggal');
            $kategori_id = $request->input('id_kategori');
            $keterangan = $request->input('keterangan');
    
            foreach ($dokumentasiFiles as $dokumentasiFile) {
                $extension = $dokumentasiFile->getClientOriginalExtension();
    
                if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'gif') {
                    $name_gen = hexdec(uniqid()) . '.' . $dokumentasiFile->getClientOriginalExtension();
                    Image::make($dokumentasiFile)->save('dokumentasi/FotoDokumentasi/' . $name_gen);
                    $lastImg = 'dokumentasi/FotoDokumentasi/' . $name_gen;
    
                    $fotoData[] = [
                        'foto_dokumentasi' => $lastImg,
                    ];
                } elseif ($extension == 'mp4' || $extension == 'mov' || $extension == 'avi') {
                    $path = 'dokumentasi/VideoDokumentasi/';
                    $name_gen = hexdec(uniqid()) . '.' . $dokumentasiFile->getClientOriginalExtension();
                    $dokumentasiFile->move($path, $name_gen);
                    $lastVideo = $path . $name_gen;
    
                    $videoData[] = [
                        'video_dokumentasi' => $lastVideo,
                    ];
                }
            }
        }
    
        if (!empty($fotoData)) {
            if (!empty($foto)) {
                $foto->update([
                    'nama_foto' => $nama,
                    'keterangan_foto' => $keterangan,
                    'admin_id' => $admin_id,
                    'kategori_id' => $kategori_id,
                    'tanggal_foto' => $tanggal,
                    'foto_dokumentasi' => json_encode($fotoData),
                ]);
            } else {
                $foto = Foto::create([
                    'nama_foto' => $nama,
                    'keterangan_foto' => $keterangan,
                    'nama_admin' => $nama_admin,
                    'admin_id' => $admin_id,
                    'kategori_id' => $kategori_id,
                    'tanggal_foto' => $tanggal,
                    'foto_dokumentasi' => json_encode($fotoData),
                ]);
            }
        }
    
        if (!empty($videoData)) {
            if (!empty($video)) {
                $video->update([
                    'nama_video' => $nama,
                    'keterangan_video' => $keterangan,
                    'kategori_id' => $kategori_id,
                    'admin_id' => $admin_id,
                    'tanggal_video' => $tanggal,
                    'video_dokumentasi' => json_encode($videoData),
                ]);
            } else {
                $video = Video::create([
                    'nama_video' => $nama,
                    'keterangan_video' => $keterangan,
                    'nama_admin' => $nama_admin,
                    'admin_id' => $admin_id,
                    'kategori_id' => $kategori_id,
                    'tanggal_video' => $tanggal,
                    'video_dokumentasi' => json_encode($videoData),
                ]);
            }
        }
    
        return redirect()->route('index.daftar');
    }
    
    public function delete($id){
        $fotos = Foto::where('id', $id)->get();
        $videos = Video::where('id', $id)->get();

        foreach ($fotos as $foto){
            $filePath = public_path($foto->foto_dokumentasi);
            if (file_exists($filePath)){
                unlink($filePath);
            }
        }
        
        foreach ($videos as $video){
            $filePath = public_path($video->video_dokumentasi);
            if(file_exists($filePath)){
                unlink($filePath);
            }
        }
        
        Video::where('id', $id)->delete();
        Foto::where('id', $id)->delete();

        return redirect()->back();
    }

    

}