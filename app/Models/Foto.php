<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Foto extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_foto',
        'kategori_id',
        'nama_admin',
        'admin_id',
        'kode_foto',
        'foto_dokumentasi',
        'keterangan_foto',
        'tanggal_foto',
    ];

    protected $guard = [];
    
    public static function boot(){
        parent::boot();
        
        static::creating(function ($model){
           $model->kode = 'F-'.str_pad(static::max('id') + 1, 2, '0', STR_PAD_LEFT); 
        });
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function getTypeLabelAttribute()
    {
        return 'Foto';
    }

}