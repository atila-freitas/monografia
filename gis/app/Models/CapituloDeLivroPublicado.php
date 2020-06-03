<?php

namespace Gis\Models;

use Illuminate\Database\Eloquent\Model;

class CapituloDeLivroPublicado extends Model
{
    protected $table = 'capitulos_de_livros_publicados';

    protected $fillable = [
        'lattes_id', 'tipo', 'titulo_do_capitulo_do_livro', 'ano', 'pais_de_publicacao', 'idioma', 'meio_de_divulgacao',
        'flag_relevancia', 'flag_divulgacao_cientifica', 'titulo_do_livro', 'cidade_da_editora', ' '
    ];

    public function lattes()
    {
        return $this->belongsTo(Lattes::class);
    }

    public function palavrasChave()
    {
        return $this->belongsToMany(PalavraChave::class, 'capitulo_de_livro_publicado_palavra_chave', 'capitulo_de_livro_publicado_id', 'palavra_chave_id');
    }

    public function autores()
    {
        return $this->belongsToMany(Autor::class, 'capitulo_de_livro_publicado_autor', 'capitulo_de_livro_publicado_id', 'autor_id')
            ->withPivot('ordem_autoria');
    }

}
