<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ComprobanteCabeza;
use Illuminate\Http\Request;

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
        $comprobanteCabeza = ComprobanteCabeza::create($request->all());
        return response()->json($comprobanteCabeza, 201);
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
