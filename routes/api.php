<?php
use Illuminate\Http\Request;
use App\Models\ParteLineas;
use App\Models\ParteCabecera;

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

Route::middleware('jwt.auth')->get('user', function (Request $request) {
    $user = auth()->user();
    return response()->json($user->all());
});

// Rexistro, login e autenticación de usuarios
Route::post('user/register','APIRegisterController@register');
Route::post('user/login','APILoginController@login');

// TODO: Inserción, update
// ParteCabecera
Route::group(['prefix'=>'ParteCabecera','middleware'=>'jwt.auth'], function() {
  Route::get('{codigoEmpresa}/{fumLocal}','ParteCabeceraController@index')
    ->where(['codigoEmpresa' => '[\d]+']);

  Route::get('{codigoEmpresa}/{ejercicioParte}/{serieParte}/{numeroParte}','ParteCabeceraController@show');
  Route::Get('FechaUltimaModificacion/{codigoEmpresa}','ParteCabeceraController@lastFUM');
});

// Articulo
Route::group(['prefix'=>'Articulo','middleware'=>'jwt.auth'], function() {
  Route::get('{codigoEmpresa}','ArticuloController@index');
  Route::get('{codigoEmpresa}/{codigoArticulo}','ArticuloController@show');
});

// Cliente
Route::group(['prefix'=>'Cliente','middleware'=>'jwt.auth'], function() {
  Route::get('{codigoEmpresa}','ClienteController@index');
  Route::get('{codigoEmpresa}/{codigoCliente}','ClienteController@show');
});

// ParteLineas
Route::Group(['prefix'=>'ParteLineas','middleware'=>'jwt.auth'], function() {
  Route::get('{codigoEmpresa}/{ejercicioParte}/{serieParte}/{numeroParte}','ParteLineasController@index');
});
