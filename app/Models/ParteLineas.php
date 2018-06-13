<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use CoenJacobs\EloquentCompositePrimaryKeys\HasCompositePrimaryKey;

class ParteLineas extends Model
{
    use HasCompositePrimaryKey;

    protected $table = 'ParteLineas';
    protected $primaryKey = array('CodigoEmpresa',
                                  'EjercicioParte',
                                  'SerieParte',
                                  'NumeroParte',
                                  'Orden',
                                  'LineasPosicion');
}
