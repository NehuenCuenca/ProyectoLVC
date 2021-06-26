<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ComprobanteCabeza;
use App\Models\ComprobanteRenglon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class ComprobanteCabezaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comprobanteCabeza = ComprobanteCabeza::all();
        return $comprobanteCabeza->toJson(JSON_PRETTY_PRINT);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* Objeto JSON a recibir: 
            {
                "codigoComprobante": 435965789867590,
                "tipoOperacion": "compra",
                "fecha": "1998-04-14 22:45:30",
                "datosPedidos": [
                    {
                        "id_art": 1,
                        "cantidad_art": 20
                    },
                    {
                        "id_art": 8,
                        "cantidad_art": 20
                    },
                    {
                        "id_art": 2,
                        "cantidad_art": 10
                    }
                ]
            }
        */ 

        //Valido datos con estas reglas
        $val = Validator::make($request->all(), [
            'codigoComprobante' => 'required|max:20',
            'tipoOperacion' => 'required',
            'fecha' => 'required',
            'datosPedidos' => 'required',
        ]); 

        if($val->fails()){
            return response()->json(['Respuesta' => 'Error', 'Mensaje' => 'Faltan datos por rellenar']);
        }else { 
            try {
                DB::beginTransaction();

                $comprobanteCabeza = ComprobanteCabeza::create([
                    "codigoComprobante" => $request->codigoComprobante,
                    "fecha" => $request->fecha,
                    "tipoOperacion" => $request->tipoOperacion, 
                ]); 

                $articulosPedidos= $request->datosPedidos;
                $cant_articulos= count($articulosPedidos);
                $id_comprobanteCabeza= DB::Table('comprobante_cabezas')->where('codigoComprobante', $request->codigoComprobante)->value('id');

                for($i=0; $i < $cant_articulos ; $i++) {
                    $comprobanteRenglon = ComprobanteRenglon::create([ 
                        "comprobanteCabeza_id" => $id_comprobanteCabeza,
                        "articulo_id" => $request->datosPedidos[$i]['id_art'],
                        "cantidad" => $request->datosPedidos[$i]['cantidad_art'],
                    ]);
                }  
                 
                $cont_articulos= 0;
                DB::commit();
            }
            // Ha ocurrido un error, devolvemos la BD a su estado previo
            catch (\Exception $e)
            {
                dd($e);
                DB::rollback();
                return response()->json(["Mensaje" => "Error!!"]);
            }
    
            //$comprobanteCabeza = ComprobanteCabeza::create($request->all());
            return response()->json($comprobanteCabeza, 201);
        } 

        //dd($request); 

        //$comprobanteCabeza = ComprobanteCabeza::create($request->all());
        //return response()->json($comprobanteCabeza, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comprobanteCabeza = ComprobanteCabeza::find($id);
        return $comprobanteCabeza->toJson(JSON_PRETTY_PRINT);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ComprobanteCabeza $comprobanteCabeza)
    {
        $comprobanteCabeza->update($request->all());
        return response()->json(['SolicitudHTTP' => 'Exitosa', 'Mensaje' => 'Comprobante CABEZA editado']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ComprobanteCabeza $comprobanteCabeza)
    {
        ComprobanteCabeza::destroy($comprobanteCabeza->id);
        return response()->json(['SolicitudHTTP' => 'Exitosa', 'Mensaje' => 'Comprobante CABEZA eliminado']);
    }
}
