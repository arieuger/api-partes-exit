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

Route::middleware('jwt.auth')->get('user', function (Request $request) {
    $user = auth()->user();
    return response()->json($user->all());
});

// Rexistro, login e autenticación de usuarios
Route::post('user/register','APIRegisterController@register');
Route::post('user/login','APILoginController@login');

Route::group(['middleware'=>'jwt.auth'], function() {
  Route::resource('ParteCabecera','ParteCabeceraController'); // TODO
});
