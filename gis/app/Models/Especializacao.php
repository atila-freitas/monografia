<?php

namespace Gis\Models;

use Illuminate\Database\Eloquent\Model;

class Especializacao extends Model
{

    protected $table = 'especializacoes';

    protected $fillable = [
        'lattes_id', 'sequencia_formacao', 'nivel', 'titulo_monografia', 'titulo_monografia_ingles',
        'nome_orientador', 'codigo_instituicao', 'nome_instituicao', 'codigo_orgao', 'nome_orgao',
        'codigo_curso', 'nome_curso', 'nome_curso_ingles', 'status_curso', 'ano_inicio', 'ano_conclusao',
        'flag_bolsa', 'codigo_agencia', 'nome_agencia', 'carga_horaria'
    ];

    public function lattes()
    {
        return $this->belongsTo(Lattes::class);
    }

    public function coordenadas()
    {
        return $this->hasOne(Coordenadas::class, 'nome', 'nome_instituicao');
    }

}
