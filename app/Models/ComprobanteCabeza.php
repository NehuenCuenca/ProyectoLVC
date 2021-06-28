<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprobanteCabeza extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigoComprobante',
        'tipoOperacion',
        'fecha',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    //Relacion uno a muchos
    public function comprobanteRenglons()
    {
        return $this->hasMany('App\Models\ComprobanteRenglon');
    }
}
