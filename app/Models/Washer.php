<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Washer extends Model
{
    use HasFactory;

    protected $fillable = [
        'marca',
        'disponibile_bool'
    ];

    public function utente(): BelongsToMany{
        return $this->belongsToMany(User::class, 'booking','id_lav', 'id_utente');
    }

    public function programmaLav(): BelongsToMany{
        return $this->belongsToMany(WashingProgram::class, 'selection', 'id_lav', 'id_progr_lav');
    }
}
