<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use JWTFactory;
use JWTAuth;
use App\User;
use Illuminate\Support\Facades\Auth;

class APILoginController extends Controller
{
    public function login(Request $request) {

      $validator = Validator::make($request->all(), [
        'email' => 'required|string|email|max:255',
        'password'=>'required'
      ]);

      if ($validator->fails()) {
        return response()->json($validator->errors());
      }

      $credentials = $request->only('email','password');

      try {
        if ( !$token = JWTAuth::attempt($credentials)) {
          return response()->json(['error'=>'Credenciales incorrectas'],401);
        }
      } catch (JWTException $e) {
        return response()->json(['error'=>'No se pudo crear el token'],500);
      }

      $codigoUsuario = \DB::table('MCUsuarios')
                          ->select('CodigoUsuario')
                          ->where('Correo',$credentials['email'])
                          ->pluck('CodigoUsuario')[0];

      $codigoPlantilla = \DB::table('MCUsuarios')
                            ->select('CodigoPlantilla')
                            ->where('CodigoUsuario', $codigoUsuario)
                            ->pluck('CodigoPlantilla')[0];

      $nombreCorto = \DB::table('MCUsuarios')
                        ->select('NombreCorto')
                        ->where('CodigoUsuario', $codigoUsuario)
                        ->pluck('NombreCorto')[0];

      $empresas =\DB::table('Empresas')
                    ->join('Empleados','Empresas.CodigoEmpresa','=','Empleados.CodigoEmpresa')
                    ->select('Empresas.CodigoEmpresa','Empresas.Empresa', 'Empleados.NombreCompleto')
                    ->where('Empleados.CodigoEmpleado','=',$codigoPlantilla)
                    ->get();


      return response()->json([
        compact('token',
                'codigoPlantilla',
                'codigoUsuario',
                'nombreCorto',
                'empresas')
      ]);

    }
}
