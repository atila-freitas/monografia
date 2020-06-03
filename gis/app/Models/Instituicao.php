<?php

namespace Gis\Models;

use Illuminate\Database\Eloquent\Model;

class Instituicao extends Model
{

    protected $table = 'instituicoes';

    public $incrementing = false;

    protected $fillable = [
        'id', 'sigla', 'sigla_uf', 'sigla_pais', 'nome_pais', 'flag_instituicao_ensino'
    ];

    protected $appends = ['coordenadas_nome'];

    public function getCoordenadasNomeAttribute()
    {
        return (!empty($this->sigla_uf) ? $this->sigla_uf . ', ' : '') . $this->nome_pais;
    }

    public function coordenadas()
    {
        return $this->hasOne(Coordenadas::class, 'nome', 'coordenadas_nome');
    }

    public function doutorados()
    {
        return $this->hasMany(Doutorado::class, 'codigo_instituicao', 'id');
    }

    public function posDoutorados()
    {
        return $this->hasMany(PosDoutorado::class, 'codigo_instituicao', 'id');
    }

}
