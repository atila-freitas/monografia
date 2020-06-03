<?php

namespace Gis\Models;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{

    protected $table = 'paises';

    protected $fillable = [
        'nome', 'nome_ingles', 'sigla2', 'sigla3'
    ];

}
