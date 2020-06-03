<?php

namespace Gis\Models;

use Illuminate\Database\Eloquent\Model;

class ResidenciaMedica extends Model
{

    protected $table = 'residencias_medicas';

    protected $fillable = [
        'lattes_id', 'sequencia_formacao', 'nivel', 'codigo_instituicao', 'nome_instituicao', 'status_curso',
        'ano_inicio', 'ano_conclusao', 'flag_bolsa', 'codigo_agencia', 'nome_agencia', 'titulo_residencia_medica',
        'titulo_residencia_medica_ingles', 'numero_registro'
    ];

    public function lattes()
    {
        return $this->belongsTo(Lattes::class);
    }

    public function palavrasChave()
    {
        return $this->belongsToMany(PalavraChave::class, 'residencia_medica_palavra_chave', 'residencia_medica_id', 'palavra_chave_id');
    }

    public function coordenadas()
    {
        return $this->hasOne(Coordenadas::class, 'nome', 'nome_instituicao');
    }

}
