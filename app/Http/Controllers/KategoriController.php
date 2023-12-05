<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class KategoriController extends Controller
{
    public function Index(){
        $kategori = Kategori::all();
        return view('admin.kategori.index', compact('kategori'));
    }

    public function tambahKategori(){
        return view('admin.kategori.tambah');
    }
    

    public function storeKategori(Request $request){
        Kategori::insert([
            //Cara Memasukkan Data Sesuai User yang menginputkan
            'nama_kategori' => $request->nama_kategori,
            'keterangan_kategori' => $request->keterangan_kategori,
            'created_at' => Carbon::now() 
        ]);
        Session::flash('success', 'Data berhasil ditambahkan.');
        return Redirect()->route('index.kategori')->with('success', 'Data berhasil ditambahkan');
    }
     public function editKategori($id){
        $kategori = Kategori::find($id);
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function updateKategori(Request $request, $id){
        $kategori = Kategori::find($id);

        $kategori->nama_kategori = $request->input('nama_kategori');
        $kategori->keterangan_kategori = $request->input('keterangan_kategori');
        $kategori->save();

        return Redirect()->route('index.kategori')->with('success', 'Data berhasil ditambahkan');
    }

    public function deleteKategori($id){
        Kategori::find($id)->delete();
        
        return redirect()->route('index.kategori');
    
    }
    
}