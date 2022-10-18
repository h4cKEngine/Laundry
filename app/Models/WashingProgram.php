<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WashingProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'prezzo',
        'durata'
    ];

    public function lavasciugaProg(): BelongsToMany{
        return $this->belongsToMany(Washer::class, 'selection',  'id_progr_lav', 'id_lav');
    }
}
