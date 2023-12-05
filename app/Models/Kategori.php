<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_kategori',
        'keterangan_kategori',
        'views',
        'click_count',
    ];
    public function foto()
    {
        return $this->hasMany(Foto::class);
    }
    public function video()
    {
        return $this->hasMany(Video::class);
    }
    public function fotos()
    {
        return $this->hasMany(Foto::class, 'kategori_id');
    }
    public function incrementClickCount()
    {
        $this->click_count++;
        $this->save();
    }
}