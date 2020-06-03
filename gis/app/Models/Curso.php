<?php

namespace Gis\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{

    public $incrementing = false;

    protected $fillable = [
        'id', 'codigo_orgao', 'nome_orgao', 'codigo_instituicao', 'nome_instituicao', 'grande_area_conhecimento',
        'area_conhecimento', 'sub_area_conhecimento', 'especialidade', 'nivel_curso'
    ];

    public function coordenadas()
    {
        return $this->hasOne(Coordenadas::class, 'nome', 'nome_instituicao');
    }

}
