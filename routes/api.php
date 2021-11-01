<?php

use Illuminate\Http\Request;
use App\Http\Controllers\API\ArticuloController;
use App\Http\Controllers\API\RubroController;
use App\Http\Controllers\API\ComprobanteCabezaController;
use App\Http\Controllers\API\ComprobanteRenglonController;
use App\Http\Controllers\API\InventarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//MIDDLEWARES 
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//API RUTAS
Route::apiResource('articulos', ArticuloController::class);
Route::get('articulos/filtro/rubro/{rubro_id}', [ArticuloController::class, 'filtroRubro']);

Route::apiResource('rubros', RubroController::class);

Route::apiResource('comprobantes-cabeza', ComprobanteCabezaController::class);

Route::apiResource('comprobantes-renglones', ComprobanteRenglonController::class);

//Ruta del inventario
Route::get('/inventario/{id_rubro}/{fecha}', [InventarioController::class,'index']);
