<?php

namespace Gis\Models;

use Illuminate\Database\Eloquent\Model;

class ArtigoPublicado extends Model
{
    protected $table = 'artigos_publicados';

    protected $fillable = [
        'lattes_id', 'natureza', 'titulo_do_artigo', 'titulo_do_artigo_ingles', 'ano_do_artigo',
        'pais_de_publicacao', 'idioma', 'meio_divulgacao','flag_relevancia', 'titulo_periodico_revista', 'issn',
        'volume', 'fasciculo', 'pagina_inicial', 'pagina_final', 'local_publicacao', 'estrato', 'buscou_estrato'
    ];

    public function lattes()
    {
        return $this->belongsTo(Lattes::class);
    }

    public function palavrasChave()
    {
        return $this->belongsToMany(PalavraChave::class, 'artigo_publicado_palavra_chave', 'artigo_publicado_id', 'palavra_chave_id');
    }

    public function autores()
    {
        return $this->belongsToMany(Autor::class, 'artigo_publicado_autor', 'artigo_publicado_id', 'autor_id')
            ->withPivot('ordem_autoria');
    }

}
