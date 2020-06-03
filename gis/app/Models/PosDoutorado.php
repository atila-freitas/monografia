<?php

namespace Gis\Models;

use Illuminate\Database\Eloquent\Model;

class PosDoutorado extends Model
{

    protected $fillable = [
        'lattes_id', 'sequencia_formacao', 'nivel', 'codigo_instituicao', 'nome_instituicao', 'ano_inicio',
        'ano_conclusao', 'ano_obtencao_titulo', 'flag_bolsa', 'codigo_agencia', 'nome_agencia', 'status_estagio',
        'status_curso', 'id_orientador', 'codigo_curso_capes', 'titulo_trabalho', 'titulo_trabalho_ingles',
        'nome_curso_ingles'
    ];

    public function lattes()
    {
        return $this->belongsTo(Lattes::class);
    }

    public function palavrasChave()
    {
        return $this->belongsToMany(PalavraChave::class, 'pos_doutorado_palavra_chave', 'pos_doutorado_id', 'palavra_chave_id');
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
