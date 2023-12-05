<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryAdmin extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'admin_id',
        'waktu_login',
        'foto_id',
        'video_id',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}