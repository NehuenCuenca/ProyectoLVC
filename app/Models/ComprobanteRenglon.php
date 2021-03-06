<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ComprobanteCabeza;

class ComprobanteRenglon extends Model
{
    use HasFactory;

    protected $fillable = [
        'comprobante_cabeza_id',
        'articulo_id',
        'cantidad',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    //Relacion uno a muchos inversa
    public function comprobanteCabeza()
    {
        return $this->belongsTo('App\Models\ComprobanteCabeza');
    }

    //Relacion uno a uno inversa
    public function articulo()
    {
        return $this->belongsTo('App\Models\Articulo');
    }
}
