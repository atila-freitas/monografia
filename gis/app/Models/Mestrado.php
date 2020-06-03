<?php

namespace Gis\Models;

use Illuminate\Database\Eloquent\Model;

class Mestrado extends Model
{

    protected $fillable = [
        'lattes_id', 'sequencia_formacao', 'nivel', 'codigo_instituicao', 'nome_instituicao', 'codigo_orgao',
        'nome_orgao', 'codigo_curso', 'nome_curso', 'nome_curso_ingles', 'codigo_area_curso', 'status_curso',
        'ano_inicio', 'ano_conclusao', 'flag_bolsa', 'codigo_agencia', 'nome_agencia', 'ano_obtencao_titulo',
        'titulo_dissertacao_tese', 'titulo_dissertacao_tese_ingles', 'nome_completo_orientador',
        'tipo_mestrado', 'id_orientador', 'codigo_curso_capes', 'nome_co_orientador', 'codigo_instituicao_dout',
        'nome_instituicao_dout', 'codigo_instituicao_outra_dout', 'nome_instituicao_outra_dout', 'nome_orientador_dout'
    ];

    public function lattes()
    {
        return $this->belongsTo(Lattes::class);
    }

    public function palavrasChave()
    {
        return $this->belongsToMany(PalavraChave::class, 'mestrado_palavra_chave', 'mestrado_id', 'palavra_chave_id');
    }

    public function coordenadas()
    {
        return $this->hasOne(Coordenadas::class, 'nome', 'nome_instituicao');
    }

}
