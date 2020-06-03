<?php

namespace Gis\Http\Controllers\Api\Ind\V1;

use Gis\Models\Aperfeicoamento;
use Gis\Models\Doutorado;
use Gis\Models\Especializacao;
use Gis\Models\Graduacao;
use Gis\Models\Lattes;
use Gis\Models\LivreDocencia;
use Gis\Models\Mestrado;
use Gis\Models\MestradoProfissionalizante;
use Gis\Models\PosDoutorado;
use Gis\Http\Controllers\Controller;
use Gis\Models\ResidenciaMedica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BuscaController extends Controller
{

    public function  getArtigosPubPorAno()
    {

        $jsonurl = "http://localhost:9000/ind/publishStatisticsByYear";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        $results = (object) $jsonresult->articles;
        $labels = array();
        foreach ($results as $result){
            array_push($labels , $result->ano_do_artigo);
        }
        $values = array();
        foreach ($results as $result){
            array_push($values , $result->count);
        }

        $ArtigoAno['labels'] = $labels;
        $ArtigoAno['values'] = $values;
        return response()->json($ArtigoAno);
    }


    // Busca trabalhos em eventos X ano no banco
    public function getTrabEvePorAno()
    {
        $jsonurl = "http://localhost:9000/ind/publishStatisticsByYear";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        $results = (object) $jsonresult->events;
        $labels = array();
        foreach ($results as $result){
            array_push($labels , $result->ano);
        }
        $values = array();
        foreach ($results as $result){
            array_push($values , $result->count);
        }

        $trabAno['labels'] = $labels;
        $trabAno['values'] = $values;
        return response()->json($trabAno);
    }

    //Retorna a quantidade de capitulos de livros publicados por ano

    public function getQuantCapDeLivrosPorAno()
    {
        $jsonurl = "http://localhost:9000/ind/publishStatisticsByYear";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        $results = (object) $jsonresult->books;
        $labels = array();
        foreach ($results as $result){
            array_push($labels , $result->ano);
        }
        $values = array();
        foreach ($results as $result){
            array_push($values , $result->count);
        }
        $capLivros['labels'] = $labels;
        $capLivros['values'] = $values;
        return response()->json($capLivros);
    }


    public function getQualisPorAno()
    {
        $jsonurl = "http://localhost:9000/ind/qualisStatistics";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        $results = (object) $jsonresult->results;
        $labels = array();
        foreach ($results as $result){
            array_push($labels , $result->estrato);
        }
        $values = array();
        foreach ($results as $result){
            array_push($values , $result->count);
        }
        $qualisAno['labels'] = $labels;
        $qualisAno['values'] = $values;
        //dd($qualisAno);
        return response()->json($qualisAno);
    }

    public function atualizaQualis(Request $request)
    {
        $ano = $request->ano;
        $jsonurl = "http://localhost:9000/ind/qualisStatisticsByYear/$ano";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        $results = (object) $jsonresult->results;
        $labels = array();
        foreach ($results as $result){
            array_push($labels , $result->estrato);
        }
        $values = array();
        foreach ($results as $result){
            array_push($values , $result->count);
        }

        $qualisAno = $jsonresult->results;
        
        $qualisAno['labels'] = $labels;
        $qualisAno['values'] = $values;
        //dd($qualisAno);
        return response()->json($qualisAno);

    }

    public function getQualisPorEstrato()
    {

        $jsonurl = "http://localhost:9000/ind/qualisStatisticsByRank/A1";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        $results = (object) $jsonresult->results;
        $labels = array();
        foreach ($results as $result){
            array_push($labels , $result->ano_do_artigo);
        }
        $values = array();
        foreach ($results as $result){
            array_push($values , $result->count);
        }

        $qualisEstrato = $jsonresult->results;
        
        $qualisEstrato['labels'] = $labels;
        $qualisEstrato['values'] = $values;
        //dd($qualisEstrato);

        return response()->json($qualisEstrato);
    }

    public function atualizaQualisPorEstrato(Request $request)
    {
        $estrato = $request->estrato;
        $jsonurl = "http://localhost:9000/ind/qualisStatisticsByRank/$estrato";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        $results = (object) $jsonresult->results;
        $labels = array();
        foreach ($results as $result){
            array_push($labels , $result->ano_do_artigo);
        }
        $values = array();
        foreach ($results as $result){
            array_push($values , $result->count);
        }

        $qualisEstrato = $jsonresult->results;
        
        $qualisEstrato['labels'] = $labels;
        $qualisEstrato['values'] = $values;
        //dd($qualisEstrato);

        return response()->json($qualisEstrato);
    }


    public function  getArtigosPubPorAnoCentro($id){

        $jsonurl = "http://localhost:9000/ind/publishedArticlesFromCenterStatistics/$id";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        $results = (object) $jsonresult->articles;
        $labels = array();
        foreach ($results as $result){
            array_push($labels , $result->ano_do_artigo);
        }
        $values = array();
        foreach ($results as $result){
            array_push($values , $result->count);
        }

        $ArtigoAno = $jsonresult->articles;
        
        $ArtigoAno['labels'] = $labels;
        $ArtigoAno['values'] = $values;
        return response()->json($ArtigoAno);
    }

    public function getQuantCapLivrosCentro($id)
    {
        $jsonurl = "http://localhost:9000/ind/publishedArticlesFromCenterStatistics/$id";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        $results = (object) $jsonresult->books;
        $labels = array();
        foreach ($results as $result){
            array_push($labels , $result->ano);
        }
        $values = array();
        foreach ($results as $result){
            array_push($values , $result->count);
        }

        $capLivros = $jsonresult->books;
        
        $capLivros['labels'] = $labels;
        $capLivros['values'] = $values;

        return response()->json($capLivros);
    }

    public function getQuantEventosCentro($id)
    {
        $jsonurl = "http://localhost:9000/ind/publishedArticlesFromCenterStatistics/$id";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        $results = (object) $jsonresult->events;
        $labels = array();
        foreach ($results as $result){
            array_push($labels , $result->ano);
        }
        $values = array();
        foreach ($results as $result){
            array_push($values , $result->count);
        }

        $trabAno = $jsonresult->events;
        
        $trabAno['labels'] = $labels;
        $trabAno['values'] = $values;
        return response()->json($trabAno);
    }

    public function atualizaQualisCentro(Request $request)
    {
        //dd($request);

        $id = $request->id;
        $ano = $request->ano;

        $jsonurl = "http://localhost:9000/ind/qualisStatisticsByCenter/$id/$ano";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        $results = (object) $jsonresult->results;
        $labels = array();
        foreach ($results as $result){
            array_push($labels , $result->estrato);
        }
        $values = array();
        foreach ($results as $result){
            array_push($values , $result->count);
        }

        $qualisAno = $jsonresult->results;
        
        $qualisAno['labels'] = $labels;
        $qualisAno['values'] = $values;


        return response()->json( $qualisAno);

    }

    public function qualisPorAnoCentro($id)
    {
        $jsonurl = "http://localhost:9000/ind/qualisStatisticsByCenter/$id/1970";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        $results = (object) $jsonresult->results;
        $labels = array();
        foreach ($results as $result){
            array_push($labels , $result->estrato);
        }
        $values = array();
        foreach ($results as $result){
            array_push($values , $result->count);
        }

        $qualisAno = $jsonresult->results;
        
        $qualisAno['labels'] = $labels;
        $qualisAno['values'] = $values;
        //dd($qualisAno);
        return response()->json($qualisAno);
    }
}



