<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Af extends Model
{
    use HasFactory;
    protected $table = 'Af_data';
    protected $fillable = [
        'admin_id',
        'foto_id',
    ];
}