<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Foto;
use App\Models\HistoryAdmin;
use App\Models\Kategori;
use App\Models\Video;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    public function showLoginForm(){
        return view('auth.login');
    }

    public function Index(Request $request){
        // $filter = $request->filter;
        $search = $request->search;
        
        $kategori = Kategori::where('nama_kategori', $search)->first();
            if ($kategori) {
                $kategori->views += 1;
                $kategori->save();
            }
        $countJlmhSeacrh = DB::select('SELECT nama_kategori, views FROM kategoris 
        WHERE views = (SELECT MAX(views) FROM kategoris);');
        $countJlmhview = DB::select('SELECT nama_kategori, click_count FROM kategoris 
        WHERE click_count = (SELECT MAX(click_count) FROM kategoris);');
        
        $id = Auth::guard('admin')->user()->id;
        $lastAccess = Admin::find($id);
        
        $rekap = DB::select("
            SELECT k.id, MAX(k.nama_kategori) AS nama_kategori, 
            MONTH(IFNULL(f.tanggal_foto, v.tanggal_video)) AS bulan, 
            YEAR(IFNULL(f.tanggal_foto, v.tanggal_video)) AS tahun, 
            COUNT(DISTINCT IFNULL(f.id, v.id)) AS total_data FROM kategoris k 
            LEFT JOIN fotos f ON k.id = f.kategori_id 
            LEFT JOIN videos v ON k.id = v.kategori_id GROUP BY k.id, bulan, tahun;
        "); 
        
        $bulanLabels = array_map(function ($data) {
            return date('F', mktime(0, 0, 0, $data->bulan, 1));
        }, $rekap);
        
        usort($bulanLabels, function ($a, $b) {
            return date_create($a)->format('m') - date_create($b)->format('m');
        });
        
        $bulanLabels = array_unique($bulanLabels);
        sort($bulanLabels, SORT_NUMERIC);
        
        $kategoriData = array();
        foreach ($rekap as $data) {
            $bulan = date('F', mktime(0, 0, 0, $data->bulan, 1));
            if (!isset($kategoriData[$bulan])) {
                $kategoriData[$bulan] = array();
            }
            $kategoriData[$bulan][$data->nama_kategori] = $data->total_data;
        }
        
        $datasets = array();
        $kategoris = array_unique(array_column($rekap, 'nama_kategori'));
        $colors = ['rgba(255, 99, 132, 0.2)', 'rgba(255, 159, 64, 0.2)', 'rgba(255, 205, 86, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(201, 203, 207, 0.2)'];
        
        foreach ($kategoris as $index => $kategori) {
            $totalData = array();
            foreach ($bulanLabels as $bulan) {
                $kategoriDataBulan = isset($kategoriData[$bulan]) ? $kategoriData[$bulan] : array();
                $totalData[] = isset($kategoriDataBulan[$kategori]) ? $kategoriDataBulan[$kategori] : 0;
            }
            $colorIndex = $index % count($colors);
            $datasets[] = array(
                'label' => $kategori,
                'data' => $totalData,
                'backgroundColor' => $colors[$colorIndex],
                'borderColor' => 'rgb(54, 162, 235)',
                'borderWidth' => 1
            );
        }
        $visitorCount = Visitor::count();
        
        return view('admin.index', compact( 'lastAccess', 'countJlmhSeacrh', 'countJlmhview', 'rekap', 
        'bulanLabels', 'datasets', 'visitorCount'));
    }

    public function login(Request $request)
    {
            $admin = Admin::where('username', $request->username)->first();
            if (!$admin) {
                return redirect()->back()->withInput()->with('error', 'Username atau Password tidak ada');
            }
        if (Hash::check($request->password, $admin->password)) {
            $rememberToken = Str::random(60);
            $admin->update([
                'remember_token' => $rememberToken,
            ]);

            session(['admin_remember_token' => $rememberToken]);

            if ($admin->role === 'superadmin') {
                Auth::guard('admin')->login($admin);
                $lastAccess = Auth::guard('admin')->user();
                $lastAccess->updateOrCreate(
                    ['id' => $admin->id],
                    ['last_access' => Carbon::now()]
                );
                $time = Carbon::now();
                
                HistoryAdmin::create([
                    'admin_id' => $lastAccess->id,
                    'waktu_login' => $time
                ]);
                return redirect()->route('admin.index', compact('lastAccess'));
            } else {
                Auth::guard('admin')->login($admin);
                $lastAccess = Auth::guard('admin')->user();
                $lastAccess->updateOrCreate(
                    ['id' => $admin->id],
                    ['last_access' => Carbon::now()]
                );
                $time = Carbon::now();
                HistoryAdmin::create([
                    'admin_id' => $lastAccess->id,
                    'waktu_login' => $time
                    
                ]);
                return redirect()->route('admin.index', compact('lastAccess'));
            }
        } else {
            // Jika tidak sesuai, kembalikan pesan error
            return redirect()->back()->withInput()->with('error', 'Username atau password salah.');
        }
    }

    public function logout(Request $request)
    {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
    }
    
        public function DetailIndex($kode)
    {   
            if (substr($kode, 0, 1) === 'F') {
                $data = Foto::where('kode', $kode)->get();
                $detail = [];
                foreach ($data as $foto) {
                    $fotoArray = json_decode($foto->foto_dokumentasi, true);
                    $fotoTerpilih = $fotoArray[0];
                    $detail[] =[
                        'id' => $foto->id,
                        'nama_foto' => $foto->nama_foto,
                        'tanggal_foto' => $foto->tanggal_foto,
                        'keterangan_foto' => $foto->keterangan_foto,
                        'foto_dokumentasi' => $fotoTerpilih['foto_dokumentasi'],
                    ];
                }
            } elseif (substr($kode, 0, 1) === 'V') {
                $data = Video::where('kode', $kode)->get();
                $detail = [];
            foreach ($data as $video) {
                $videoArray = json_decode($video->video_dokumentasi, true);
                $videoTerpilih = $videoArray[0];
                $detail[] = [
                    'id' => $video->id,
                    'nama_video' => $video->nama_video,
                    'tanggal_video' => $video->tanggal_video,
                    'keterangan_video' => $video->keterangan_video,
                    'video_dokumentasi' => isset($videoTerpilih['video_dokumentasi']) ? $videoTerpilih['video_dokumentasi'] : null,
                ];
                
            }
            }
        
            
            return view('admin.detail', compact('data', 'detail'));
    }
    
    public function history(){
        Paginator::useBootstrap(); 
        $history = DB::table('history_admins')
                ->join('admins', 'history_admins.admin_id', '=', 'admins.id')
                ->select('history_admins.waktu_login', 'admins.nama_admin', 'admins.jabatan',
                 'history_admins.foto_id', 'history_admins.video_id')
                ->paginate(10);
                
            $fotoId = $history->pluck('foto_id')->toArray();
            $videoId = $history->pluck('video_id')->toArray();

            $foto = [];
            $video = [];

            if (!empty($fotoId)) {
                $foto = DB::table('fotos')->whereIn('id', $fotoId)->get();
            }

            if (!empty($videoId)) {
                $video = DB::table('videos')->whereIn('id', $videoId)->get();
            }

        return view('admin.history', compact('history', 'foto', 'video'));
    }
        
    
}   