<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Washer extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'marca',
        'stato'
    ];

    public function prenotazioneLavasciuga(){
        return $this->hasMany(Reservation::class, 'id_lav', 'id');
    }

    public function programmaLavaggio(){
        return $this->belongsToMany(WashingProgram::class, 'selectings', 'id_lav', 'id_progr_lav');
    }
}
