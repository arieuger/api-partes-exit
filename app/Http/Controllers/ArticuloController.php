<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Articulo;

class ArticuloController extends Controller
{
    public function index($codigoEmpresa) {
        $articulos = Articulo::where('CodigoEmpresa',$codigoEmpresa)
                                ->get();
        return response()->json($articulos);
    }

    public function show($codigoEmpresa, $codigoArticulo) {
      $articulos = Articulo::where('CodigoEmpresa',$codigoEmpresa)
                           ->where('CodigoArticulo',$codigoArticulo)
                           ->get();

      return response()->json($articulos);
    }
}
