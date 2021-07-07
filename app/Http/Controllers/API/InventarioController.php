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
        if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fecha)){
            $fecha= date('Y-m-d');
        }


        if($id_rubro == 0){
            $inventario= DB::table('articulos')
            ->select("articulos.id", "articulos.nombre", "articulos.rubro_id", DB::raw("(SELECT
            (COALESCE(
                SUM(
                    (CASE 
                        WHEN comprobante_cabezas.tipoOperacion=2
                            THEN -1 ELSE 1 END) * comprobante_renglons.cantidad),0))
                                FROM comprobante_renglons 
                                INNER JOIN comprobante_cabezas ON comprobante_renglons.comprobante_cabeza_id = comprobante_cabezas.id
                                WHERE (comprobante_renglons.articulo_id = articulos.id) AND (comprobante_cabezas.fecha <= '$fecha')) AS stock "))
            ->orderBy('articulos.rubro_id', 'ASC')
            ->get();    
        } else {
            $existeRubro= count(Articulo::where('rubro_id', $id_rubro)->get());
            if(($id_rubro <= -1) || ($existeRubro == 0)){
                return response()->json(['Solicitud HTTP' => 'Rechazada', 'Mensaje' => 'No existe ese rubro o no se encontraron registros de tal'], 400);
            } else {
                $inventario= DB::table('articulos')
                    ->select("articulos.id", "articulos.nombre", "articulos.rubro_id", DB::raw("(SELECT
                    (COALESCE(
                        SUM(
                            (CASE 
                                WHEN comprobante_cabezas.tipoOperacion=2
                                    THEN -1 ELSE 1 END) * comprobante_renglons.cantidad),0))
                                        FROM comprobante_renglons 
                                        INNER JOIN comprobante_cabezas ON comprobante_renglons.comprobante_cabeza_id = comprobante_cabezas.id
                                        WHERE (comprobante_renglons.articulo_id = articulos.id) AND (comprobante_cabezas.fecha <= '$fecha')) AS stock "))
                    ->where('articulos.rubro_id', '=', $id_rubro)
                    ->orderBy('articulos.rubro_id', 'ASC') 
                    ->get();
            }
        }

        
        return response()->json($inventario, 200);
        $id_rubro=0;
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
