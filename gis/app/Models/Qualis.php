<?php

namespace Gis\Models;

use Illuminate\Database\Eloquent\Model;

class Qualis extends Model
{

    protected $fillable = [
        'issn', 'titulo', 'area', 'estrato'
    ];

}
