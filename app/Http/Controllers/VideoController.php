<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use ZipArchive;

class VideoController extends Controller
{
    

    public function editVideo($id){
        $video = video::findOrFail($id);
        $kategori = Kategori::all();
        $videos = json_decode($video->video_dokumentasi, true);
        return view('admin.video.edit', compact('video', 'videos','kategori'));
    }

    public function deleteVideo($id, $index){
        $video = Video::findOrFail($id);
        $video_dokumentasi = json_decode($video->video_dokumentasi, true);

            if(isset($video_dokumentasi[$index])){
                $path = $video_dokumentasi[$index]['video_dokumentasi'];
                if(file_exists($path)){
                    unlink($path);
                }
                unset($video_dokumentasi[$index]);
            }

            $video_dokumentasi = array_values($video_dokumentasi);

            $video->video_dokumentasi = json_encode($video_dokumentasi);
            $video->save();

            return redirect()->route('index.daftar');
    }

    

    public function download(Request $request) {
        $fileName = $request->input('path');
        return response()->download('dokumentasi/VideoDokumentasi/'.$fileName);
   
    }
}