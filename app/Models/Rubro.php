<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Models\Articulo;

class Rubro extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    //Relacion uno a Muchos
    public function articulos()
    {
        return $this->hasMany('App\Models\Articulo');
    }
}
