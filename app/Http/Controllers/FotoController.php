<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\Kategori;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Image;
use ZipArchive;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FotoController extends Controller
{

//Ni Detail
    public function Detail(Request $request, $id){
        $kode = $request->filter;
        // dd($kode);
        $nilai = preg_replace('/[^0-9]/', '', $kode);
        $fotos = []; 
        $videos = [];
        $validasi = '';
        if (preg_match('/[VF]/', $kode, $matches)) {
            $validasi = $matches[0];
        }
        
        if ($validasi === "F"){
            $data = DB::select("SELECT f.nama_foto, f.foto_dokumentasi, f.tanggal_foto, 'Filter' AS video_dokumentasi, 
                v.tanggal_video, f.kode AS kode_foto, v.kode AS kode_video FROM videos v 
                LEFT JOIN fotos f ON SUBSTRING_INDEX(v.kode, '-', -1) = SUBSTRING_INDEX(f.kode, '-', -1) 
                WHERE SUBSTRING_INDEX(v.kode, '-', -1) = '$nilai';");
        }
         elseif($validasi === "V"){
            $data = DB::select("SELECT v.nama_video, v.video_dokumentasi, v.tanggal_video, 'Filter' AS foto_dokumentasi, 
            f.tanggal_foto, f.kode AS kode_foto, v.kode AS kode_video FROM videos v 
            LEFT JOIN fotos f ON SUBSTRING_INDEX(v.kode, '-', -1) = SUBSTRING_INDEX(f.kode, '-', -1) 
            WHERE SUBSTRING_INDEX(v.kode, '-', -1) = '$nilai';");
        } else {
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
            $query = DB::select($kon1);
            $kon2 = "SELECT videos.video_dokumentasi, fotos.foto_dokumentasi, videos.kode AS kode_video,
                    fotos.kode AS kode_foto, videos.nama_video AS nama_video, fotos.nama_foto AS nama_foto, videos.keterangan_video AS keterangan_video, fotos.keterangan_foto AS keterangan_foto,
                    videos.tanggal_video AS tanggal_video, fotos.tanggal_foto AS tanggal_foto FROM videos LEFT JOIN fotos ON videos.id = fotos.id
                    WHERE videos.id = $id OR fotos.id = $id GROUP BY videos.video_dokumentasi, fotos.foto_dokumentasi, videos.kode, fotos.kode,
                        videos.nama_video, fotos.nama_foto, videos.keterangan_video, fotos.keterangan_foto, videos.tanggal_video, fotos.tanggal_foto
                    HAVING video_dokumentasi IS NOT NULL OR foto_dokumentasi IS NOT NULL;";
            $query1 = DB::select($kon2);
            // $query1 = DB::select($kon2);
                $value = $query[0];
                $nilai_foto = $value->foto_dokumentasi;
                $nilai_video = $value->video_dokumentasi;
                if (!empty($query1)) {
                    $value1 = $query1[0];
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
                // if($nilai_foto == null || $nilai_video == null){
                //     $data = DB::select($kon1);
                // } else if ($nilai_foto == null || $nilai_video == null ){
                //     $data = DB::select($kon2);
                // }
                // elseif($nilai_foto == null && $nilai_video == null ){
                    // $data = DB::select($kon1);
                //   elseif ($nilai_foto !== null && $nilai_video == null){
                //     $data = DB::select($kon1);
                // } elseif($nilai_foto == null && $nilai_video !== null) {
                //     $data = DB::select($kon1);
                // }
        }
        
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
            
        return view('admin.foto.detail', compact('data', 'fotos', 'videos', 'id'));
    }
// //Update 
//     public function updateFoto(Request $request, $id){
//         $validator = Validator::make($request->all(), [
//             'nama_foto' => 'required',
//             'kategori_id' => 'required',
//             'keterangan_foto' => 'required',
//             'tanggal_foto' => 'required',
//             'foto_dokumentasi' => 'required|array|min:1',
//             'foto_dokumentasi.*' => 'required|mimes:jpeg,jpg,png|max:2048'
            
//         ], [
//             'nama_foto.required' => 'Bagian ini harus diisi',
//             'kategori_id.required' => 'Id Kategori harus diisi',
//             'keterangan_foto.required' => 'Bagian ini harus diisi',
//             'tanggal_foto.required' => 'Bagian ini harus diisi',
//             'foto_dokumentasi.required' => 'File harus diunggah',
//             'foto_dokumentasi.*.mimes' => 'File harus berformat jpeg, jpg, atau png',
//             'foto_dokumentasi.*.max' => 'File tidak boleh lebih dari 2 MB'
//         ]);
        
//         if ($validator->fails()) {
//             return redirect()
//                 ->back()
//                 ->withErrors($validator)
//                 ->withInput();
//         }
        
//         //Rawan
//         $foto = Foto::find($id);
//         $fotoArray = json_decode($foto->foto_dokumentasi, true);
    
//         // hapus file lama
//         foreach(json_decode($foto->foto_dokumentasi, true) as $foto_dok) {
//             $del = $foto_dok['foto_dokumentasi'];
//             if (file_exists($del)){
//                 unlink($del);
//             }
//         }
    
//         if($request->hasFile('foto_dokumentasi')) {
//             $fotoArray = [];
//             foreach ($request->file('foto_dokumentasi') as $fotoDokumentasi) {
//                 $name_gen = hexdec(uniqid());
//                 $img_ext = strtolower($fotoDokumentasi->getClientOriginalExtension());
//                 $img_name = $name_gen.'.'.$img_ext;
//                 $up_location = 'dokumentasi/FotoDokumentasi/';
//                 $last_img = $up_location.$img_name;
//                 $fotoDokumentasi->move($up_location,$img_name);
//                 $fotoArray[] = ['foto_dokumentasi' => $last_img];
//             }
//         }
    
//         $foto->update([
//             'nama_foto' => $request->nama_foto,
//             'foto_dokumentasi' => json_encode($fotoArray),
//             'keterangan_foto' => $request->keterangan_foto,
//             'kategori_id' => $request->kategori_id,
//             'tanggal_foto' => $request->tanggal_foto,
//             'updated_at' => Carbon::now()
//         ]);
    
//         return Redirect()->route('index.foto');
//     }
    
//Delete
    public function deleteFoto($id, $index)
        {
            $foto = Foto::findOrFail($id);
            $foto_dokumentasi = json_decode($foto->foto_dokumentasi, true);

                if(isset($foto_dokumentasi[$index])){
                    $path = $foto_dokumentasi[$index]['foto_dokumentasi'];
                    if(file_exists($path)){
                        unlink($path);
                    }
                    unset($foto_dokumentasi[$index]);
                }

            $foto_dokumentasi = array_values($foto_dokumentasi);

            $foto->foto_dokumentasi = json_encode($foto_dokumentasi);
            $foto->save();

            return redirect()->route('index.daftar');
        }


    
    public function download(Request $request) {
        $fileName = $request->input('path');
        return response()->download('dokumentasi/FotoDokumentasi/'.$fileName);
    }

    public function downloadAllFoto($id)
    {
        $foto = Foto::find($id);
        $video = Video::find($id);
        
        if (!$foto) {
            return response()->json(['message' => 'Foto tidak ditemukan.'], Response::HTTP_NOT_FOUND);
        }
        
        $data = json_decode($foto->foto_dokumentasi, true);
        $nama = $foto->nama_foto;
        
        // Menginisialisasi objek ZipArchive
        $zip = new ZipArchive();
        
        $zipFileName = $nama . '.zip';
        $zipFilePath = storage_path('app/' . $zipFileName);
        
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($data as $dokumentasi) {
                $filePath = $dokumentasi['foto_dokumentasi'];
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, basename($dokumentasi['foto_dokumentasi']));
                }
            }
        
            if ($video) {
                $videoData = json_decode($video->video_dokumentasi, true);
                foreach ($videoData as $dokumentasi) {
                    $filePath = $dokumentasi['video_dokumentasi'];
                    if (file_exists($filePath)) {
                        $zip->addFile($filePath, basename($dokumentasi['video_dokumentasi']));
                    }
                }
            }
        
            $zip->close();
        
            return response()->download($zipFilePath, $zipFileName)->deleteFileAfterSend(true);
        }
        
        return response()->json(['message' => 'Gagal membuat file zip.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        
    }
    
   

}