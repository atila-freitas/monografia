<?php

namespace Gis\Models;

use Illuminate\Database\Eloquent\Model;

class CursoFaculdade extends Model
{

    protected $table = 'cursos_faculdade';

    protected $fillable = [
        'centro_faculdade_id', 'nome'
    ];

    public function centrosFaculdade()
    {
        return $this->belongsTo(CentroFaculdade::class, 'centro_faculdade_id');
    }

    public function lattes()
    {
        return $this->hasMany(Lattes::class, 'curso_faculdade_id');
    }

}
