<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprobanteCabeza extends Model
{
    use HasFactory;

    //Relacion uno a muchos
    public function comprobanteRenglon()
    {
        return $this->hasMany('App\Models\ComprobanteRenglon');
    }
}
