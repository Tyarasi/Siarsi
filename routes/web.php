<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DaftarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/  
// Route::get('/admin/dashboard/video/edit/{id}', [VideoController::class, 'editVideo']);
// Route::post('/admin/dashboard/video/edit/{id}', [VideoController::class, 'updateVideo']);
// Route::get('/admin/dashboard/video/add', [VideoController::class, 'tambahVideo'])->name('tambah.video');
// Route::post('/admin/dashboard/foto/edit/{id}', [FotoController::class, 'updateFoto']);
// Route::get('/admin/dashboard/foto/edit/{id}', [FotoController::class, 'editFoto']);
// Route::get('/admin/dashboard/foto/add', [FotoController::class, 'tambahFoto'])->name('tambah.foto');
// Route::post('/admin/dashboard/foto/adddata', [FotoController::class, 'store'])->name('StoreFoto');

Route::get('/', [DashboardController::class, 'Index'])->name('home');
Route::middleware(['admin.auth'])->group(function () {
Route::get('/admin/dashboard', [AuthController::class, 'Index'])->name('admin.index');
Route::get('admin/dashboard/detail/{kode}', [AuthController::class, 'DetailIndex']);


//Route Foto
Route::get('/admin/dashboard/foto/{kode}', [FotoController::class, 'Index']);
Route::get('/admin/dashboard/data/detail/{id}', [FotoController::class, 'Detail']);
Route::get('/admin/dashboard/foto/delete/{id}/{index}', [FotoController::class, 'deleteFoto'])->name('delete.foto');
Route::post('/foto/download/', [FotoController::class, 'download'])->name('foto.download');
Route::get('/foto/downloadall/{id}', [FotoController::class, 'downloadAllFoto'])->name('download.allfoto');


//Route Kategiri
Route::get('/admin/dashboard/kategori', [KategoriController::class, 'Index'])->name('index.kategori');
Route::get('/admin/dashboard/kategori/add', [KategoriController::class, 'tambahKategori'])->name('tambah.kategori');
Route::post('/admin/dashboard/kategori/adddata', [KategoriController::class, 'storeKategori'])->name('StoreKategori');
Route::get('/admin/dashboard/kategori/delete/{id}', [KategoriController::class, 'deleteKategori']);
Route::get('/admin/dashboard/kategori/edit/{id}', [KategoriController::class, 'editKategori'])->name('edit.kategori');
Route::post('/admin/dashboard/kategori/update/{id}', [KategoriController::class, 'updateKategori']);

//Route Video

Route::get('/admin/dashboard/video/{kode}', [VideoController::class, 'Index']);
Route::get('/admin/dashboard/video/delete/{id}/{index}', [VideoController::class, 'deleteVideo'])->name('delete.video');
Route::get('/admin/dashboard/video/detail/{kode}', [VideoController::class, 'Detail']);
Route::post('/video/download', [VideoController::class, 'download'])->name('video.download');
Route::get('/video/downloadall/{id}', [VideoController::class, 'downloadAllVideo'])->name('download.allvideo');


//Route Admin
Route::get('/admin/views/', [AdminController::class, 'Index'])->name('index.admin');
Route::get('/admin/profile/foto/upload', [AdminController::class, 'tambahProfile'])->name('update.profile');
Route::post('/admin/profile/foto/edit/{id}', [AdminController::class, 'updateFoto']);
Route::post('/admin/password/update', [AdminController::class, 'UpdatePassword'])->name('password.update');
Route::post('/admin/newAdmin/addAdmin', [AdminController::class, 'newAdmin'])->name('addAdmin');
Route::get('/admin/profile/foto/delete/{id}', [AdminController::class, 'deleteFoto']);

//Route DaftarData
Route::get('/admin/dashboard/daftar/', [DaftarController::class, 'Index'])->name('index.daftar');
Route::get('/admin/dashboard/daftar/add', [DaftarController::class, 'tambahData'])->name('tambah.data');
Route::post('/admin/dashboard/daftar/adddata', [DaftarController::class, 'store'])->name('StoreData');
// Route::get('/admin/dashboard/daftar/detail/{id}', [DaftarController::class, 'detailData'])->name('detailDaftar');
Route::get('/admin/dashboard/daftar/edit/{id}', [DaftarController::class, 'editData']);
Route::post('/admin/dashboard/daftar/edit', [DaftarController::class, 'update'])->name('update.data');
Route::get('/admin/dashboard/daftar/delete/{id}', [DaftarController::class, 'delete']);


//Route Rekap
Route::get('/admin/dashboard/rekapitulasi/', [RekapController::class, 'rekap'])->name('index.rekap');
Route::get('/admin/history/', [AuthController::class, 'history'])->name('history.admin');
});


Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('loginadmin');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('/video/download', [VideoController::class, 'download'])->name('video.download');
Route::post('/foto/download/', [FotoController::class, 'download'])->name('foto.download');


// Route User

Route::get('/dashboard/dokumentasi/{id}', [DashboardController::class, 'kategori'])->name('kategori.index'); 
Route::get('/dashboard/dokumentasi/detail/{id}', [DashboardController::class, 'detail'])->name('kategori.detail');

Route::get('/dashboard/dokumentasi/view/{id}/{kode}/{key}',  [DashboardController::class, 'view']);
Route::get('/dashboard/about', [DashboardController::class, 'about'])->name('about.index'); 