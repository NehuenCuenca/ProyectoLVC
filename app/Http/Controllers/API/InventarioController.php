<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        //settype($id_rubro, "integer");
       
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
            /* ->where($id_rubro, '=', 0) 
            ->orWhere([
                [$id_rubro, '!=', 0],
                [$id_rubro, '=', 'articulos.rubro_id'],
            ])  */ 
            ->get();
            
        dd($inventario);


        /* $inventario= "
        SELECT articulos.id, articulos.nombre, articulos.rubro_id,
			(SELECT
                COALESCE( 
                SUM(
                    (CASE 
                        WHEN comprobante_cabezas.tipoOperacion=2
                            THEN -1 ELSE 1 END) * comprobante_renglons.cantidad),0)
									FROM comprobante_renglons 
									INNER JOIN comprobante_cabezas ON comprobante_renglons.comprobante_cabeza_id = comprobante_cabezas.id
									WHERE (comprobante_renglons.articulo_id = articulos.id) AND (comprobante_cabezas.fecha <= 1980-06-29)) AS stock 
        FROM articulos
        WHERE $id_rubro = 0 OR ($id_rubro <> 0 AND $id_rubro = articulos.rubro_id)
        ORDER BY (articulos.rubro_id) 
        ;";  

        $inv= DB::select($inventario);
        dd($inv); */
                    
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
