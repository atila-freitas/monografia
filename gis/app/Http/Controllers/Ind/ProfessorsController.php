<?php

namespace Gis\Http\Controllers\Ind;
use Gis\Http\Controllers\Controller;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;


class ProfessorsController extends Controller
{

    public function index(){

        $page_title = 'Indicadores por Professores';

        $jsonurl = "http://localhost:9000/ind/teachers";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        $professores = $jsonresult->results;


        return view('ind/professors', compact(['page_title','professores']));
    }

    public function professorDetails($id){

        $jsonurl = "http://localhost:9000/ind/teacherDetail/$id";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        $professor = $jsonresult->results[0];
        $centro = $jsonresult->centro[0];
        $artigos = $jsonresult->artigos;
        $trabalhosEventos = $jsonresult->trabalhosEventos;
        $capLivrosPub = $jsonresult->capLivrosPub;

        return view('ind/professorDetails', compact(['professor', 'centro','artigos','trabalhosEventos','capLivrosPub']));
    }

    public function compararProfessores($nome1, $nome2){

        $jsonurl = "http://localhost:9000/ind/teacherId";

        $body = json_encode(array(
                'nome_completo' => $nome1
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
        $professor_id1 = json_decode($resposta)[0];
//RECUPERA IDS
        $body = json_encode(array(
                'nome_completo' => $nome2
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
        $professor_id2 = json_decode($resposta)[0];
//RECUPERA OS DADOS DO PROFESSOR 1
        $jsonurl = "http://localhost:9000/ind/teacherDetail/$professor_id1";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        $professor1 = $jsonresult->results[0];
        $centro1 = $jsonresult->centro[0];
        $artigos1 = $jsonresult->artigos;
        $trabalhosEventos1 = $jsonresult->trabalhosEventos;
        $capLivrosPub1 = $jsonresult->capLivrosPub;
//RECUPERA OS DADOS DO PROFESSOR 2
        $jsonurl = "http://localhost:9000/ind/teacherDetail/$professor_id2";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        $professor2 = $jsonresult->results[0];
        $centro2 = $jsonresult->centro[0];
        $artigos2 = $jsonresult->artigos;
        $trabalhosEventos2 = $jsonresult->trabalhosEventos;
        $capLivrosPub2 = $jsonresult->capLivrosPub;

        return view('ind/compararProfessores', compact(['professor1', 'centro1','artigos1','trabalhosEventos1','capLivrosPub1','professor2', 'centro2','artigos2','trabalhosEventos2','capLivrosPub2']));
    }


}

