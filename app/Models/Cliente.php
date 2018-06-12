<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use CoenJacobs\EloquentCompositePrimaryKeys\HasCompositePrimaryKey;

class Cliente extends Model {

  use HasCompositePrimaryKey;

  protected $table = 'Clientes';
  protected $primaryKey = array('CodigoEmpresa','CodigoCliente');

}
