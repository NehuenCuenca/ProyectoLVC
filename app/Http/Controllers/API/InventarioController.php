<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Articulo;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_rubro,$fecha)
    {   
        if($id_rubro!=0){
            $existeRubro= DB::table('rubros')
                                ->where('rubros.id', '=', $id_rubro)
                                ->get();
            
            if($existeRubro->isEmpty() || $id_rubro <= -1){
                return response()->json([
                    'SolicitudHTTP' => 'Error', 
                    'Mensaje' => 'El rubro especificado no existe. Intente con otro rubro.'
                ],400);
            }
        }

        $inventario= DB::table('articulos')
            ->select("articulos.id", "articulos.nombre", "rubros.titulo", DB::raw("(SELECT
            (COALESCE(
                SUM(
                    (CASE 
                        WHEN comprobante_cabezas.tipoOperacion=2
                            THEN -1 ELSE 1 END) * comprobante_renglons.cantidad),0))
                                FROM comprobante_renglons 
                                INNER JOIN comprobante_cabezas ON comprobante_renglons.comprobante_cabeza_id = comprobante_cabezas.id
                                WHERE (comprobante_renglons.articulo_id = articulos.id) AND (comprobante_cabezas.fecha <= '$fecha')) AS stock "))
            ->join('rubros', 'articulos.rubro_id', '=', 'rubros.id')
            ->orderBy('articulos.rubro_id', 'ASC')
            ->when($id_rubro, function ($query, $id_rubro) {
                return $query->where('rubros.id', $id_rubro);
            })
            ->get();
        
        return response()->json($inventario, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * 
     * 
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       // 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
