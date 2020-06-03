<?php

namespace Gis\Models;

use Illuminate\Database\Eloquent\Model;

class Lattes extends Model
{

    public $incrementing = false;

    protected $fillable = [
        'id', 'curso_faculdade_id', 'data_atualizacao', 'hora_atualizacao', 'nome_completo',
        'nome_citacao', 'nacionalidade', 'pais_nacimento', 'uf_nascimento', 'cidade_nascimento',
        'sigla_pais_nacionalidade', 'pais_nacionalidade', 'resumo_cv', 'resumo_cv_ingles'
    ];

    public function idiomas()
    {
        return $this->belongsToMany(Idioma::class, 'lattes_idioma', 'lattes_id','idioma_id')
            ->withPivot('leitura', 'fala', 'escrita', 'compreensao')->withTimestamps();
    }

    public function cursosFaculdade()
    {
        return $this->belongsTo(CentroFaculdade::class, 'curso_faculdade_id');
    }

    public function graduacoes()
    {
        return $this->hasMany(Graduacao::class);
    }

    public function aperfeicoamentos()
    {
        return $this->hasMany(Aperfeicoamento::class);
    }

    public function especializacoes()
    {
        return $this->hasMany(Especializacao::class);
    }

    public function mestrados()
    {
        return $this->hasMany(Mestrado::class);
    }

    public function mestradosProfissionalizantes()
    {
        return $this->hasMany(MestradoProfissionalizante::class);
    }

    public function doutorados()
    {
        return $this->hasMany(Doutorado::class);
    }

    public function residenciasMedicas()
    {
        return $this->hasMany(ResidenciaMedica::class);
    }

    public function livreDocencias()
    {
        return $this->hasMany(LivreDocencia::class);
    }

    public function posDoutorados()
    {
        return $this->hasMany(PosDoutorado::class);
    }

    public function trabalhosEmEventos()
    {
        return $this->hasMany(TrabalhoEmEvento::class);
    }

    public function artigosPublicados()
    {
        return $this->hasMany(ArtigoPublicado::class);
    }

    public function capitulosDeLivrosPublicados()
    {
        return $this->hasMany(CapituloDeLivroPublicado::class);
    }

}
