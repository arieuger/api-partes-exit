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
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($codigoEmpresa, $ejercicioParte, $serieParte, $numeroParte) {
      $parte = \DB::table('ParteCabecera')
                  ->select(\DB::raw('CodigoEmpresa, EjercicioParte, SerieParte, NumeroParte, StatusParte,
                                TipoParte, DescripcionTipoParte, CodigoArticulo, DescripcionArticulo,
                                FechaParte, isnull(FechaEjecucion,\'\') AS FechaEjecucion, CodigoEmpleado, NombreCompleto, CodigoProyecto,
                                NombreProyecto, ComentarioCierre, ComentarioRecepcion, CodigoCliente, Nombre,
                                Importe, ImporteGastos, ImporteFacturable, CodigoUsuario, FechaUltimaModificacion,
                                isnull(FechaCierre,\'\') AS FechaCierre, HoraCierre, TotalUnidades, NombreUsuarioCierre,
                                CodigoUsuarioCierre'))
                              ->where('CodigoEmpresa', $codigoEmpresa)
                              ->where('EjercicioParte', $ejercicioParte)
                              ->where('SerieParte', $serieParte)
                              ->where('NumeroParte', $numeroParte)
                              ->get();
      return response()->json($parte);
    }

    public function updateOrCreate(Request $request) {
      // $parte = ParteCabecera::where('CodigoEmpresa', $request->input('$codigoEmpresa'))
      //                       ->where('EjercicioParte', $request->input('$ejercicioParte'))
      //                       ->where('SerieParte', $request->input('$serieParte'))
      //                       ->where('NumeroParte', $request->input('$numeroParte'))
      //                       ->get();

      // if (count($parte) === 0) {
      //   $this->insert($request);
      //   return '{"string": "insert"}';
      // } else {
      //   $this->update($request);
      //   return '{"string": "update"}';
      // }

      $CodigoEmpresa = $request->input('CodigoEmpresa');
      $EjercicioParte = $request->input('EjercicioParte');
      $SerieParte = $request->input('SerieParte');
      $NumeroParte = $request->input('NumeroParte');
      $StatusParte = $request->input('StatusParte');
      $CodigoArticulo = $request->input('CodigoArticulo');
      $DescripcionArticulo = $request->input('DescripcionArticulo');
      $FechaParte = $request->input('FechaParte');
      $CodigoEmpleado = $request->input('CodigoEmpleado');
      $NombreCompleto = $request->input('NombreCompleto');
      $CodigoProyecto = $request->input('CodigoProyecto');
      $NombreProyecto = $request->input('NombreProyecto');
      $ComentarioCierre = $request->input('ComentarioCierre');
      $ComentarioRecepcion = $request->input('ComentarioRecepcion');
      $CodigoCliente = $request->input('CodigoCliente');
      $Importe = $request->input('Importe');
      $ImporteGastos = $request->input('ImporteGastos');
      $ImporteFacturable = $request->input('ImporteFacturable');
      $FechaUltimaModificacion = $request->input('FechaUltimaModificacion');
      $FechaEjecucion = $request->input('FechaEjecucion');
      $EstadoEjecucion = $request->input('EstadoEjecucion');
      $CodigoUsuarioCierre = $request->input('CodigoUsuarioCierre');
      $FechaCierre = $request->input('FechaCierre');
      $HoraCierre = $request->input('HoraCierre');

      \DB::statement("
          DECLARE @msg varchar(100);
          DECLARE @FechaCierre as datetime;

          IF '$FechaCierre' = '1900-01-01T00:00:00.000000'
            SET @FechaCierre = NULL;
          ELSE
            SET @FechaCierre = '$FechaCierre';

          IF EXISTS (SELECT * FROM ParteCabecera WHERE CodigoEmpresa = $CodigoEmpresa
                       AND SerieParte = '$SerieParte'
                       AND EjercicioParte = $EjercicioParte
                       AND NumeroParte = $NumeroParte)

              EXEC [dbo].[Movil_UpdateParteCabecera] $CodigoEmpresa, $EjercicioParte, '$SerieParte', $NumeroParte, '$StatusParte',
              '$CodigoArticulo', '$DescripcionArticulo', '$FechaParte', '$CodigoEmpleado', '$NombreCompleto', $CodigoProyecto, '$NombreProyecto',
              '$ComentarioCierre','$ComentarioRecepcion','$CodigoCliente', $Importe, $ImporteGastos, $ImporteFacturable,'$FechaUltimaModificacion',
              '$FechaEjecucion','$EstadoEjecucion',$CodigoUsuarioCierre,@FechaCierre,$HoraCierre, @msg OUTPUT;
          ELSE
              EXEC [dbo].[Movil_InsertaParteCabecera] $CodigoEmpresa, $EjercicioParte, '$SerieParte', $NumeroParte, '$StatusParte',
              '$CodigoArticulo', '$DescripcionArticulo', '$FechaParte', '$CodigoEmpleado', '$NombreCompleto', $CodigoProyecto, '$NombreProyecto',
              '$ComentarioCierre','$ComentarioRecepcion','$CodigoCliente', $Importe, $ImporteGastos, $ImporteFacturable,'$FechaUltimaModificacion',
              '$FechaEjecucion','$EstadoEjecucion',$CodigoUsuarioCierre,@FechaCierre,$HoraCierre, @msg OUTPUT;");

          return '{"string": "ok"}';


    }

    // Obten fecha última modificación
    public function lastFUM($codigoEmpresa) {
      $fecha = ParteCabecera::selectRaw('max(FechaUltimaModificacion) as string')
                            ->where('CodigoEmpresa', $codigoEmpresa)
                            ->get();
      return $fecha[0];
    }


    // funcións privadas
    function update(Request $request) {
      $CodigoEmpresa = $request->input('CodigoEmpresa');
      $EjercicioParte = $request->input('EjercicioParte');
      $SerieParte = $request->input('SerieParte');
      $NumeroParte = $request->input('NumeroParte');
      $StatusParte = $request->input('StatusParte');
      $CodigoArticulo = $request->input('CodigoArticulo');
      $DescripcionArticulo = $request->input('DescripcionArticulo');
      $FechaParte = $request->input('FechaParte');
      $CodigoEmpleado = $request->input('CodigoEmpleado');
      $NombreCompleto = $request->input('NombreCompleto');
      $CodigoProyecto = $request->input('CodigoProyecto');
      $NombreProyecto = $request->input('NombreProyecto');
      $ComentarioCierre = $request->input('ComentarioCierre');
      $ComentarioRecepcion = $request->input('ComentarioRecepcion');
      $CodigoCliente = $request->input('CodigoCliente');
      $Importe = $request->input('Importe');
      $ImporteGastos = $request->input('ImporteGastos');
      $ImporteFacturable = $request->input('ImporteFacturable');
      $FechaUltimaModificacion = $request->input('FechaUltimaModificacion');
      $FechaEjecucion = $request->input('FechaEjecucion');
      $EstadoEjecucion = $request->input('EstadoEjecucion');
      $CodigoUsuarioCierre = $request->input('CodigoUsuarioCierre');
      $FechaCierre = $request->input('FechaCierre');
      $HoraCierre = $request->input('HoraCierre');

      \DB::statement("
          DECLARE @msg varchar(100);
          DECLARE @FechaCierre as datetime;

          IF '$FechaCierre' = '1900-01-01T00:00:00.000000'
            SET @FechaCierre = NULL;
          ELSE
            SET @FechaCierre = '$FechaCierre';

          EXEC [dbo].[Movil_UpdateParteCabecera] $CodigoEmpresa, $EjercicioParte, '$SerieParte', $NumeroParte, '$StatusParte',
          '$CodigoArticulo', '$DescripcionArticulo', '$FechaParte', '$CodigoEmpleado', '$NombreCompleto', $CodigoProyecto, '$NombreProyecto',
          '$ComentarioCierre','$ComentarioRecepcion','$CodigoCliente', $Importe, $ImporteGastos, $ImporteFacturable,'$FechaUltimaModificacion',
          '$FechaEjecucion','$EstadoEjecucion',$CodigoUsuarioCierre,@FechaCierre,$HoraCierre, @msg OUTPUT;");

    }

    function insert(Request $request) {
      $CodigoEmpresa = $request->input('CodigoEmpresa');
      $EjercicioParte = $request->input('EjercicioParte');
      $SerieParte = $request->input('SerieParte');
      $NumeroParte = $request->input('NumeroParte');
      $StatusParte = $request->input('StatusParte');
      $CodigoArticulo = $request->input('CodigoArticulo');
      $DescripcionArticulo = $request->input('DescripcionArticulo');
      $FechaParte = $request->input('FechaParte');
      $CodigoEmpleado = $request->input('CodigoEmpleado');
      $NombreCompleto = $request->input('NombreCompleto');
      $CodigoProyecto = $request->input('CodigoProyecto');
      $NombreProyecto = $request->input('NombreProyecto');
      $ComentarioCierre = $request->input('ComentarioCierre');
      $ComentarioRecepcion = $request->input('ComentarioRecepcion');
      $CodigoCliente = $request->input('CodigoCliente');
      $Importe = $request->input('Importe');
      $ImporteGastos = $request->input('ImporteGastos');
      $ImporteFacturable = $request->input('ImporteFacturable');
      $FechaUltimaModificacion = $request->input('FechaUltimaModificacion');
      $FechaEjecucion = $request->input('FechaEjecucion');
      $EstadoEjecucion = $request->input('EstadoEjecucion');
      $CodigoUsuarioCierre = $request->input('CodigoUsuarioCierre');
      $FechaCierre = $request->input('FechaCierre');
      $HoraCierre = $request->input('HoraCierre');

      $sql = "
          DECLARE @msg varchar(100);
          DECLARE @FechaCierre as datetime;

          IF '$FechaCierre' = '1900-01-01T00:00:00.000000'
            SET @FechaCierre = NULL;
          ELSE
            SET @FechaCierre = '$FechaCierre';

          EXEC [dbo].[Movil_InsertaParteCabecera] $CodigoEmpresa, $EjercicioParte, '$SerieParte', $NumeroParte, '$StatusParte',
          '$CodigoArticulo', '$DescripcionArticulo', '$FechaParte', '$CodigoEmpleado', '$NombreCompleto', $CodigoProyecto, '$NombreProyecto',
          '$ComentarioCierre','$ComentarioRecepcion','$CodigoCliente', $Importe, $ImporteGastos, $ImporteFacturable,'$FechaUltimaModificacion',
          '$FechaEjecucion','$EstadoEjecucion',$CodigoUsuarioCierre,@FechaCierre,$HoraCierre, @msg OUTPUT;";

      \DB::statement($sql);
      return $sql;
    }
}
