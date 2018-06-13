<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller {

    public function index($codigoEmpresa) {
     $clientes = Cliente::select('CodigoEmpresa', 'CodigoCliente', 'SiglaNacion', 'CifDni', 'CifEuropeo',
                                  'RazonSocial', 'Nombre', 'Domicilio', 'CodigoCondiciones')
                        ->where('CodigoEmpresa', $codigoEmpresa)
                        ->where('Potencial',0)
                        ->get();

      return response()->json($clientes);
    }

    public function show($codigoEmpresa, $codigoCliente) {
      $clientes = Cliente::where('CodigoEmpresa', $codigoEmpresa)
                         ->where('CodigoCliente', $codigoCliente)
                         ->get();


      return response()->json($clientes);
    }
}
