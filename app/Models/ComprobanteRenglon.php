<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprobanteRenglon extends Model
{
    use HasFactory;

    public function comprobanteCabeza()
    {
        return $this->belongsTo('App\Models\ComprobanteCabeza');
    }

    public function articulos()
    {
        return $this->hasMany('App\Models\Articulo');
    }
}
