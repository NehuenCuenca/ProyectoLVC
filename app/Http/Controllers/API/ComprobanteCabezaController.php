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
            //'datosPedidos' => 'required',
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
               
                for($i=0; $i < $cant_articulos ; $i++) {
                    $comprobanteRenglon = ComprobanteRenglon::create([ 
                        "comprobante_cabeza_id" => $comprobanteCabeza->id,
                        "articulo_id" => $request->datosPedidos[$i]['id_art'],
                        "cantidad" => $request->datosPedidos[$i]['cantidad_art'],
                    ]);  
                    //abort(404);                  
                }  

                $cont_articulos= 0;
                DB::commit(); 
            }
            // Ha ocurrido un error, devolvemos la BD a su estado previo
            catch (\Exception $e)
            {
                //dd($e);
                DB::rollback();
                return response()->json(["Mensaje" => "Error!!"]);
            }
    
            //$comprobanteCabeza = ComprobanteCabeza::create($request->all());
            return response()->json($comprobanteCabeza, 201);
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
        //Comprobante CABEZA con sus RENGLONES
        $cabezas= DB::table('comprobante_cabezas')
            ->join('comprobante_renglons', 'comprobante_renglons.comprobante_cabeza_id', '=', 'comprobante_cabezas.id')
            ->join('articulos', 'articulos.id', '=', 'comprobante_renglons.articulo_id')
            ->select('comprobante_cabezas.*', 'articulos.nombre as nombre_articulo', 'comprobante_renglons.cantidad')
            ->where('comprobante_cabezas.id', $id)
            ->get();
        return response()->json($cabezas, 200);


        /* $consulta= "SELECT comprobante_cabezas.id, comprobante_cabezas.codigoComprobante, comprobante_cabezas.fecha, comprobante_cabezas.tipoOperacion, 
        articulos.nombre AS nombre_articulo, comprobante_renglons.cantidad 
        FROM comprobante_cabezas INNER JOIN comprobante_renglons 
                ON	comprobante_cabezas.id = comprobante_renglons.comprobante_cabeza_id 
                    INNER JOIN articulos 
                                ON articulos.id = comprobante_renglons.articulo_id
        WHERE comprobante_cabezas.id = $id
        ORDER BY(comprobante_renglons.articulo_id)
        ;";
        $comprobanteCabeza= DB::select($consulta);
        return response()->json($comprobanteCabeza, 200); */
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
    public function destroy($id, ComprobanteCabeza $comprobanteCabeza)
    {
        try {
            DB::beginTransaction();
            $articulos= ComprobanteCabeza::find($id)->comprobanteRenglons;
            
            $cant_articulos= count($articulos);
            //dd($cant_articulos);

            for($i=0; $i < $cant_articulos ; $i++) { 
                ComprobanteRenglon::where('comprobante_cabeza_id', $id)
                                    ->delete();                   
            }  
     
            ComprobanteCabeza::where('id', $id)->delete();
        
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
        return response()
                    ->json(['SolicitudHTTP' => 'Exitosa',
                     'Mensaje' => 'Comprobante CABEZA y sus RENGLONES eliminados']);

        /* ComprobanteCabeza::destroy($comprobanteCabeza->id);
         */
    }
}
