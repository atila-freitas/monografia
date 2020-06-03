<?php

namespace Gis\Models;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{

    protected $table = 'autores';

    public $timestamps = false;

    protected $fillable = [
        'nome_completo', 'nome_citacao', 'id_cnpq'
    ];

    public function trabalhosEmEventos()
    {
        return $this->belongsToMany(TrabalhoEmEvento::class, 'trabalho_em_evento_autor', 'autor_id', 'trabalho_em_evento_id')
            ->withPivot('ordem_autoria');
    }

    public function artigosPublicados()
    {
        return $this->belongsToMany(ArtigoPublicado::class, 'artigo_publicado_autor', 'autor_id', 'artigo_publicado_id')
            ->withPivot('ordem_autoria');
    }

    public function capitulosDeLivrosPublicados()
    {
        return $this->belongsToMany(CapituloDeLivroPublicado::class, 'capitulo_de_livro_publicado_autor', 'autor_id', 'capitulo_de_livro_publicado_id')
            ->withPivot('ordem_autoria');
    }

}
