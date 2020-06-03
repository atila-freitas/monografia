<?php

namespace Gis\Http\Controllers\Ind;
use Gis\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CentersController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

public function index(){
    $page_title = 'Indicadores por Centros';

    $jsonurl = "http://localhost:9000/ind/centers";
    $json = file_get_contents($jsonurl);
    $jsonresult = json_decode($json);
    $centros = $jsonresult->results;

    //dd($centros);
    return view('ind/centers', compact(['page_title','centros']));
}


    public function centerDetails($id){
        $page_title = 'Indicadores por Centros';

        $jsonurl = "http://localhost:9000/ind/centersSpecific/$id";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        
        $centro = $jsonresult->results[0];

        $sigla = $centro->sigla;
        $nome = $centro->nome;
        
        // Busca a quantidade de professores com Lattes
        $jsonurl = "http://localhost:9000/ind/teachersFromCenter/$id/count=true";
        $json = file_get_contents($jsonurl);
        $numDeProfessores = $json;
        // Busca a quantidade de cursos Cadastradoss no Banco
        $jsonurl = "http://localhost:9000/ind/universityCoursesFromCenter/$id/count=true";
        $json = file_get_contents($jsonurl);
        $qtdCursos = $json;

        $jsonurl = "http://localhost:9000/ind/articleYear/$id";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        $anos = $jsonresult->results;
        
        $jsonurl = "http://localhost:9000/ind/publishedArticlesFromCenter/$id/count=true";
        $json = file_get_contents($jsonurl);
        $artigosPub = $json;

        $jsonurl = "http://localhost:9000/ind/eventsWorksFromCenter/$id/count=true";
        $json = file_get_contents($jsonurl);
        $trabEventos = $json;
        
        $jsonurl = "http://localhost:9000/ind/publishedCapBooksFromCenter/$id/count=true";
        $json = file_get_contents($jsonurl);
        $capLivros = $json;
        
        return view('ind/centerDetails', compact(['page_title','numDeProfessores','qtdCursos','anos','artigosPub','trabEventos','capLivros','id','sigla','nome']));

    }


}



