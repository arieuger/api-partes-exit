<?php
use Illuminate\Http\Request;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('jwt.auth')->get('user', function (Request $request) {
    $user = auth()->user();
    return response()->json($user->all());
});

// TODO: Controlador ParteCabecera
// Route::resource('ParteCabecera','ParteCabeceraController');

Route::middleware('jwt.auth')->resource('ParteCabecera','ParteCabeceraController');


// Rexistro, login e autenticación de usuarios
Route::post('user/register','APIRegisterController@register');
Route::post('user/login','APILoginController@login');

// Route::get('partes/todos', function() {
//   $partes = ParteCabecera::all();
//   return $partes->toJson();
// });
