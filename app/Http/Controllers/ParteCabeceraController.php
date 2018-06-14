<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParteCabecera;

class ParteCabeceraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($codigoEmpresa, $fumLocal) {

        // Selecciona os partes que se modificasen máis tarde que os que hai en local
        $partes = \DB::table('ParteCabecera')
                    ->select(\DB::raw('CodigoEmpresa, EjercicioParte, SerieParte, NumeroParte, StatusParte,
                                  TipoParte, DescripcionTipoParte, CodigoArticulo, DescripcionArticulo,
                                  FechaParte, isnull(FechaEjecucion,\'\') AS FechaEjecucion, CodigoEmpleado, NombreCompleto, CodigoProyecto,
                                  NombreProyecto, ComentarioCierre, ComentarioRecepcion, CodigoCliente, Nombre,
                                  Importe, ImporteGastos, ImporteFacturable, CodigoUsuario, FechaUltimaModificacion,
                                  isnull(FechaCierre,\'\') AS FechaCierre, HoraCierre, TotalUnidades, NombreUsuarioCierre,
                                  CodigoUsuarioCierre'))
                    ->where('CodigoEmpresa',$codigoEmpresa)
                    ->whereRaw( '? < FechaUltimaModificacion', [$fumLocal])
                    ->get();

        return response()->json($partes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($codigoEmpresa, $ejercicioParte, $serieParte, $numeroParte) {
      $partes = ParteCabecera::where('CodigoEmpresa', $codigoEmpresa)
                              ->where('EjercicioParte', $ejercicioParte)
                              ->where('SerieParte', $serieParte)
                              ->where('NumeroParte', $numeroParte)
                              ->get();
      return response()->json($partes);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    // Obten fecha última modificación
    public function lastFUM($codigoEmpresa) {
      $fecha = ParteCabecera::selectRaw('max(FechaUltimaModificacion) as string')
                            ->where('CodigoEmpresa', $codigoEmpresa)
                            ->get();
      return $fecha[0];
    }
}
