<?php

namespace Gis\Models;

use Illuminate\Database\Eloquent\Model;

class Doutorado extends Model
{

    protected $fillable = [
        'lattes_id', 'sequencia_formacao', 'nivel', 'codigo_instituicao', 'nome_instituicao', 'codigo_orgao',
        'nome_orgao', 'codigo_curso', 'nome_curso', 'nome_curso_ingles', 'codigo_area_curso', 'status_curso',
        'ano_inicio', 'ano_conclusao', 'flag_bolsa', 'codigo_agencia', 'nome_agencia', 'ano_obtencao_titulo',
        'titulo_dissertacao_tese', 'titulo_dissertacao_tese_ingles', 'nome_completo_orientador', 'tipo_doutorado',
        'codigo_instituicao_dout', 'nome_instituicao_dout', 'codigo_instituicao_outra_dout',
        'nome_instituicao_outra_dout', 'nome_orientador_dout', 'id_orientador', 'codigo_curso_capes',
        'nome_orientador_co_tutela', 'codigo_instituicao_co_tutela', 'codigo_instituicao_outra_co_tutela',
        'nome_orientador_sanduiche', 'codigo_instituicao_sanduiche', 'codigo_instituicao_outra_sanduiche',
        'nome_co_orientador'
    ];

    public function lattes()
    {
        return $this->belongsTo(Lattes::class);
    }

    public function palavrasChave()
    {
        return $this->belongsToMany(PalavraChave::class, 'doutorado_palavra_chave', 'doutorado_id', 'palavra_chave_id');
    }

    public function instituicao()
    {
        return $this->hasOne(Instituicao::class, 'id', 'codigo_instituicao');
    }

    public function coordenadas()
    {
        return $this->hasOne(Coordenadas::class, 'nome', 'nome_instituicao');
    }

}
