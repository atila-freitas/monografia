<?php

namespace Gis\Models;

use Illuminate\Database\Eloquent\Model;

class TrabalhoEmEvento extends Model
{

    protected $table = 'trabalhos_em_eventos';

    protected $fillable = [
        'natureza', 'lattes_id', 'titulo', 'titulo_ingles', 'ano', 'pais', 'idioma', 'meio_divulgacao',
        'flag_relevancia', 'flag_divulgacao_cientifica', 'classificacao_evento', 'nome_evento',
        'nome_evento_ingles', 'cidade_evento', 'ano_evento', 'titulo_anais_ou_proceedings', 'volume',
        'fasciculo', 'serie', 'pagina_inicial', 'pagina_final', 'isbn', 'nome_editora', 'cidade_editora'
    ];

    protected $appends = ['coordenadas_nome'];

    public function getCoordenadasNomeAttribute()
    {
        return (!empty($this->cidade_evento) ? $this->cidade_evento . ', ' : '') . $this->pais;
    }

    public function lattes()
    {
        return $this->belongsTo(Lattes::class);
    }

    public function coordenadas()
    {
        return $this->hasOne(Coordenadas::class, 'nome', 'coordenadas_nome');
    }

    public function palavrasChave()
    {
        return $this->belongsToMany(PalavraChave::class, 'trabalho_em_evento_palavra_chave', 'trabalho_em_evento_id', 'palavra_chave_id');
    }

    public function autores()
    {
        return $this->belongsToMany(Autor::class, 'trabalho_em_evento_autor', 'trabalho_em_evento_id', 'autor_id')
            ->withPivot('ordem_autoria');
    }

}
