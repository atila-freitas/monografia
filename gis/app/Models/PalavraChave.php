<?php

namespace Gis\Models;

use Illuminate\Database\Eloquent\Model;

class PalavraChave extends Model
{

    protected $table = 'palavras_chave';

    public $timestamps = false;

    protected $fillable = [
        'palavra'
    ];

    public function mestrados()
    {
        return $this->belongsToMany(Mestrado::class, 'mestrado_palavra_chave', 'palavra_chave_id', 'mestrado_id');
    }

    public function mestradosProfissionalizantes()
    {
        return $this->belongsToMany(MestradoProfissionalizante::class, 'mestrado_profissionalizante_palavra_chave', 'palavra_chave_id', 'mestrado_profissionalizante_id');
    }

    public function residenciasMedicas()
    {
        return $this->belongsToMany(ResidenciaMedica::class, 'residencia_medica_palavra_chave', 'palavra_chave_id', 'residencia_medica_id');
    }

    public function livreDocencias()
    {
        return $this->belongsToMany(LivreDocencia::class, 'livre_docencia_palavra_chave', 'palavra_chave_id', 'livre_docencia_id');
    }

    public function doutorados()
    {
        return $this->belongsToMany(Doutorado::class, 'doutorado_palavra_chave', 'palavra_chave_id', 'doutorado_id');
    }

    public function posDoutorados()
    {
        return $this->belongsToMany(PosDoutorado::class, 'pos_doutorado_palavra_chave', 'palavra_chave_id', 'pos_doutorado_id');
    }

    public function trabalhosEmEventos()
    {
        return $this->belongsToMany(TrabalhoEmEvento::class, 'trabalho_em_evento_palavra_chave', 'palavra_chave_id', 'trabalho_em_evento_id');
    }

}
