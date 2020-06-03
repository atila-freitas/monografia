<?php

namespace Gis\Http\Controllers\Api\Gis\V1;

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

    public function getAll()
    {
        $jsonurl = "http://localhost:9000/gis/allDoutoradoCoordinates";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);

        $doutorados = $jsonresult->results;
        
        $jsonurl = "http://localhost:9000/gis/allPosDoutoradoCoordinates";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);

        $posDoutorados = $jsonresult->results;

        $dados = [];

        foreach ($doutorados as $data)
            if ($data->coordenadas)
                array_push($dados, ['latLng' => [$data->coordenadas->latitude, $data->coordenadas->longitude], 'name' => $data->coordenadas->nome, 'style' => ['fill' => 'green']]);

        foreach ($posDoutorados as $data)
            if ($data->coordenadas)
                array_push($dados, ['latLng' => [($data->coordenadas->latitude), ($data->coordenadas->longitude)], 'name' => $data->coordenadas->nome, 'style' => ['fill' => 'red']]);

        return response()->json($dados);
    }

    public function getTotais()
    {
        $jsonurl = "http://localhost:9000/gis/teachersFormationStatistics";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);

        $totais = [
            'cadastros' => $jsonresult->professores,
            'posDoutorados' => $jsonresult->posDoutorados,
            'graduacao'=> $jsonresult->graduacao,
            'mestrado'=> $jsonresult->mestrado,
            'mestradoProfissionalizante'=> $jsonresult->mestradoProfissionalizante,
            'doutorado'=> $jsonresult->doutorado
        ];
        
        return response()->json($totais);
    }

    public function filter(Request $request)
    {
        $dados = [];

        $titulacoes = $request->titulacoes;
        $centros = $request->centros ?? [];
        $cursos = $request->cursos ?? [];
        
        $whereCentros = [];
        foreach($centros as $centro)
            array_push($whereCentros, (int) $centro);
        
        $whereCursos = [];
        foreach($cursos as $curso)
            array_push($whereCursos, $curso);

        foreach ($titulacoes as $titulacao)
        {
            switch ($titulacao) {
                case 'graduacao':
                    $jsonurl = 'http://localhost:9000/gis/teachersFormationGraduate';

                    $body = json_encode(array(
                        'centro_faculdade_id' => $whereCentros,
                        'curf.nome' => $whereCursos
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
                    $results = json_decode($resposta)->results;
                    foreach ($results as $result) {
                        $result->color = 'RoyalBlue';
                    }
                    break;
                case 'aperfeicoamento':
                    $jsonurl = 'http://localhost:9000/gis/teachersFormationAperfeicoa';

                    $body = json_encode(array(
                        'centro_faculdade_id' => $whereCentros,
                        'curf.nome' => $whereCursos
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
                    $results = json_decode($resposta)->results;
                    foreach ($results as $result) {
                        $result->color = 'MediumVioletRed';
                    }
                    break;
                case 'especializacao':
                    $jsonurl = 'http://localhost:9000/gis/teachersFormationEspecializa';

                    $body = json_encode(array(
                        'centro_faculdade_id' => $whereCentros,
                        'curf.nome' => $whereCursos
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
                    $results = json_decode($resposta)->results;
                    foreach ($results as $result) {
                        $result->color = 'DarkOrange';
                    }
                    break;
                case 'mestrado':
                    $jsonurl = 'http://localhost:9000/gis/teachersFormationMaster';

                    $body = json_encode(array(
                        'centro_faculdade_id' => $whereCentros,
                        'curf.nome' => $whereCursos
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
                    $results = json_decode($resposta)->results;
                    foreach ($results as $result) {
                        $result->color = 'Yellow';
                    }
                    break;
                case 'mestradoprofissionalizante':
                    $jsonurl = 'http://localhost:9000/gis/teachersFormationBusinessMaster';

                    $body = json_encode(array(
                        'centro_faculdade_id' => $whereCentros,
                        'curf.nome' => $whereCursos
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
                    $results = json_decode($resposta)->results;
                    foreach ($results as $result) {
                        $result->color = 'Purple';
                    }
                    break;
                case 'doutorado':
                    $jsonurl = 'http://localhost:9000/gis/teachersFormationDoutorado';

                    $body = json_encode(array(
                        'centro_faculdade_id' => $whereCentros,
                        'curf.nome' => $whereCursos
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
                    $results = json_decode($resposta)->results;
                    foreach ($results as $result) {
                        $result->color = 'LightGreen';
                    }
                    break;
                case 'residenciamedica':
                    $jsonurl = 'http://localhost:9000/gis/teachersFormationMedicalSpecial';

                    $body = json_encode(array(
                        'centro_faculdade_id' => $whereCentros,
                        'curf.nome' => $whereCursos
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
                    $results = json_decode($resposta)->results;
                    foreach ($results as $result) {
                        $result->color = 'DarkGoldenRod';
                    }
                    break;
                case 'livredocencia':
                    $jsonurl = 'http://localhost:9000/gis/teachersFormationLivreDocencia';

                    $body = json_encode(array(
                        'centro_faculdade_id' => $whereCentros,
                        'curf.nome' => $whereCursos
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
                    $results = json_decode($resposta)->results;
                    foreach ($results as $result) {
                        $result->color = 'CornflowerBlue';
                    }
                    break;
                case 'posdoutorado':
                    $jsonurl = 'http://localhost:9000/gis/teachersFormationLivreDocencia';

                    $body = json_encode(array(
                        'centro_faculdade_id' => $whereCentros,
                        'curf.nome' => $whereCursos
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
                    $results = json_decode($resposta)->results;
                    foreach ($results as $result) {
                        $result->color = 'LightSeaGreen';
                    }
                    break;
            }

            if (!empty($results))
                foreach ($results as $data)
                    array_push($dados, ['latLng' => [($data->latitude), ($data->longitude)], 'name' => $data->nome_instituicao, 'style' => ['fill' => $data->color ?? 'black']]);

            unset($results);
            unset($color);
        }
        //echo json_encode($dados);
        return response()->json($dados);
    }

    public function estatisticas(Request $request)
    {
        $jsonurl = "http://localhost:9000/gis/teachersFormationCountryStatistics/graduacoes";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        
        $response = (object) $jsonresult->results;
        $graduacoes = array();
        foreach ($response as $graduacao) {
           $graduacoes[$graduacao->nome_pais] = $graduacao->quantidade;
        };

        $jsonurl = "http://localhost:9000/gis/teachersFormationCountryStatistics/aperfeicoamentos";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        
        $response = (object) $jsonresult->results;
        $aperfeicoamentos = array();
        foreach ($response as $graduacao) {
           $aperfeicoamentos[$graduacao->nome_pais] = $graduacao->quantidade;
        };

        $jsonurl = "http://localhost:9000/gis/teachersFormationCountryStatistics/especializacoes";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        
        $response = (object) $jsonresult->results;
        $especializacaos = array();
        foreach ($response as $graduacao) {
           $especializacaos[$graduacao->nome_pais] = $graduacao->quantidade;
        };

        $jsonurl = "http://localhost:9000/gis/teachersFormationCountryStatistics/mestrados";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        
        $response = (object) $jsonresult->results;
        $mestrados = array();
        foreach ($response as $graduacao) {
           $mestrados[$graduacao->nome_pais] = $graduacao->quantidade;
        };
        
        $jsonurl = "http://localhost:9000/gis/teachersFormationCountryStatistics/mestrados_profissionalizantes";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        
        $response = (object) $jsonresult->results;
        $mestradosProfissionalizantes = array();
        foreach ($response as $graduacao) {
           $mestradosProfissionalizantes[$graduacao->nome_pais] = $graduacao->quantidade;
        };
        
        $jsonurl = "http://localhost:9000/gis/teachersFormationCountryStatistics/doutorados";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        
        $response = (object) $jsonresult->results;
        $doutorados = array();
        foreach ($response as $graduacao) {
           $doutorados[$graduacao->nome_pais] = $graduacao->quantidade;
        };

        $jsonurl = "http://localhost:9000/gis/teachersFormationCountryStatistics/residencias_medicas";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        
        $response = (object) $jsonresult->results;
        $residenciasMedicas = array();
        foreach ($response as $graduacao) {
           $residenciasMedicas[$graduacao->nome_pais] = $graduacao->quantidade;
        };

        $jsonurl = "http://localhost:9000/gis/teachersFormationCountryStatistics/livre_docencias";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        
        $response = (object) $jsonresult->results;
        $livreDocencias = array();
        foreach ($response as $graduacao) {
           $livreDocencias[$graduacao->nome_pais] = $graduacao->quantidade;
        };

        $jsonurl = "http://localhost:9000/gis/teachersFormationCountryStatistics/pos_doutorados";
        $json = file_get_contents($jsonurl);
        $jsonresult = json_decode($json);
        
        $response = (object) $jsonresult->results;
        $posDoutorados = array();
        foreach ($response as $graduacao) {
           $posDoutorados[$graduacao->nome_pais] = $graduacao->quantidade;
        };
        
        $sum = 0;
        foreach ($graduacoes as $key => $value)
            if ($key != 'Brasil')
                $sum += $value;

        $graduacoesGeral = ['Brasil' => ($graduacoes['Brasil'] ?? 0), 'Outros' => $sum];

        $sum = 0;
        foreach ($aperfeicoamentos as $key => $value)
            if ($key != 'Brasil')
                $sum += $value;

        $aperfeicoamentosGeral = ['Brasil' => ($aperfeicoamentos['Brasil'] ?? 0), 'Outros' => $sum];

        $sum = 0;
        foreach ($especializacaos as $key => $value)
            if ($key != 'Brasil')
                $sum += $value;

        $especializacaosGeral = ['Brasil' => ($especializacaos['Brasil'] ?? 0), 'Outros' => $sum];

        $sum = 0;
        foreach ($mestrados as $key => $value)
            if ($key != 'Brasil')
                $sum += $value;

        $mestradosGeral = ['Brasil' => ($mestrados['Brasil'] ?? 0), 'Outros' => $sum];

        $sum = 0;
        foreach ($mestradosProfissionalizantes as $key => $value)
            if ($key != 'Brasil')
                $sum += $value;

        $mestradosProfissionalizantesGeral = ['Brasil' => ($mestradosProfissionalizantes['Brasil'] ?? 0), 'Outros' => $sum];

        $sum = 0;
        foreach ($doutorados as $key => $value)
            if ($key != 'Brasil')
                $sum += $value;

        $doutoradosGeral = ['Brasil' => ($doutorados['Brasil'] ?? 0), 'Outros' => $sum];

        $sum = 0;
        foreach ($residenciasMedicas as $key => $value)
            if ($key != 'Brasil')
                $sum += $value;

        $residenciasMedicasGeral = ['Brasil' => ($residenciasMedicas['Brasil'] ?? 0), 'Outros' => $sum];

        $sum = 0;
        foreach ($livreDocencias as $key => $value)
            if ($key != 'Brasil')
                $sum += $value;

        $livreDocenciasGeral = ['Brasil' => ($livreDocencias['Brasil'] ?? 0), 'Outros' => $sum];

        $sum = 0;
        foreach ($posDoutorados as $key => $value)
            if ($key != 'Brasil')
                $sum += $value;

        $posDoutoradosGeral = ['Brasil' => ($posDoutorados['Brasil'] ?? 0), 'Outros' => $sum];

        $dados = [
            'graduacaoGraph' => $graduacoes,
            'aperfeicoamentoGraph' => $aperfeicoamentos,
            'especializacaoGraph' => $especializacaos,
            'mestradoGraph' => $mestrados,
            'mestradoProfissionalizanteGraph' => $mestradosProfissionalizantes,
            'doutoradoGraph' => $doutorados,
            'residenciaMedicaGraph' => $residenciasMedicas,
            'livreDocenciaGraph' => $livreDocencias,
            'posDoutoradoGraph' => $posDoutorados,
            'graduacaoGraphGeral' => $graduacoesGeral,
            'aperfeicoamentoGraphGeral' => $aperfeicoamentosGeral,
            'especializacaoGraphGeral' => $especializacaosGeral,
            'mestradoGraphGeral' => $mestradosGeral,
            'mestradoProfissionalizanteGraphGeral' => $mestradosProfissionalizantesGeral,
            'doutoradoGraphGeral' => $doutoradosGeral,
            'residenciaMedicaGraphGeral' => $residenciasMedicasGeral,
            'livreDocenciaGraphGeral' => $livreDocenciasGeral,
            'posDoutoradoGraphGeral' => $posDoutoradosGeral
        ];

        return response()->json($dados);
    }

    public function pais(Request $request) {
        $siglaBusca = $request->sigla;

        $jsonurl = 'http://localhost:9000/gis/teachersFormationUniversityTop10/graduacoes';

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
            $results = (object) json_decode($resposta)->results;
            $graduacoes = array();
            foreach ($results as $graduacao) {
                $graduacoes[$graduacao->instituicao] = $graduacao->quantidade;
            };

            $jsonurl = 'http://localhost:9000/gis/teachersFormationUniversityTop10/aperfeicoamentos';

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
            $results = (object) json_decode($resposta)->results;
            $aperfeicoamentos = array();
            foreach ($results as $graduacao) {
                $aperfeicoamentos[$graduacao->instituicao] = $graduacao->quantidade;
            };

            $jsonurl = 'http://localhost:9000/gis/teachersFormationUniversityTop10/especializacoes';

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
            $results = (object) json_decode($resposta)->results;
            $especializacaos = array();
            foreach ($results as $graduacao) {
                $especializacaos[$graduacao->instituicao] = $graduacao->quantidade;
            };

            $jsonurl = 'http://localhost:9000/gis/teachersFormationUniversityTop10/mestrados';

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
            $results = (object) json_decode($resposta)->results;
            $mestrados = array();
            foreach ($results as $graduacao) {
                $mestrados[$graduacao->instituicao] = $graduacao->quantidade;
            };

            $jsonurl = 'http://localhost:9000/gis/teachersFormationUniversityTop10/mestrados_profissionalizantes';

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
            $results = (object) json_decode($resposta)->results;
            $mestradosProfissionalizantes = array();
            foreach ($results as $graduacao) {
                $mestradosProfissionalizantes[$graduacao->instituicao] = $graduacao->quantidade;
            };

        $jsonurl = 'http://localhost:9000/gis/teachersFormationUniversityTop10/doutorados';

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
            $results = (object) json_decode($resposta)->results;
            $doutorados = array();
            foreach ($results as $graduacao) {
                $doutorados[$graduacao->instituicao] = $graduacao->quantidade;
            };

            $jsonurl = 'http://localhost:9000/gis/teachersFormationUniversityTop10/residencias_medicas';

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
            $results = (object) json_decode($resposta)->results;
            $residenciasMedicas = array();

            foreach ($results as $graduacao) {
                $residenciasMedicas[$graduacao->instituicao] = $graduacao->quantidade;
            };

            $jsonurl = 'http://localhost:9000/gis/teachersFormationUniversityTop10/livre_docencias';

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
            $results = (object) json_decode($resposta)->results;
            $livreDocencias = array();
            foreach ($results as $graduacao) {
                $livreDocencias[$graduacao->instituicao] = $graduacao->quantidade;
            };

            $jsonurl = 'http://localhost:9000/gis/teachersFormationUniversityTop10/pos_doutorados';

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
            $results = (object) json_decode($resposta)->results;
            $posDoutorados = array();
            foreach ($results as $graduacao) {
                $posDoutorados[$graduacao->instituicao] = $graduacao->quantidade;
            };
        

            $jsonurl = 'http://localhost:9000/gis/teachersFormationUniversityStatus/graduacoes';

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
            $results = (object) json_decode($resposta)->results;
            $graduacoesStatus = array();
            foreach ($results as $graduacao) {
                $graduacoesStatus[$graduacao->status_curso] = $graduacao->quantidade;
            };
            
            $jsonurl = 'http://localhost:9000/gis/teachersFormationUniversityStatus/aperfeicoamentos';

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
            $results = (object) json_decode($resposta)->results;
            $aperfeicoamentosStatus = array();
            foreach ($results as $graduacao) {
                $aperfeicoamentosStatus[$graduacao->status_curso] = $graduacao->quantidade;
            };
            $jsonurl = 'http://localhost:9000/gis/teachersFormationUniversityStatus/especializacoes';

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
            $results = (object) json_decode($resposta)->results;
            $especializacaosStatus = array();
            foreach ($results as $graduacao) {
                $especializacaosStatus[$graduacao->status_curso] = $graduacao->quantidade;
            };

            $jsonurl = 'http://localhost:9000/gis/teachersFormationUniversityStatus/mestrados';

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
            $results = (object) json_decode($resposta)->results;
            $mestradosStatus = array();
            foreach ($results as $graduacao) {
                $mestradosStatus[$graduacao->status_curso] = $graduacao->quantidade;
            };
            $jsonurl = 'http://localhost:9000/gis/teachersFormationUniversityStatus/mestrados_profissionalizantes';

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
            $results = (object) json_decode($resposta)->results;
            $mestradosProfissionalizantesStatus = array();
            foreach ($results as $graduacao) {
                $mestradosProfissionalizantesStatus[$graduacao->status_curso] = $graduacao->quantidade;
            };

            $jsonurl = 'http://localhost:9000/gis/teachersFormationUniversityStatus/doutorados';

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
            $results = (object) json_decode($resposta)->results;
            $doutoradosStatus = array();
            foreach ($results as $graduacao) {
                $doutoradosStatus[$graduacao->status_curso] = $graduacao->quantidade;
            };

            $jsonurl = 'http://localhost:9000/gis/teachersFormationUniversityStatus/residencias_medicas';

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
            $results = (object) json_decode($resposta)->results;
            $residenciasMedicasStatus = array();
            foreach ($results as $graduacao) {
                $residenciasMedicasStatus[$graduacao->status_curso] = $graduacao->quantidade;
            };

            $jsonurl = 'http://localhost:9000/gis/teachersFormationUniversityStatus/pos_doutorados';

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
            $results = (object) json_decode($resposta)->results;
            $posDoutoradosStatus = array();
            foreach ($results as $graduacao) {
                $posDoutoradosStatus[$graduacao->status_curso] = $graduacao->quantidade;
            };

        $dados = [
            'Graduação' => $graduacoes,
            'Aperfeiçoamento' => $aperfeicoamentos,
            'Especialização' => $especializacaos,
            'Mestrado' => $mestrados,
            'Mestrado_Profissionalizante' => $mestradosProfissionalizantes,
            'Doutorado' => $doutorados,
            'Residência_Médica' => $residenciasMedicas,
            'Livre_Docência' => $livreDocencias,
            'Pós-doutorado' => $posDoutorados,
            'GraduaçãoStatus' => $graduacoesStatus,
            'AperfeiçoamentoStatus' => $aperfeicoamentosStatus,
            'EspecializaçãoStatus' => $especializacaosStatus,
            'MestradoStatus' => $mestradosStatus,
            'Mestrado_ProfissionalizanteStatus' => $mestradosProfissionalizantesStatus,
            'DoutoradoStatus' => $doutoradosStatus,
            'Residência_MédicaStatus' => $residenciasMedicasStatus,
            'Pós-doutoradoStatus' => $posDoutoradosStatus,
        ];

        return response()->json($dados);
    }

    public function instituicao(Request $request) {
        $instituicao = $request->instituicao;
        $jsonurl = 'http://localhost:9000/gis/teachersFormationUniversityStatus/graduacoes';

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
                    $results = (object) json_decode($resposta)->results;
                    $graduacoesStatus = array();
                    foreach ($results as $graduacao) {
                        $graduacoesStatus[$graduacao->status_curso] = $graduacao->quantidade;
                    };
                    
                    $jsonurl = 'http://localhost:9000/gis/teachersFormationUniversityStatus/aperfeicoamentos';

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
                    $results = (object) json_decode($resposta)->results;
                    $aperfeicoamentosStatus = array();
                    foreach ($results as $graduacao) {
                        $aperfeicoamentosStatus[$graduacao->status_curso] = $graduacao->quantidade;
                    };
                    $jsonurl = 'http://localhost:9000/gis/teachersFormationUniversityStatus/especializacoes';

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
                    $results = (object) json_decode($resposta)->results;
                    $especializacaosStatus = array();
                    foreach ($results as $graduacao) {
                        $especializacaosStatus[$graduacao->status_curso] = $graduacao->quantidade;
                    };
        
                    $jsonurl = 'http://localhost:9000/gis/teachersFormationUniversityStatus/mestrados';

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
                    $results = (object) json_decode($resposta)->results;
                    $mestradosStatus = array();
                    foreach ($results as $graduacao) {
                        $mestradosStatus[$graduacao->status_curso] = $graduacao->quantidade;
                    };
                    $jsonurl = 'http://localhost:9000/gis/teachersFormationUniversityStatus/mestrados_profissionalizantes';

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
                    $results = (object) json_decode($resposta)->results;
                    $mestradosProfissionalizantesStatus = array();
                    foreach ($results as $graduacao) {
                        $mestradosProfissionalizantesStatus[$graduacao->status_curso] = $graduacao->quantidade;
                    };
        
                    $jsonurl = 'http://localhost:9000/gis/teachersFormationUniversityStatus/doutorados';

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
                    $results = (object) json_decode($resposta)->results;
                    $doutoradosStatus = array();
                    foreach ($results as $graduacao) {
                        $doutoradosStatus[$graduacao->status_curso] = $graduacao->quantidade;
                    };
        
                    $jsonurl = 'http://localhost:9000/gis/teachersFormationUniversityStatus/residencias_medicas';

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
                    $results = (object) json_decode($resposta)->results;
                    $residenciasMedicasStatus = array();
                    foreach ($results as $graduacao) {
                        $residenciasMedicasStatus[$graduacao->status_curso] = $graduacao->quantidade;
                    };
        
                    $jsonurl = 'http://localhost:9000/gis/teachersFormationUniversityStatus/pos_doutorados';

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
                    $results = (object) json_decode($resposta)->results;
                    $posDoutoradosStatus = array();
                    foreach ($results as $graduacao) {
                        $posDoutoradosStatus[$graduacao->status_curso] = $graduacao->quantidade;
                    };
        
        $dados = [
            'GraduaçãoStatus' => $graduacoesStatus,
            'AperfeiçoamentoStatus' => $aperfeicoamentosStatus,
            'EspecializaçãoStatus' => $especializacaosStatus,
            'MestradoStatus' => $mestradosStatus,
            'Mestrado_ProfissionalizanteStatus' => $mestradosProfissionalizantesStatus,
            'DoutoradoStatus' => $doutoradosStatus,
            'Residência_MédicaStatus' => $residenciasMedicasStatus,
            'Pós-doutoradoStatus' => $posDoutoradosStatus,
        ];

        return response()->json($dados);
    }

}
