<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParteLineas;

class ParteLineasController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
    public function index($codigoEmpresa, $ejercicioParte, $serieParte, $numeroParte) {
      $lineas = ParteLineas::select('CodigoEmpresa','EjercicioParte','SerieParte','NumeroParte',
                                    'Orden','CodigoArticulo','DescripcionArticulo', 'DescripcionLinea','FechaParte',
                                    'FechaRegistro','MIL_FechaEntrega','CodigoEmpleado','NombreCompleto','Precio',
                                    'Importe','Gastos', 'Unidades', 'Facturable')
                           ->where('CodigoEmpresa', $codigoEmpresa)
                           ->where('SerieParte', $serieParte)
                           ->where('EjercicioParte', $ejercicioParte)
                           ->where('NumeroParte', $numeroParte)
                           ->get();

      return response()->json($lineas);
    }
}
