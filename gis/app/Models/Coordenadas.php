<?php

namespace Gis\Models;

use Illuminate\Database\Eloquent\Model;

class Coordenadas extends Model
{

    protected $table = 'coordenadas';

    public $timestamps = false;

    protected $fillable = [
        'nome', 'latitude', 'longitude'
    ];

}
