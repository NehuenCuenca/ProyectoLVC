<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ComprobanteRenglon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ComprobanteRenglonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comprobanteRenglones = ComprobanteRenglon::all();
        /* $comprobanteRenglones = ComprobanteRenglon::orderBy('comprobante_cabeza_id','ASC')->get(); */
        return $comprobanteRenglones->toJson(JSON_PRETTY_PRINT);  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comprobanteRenglones = ComprobanteRenglon::create($request->all());
        return response()->json($comprobanteRenglones, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comprobanteRenglones = ComprobanteRenglon::where('id', $id)
                                                        ->get();
        return $comprobanteRenglones->toJson(JSON_PRETTY_PRINT);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ComprobanteRenglon $comprobanteRenglones)
    {
        $comprobanteRenglones->update($request->all());
        return response()->json(['SolicitudHTTP' => 'Exitosa', 'Mensaje' => 'Comprobante RENGLONES editado']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ComprobanteRenglon $comprobanteRenglones)
    {
        ComprobanteRenglon::destroy($comprobanteRenglones->id);
        return response()->json(['SolicitudHTTP' => 'Exitosa', 'Mensaje' => 'Comprobante RENGLONES eliminado']);
    }
}
