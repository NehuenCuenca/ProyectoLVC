<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprobanteRenglon extends Model
{
    use HasFactory;

    //Relacion uno a muchos inversa
    public function comprobanteCabeza()
    {
        return $this->belongsTo('App\Models\ComprobanteCabeza');
    }

    //Relacion uno a uno
    public function articulos()
    {
        return $this->hasOne('App\Models\Articulo');
    }
}
