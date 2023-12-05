<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_video',
        'kategori_id',
        'kode_video',
        'admin_id',
        'nama_admin',
        'keterangan_video',
        'video_dokumentasi',
        'tanggal_video',
    ];

    protected $guard = [];

    public static function boot(){
        parent::boot();

        static::creating(function ($model){
           $model->kode = 'V-'.str_pad(static::max('id') + 1, 2, '0', STR_PAD_LEFT); 
        });
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}