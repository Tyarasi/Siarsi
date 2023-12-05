<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Image;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function Index(){
        $id = Auth::guard('admin')->user()->id;
        $admin = Admin::find($id);
        $allAdmin = Admin::all();
        return view('admin.views.index', compact('admin', 'allAdmin'));
    }

    public function tambahProfile(){
        $id = Auth::guard('admin')->user()->id;
        $admin = Admin::find($id);
        return view('admin.views.profile', compact('admin'));
    }

    public function updateFoto(Request $request, $id){
        $foto_admin = $request->file('foto_admin');
        $admin = Admin::find($id);
        
        if ($admin->foto_admin) {
            $file_path = public_path($admin->foto_admin);
        
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        
        $name_gen = hexdec(uniqid()) . '.' . $foto_admin->getClientOriginalExtension();
        Image::make($foto_admin)->save('dokumentasi/DataAdmin/' . $name_gen);
        
        $last_img = 'dokumentasi/DataAdmin/' . $name_gen;
        
        $admin->foto_admin = $last_img;
        $admin->updated_at = Carbon::now();
        $admin->save(); 
        
        return redirect()->route('index.admin');
        
        
    }

    public function UpdatePassword(Request $request){
        $validateData = $request->validate([
            'oldpassword' => 'required',
            'password' => 'required|confirmed'
        ]);
 
        $hashedPassword = Auth::guard('admin')->user()->password;
        $id = Auth::guard('admin')->user()->id;
        if(Hash::check($request->oldpassword,$hashedPassword)){
            $admin = Admin::find($id);
            $admin->password = Hash::make($request->password);
            $admin->save();
            Auth::guard('admin')->logout();
            return redirect()->route('loginadmin')->with('succes', 'Passwor Is Change');
        }else{
            return redirect()->back()->with('error', 'Current Password Invalid');
        }
    }

    public function Logout(){
        Auth::logout();
        return Redirect()->route('login')->with('success', 'User Logout');
    }

    public function makeSuperAdmin(){
        DB::table('admins')->where('id', 1)->update(['role' => 'superadmin']);
    }

    public function newAdmin(Request $request){
        $validator = Validator::make($request->all(),[
           'nama_admin' => 'required|alpha_spaces',
           'username' => 'required|unique:admins',
           'jabatan' => 'required|alpha',
           'password' => 'required|min:6',
        ], [
            'nama_admin.required' => 'Bagian ini harus diisi',
            'nama_admin.alpha_spaces' => 'Bagian ini hanya boleh berisi huruf contoh : Fulan Bin Fulan',
            'username.required' => 'Bagian ini harus diisi',
            'jabatan.required' => 'Bagian ini harus diisi',
            'jabatan.alpha' => 'Bagian ini hanya boleh berisi huruf',
            'password.required' => 'Bagian ini harus diisi',
            'password.min' => 'Minimal panjang password adalah 6 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $admin = new Admin();
        $admin->nama_admin = $request->nama_admin;
        $admin->username = $request->username;
        $admin->jabatan = $request->jabatan;
        $admin->password = bcrypt($request->password);

        $admin->save();

        // Redirect ke halaman yang sesuai
        return redirect()->route('index.admin')->with('success', 'Admin berhasil ditambahkan'); 
        }

    
}