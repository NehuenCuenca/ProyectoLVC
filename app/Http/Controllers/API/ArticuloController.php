<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Articulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class ArticuloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articulos= DB::table('articulos')
            ->join('rubros', 'articulos.rubro_id', '=', 'rubros.id')
            ->select('articulos.*', 'rubros.titulo as nombre_rubro')
            ->get();
        return response()->json($articulos, 200); 

        /* $articulo = Articulo::all()->join();
        return $articulo->toJson(JSON_PRETTY_PRINT); */ 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $val = Validator::make($request->all(), [
            'nombre' => 'required|max:255',
            'precio' => 'required',
            'fechaVencimiento' => 'required',
            'stockMinimo' => 'required',
            'stockMaximo' => 'required',
            'rubro_id' => 'required'
        ]); 
        if($val->fails()){
            return response()->json(['Respuesta' => 'Error', 'Mensaje' => 'Faltan datos por rellenar']);
        } else {
            $articulo = Articulo::create($request->all());
            return response()->json($articulo, 201);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $articulosSQL= "SELECT articulos.id, articulos.nombre, 
                                articulos.precio, 
                                articulos.fechaVencimiento, 
                                articulos.stockMinimo, 
                                articulos.stockMaximo, 
                                articulos.rubro_id, 
                                rubros.titulo AS nombre_rubro 
            FROM articulos
                INNER JOIN rubros 
                        ON articulos.rubro_id = rubros.id
            WHERE articulos.id = $id;";
        $articulos= DB::select($articulosSQL);
        return response()->json($articulos[0], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Articulo $articulo)
    {
        $articulo->update($request->all());
        return response()->json(['SolicitudHTTP' => 'Exitosa', 'Mensaje' => 'Articulo editado']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Articulo $articulo)
    {
        Articulo::destroy($articulo->id);
        return response()->json(['SolicitudHTTP' => 'Exitosa', 'Mensaje' => 'Articulo eliminado']);
    }
}
