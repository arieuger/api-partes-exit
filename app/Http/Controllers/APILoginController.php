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

      return response()->json(compact('token'));

    }
}
