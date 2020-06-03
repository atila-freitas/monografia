<?php

namespace Gis\Models;

use Illuminate\Database\Eloquent\Model;

class CentroFaculdade extends Model
{

    protected $table = 'centros_faculdades';

    protected $fillable = [
        'sigla', 'nome', 'tipo'
    ];

    public function cursosFaculdade()
    {
        return $this->hasMany(CursoFaculdade::class, 'centro_faculdade_id');
    }

}
