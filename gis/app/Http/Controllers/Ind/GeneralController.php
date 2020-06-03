<?php

namespace Gis\Http\Controllers\Ind;

use Gis\Http\Controllers\Controller;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use JavaScript;

class GeneralController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(){
         $page_title = 'Indicadores Gerais:';

         // Busca a quantidade de professores com Lattes
         $jsonurl = "http://localhost:9000/ind/teachers/count=true";
         $json = file_get_contents($jsonurl);
         $numDeProfessores = $json;
         // Busca a quantidade de cursos Cadastradoss no Banco
         $jsonurl = "http://localhost:9000/ind/universityCourses/count=true";
         $json = file_get_contents($jsonurl);
         $qtdCursos = $json;
        
         $jsonurl = "http://localhost:9000/ind/centers/count=true";
         $json = file_get_contents($jsonurl);
         $qtdUnidades = $json;
 
         $jsonurl = "http://localhost:9000/ind/articleYear";
         $json = file_get_contents($jsonurl);
         $jsonresult = json_decode($json);
         $anos = $jsonresult->results;
         
         $jsonurl = "http://localhost:9000/ind/publishedArticles/count=true";
         $json = file_get_contents($jsonurl);
         $artigosPub = $json;
 
         $jsonurl = "http://localhost:9000/ind/eventsWorks/count=true";
         $json = file_get_contents($jsonurl);
         $trabEventos = $json;
         
         $jsonurl = "http://localhost:9000/ind/publishedCapBooks/count=true";
         $json = file_get_contents($jsonurl);
         $capLivros = $json;

        return view('ind/general', compact(['page_title','numDeProfessores','qtdCursos','qtdUnidades','anos','artigosPub','trabEventos','capLivros']));


    }



    public function destaques(){
        $page_title = 'Indicadores Gerais:';

        $jsonurl = "http://localhost:9000/ind/teacherStatistics/10";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        $profArtigos = (object) $jsonresult->articles;
        
        foreach ($profArtigos as $professor){

            $professor->name = $professor->nome_completo;

        }
        
        $profEventos = (object) $jsonresult->events;
        
        foreach ($profEventos as $professor){

            $professor->name = $professor->nome_completo;

        }

        $profCapLivros = (object) $jsonresult->books;
        
        foreach ($profCapLivros as $professor){

            $professor->name = $professor->nome_completo;

        }

        return view('ind/destaques', compact(['page_title','profArtigos','profEventos','profCapLivros']));


    }


    public function comparar(){
        $page_title = 'Indicadores Gerais:';

        $jsonurl = "http://localhost:9000/ind/teachers";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        $professores = $jsonresult->results;
        
        $jsonurl = "http://localhost:9000/ind/centers";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        $centros = $jsonresult->results;
        
        return view('ind/comparar', compact(['page_title','professores','centros']));
    }

    public function compararCentros($centro1, $centro2){


        $page_title = 'Indicadores Gerais:';

        $jsonurl = "http://localhost:9000/ind/centerId";

        $body = json_encode(array(
                'sigla' => $centro1
                ));
                
        $contexto = stream_context_create(array(
                    'http' => array(
                        'method' => 'POST',
                        'content' => $body,
                        'header' => "Content-Type: application/json\r\n"
                        . "Content-Length: " . strlen($body) . "\r\n",
                )
        ));
                            
        $resposta = file_get_contents($jsonurl, null, $contexto);
        $centro1_id = json_decode($resposta)[0];
//RECUPERA IDS
        $body = json_encode(array(
                'sigla' => $centro2
                ));
                
        $contexto = stream_context_create(array(
                'http' => array(
                        'method' => 'POST',
                        'content' => $body,
                        'header' => "Content-Type: application/json\r\n"
                        . "Content-Length: " . strlen($body) . "\r\n",
                )
        ));
                    
        $resposta = file_get_contents($jsonurl, null, $contexto);
        $centro2_id = json_decode($resposta)[0];

// QUANTIDADE DE PROFESSORES
        $jsonurl = "http://localhost:9000/ind/teachersFromCenter/$centro1_id/count=true";
        $json = file_get_contents($jsonurl);
        $numDeProfessores1 = $json;
        $jsonurl = "http://localhost:9000/ind/teachersFromCenter/$centro2_id/count=true";
        $json = file_get_contents($jsonurl);
        $numDeProfessores2 = $json;

// QUANTIDADE DE CURSOS

        $jsonurl = "http://localhost:9000/ind/universityCoursesFromCenter/$centro1_id/count=true";
        $json = file_get_contents($jsonurl);
        $qtdCursos1 = $json;
        $jsonurl = "http://localhost:9000/ind/universityCoursesFromCenter/$centro2_id/count=true";
        $json = file_get_contents($jsonurl);
        $qtdCursos2 = $json;

// QUANTIDADE DE ARTIGOS PUBLICADOS
        
        $jsonurl = "http://localhost:9000/ind/publishedArticlesFromCenter/$centro1_id/count=true";
        $json = file_get_contents($jsonurl);
        $artigosPub1 = $json;
        $jsonurl = "http://localhost:9000/ind/publishedArticlesFromCenter/$centro2_id/count=true";
        $json = file_get_contents($jsonurl);
        $artigosPub2 = $json;

// QUANTIDADE DE TRABALHOS EM EVENTOS
        
        $jsonurl = "http://localhost:9000/ind/eventsWorksFromCenter/$centro1_id/count=true";
        $json = file_get_contents($jsonurl);
        $trabEventos1 = $json;
        $jsonurl = "http://localhost:9000/ind/eventsWorksFromCenter/$centro2_id/count=true";
        $json = file_get_contents($jsonurl);
        $trabEventos2 = $json;

// CAPITULOS DE LIVROS

        $jsonurl = "http://localhost:9000/ind/publishedCapBooksFromCenter/$centro1_id/count=true";
        $json = file_get_contents($jsonurl);
        $capLivros1 = $json;
        $jsonurl = "http://localhost:9000/ind/publishedCapBooksFromCenter/$centro2_id/count=true";
        $json = file_get_contents($jsonurl);
        $capLivros2 = $json;
// ANOS QUALIS
        $jsonurl = "http://localhost:9000/ind/articleYear/$centro1_id";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        $anos1 = $jsonresult->results;
        $jsonurl = "http://localhost:9000/ind/articleYear/$centro2_id";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        $anos2 = $jsonresult->results;

        return view('ind/compararCentros', compact(['page_title','centro1','centro2','artigosPub1','artigosPub2','capLivros1','capLivros2','trabEventos1','trabEventos2','numDeProfessores1', 'numDeProfessores2','centro1_id','centro2_id','anos1','anos2']));


    }


}



