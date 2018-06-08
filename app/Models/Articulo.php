<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $table = 'Articulos';
    protected $primaryKey = ['CodigoEmpresa',
                             'CodigoArticulo'];
}
