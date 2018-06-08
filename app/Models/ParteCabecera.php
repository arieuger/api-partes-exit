<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// Para o uso de PK múltiple
use CoenJacobs\EloquentCompositePrimaryKeys\HasCompositePrimaryKey;

class ParteCabecera extends Model {

  use HasCompositePrimaryKey;

  protected $table = 'ParteCabecera';
  protected $primaryKey = array('CodigoEmpresa', 'EjercicioParte', 'SerieParte', 'NumeroParte');


}
