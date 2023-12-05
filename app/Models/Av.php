<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Av extends Model
{
    use HasFactory;
    protected $table = 'Av_data';
    protected $fillable = [
        'admin_id',
        'video_id',
    ];
}