<?php

namespace Gis\Models;

use Illuminate\Database\Eloquent\Model;

class Idioma extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'idioma', 'descricao_idioma'
    ];

    public function lattes()
    {
        return $this->belongsToMany(Lattes::class, 'lattes_idioma', 'idioma_id', 'lattes_id')
            ->withPivot('leitura', 'fala', 'escrita', 'compreensao')->withTimestamps();
    }

}
