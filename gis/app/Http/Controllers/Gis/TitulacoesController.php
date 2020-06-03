<?php

namespace Gis\Http\Controllers\Gis;

use Gis\Models\Aperfeicoamento;
use Gis\Models\CentroFaculdade;
use Gis\Models\CursoFaculdade;
use Gis\Models\Doutorado;
use Gis\Models\Especializacao;
use Gis\Models\Graduacao;
use Gis\Models\Lattes;
use Gis\Models\LivreDocencia;
use Gis\Models\Mestrado;
use Gis\Models\MestradoProfissionalizante;
use Gis\Models\Pais;
use Gis\Models\PosDoutorado;
use Gis\Models\ResidenciaMedica;
use Gis\Http\Controllers\Controller;

class TitulacoesController extends Controller
{

    public function index()
    {
        $pageTitle = 'GIS - Titulações';
        $pageDescription = '';
        $breadcrumbs = ['Titulações' => ''];

        $jsonurl = "http://localhost:9000/gis/teachersFormationStatistics";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        

        $total = [
            'cadastros' => $jsonresult->professores,
            'doutorados' => $jsonresult->doutorado,
            'posdoutorados' => $jsonresult->posDoutorados
        ];    

        $titulacoes = [
            'graduacao' => 'Graduação',
            'aperfeicoamento' => 'Aperfeiçoamento',
            'especializacao' => 'Especialização',
            'mestrado' => 'Mestrado',
            'mestradoprofissionalizante' => 'Mestrado Profissionalizante',
            'doutorado' => 'Doutorado',
            'residenciamedica' => 'Residência Médica',
            'livredocencia' => 'Livre Docência',
            'posdoutorado' => 'Pós-Doutorado',
        ];
        
        $jsonurl = "http://localhost:9000/ind/centers";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        
        $response = (object) $jsonresult->results;
        $centros = array();
        $count = 0;
        foreach ($response as $centro) {
           $centros[$centro->id] = $centro->sigla;
            $count = $count + 1;
        };
        
        $jsonurl = "http://localhost:9000/ind/universityCourses";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        
        $response = (object) $jsonresult->results;
        $cursos = array();
        $cursosNomes = array();
        foreach ($response as $curso) {
            $cursos[$curso->sigla_centro][$curso->id] = $curso->nome_curso;
            if(!in_array($curso->nome_curso, $cursosNomes)){
                array_push($cursosNomes, $curso->nome_curso);
            }
         };
        
        return view('gis.titulacoes.index', compact(['pageTitle', 'pageDescription', 'breadcrumbs', 'total', 'titulacoes', 'centros', 'cursos', 'cursosNomes']));
    }
    //To Do
    public function pais($sigla) {
        $pageTitle = 'GIS - Titulações';
        $pageDescription = 'Listagem por País';
        $breadcrumbs = ['Titulações' => 'gis/titulacoes', 'País' => ''];

        $jsonurl = 'http://localhost:9000/gis/paises';

        $body = json_encode(array(
            'sigla2' => $sigla
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
        $paises = json_decode($resposta)->count;

        if ($paises == 0) {
            $arrayMensagem = ['tipo' => 'erro', 'mensagem' => 'País não encontrado: ' . $sigla . '.', 'submensagem' => ''];
            return view('mensagem', compact(['arrayMensagem']));
        }else{
            $siglaBusca = json_decode($resposta)->results[0];
        }

        $pais = $siglaBusca->nome;

        $siglaBusca = $siglaBusca->sigla;
        
        $jsonurl = 'http://localhost:9000/gis/teachersFormationGraduate';

        $body = json_encode(array(
            'sigla_pais' => $siglaBusca
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
        $graduacoes = json_decode($resposta)->results;

        $jsonurl = 'http://localhost:9000/gis/teachersFormationAperfeicoa';

        $body = json_encode(array(
            'sigla_pais' => $siglaBusca
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
        $aperfeicoamentos = json_decode($resposta)->results;

        $jsonurl = 'http://localhost:9000/gis/teachersFormationEspecializa';

        $body = json_encode(array(
            'sigla_pais' => $siglaBusca
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
        $especializacaos = json_decode($resposta)->results;

        $jsonurl = 'http://localhost:9000/gis/teachersFormationMaster';

        $body = json_encode(array(
            'sigla_pais' => $siglaBusca
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
        $mestrados = json_decode($resposta)->results;

        $jsonurl = 'http://localhost:9000/gis/teachersFormationBusinessMaster';

        $body = json_encode(array(
            'sigla_pais' => $siglaBusca
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
        $mestradosProfissionalizantes = json_decode($resposta)->results;

        $jsonurl = 'http://localhost:9000/gis/teachersFormationDoutorado';

        $body = json_encode(array(
            'sigla_pais' => $siglaBusca
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
        $doutorados = json_decode($resposta)->results;

        $jsonurl = 'http://localhost:9000/gis/teachersFormationMedicalSpecial';

        $body = json_encode(array(
            'sigla_pais' => $siglaBusca
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
        $residenciasMedicas = json_decode($resposta)->results;

        $jsonurl = 'http://localhost:9000/gis/teachersFormationLivreDocencia';

        $body = json_encode(array(
            'sigla_pais' => $siglaBusca
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
        $livreDocencias = json_decode($resposta)->results;

        $jsonurl = 'http://localhost:9000/gis/teachersFormationPosDoutorado';

        $body = json_encode(array(
            'sigla_pais' => $siglaBusca
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
        $posDoutorados = json_decode($resposta)->results;

        $dados = [];

        if (sizeof($graduacoes) > 0) $dados['Graduação'] = $graduacoes;
        if (sizeof($aperfeicoamentos) > 0) $dados['Aperfeiçoamento'] = $aperfeicoamentos;
        if (sizeof($especializacaos) > 0) $dados['Especialização'] = $especializacaos;
        if (sizeof($mestrados) > 0) $dados['Mestrado'] = $mestrados;
        if (sizeof($mestradosProfissionalizantes) > 0) $dados['Mestrado_Profissionalizante'] = $mestradosProfissionalizantes;
        if (sizeof($doutorados) > 0) $dados['Doutorado'] = $doutorados;
        if (sizeof($residenciasMedicas) > 0) $dados['Residência_Médica'] = $residenciasMedicas;
        if (sizeof($livreDocencias) > 0) $dados['Livre_Docência'] = $livreDocencias;
        if (sizeof($posDoutorados) > 0) $dados['Pós-doutorado'] = $posDoutorados;

        return view('gis.titulacoes.pais', compact(['pageTitle', 'pageDescription', 'breadcrumbs', 'pais', 'siglaBusca', 'dados']));
    }

    public function instituicao($instituicao) {
        $pageTitle = 'GIS - Titulações';
        $pageDescription = 'Listagem por Instituição';
        $breadcrumbs = ['Titulações' => 'gis/titulacoes', 'Instituição' => ''];

        $jsonurl = 'http://localhost:9000/gis/teachersFormationGraduate';

        $body = json_encode(array(
            'nome_instituicao' => $instituicao
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
        $graduacoes = json_decode($resposta)->results;

        $jsonurl = 'http://localhost:9000/gis/teachersFormationAperfeicoa';

        $body = json_encode(array(
            'nome_instituicao' => $instituicao
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
        $aperfeicoamentos = json_decode($resposta)->results;

        $jsonurl = 'http://localhost:9000/gis/teachersFormationEspecializa';

        $body = json_encode(array(
            'nome_instituicao' => $instituicao
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
        $especializacaos = json_decode($resposta)->results;

        $jsonurl = 'http://localhost:9000/gis/teachersFormationMaster';

        $body = json_encode(array(
            'nome_instituicao' => $instituicao
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
        $mestrados = json_decode($resposta)->results;

        $jsonurl = 'http://localhost:9000/gis/teachersFormationBusinessMaster';

        $body = json_encode(array(
            'nome_instituicao' => $instituicao
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
        $mestradosProfissionalizantes = json_decode($resposta)->results;

        $jsonurl = 'http://localhost:9000/gis/teachersFormationDoutorado';

        $body = json_encode(array(
            'nome_instituicao' => $instituicao
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
        $doutorados = json_decode($resposta)->results;

        $jsonurl = 'http://localhost:9000/gis/teachersFormationMedicalSpecial';

        $body = json_encode(array(
            'nome_instituicao' => $instituicao
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
        $residenciasMedicas = json_decode($resposta)->results;

        $jsonurl = 'http://localhost:9000/gis/teachersFormationLivreDocencia';

        $body = json_encode(array(
            'nome_instituicao' => $instituicao
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
        $livreDocencias = json_decode($resposta)->results;

        $jsonurl = 'http://localhost:9000/gis/teachersFormationPosDoutorado';

        $body = json_encode(array(
            'nome_instituicao' => $instituicao
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
        $posDoutorados = json_decode($resposta)->results;

        $dados = [];

        if (sizeof($graduacoes) > 0) $dados['Graduação'] = $graduacoes;
        if (sizeof($aperfeicoamentos) > 0) $dados['Aperfeiçoamento'] = $aperfeicoamentos;
        if (sizeof($especializacaos) > 0) $dados['Especialização'] = $especializacaos;
        if (sizeof($mestrados) > 0) $dados['Mestrado'] = $mestrados;
        if (sizeof($mestradosProfissionalizantes) > 0) $dados['Mestrado_Profissionalizante'] = $mestradosProfissionalizantes;
        if (sizeof($doutorados) > 0) $dados['Doutorado'] = $doutorados;
        if (sizeof($residenciasMedicas) > 0) $dados['Residência_Médica'] = $residenciasMedicas;
        if (sizeof($livreDocencias) > 0) $dados['Livre_Docência'] = $livreDocencias;
        if (sizeof($posDoutorados) > 0) $dados['Pós-doutorado'] = $posDoutorados;

        return view('gis.titulacoes.instituicao', compact(['pageTitle', 'pageDescription', 'breadcrumbs', 'instituicao', 'dados']));
    }

    public function estatisticas() {
        $pageTitle = 'GIS - Titulações';
        $pageDescription = 'Estatísticas Gerais';
        $breadcrumbs = ['Titulações' => 'gis/titulacoes', 'Estatísticas' => ''];

        $dados = [
            'Graduação' => 'graduacaoGraph',
            'Aperfeiçoamento' => 'aperfeicoamentoGraph',
            'Especialização' => 'especializacaoGraph',
            'Mestrado' => 'mestradoGraph',
            'Mestrado Profissionalizante' => 'mestradoProfissionalizanteGraph',
            'Doutorado' => 'doutoradoGraph',
            'Residência Médica' => 'residenciaMedicaGraph',
            'Livre Docência' => 'livreDocenciaGraph',
            'Pós-doutorado' => 'posDoutoradoGraph'
        ];

        return view('gis.titulacoes.estatisticas', compact(['pageTitle', 'pageDescription', 'breadcrumbs', 'dados']));
    }

}
