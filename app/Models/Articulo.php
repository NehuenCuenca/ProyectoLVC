<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Models\Rubro;


class Articulo extends Model
{
    use HasFactory;

    //Relacion uno a muchos inversa
    public function rubro()
    {
        return $this->belongsTo('App\Models\Rubro');
    }
}
