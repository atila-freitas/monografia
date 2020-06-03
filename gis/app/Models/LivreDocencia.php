<?php

namespace Gis\Models;

use Illuminate\Database\Eloquent\Model;

class LivreDocencia extends Model
{

    protected $fillable = [
        'lattes_id', 'sequencia_formacao', 'nivel', 'codigo_instituicao', 'nome_instituicao',
        'ano_obtencao_titulo', 'titulo_trabalho', 'titulo_trabalho_ingles'
    ];

    public function lattes()
    {
        return $this->belongsTo(Lattes::class);
    }

    public function palavrasChave()
    {
        return $this->belongsToMany(PalavraChave::class, 'livre_docencia_palavra_chave', 'livre_docencia_id', 'palavra_chave_id');
    }

    public function coordenadas()
    {
        return $this->hasOne(Coordenadas::class, 'nome', 'nome_instituicao');
    }

}
