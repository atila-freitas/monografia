<?php

namespace Gis\Models;

use Illuminate\Database\Eloquent\Model;

class Graduacao extends Model
{

    protected $table = 'graduacoes';

    protected $fillable = [
        'lattes_id', 'sequencia_formacao', 'nivel', 'titulo_trabalho_conclusao', 'titulo_trabalho_conclusao_ingles',
        'nome_orientador', 'codigo_instituicao', 'nome_instituicao', 'codigo_orgao', 'nome_orgao', 'codigo_curso',
        'nome_curso', 'nome_curso_ingles', 'codigo_area_curso', 'status_curso', 'ano_inicio', 'ano_conclusao',
        'flag_bolsa', 'codigo_agencia', 'nome_agencia', 'id_orientador', 'codigo_curso_capes', 'titulacao',
        'tipo_graduacao', 'codigo_instituicao_grad', 'nome_instituicao_grad', 'codigo_instituicao_outra_grad',
        'nome_instituicao_outra_grad', 'nome_orientador_grad'
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
