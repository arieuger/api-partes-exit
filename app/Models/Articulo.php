<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// Para o uso de PK múltiple
use CoenJacobs\EloquentCompositePrimaryKeys\HasCompositePrimaryKey;

class Articulo extends Model {

  use HasCompositePrimaryKey;

  protected $table = 'Articulos';
  protected $primaryKey = ['CodigoEmpresa',
                           'CodigoArticulo'];
}
