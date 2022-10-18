<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Selection extends Model
{
    use HasFactory;

    protected $fillable = [
        'dataora',
        'id_progr_lav',
        'id_lav'
    ];
}
