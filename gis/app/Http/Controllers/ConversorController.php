<?php

namespace Gis\Http\Controllers;

use Carbon\Carbon;
use Geocoder\Laravel\Facades\Geocoder;
use Gis\Models\Aperfeicoamento;
use Gis\Models\AreaCurso;
use Gis\Models\ArtigoPublicado;
use Gis\Models\Autor;
use Gis\Models\CapituloDeLivroPublicado;
use Gis\Models\CentroFaculdade;
use Gis\Models\Curso;
use Gis\Models\CursoFaculdade;
use Gis\Models\Doutorado;
use Gis\Models\Especializacao;
use Gis\Models\Graduacao;
use Gis\Models\Idioma;
use Gis\Models\Instituicao;
use Gis\Models\Lattes;
use Gis\Models\LivreDocencia;
use Gis\Models\Mestrado;
use Gis\Models\MestradoProfissionalizante;
use Gis\Models\Coordenadas;
use Gis\Models\PalavraChave;
use Gis\Models\PosDoutorado;
use Gis\Models\Qualis;
use Gis\Models\ResidenciaMedica;
use Gis\Models\TrabalhoEmEvento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Gis\Helpers\XmlParser\XmlToArray;
use Illuminate\Support\Facades\Validator;

class ConversorController extends Controller
{

    public function index()
    {
        $pageTitle = "Conversão de Curriculos Lattes";

        $cursosAll = CursoFaculdade::with('centrosFaculdade')->get();

        $cursos = [];

        foreach ($cursosAll as $curso)
        {
            $cursos[$curso->id] = $curso->centrosFaculdade->sigla . ' - ' . $curso->nome;
        }

        return view('conversor.index', compact(['cursos', 'pageTitle']));
    }

    public function upload(Request $request)
    {
        $dataForm = $request->all();

        $rules = array(
            'files' => 'required|upload_count:files,10',
            'curso' => 'required',
        );

        $messages = [
            'mimes'         => 'O arquivo precisa ser no formato XML',
            'upload_count'  => 'Você pode converter no máximo 10 arquivos por vez',
        ];

        $countFiles = count($request->file('files')) - 1;

        foreach (range(0, $countFiles) as $index)
            $rules['files.' . $index] = 'mimes:xml|max:5000';

        $validation = Validator::make($dataForm, $rules, $messages);

        if ($validation->fails())
            return redirect()->back()->withErrors($validation->messages())->withInput($request->input());

        $files = $request->file('files');
        $curso = $request->curso;

        $errors = [];

        foreach ($files as $file)
            if (!ConversorController::converterArquivo($file, $curso))
                array_push($errors, $file->getClientOriginalName());

        if ($errors)
            return redirect()->back()->with('erro', 'erro')->withErrors($errors)->withInput($request->input());

        return redirect()->back()->with('sucesso', 'sucesso');
    }

    public function converterArquivo($file, $curso = null)
    {
        $data = file_get_contents($file);
        $xml = simplexml_load_string($data);

        return ConversorController::converter($xml, $curso);
    }

    public function converterTodos()
    {
        $url = 'http://127.0.0.1:8000/gis/public/uploads/curriculos/';

        $files = Storage::disk('curriculos')->files();

        foreach ($files as $file)
        {
            $data = file_get_contents($url . $file);
            $xml = simplexml_load_string($data);

            ConversorController::converter($xml);
        }

        $tipo = 'sucesso';
        $mensagem = "Convertidos com sucesso!";

        return view('mensagem', compact(['tipo', 'mensagem']));
    }

    public function converterTodosComCurso()
    {
        /*
         * Change php.ini
         * max_execution_time = 120
         * max_input_time = 60
         */

        $errors = [];

        $url = 'http://127.0.0.1:8000/gis/public/uploads/CurriculosComCurso/';

        $centros = Storage::disk('curriculosComCurso')->directories();

        foreach ($centros as $centro)
        {
            $cursos = Storage::disk('curriculosComCurso')->directories($centro);

            foreach ($cursos as $curso)
            {
                $arquivos = Storage::disk('curriculosComCurso')->files($curso);

                foreach ($arquivos as $arquivo)
                {
                    $data = file_get_contents($url . str_replace(' ', '%20', $arquivo));
                    $xml = simplexml_load_string($data);

                    $cursoNome = str_replace($centro . '/', '', $curso);

                    $cursoId = ConversorController::getCurso($cursoNome, $centro);

                    if (!ConversorController::converter($xml, $cursoId))
                        array_push($errors, str_replace($curso . '/', '', $arquivo));

                    Storage::disk('curriculosComCurso')->delete($arquivo);
                    unset($data);
                    unset($xml);
                }
            }
        }

        $arrayMensagem = ['tipo' => 'sucesso', 'mensagem' => 'Currículos convertidos com sucesso!'];

        if ($errors)
            $arrayMensagem = ['tipo' => 'observacao', 'mensagem' => 'Erro ao converter currículos!', 'submensagemlist' => $errors];

        return view('mensagem', compact(['arrayMensagem']));
    }

    public function importAreaCurso()
    {

    }

    public function converterAreaCurso()
    {
        $areaCursos = self::getCsvData('areacursos/areacursos.csv', ';');

        foreach ($areaCursos as $areaCurso) {
            AreaCurso::firstOrCreate($areaCurso);
            
        }

        $tipo = 'sucesso';
        $mensagem = "Área Cursos importados com sucesso!";

        return view('mensagem', compact(['tipo', 'mensagem']));
    }

    public function importQualis()
    {

    }

    public function converterQualis()
    {
        $dadosQualis = self::getCsvData('qualis/qualis1.csv', ';');

        foreach ($dadosQualis as $qualis) {
            Qualis::firstOrCreate($qualis);
        }

        $tipo = 'sucesso';
        $mensagem = "Qualis importado com sucesso!";

        return view('mensagem', compact(['tipo', 'mensagem']));
    }

    public static function getCsvData($fileName, $delimiter)
    {
        $fileName = public_path('uploads/' . $fileName);

        if (!file_exists($fileName) || !is_readable($fileName))
            return false;

        $header = null;
        $data = array();

        if (($handle = fopen($fileName, 'r')) !== false) {
            while (($row = fgetcsv($handle, 500, $delimiter)) !== false)
            {
                if (empty($row)) continue;

                if ($header) {
                    $row = array_map("utf8_encode", array_map("trim", $row));
                    $data[] = array_combine($header, $row);
                }
                else
                    $header = $row;
            }

            fclose($handle);

            //unlink($fileName);
        }

        return $data;
    }

    public function converter($xml, $curso = null)
    {
        $arrayData = XmlToArray::parser($xml);

        // Verifica currículo
        if (empty($arrayData['CURRICULO-VITAE']) || empty($arrayData['CURRICULO-VITAE']['@NUMERO-IDENTIFICADOR'])) return false;
        $arrayData = $arrayData['CURRICULO-VITAE'];

        // Dados Gerais
        $dadosLattes = [
            'id' => $arrayData['@NUMERO-IDENTIFICADOR'],
            'curso_faculdade_id' => $curso,
            'data_atualizacao' => $arrayData['@DATA-ATUALIZACAO'],
            'hora_atualizacao' => $arrayData['@HORA-ATUALIZACAO'],
            'nome_completo' => $arrayData['DADOS-GERAIS']['@NOME-COMPLETO'] ?? null,
            'nome_citacao' => $arrayData['DADOS-GERAIS']['@NOME-EM-CITACOES-BIBLIOGRAFICAS'] ?? null,
            'nacionalidade' => $arrayData['DADOS-GERAIS']['@NACIONALIDADE'] ?? null,
            'pais_nacimento' => $arrayData['DADOS-GERAIS']['@PAIS-DE-NASCIMENTO'] ?? null,
            'uf_nascimento' => $arrayData['DADOS-GERAIS']['@UF-NASCIMENTO'] ?? null,
            'cidade_nascimento' => $arrayData['DADOS-GERAIS']['@CIDADE-NASCIMENTO'] ?? null,
            'sigla_pais_nacionalidade' => $arrayData['DADOS-GERAIS']['@SIGLA-PAIS-NACIONALIDADE'] ?? null,
            'pais_nacionalidade' => $arrayData['DADOS-GERAIS']['@PAIS-DE-NACIONALIDADE'] ?? null,
            'resumo_cv' => $arrayData['DADOS-GERAIS']['RESUMO-CV']['@TEXTO-RESUMO-CV-RH'] ?? null,
            'resumo_cv_ingles' => $arrayData['DADOS-GERAIS']['RESUMO-CV']['@TEXTO-RESUMO-CV-RH-EN'] ?? null,
        ];

        $lattes = ConversorController::buscarLattes($dadosLattes);

        if ($lattes == null) return false;

        $lattesId = $lattes->id;

        // Idiomas
        $idiomas = [];

        $infoIdiomas = $arrayData['DADOS-GERAIS']['IDIOMAS']['IDIOMA'] ?? null;

        if (!empty($infoIdiomas) && is_array($infoIdiomas)) {
            if (is_string(reset($infoIdiomas))) $infoIdiomas = [$infoIdiomas];

            foreach ($infoIdiomas as $infoIdioma)
            {
                $dadosIdiomas = [
                    'idioma' => $infoIdioma['@IDIOMA'] ?? null,
                    'descricao_idioma' => $infoIdioma['@DESCRICAO-DO-IDIOMA'] ?? null,
                ];

                $idioma = Idioma::firstOrCreate($dadosIdiomas);

                $dadosIdiomaExtra = [
                    'leitura' => $infoIdioma['@PROFICIENCIA-DE-LEITURA'] ?? null,
                    'fala' => $infoIdioma['@PROFICIENCIA-DE-FALA'] ?? null,
                    'escrita' => $infoIdioma['@PROFICIENCIA-DE-ESCRITA'] ?? null,
                    'compreensao' => $infoIdioma['@PROFICIENCIA-DE-COMPREENSAO'] ?? null,
                ];

                $idiomas[$idioma->id] = $dadosIdiomaExtra;
            }

            $lattes->idiomas()->sync($idiomas);
        }

        // Fomação acadêmica titulação
        $titulacao = $arrayData['DADOS-GERAIS']['FORMACAO-ACADEMICA-TITULACAO'];

        // Graduações
        $infoGraduacoes = $titulacao['GRADUACAO'] ?? null;

        if (!empty($infoGraduacoes) && is_array($infoGraduacoes)) {
            if (is_string(reset($infoGraduacoes))) $infoGraduacoes = [$infoGraduacoes];

            foreach ($infoGraduacoes as $infoGraduacao)
            {
                $dadosGraduacao = [
                    'lattes_id' => $lattesId ?? null,
                    'sequencia_formacao' => $infoGraduacao['@SEQUENCIA-FORMACAO'] ?? null,
                    'nivel' => $infoGraduacao['@NIVEL'] ?? null,
                    'titulo_trabalho_conclusao' => $infoGraduacao['@TITULO-DO-TRABALHO-DE-CONCLUSAO-DE-CURSO'] ?? null,
                    'nome_orientador' => $infoGraduacao['@NOME-DO-ORIENTADOR'] ?? null,
                    'codigo_instituicao' => $infoGraduacao['@CODIGO-INSTITUICAO'] ?? null,
                    'nome_instituicao' => $infoGraduacao['@NOME-INSTITUICAO'] ?? null,
                    'codigo_orgao' => $infoGraduacao['@CODIGO-ORGAO'] ?? null,
                    'nome_orgao' => $infoGraduacao['@NOME-ORGAO'] ?? null,
                    'codigo_curso' => $infoGraduacao['@CODIGO-CURSO'] ?? null,
                    'nome_curso' => $infoGraduacao['@NOME-CURSO'] ?? null,
                    'codigo_area_curso' => $infoGraduacao['@CODIGO-AREA-CURSO'] ?? null,
                    'status_curso' => $infoGraduacao['@STATUS-DO-CURSO'] ?? null,
                    'ano_inicio' => $infoGraduacao['@ANO-DE-INICIO'] ?? null,
                    'ano_conclusao' => $infoGraduacao['@ANO-DE-CONCLUSAO'] ?? null,
                    'flag_bolsa' => $infoGraduacao['@FLAG-BOLSA'] ?? null,
                    'codigo_agencia' => $infoGraduacao['@CODIGO-AGENCIA-FINANCIADORA'] ?? null,
                    'nome_agencia' => $infoGraduacao['@NOME-AGENCIA'] ?? null,
                    'id_orientador' => $infoGraduacao['@NUMERO-ID-ORIENTADOR'] ?? null,
                    'codigo_curso_capes' => $infoGraduacao['@CODIGO-CURSO-CAPES'] ?? null,
                    'titulo_trabalho_conclusao_ingles' => $infoGraduacao['@TITULO-DO-TRABALHO-DE-CONCLUSAO-DE-CURSO-INGLES'] ?? null,
                    'nome_curso_ingles' => $infoGraduacao['@NOME-CURSO-INGLES'] ?? null,
                    'titulacao' => $infoGraduacao['@FORMACAO-ACADEMICA-TITULACAO'] ?? null,
                    'tipo_graduacao' => $infoGraduacao['@TIPO-GRADUACAO'] ?? null,
                    'codigo_instituicao_grad' => $infoGraduacao['@CODIGO-INSTITUICAO-GRAD'] ?? null,
                    'nome_instituicao_grad' => $infoGraduacao['@NOME-INSTITUICAO-GRAD'] ?? null,
                    'codigo_instituicao_outra_grad' => $infoGraduacao['@CODIGO-INSTITUICAO-OUTRA-GRAD'] ?? null,
                    'nome_instituicao_outra_grad' => $infoGraduacao['@NOME-INSTITUICAO-OUTRA-GRAD'] ?? null,
                    'nome_orientador_grad' => $infoGraduacao['@NOME-ORIENTADOR-GRAD'] ?? null,
                ];

                $graduacao = Graduacao::firstOrCreate($dadosGraduacao);

                $coordenadas = ConversorController::buscarCoordenadas($graduacao->nome_instituicao);
            }
        }

        // Aperfeiçoamentos
        $infoAperfeicoamentos = $titulacao['APERFEICOAMENTO'] ?? null;

        if (!empty($infoAperfeicoamentos) && is_array($infoAperfeicoamentos)) {
            if (is_string(reset($infoAperfeicoamentos))) $infoAperfeicoamentos = [$infoAperfeicoamentos];

            foreach ($infoAperfeicoamentos as $infoAperfeicoamento)
            {
                $dadosAperfeicoamento = [
                    'lattes_id' => $lattesId ?? null,
                    'sequencia_formacao' => $infoAperfeicoamento['@SEQUENCIA-FORMACAO'] ?? null,
                    'nivel' => $infoAperfeicoamento['@NIVEL'] ?? null,
                    'titulo_monografia' => $infoAperfeicoamento['@TITULO-DA-MONOGRAFIA'] ?? null,
                    'nome_orientador' => $infoAperfeicoamento['@NOME-DO-ORIENTADOR'] ?? null,
                    'codigo_instituicao' => $infoAperfeicoamento['@CODIGO-INSTITUICAO'] ?? null,
                    'nome_instituicao' => $infoAperfeicoamento['@NOME-INSTITUICAO'] ?? null,
                    'codigo_orgao' => $infoAperfeicoamento['@CODIGO-ORGAO'] ?? null,
                    'nome_orgao' => $infoAperfeicoamento['@NOME-ORGAO'] ?? null,
                    'codigo_curso' => $infoAperfeicoamento['@CODIGO-CURSO'] ?? null,
                    'nome_curso' => $infoAperfeicoamento['@NOME-CURSO'] ?? null,
                    'codigo_area_curso' => $infoAperfeicoamento['@CODIGO-AREA-CURSO'] ?? null,
                    'status_curso' => $infoAperfeicoamento['@STATUS-DO-CURSO'] ?? null,
                    'ano_inicio' => $infoAperfeicoamento['@ANO-DE-INICIO'] ?? null,
                    'ano_conclusao' => $infoAperfeicoamento['@ANO-DE-CONCLUSAO'] ?? null,
                    'flag_bolsa' => $infoAperfeicoamento['@FLAG-BOLSA'] ?? null,
                    'codigo_agencia' => $infoAperfeicoamento['@CODIGO-AGENCIA-FINANCIADORA'] ?? null,
                    'nome_agencia' => $infoAperfeicoamento['@NOME-AGENCIA'] ?? null,
                    'carga_horaria' => $infoAperfeicoamento['@CARGA-HORARIA'] ?? null,
                    'titulo_monografia_ingles' => $infoAperfeicoamento['@TITULO-DA-MONOGRAFIA-INGLES'] ?? null,
                    'nome_curso_ingles' => $infoAperfeicoamento['@NOME-CURSO-INGLES'] ?? null,
                ];

                $aperfeicoamento = Aperfeicoamento::firstOrCreate($dadosAperfeicoamento);

                $coordenadas = ConversorController::buscarCoordenadas($aperfeicoamento->nome_instituicao);
            }
        }

        // Especializações
        $infoEspecializacoes = $titulacao['ESPECIALIZACAO'] ?? null;

        if (!empty($infoEspecializacoes) && is_array($infoEspecializacoes)) {
            if (is_string(reset($infoEspecializacoes))) $infoEspecializacoes = [$infoEspecializacoes];

            foreach ($infoEspecializacoes as $infoEspecializacao)
            {
                $dadosEspecializacao = [
                    'lattes_id' => $lattesId ?? null,
                    'sequencia_formacao' => $infoEspecializacao['@SEQUENCIA-FORMACAO'] ?? null,
                    'nivel' => $infoEspecializacao['@NIVEL'] ?? null,
                    'titulo_monografia' => $infoEspecializacao['@TITULO-DA-MONOGRAFIA'] ?? null,
                    'nome_orientador' => $infoEspecializacao['@NOME-DO-ORIENTADOR'] ?? null,
                    'codigo_instituicao' => $infoEspecializacao['@CODIGO-INSTITUICAO'] ?? null,
                    'nome_instituicao' => $infoEspecializacao['@NOME-INSTITUICAO'] ?? null,
                    'codigo_orgao' => $infoEspecializacao['@CODIGO-ORGAO'] ?? null,
                    'nome_orgao' => $infoEspecializacao['@NOME-ORGAO'] ?? null,
                    'codigo_curso' => $infoEspecializacao['@CODIGO-CURSO'] ?? null,
                    'nome_curso' => $infoEspecializacao['@NOME-CURSO'] ?? null,
                    'status_curso' => $infoEspecializacao['@STATUS-DO-CURSO'] ?? null,
                    'ano_inicio' => $infoEspecializacao['@ANO-DE-INICIO'] ?? null,
                    'ano_conclusao' => $infoEspecializacao['@ANO-DE-CONCLUSAO'] ?? null,
                    'flag_bolsa' => $infoEspecializacao['@FLAG-BOLSA'] ?? null,
                    'codigo_agencia' => $infoEspecializacao['@CODIGO-AGENCIA-FINANCIADORA'] ?? null,
                    'nome_agencia' => $infoEspecializacao['@NOME-AGENCIA'] ?? null,
                    'carga_horaria' => $infoEspecializacao['@CARGA-HORARIA'] ?? null,
                    'titulo_monografia_ingles' => $infoEspecializacao['@TITULO-DA-MONOGRAFIA-INGLES'] ?? null,
                    'nome_curso_ingles' => $infoEspecializacao['@NOME-CURSO-INGLES'] ?? null,
                ];

                $especializacao = Especializacao::firstOrCreate($dadosEspecializacao);

                $coordenadas = ConversorController::buscarCoordenadas($especializacao->nome_instituicao);
            }
        }

        // Mestrados
        $infoMestrados = $titulacao['MESTRADO'] ?? null;

        if (!empty($infoMestrados) && is_array($infoMestrados)) {
            if (is_string(reset($infoMestrados))) $infoMestrados = [$infoMestrados];

            foreach ($infoMestrados as $infoMestrado)
            {
                $dadosMestrado = [
                    'lattes_id' => $lattesId ?? null,
                    'sequencia_formacao' => $infoMestrado['@SEQUENCIA-FORMACAO'] ?? null,
                    'nivel' => $infoMestrado['@NIVEL'] ?? null,
                    'codigo_instituicao' => $infoMestrado['@CODIGO-INSTITUICAO'] ?? null,
                    'nome_instituicao' => $infoMestrado['@NOME-INSTITUICAO'] ?? null,
                    'codigo_orgao' => $infoMestrado['@CODIGO-ORGAO'] ?? null,
                    'nome_orgao' => $infoMestrado['@NOME-ORGAO'] ?? null,
                    'codigo_curso' => $infoMestrado['@CODIGO-CURSO'] ?? null,
                    'nome_curso' => $infoMestrado['@NOME-CURSO'] ?? null,
                    'codigo_area_curso' => $infoMestrado['@CODIGO-AREA-CURSO'] ?? null,
                    'status_curso' => $infoMestrado['@STATUS-DO-CURSO'] ?? null,
                    'ano_inicio' => $infoMestrado['@ANO-DE-INICIO'] ?? null,
                    'ano_conclusao' => $infoMestrado['@ANO-DE-CONCLUSAO'] ?? null,
                    'flag_bolsa' => $infoMestrado['@FLAG-BOLSA'] ?? null,
                    'codigo_agencia' => $infoMestrado['@CODIGO-AGENCIA-FINANCIADORA'] ?? null,
                    'nome_agencia' => $infoMestrado['@NOME-AGENCIA'] ?? null,
                    'ano_obtencao_titulo' => $infoMestrado['@ANO-DE-OBTENCAO-DO-TITULO'] ?? null,
                    'titulo_dissertacao_tese' => $infoMestrado['@TITULO-DA-DISSERTACAO-TESE'] ?? null,
                    'nome_completo_orientador' => $infoMestrado['@NOME-COMPLETO-DO-ORIENTADOR'] ?? null,
                    'tipo_mestrado' => $infoMestrado['@TIPO-MESTRADO'] ?? null,
                    'id_orientador' => $infoMestrado['@NUMERO-ID-ORIENTADOR'] ?? null,
                    'codigo_curso_capes' => $infoMestrado['@CODIGO-CURSO-CAPES'] ?? null,
                    'titulo_dissertacao_tese_ingles' => $infoMestrado['@TITULO-DA-DISSERTACAO-TESE-INGLES'] ?? null,
                    'nome_curso_ingles' => $infoMestrado['@NOME-CURSO-INGLES'] ?? null,
                    'nome_co_orientador' => $infoMestrado['@NOME-DO-CO-ORIENTADOR'] ?? null,
                    'codigo_instituicao_dout' => $infoMestrado['@CODIGO-INSTITUICAO-DOUT'] ?? null,
                    'nome_instituicao_dout' => $infoMestrado['@NOME-INSTITUICAO-DOUT'] ?? null,
                    'codigo_instituicao_outra_dout' => $infoMestrado['@CODIGO-INSTITUICAO-OUTRA-DOUT'] ?? null,
                    'nome_instituicao_outra_dout' => $infoMestrado['@NOME-INSTITUICAO-OUTRA-DOUT'] ?? null,
                    'nome_orientador_dout' => $infoMestrado['@NOME-ORIENTADOR-DOUT'] ?? null,
                ];

                $mestrado = Mestrado::firstOrCreate($dadosMestrado);

                $coordenadas = ConversorController::buscarCoordenadas($mestrado->nome_instituicao);

                // Mestrado - Palavras Chave
                if (isset($infoMestrado['PALAVRAS-CHAVE'])) {
                    $palavras = ConversorController::buscarPalavrasChave($infoMestrado['PALAVRAS-CHAVE']);
                    $mestrado->palavrasChave()->sync($palavras);
                }
            }
        }

        // Mestrados Profissionalizantes
        $infoMestradosProfissionalizantes = $titulacao['MESTRADO-PROFISSIONALIZANTE'] ?? null;

        if (!empty($infoMestradosProfissionalizantes) && is_array($infoMestradosProfissionalizantes)) {
            if (is_string(reset($infoMestradosProfissionalizantes))) $infoMestradosProfissionalizantes = [$infoMestradosProfissionalizantes];

            foreach ($infoMestradosProfissionalizantes as $infoMestradosProfissionalizante)
            {
                $dadosMestradoProfissionalizante = [
                    'lattes_id' => $lattesId ?? null,
                    'sequencia_formacao' => $infoMestradosProfissionalizante['@SEQUENCIA-FORMACAO'] ?? null,
                    'nivel' => $infoMestradosProfissionalizante['@NIVEL'] ?? null,
                    'codigo_instituicao' => $infoMestradosProfissionalizante['@CODIGO-INSTITUICAO'] ?? null,
                    'nome_instituicao' => $infoMestradosProfissionalizante['@NOME-INSTITUICAO'] ?? null,
                    'codigo_orgao' => isset($infoMestradosProfissionalizante['@CODIGO-ORGAO']) ? $infoMestradosProfissionalizante['@CODIGO-ORGAO'] : null ?? null,
                    'nome_orgao' => isset($infoMestradosProfissionalizante['@NOME-ORGAO']) ? $infoMestradosProfissionalizante['@NOME-ORGAO'] : null ?? null,
                    'codigo_curso' => $infoMestradosProfissionalizante['@CODIGO-CURSO'] ?? null,
                    'nome_curso' => $infoMestradosProfissionalizante['@NOME-CURSO'] ?? null,
                    'codigo_area_curso' => $infoMestradosProfissionalizante['@CODIGO-AREA-CURSO'] ?? null,
                    'status_curso' => $infoMestradosProfissionalizante['@STATUS-DO-CURSO'] ?? null,
                    'ano_inicio' => $infoMestradosProfissionalizante['@ANO-DE-INICIO'] ?? null,
                    'ano_conclusao' => $infoMestradosProfissionalizante['@ANO-DE-CONCLUSAO'] ?? null,
                    'flag_bolsa' => $infoMestradosProfissionalizante['@FLAG-BOLSA'] ?? null,
                    'codigo_agencia' => $infoMestradosProfissionalizante['@CODIGO-AGENCIA-FINANCIADORA'] ?? null,
                    'nome_agencia' => $infoMestradosProfissionalizante['@NOME-AGENCIA'] ?? null,
                    'ano_obtencao_titulo' => $infoMestradosProfissionalizante['@ANO-DE-OBTENCAO-DO-TITULO'] ?? null,
                    'titulo_dissertacao_tese' => $infoMestradosProfissionalizante['@TITULO-DA-DISSERTACAO-TESE'] ?? null,
                    'nome_completo_orientador' => $infoMestradosProfissionalizante['@NOME-COMPLETO-DO-ORIENTADOR'] ?? null,
                    'id_orientador' => $infoMestradosProfissionalizante['@NUMERO-ID-ORIENTADOR'] ?? null,
                    'codigo_curso_capes' => $infoMestradosProfissionalizante['@CODIGO-CURSO-CAPES'] ?? null,
                    'titulo_dissertacao_tese_ingles' => $infoMestradosProfissionalizante['@TITULO-DA-DISSERTACAO-TESE-INGLES'] ?? null,
                    'nome_curso_ingles' => $infoMestradosProfissionalizante['@NOME-CURSO-INGLES'] ?? null,
                    'nome_co_orientador' => $infoMestradosProfissionalizante['@NOME-DO-CO-ORIENTADOR'] ?? null,
                ];

                $mestradoProfissionalizante = MestradoProfissionalizante::firstOrCreate($dadosMestradoProfissionalizante);

                $coordenadas = ConversorController::buscarCoordenadas($mestradoProfissionalizante->nome_instituicao);

                // Mestrado Profissionalizante - Palavras Chave
                if (isset($infoMestradosProfissionalizante['PALAVRAS-CHAVE'])) {
                    $palavras = ConversorController::buscarPalavrasChave($infoMestradosProfissionalizante['PALAVRAS-CHAVE']);
                    $mestradoProfissionalizante->palavrasChave()->sync($palavras);
                }
            }
        }

        // Doutorados
        $infoDoutorados = $titulacao['DOUTORADO'] ?? null;

        if (!empty($infoDoutorados) && is_array($infoDoutorados)) {
            if (is_string(reset($infoDoutorados))) $infoDoutorados = [$infoDoutorados];

            foreach ($infoDoutorados as $infoDoutorado)
            {
                $dadosDoutorado = [
                    'lattes_id' => $lattesId ?? null,
                    'sequencia_formacao' => $infoDoutorado['@SEQUENCIA-FORMACAO'] ?? null,
                    'nivel' => $infoDoutorado['@NIVEL'] ?? null,
                    'codigo_instituicao' => $infoDoutorado['@CODIGO-INSTITUICAO'] ?? null,
                    'nome_instituicao' => $infoDoutorado['@NOME-INSTITUICAO'] ?? null,
                    'codigo_orgao' => $infoDoutorado['@CODIGO-ORGAO'] ?? null,
                    'nome_orgao' => $infoDoutorado['@NOME-ORGAO'] ?? null,
                    'codigo_curso' => $infoDoutorado['@CODIGO-CURSO'] ?? null,
                    'nome_curso' => $infoDoutorado['@NOME-CURSO'] ?? null,
                    'codigo_area_curso' => $infoDoutorado['@CODIGO-AREA-CURSO'] ?? null,
                    'status_curso' => $infoDoutorado['@STATUS-DO-CURSO'] ?? null,
                    'ano_inicio' => $infoDoutorado['@ANO-DE-INICIO'] ?? null,
                    'ano_conclusao' => $infoDoutorado['@ANO-DE-CONCLUSAO'] ?? null,
                    'flag_bolsa' => $infoDoutorado['@FLAG-BOLSA'] ?? null,
                    'codigo_agencia' => $infoDoutorado['@CODIGO-AGENCIA-FINANCIADORA'] ?? null,
                    'nome_agencia' => $infoDoutorado['@NOME-AGENCIA'] ?? null,
                    'ano_obtencao_titulo' => $infoDoutorado['@ANO-DE-OBTENCAO-DO-TITULO'] ?? null,
                    'titulo_dissertacao_tese' => $infoDoutorado['@TITULO-DA-DISSERTACAO-TESE'] ?? null,
                    'nome_completo_orientador' => $infoDoutorado['@NOME-COMPLETO-DO-ORIENTADOR'] ?? null,
                    'tipo_doutorado' => $infoDoutorado['@TIPO-DOUTORADO'] ?? null,
                    'codigo_instituicao_dout' => $infoDoutorado['@CODIGO-INSTITUICAO-DOUT'] ?? null,
                    'nome_instituicao_dout' => $infoDoutorado['@NOME-INSTITUICAO-DOUT'] ?? null,
                    'codigo_instituicao_outra_dout' => $infoDoutorado['@CODIGO-INSTITUICAO-OUTRA-DOUT'] ?? null,
                    'nome_instituicao_outra_dout' => $infoDoutorado['@NOME-INSTITUICAO-OUTRA-DOUT'] ?? null,
                    'nome_orientador_dout' => $infoDoutorado['@NOME-ORIENTADOR-DOUT'] ?? null,
                    'id_orientador' => $infoDoutorado['@NUMERO-ID-ORIENTADOR'] ?? null,
                    'codigo_curso_capes' => $infoDoutorado['@CODIGO-CURSO-CAPES'] ?? null,
                    'titulo_dissertacao_tese_ingles' => $infoDoutorado['@TITULO-DA-DISSERTACAO-TESE-INGLES'] ?? null,
                    'nome_curso_ingles' => $infoDoutorado['@NOME-CURSO-INGLES'] ?? null,
                    'nome_orientador_co_tutela' => $infoDoutorado['@NOME-DO-ORIENTADOR-CO-TUTELA'] ?? null,
                    'codigo_instituicao_outra_co_tutela' => $infoDoutorado['@CODIGO-INSTITUICAO-OUTRA-CO-TUTELA'] ?? null,
                    'codigo_instituicao_co_tutela' => $infoDoutorado['@CODIGO-INSTITUICAO-CO-TUTELA'] ?? null,
                    'nome_orientador_sanduiche' => $infoDoutorado['@NOME-DO-ORIENTADOR-SANDUICHE'] ?? null,
                    'codigo_instituicao_outra_sanduiche' => $infoDoutorado['@CODIGO-INSTITUICAO-OUTRA-SANDUICHE'] ?? null,
                    'codigo_instituicao_sanduiche' => $infoDoutorado['@CODIGO-INSTITUICAO-SANDUICHE'] ?? null,
                    'nome_co_orientador' => $infoDoutorado['@NOME-DO-CO-ORIENTADOR'] ?? null,
                ];

                $doutorado = Doutorado::firstOrCreate($dadosDoutorado);

                $coordenadas = ConversorController::buscarCoordenadas($doutorado->nome_instituicao);

                // Doutorado - Palavras Chave
                if (isset($infoDoutorado['PALAVRAS-CHAVE'])) {
                    $palavras = ConversorController::buscarPalavrasChave($infoDoutorado['PALAVRAS-CHAVE']);
                    $doutorado->palavrasChave()->sync($palavras);
                }
            }
        }

        // Residencias Medicas
        $infoResidenciasMedicas = $titulacao['RESIDENCIA-MEDICA'] ?? null;

        if (!empty($infoResidenciasMedicas) && is_array($infoResidenciasMedicas)) {
            if (is_string(reset($infoResidenciasMedicas))) $infoResidenciasMedicas = [$infoResidenciasMedicas];

            foreach ($infoResidenciasMedicas as $infoResidenciaMedica)
            {
                $dadosResidenciaMedica = [
                    'lattes_id' => $lattesId ?? null,
                    'sequencia_formacao' => $infoResidenciaMedica['@SEQUENCIA-FORMACAO'] ?? null,
                    'nivel' => $infoResidenciaMedica['@NIVEL'] ?? null,
                    'codigo_instituicao' => $infoResidenciaMedica['@CODIGO-INSTITUICAO'] ?? null,
                    'nome_instituicao' => $infoResidenciaMedica['@NOME-INSTITUICAO'] ?? null,
                    'status_curso' => $infoResidenciaMedica['@STATUS-DO-CURSO'] ?? null,
                    'ano_inicio' => $infoResidenciaMedica['@ANO-DE-INICIO'] ?? null,
                    'ano_conclusao' => $infoResidenciaMedica['@ANO-DE-CONCLUSAO'] ?? null,
                    'flag_bolsa' => $infoResidenciaMedica['@FLAG-BOLSA'] ?? null,
                    'codigo_agencia' => $infoResidenciaMedica['@CODIGO-AGENCIA-FINANCIADORA'] ?? null,
                    'nome_agencia' => $infoResidenciaMedica['@NOME-AGENCIA'] ?? null,
                    'titulo_residencia_medica' => $infoResidenciaMedica['@TITULO-DA-RESIDENCIA-MEDICA'] ?? null,
                    'numero_registro' => $infoResidenciaMedica['@NUMERO-DO-REGISTRO'] ?? null,
                    'titulo_residencia_medica_ingles' => $infoResidenciaMedica['@TITULO-DA-RESIDENCIA-MEDICA-INGLES'] ?? null,
                ];

                $residenciaMedica = ResidenciaMedica::firstOrCreate($dadosResidenciaMedica);

                $coordenadas = ConversorController::buscarCoordenadas($residenciaMedica->nome_instituicao);

                // Residencia Medica - Palavras Chave
                if (isset($infoResidenciaMedica['PALAVRAS-CHAVE'])) {
                    $palavras = ConversorController::buscarPalavrasChave($infoResidenciaMedica['PALAVRAS-CHAVE']);
                    $residenciaMedica->palavrasChave()->sync($palavras);
                }
            }
        }

        // Livre Docencias
        $infoLivreDocencias = $titulacao['LIVRE-DOCENCIA'] ?? null;

        if (!empty($infoLivreDocencias) && is_array($infoLivreDocencias)) {
            if (is_string(reset($infoLivreDocencias))) $infoLivreDocencias = [$infoLivreDocencias];

            foreach ($infoLivreDocencias as $infoLivreDocencia)
            {
                $dadosLivreDocencia = [
                    'lattes_id' => $lattesId ?? null,
                    'sequencia_formacao' => $infoLivreDocencia['@SEQUENCIA-FORMACAO'] ?? null,
                    'nivel' => $infoLivreDocencia['@NIVEL'] ?? null,
                    'codigo_instituicao' => $infoLivreDocencia['@CODIGO-INSTITUICAO'] ?? null,
                    'nome_instituicao' => $infoLivreDocencia['@NOME-INSTITUICAO'] ?? null,
                    'ano_obtencao_titulo' => $infoLivreDocencia['@ANO-DE-OBTENCAO-DO-TITULO'] ?? null,
                    'titulo_trabalho' => $infoLivreDocencia['@TITULO-DO-TRABALHO'] ?? null,
                    'titulo_trabalho_ingles' => $infoLivreDocencia['@TITULO-DO-TRABALHO-INGLES'] ?? null,
                ];

                $livreDocencia = LivreDocencia::firstOrCreate($dadosLivreDocencia);

                $coordenadas = ConversorController::buscarCoordenadas($livreDocencia->nome_instituicao);

                // Livre Docencia - Palavras Chave
                if (isset($infoLivreDocencia['PALAVRAS-CHAVE'])) {
                    $palavras = ConversorController::buscarPalavrasChave($infoLivreDocencia['PALAVRAS-CHAVE']);
                    $livreDocencia->palavrasChave()->sync($palavras);
                }
            }
        }

        // Pos-Doutorados
        $infoPosDoutorados = $titulacao['POS-DOUTORADO'] ?? null;

        if (!empty($infoPosDoutorados) && is_array($infoPosDoutorados)) {
            if (is_string(reset($infoPosDoutorados))) $infoPosDoutorados = [$infoPosDoutorados];

            foreach ($infoPosDoutorados as $infoPosDoutorado)
            {
                $dadosPosDoutorado = [
                    'lattes_id' => $lattesId ?? null,
                    'sequencia_formacao' => $infoPosDoutorado['@SEQUENCIA-FORMACAO'] ?? null,
                    'nivel' => $infoPosDoutorado['@NIVEL'] ?? null,
                    'codigo_instituicao' => $infoPosDoutorado['@CODIGO-INSTITUICAO'] ?? null,
                    'nome_instituicao' => $infoPosDoutorado['@NOME-INSTITUICAO'] ?? null,
                    'ano_inicio' => $infoPosDoutorado['@ANO-DE-INICIO'] ?? null,
                    'ano_conclusao' => $infoPosDoutorado['@ANO-DE-CONCLUSAO'] ?? null,
                    'ano_obtencao_titulo' => $infoPosDoutorado['@ANO-DE-OBTENCAO-DO-TITULO'] ?? null,
                    'flag_bolsa' => $infoPosDoutorado['@FLAG-BOLSA'] ?? null,
                    'codigo_agencia' => $infoPosDoutorado['@CODIGO-AGENCIA-FINANCIADORA'] ?? null,
                    'nome_agencia' => $infoPosDoutorado['@NOME-AGENCIA'] ?? null,
                    'status_estagio' => $infoPosDoutorado['@STATUS-DO-ESTAGIO'] ?? null,
                    'status_curso' => $infoPosDoutorado['@STATUS-DO-CURSO'] ?? null,
                    'id_orientador' => $infoPosDoutorado['@NUMERO-ID-ORIENTADOR'] ?? null,
                    'codigo_curso_capes' => $infoPosDoutorado['@CODIGO-CURSO-CAPES'] ?? null,
                    'titulo_trabalho' => $infoPosDoutorado['@TITULO-DO-TRABALHO'] ?? null,
                    'titulo_trabalho_ingles' => $infoPosDoutorado['@TITULO-DO-TRABALHO-INGLES'] ?? null,
                    'nome_curso_ingles' => $infoPosDoutorado['@NOME-CURSO-INGLES'] ?? null,
                ];

                $posDoutorado = PosDoutorado::firstOrCreate($dadosPosDoutorado);

                $coordenadas = ConversorController::buscarCoordenadas($posDoutorado->nome_instituicao);

                // Pos-Doutorado - Palavras Chave
                if (isset($infoPosDoutorado['PALAVRAS-CHAVE'])) {
                    $palavras = ConversorController::buscarPalavrasChave($infoPosDoutorado['PALAVRAS-CHAVE']);
                    $posDoutorado->palavrasChave()->sync($palavras);
                }
            }
        }

        // Trabalhos em Eventos
        $producaoBibliografica = $arrayData['PRODUCAO-BIBLIOGRAFICA'] ?? null;

        $infoTrabalhosEventos = $producaoBibliografica['TRABALHOS-EM-EVENTOS']['TRABALHO-EM-EVENTOS'] ?? null;

        if (!empty($infoTrabalhosEventos) && is_array($infoTrabalhosEventos)) {
            if (is_string(reset($infoTrabalhosEventos))) $infoTrabalhosEventos = [$infoTrabalhosEventos];

            foreach ($infoTrabalhosEventos as $infoTrabalhoEmEvento) {
                $dadosTrabalhoEvento = [
                    'lattes_id' => $lattesId ?? null,
                    'natureza' => $infoTrabalhoEmEvento['DADOS-BASICOS-DO-TRABALHO']['@NATUREZA'] ?? null,
                    'titulo' => $infoTrabalhoEmEvento['DADOS-BASICOS-DO-TRABALHO']['@TITULO-DO-TRABALHO'] ?? null,
                    'titulo_ingles' => $infoTrabalhoEmEvento['DADOS-BASICOS-DO-TRABALHO']['@TITULO-DO-TRABALHO-INGLES'] ?? null,
                    'ano' => $infoTrabalhoEmEvento['DADOS-BASICOS-DO-TRABALHO']['@ANO-DO-TRABALHO'] ?? null,
                    'pais' => $infoTrabalhoEmEvento['DADOS-BASICOS-DO-TRABALHO']['@PAIS-DO-EVENTO'] ?? null,
                    'idioma' => $infoTrabalhoEmEvento['DADOS-BASICOS-DO-TRABALHO']['@IDIOMA'] ?? null,
                    'meio_divulgacao' => $infoTrabalhoEmEvento['DADOS-BASICOS-DO-TRABALHO']['@MEIO-DE-DIVULGACAO'] ?? null,
                    'flag_relevancia' => $infoTrabalhoEmEvento['DADOS-BASICOS-DO-TRABALHO']['@FLAG-RELEVANCIA'] ?? null,
                    'flag_divulgacao_cientifica' => $infoTrabalhoEmEvento['DADOS-BASICOS-DO-TRABALHO']['@FLAG-DIVULGACAO-CIENTIFICA'] ?? null,
                    'classificacao_evento' => $infoTrabalhoEmEvento['DETALHAMENTO-DO-TRABALHO']['@CLASSIFICACAO-DO-EVENTO'] ?? null,
                    'nome_evento' => $infoTrabalhoEmEvento['DETALHAMENTO-DO-TRABALHO']['@NOME-DO-EVENTO'] ?? null,
                    'nome_evento_ingles' => $infoTrabalhoEmEvento['DETALHAMENTO-DO-TRABALHO']['@NOME-DO-EVENTO-INGLES'] ?? null,
                    'cidade_evento' => $infoTrabalhoEmEvento['DETALHAMENTO-DO-TRABALHO']['@CIDADE-DO-EVENTO'] ?? null,
                    'ano_evento' => $infoTrabalhoEmEvento['DETALHAMENTO-DO-TRABALHO']['@ANO-DE-REALIZACAO'] ?? null,
                    'titulo_anais_ou_proceedings' => $infoTrabalhoEmEvento['DETALHAMENTO-DO-TRABALHO']['@TITULO-DOS-ANAIS-OU-PROCEEDINGS'] ?? null,
                    'volume' => $infoTrabalhoEmEvento['DETALHAMENTO-DO-TRABALHO']['@VOLUME'] ?? null,
                    'fasciculo' => $infoTrabalhoEmEvento['DETALHAMENTO-DO-TRABALHO']['@FASCICULO'] ?? null,
                    'serie' => $infoTrabalhoEmEvento['DETALHAMENTO-DO-TRABALHO']['@SERIE'] ?? null,
                    'pagina_inicial' => $infoTrabalhoEmEvento['DETALHAMENTO-DO-TRABALHO']['@PAGINA-INICIAL'] ?? null,
                    'pagina_final' => $infoTrabalhoEmEvento['DETALHAMENTO-DO-TRABALHO']['@PAGINA-FINAL'] ?? null,
                    'isbn' => $infoTrabalhoEmEvento['DETALHAMENTO-DO-TRABALHO']['@ISBN'] ?? null,
                    'nome_editora' => $infoTrabalhoEmEvento['DETALHAMENTO-DO-TRABALHO']['@NOME-DA-EDITORA'] ?? null,
                    'cidade_editora' => $infoTrabalhoEmEvento['DETALHAMENTO-DO-TRABALHO']['@CIDADE-DA-EDITORA'] ?? null,
                ];

                $trabalho = TrabalhoEmEvento::firstOrCreate($dadosTrabalhoEvento);

                $coordenadas = ConversorController::buscarCoordenadas($trabalho->coordenadas_nome);

                // Trabalho em Evento - Palavras Chave
                if (isset($infoTrabalhoEmEvento['PALAVRAS-CHAVE'])) {
                    $palavras = ConversorController::buscarPalavrasChave($infoTrabalhoEmEvento['PALAVRAS-CHAVE']);
                    $trabalho->palavrasChave()->sync($palavras);
                }

                // Trabalho em Eventos - Autores
                $autores = [];

                $infoAutores = $infoTrabalhoEmEvento['AUTORES'];

                if (!empty($infoAutores) && is_array($infoAutores)) {
                    if (is_string(reset($infoAutores))) $infoAutores = [$infoAutores];

                    foreach ($infoAutores as $infoAutor) {
                        $dadosAutor = [
                            'nome_completo' => $infoAutor['@NOME-COMPLETO-DO-AUTOR'] ?? null,
                            'nome_citacao' => $infoAutor['@NOME-PARA-CITACAO'] ?? null,
                            'id_cnpq' => $infoAutor['@NRO-ID-CNPQ'] ?? null,
                        ];

                        $autor = ConversorController::buscarAutor($dadosAutor);

                        $autores[$autor->id] = ['ordem_autoria' => $infoAutor['@ORDEM-DE-AUTORIA']];
                    }
                }

                $trabalho->autores()->sync($autores);
            }
        }

        // Artigos Publicados
        $infoArtigosPublicados = $producaoBibliografica['ARTIGOS-PUBLICADOS']['ARTIGO-PUBLICADO'] ?? null;

        if (!empty($infoArtigosPublicados) && is_array($infoArtigosPublicados)) {
            if (is_string(reset($infoArtigosPublicados))) $infoArtigosPublicados = [$infoArtigosPublicados];

            foreach ($infoArtigosPublicados as $infoArtigoPublicado)
            {
                $dadosArtigoPublicado = [
                    'lattes_id' => $lattesId ?? null,
                    'natureza' => $infoArtigoPublicado['DADOS-BASICOS-DO-ARTIGO']['@NATUREZA'] ?? null,
                    'titulo_do_artigo' => $infoArtigoPublicado['DADOS-BASICOS-DO-ARTIGO']['@TITULO-DO-ARTIGO'] ?? null,
                    'titulo_do_artigo_ingles' => $infoArtigoPublicado['DADOS-BASICOS-DO-ARTIGO']['@TITULO-DO-ARTIGO-INGLE'] ?? null,
                    'ano_do_artigo' => $infoArtigoPublicado['DADOS-BASICOS-DO-ARTIGO']['@ANO-DO-ARTIGO'] ?? null,
                    'pais_de_publicacao' => $infoArtigoPublicado['DADOS-BASICOS-DO-ARTIGO']['@PAIS-DE-PUBLICACA'] ?? null,
                    'idioma' => $infoArtigoPublicado['DADOS-BASICOS-DO-ARTIGO']['@IDIOMA'] ?? null,
                    'meio_de_divulgacao' => $infoArtigoPublicado['DADOS-BASICOS-DO-ARTIGO']['@MEIO-DE-DIVULGACAO'] ?? null,
                    'flag_relevancia' => $infoArtigoPublicado['DADOS-BASICOS-DO-ARTIGO']['@FLAG-RELEVANCIA'] ?? null,
                    'flag_divulgacao_cientifica' => $infoArtigoPublicado['DADOS-BASICOS-DO-ARTIGO']['@FLAG-DIVULGACAO-CIENTIFICA'] ?? null,
                    'titulo_periodico_revista' => $infoArtigoPublicado['DETALHAMENTO-DO-ARTIGO']['@TITULO-DO-PERIODICO-OU-REVISTA'] ?? null,
                    'issn' => $infoArtigoPublicado['DETALHAMENTO-DO-ARTIGO']['@ISSN'] ?? null,
                    'volume' => $infoArtigoPublicado['DETALHAMENTO-DO-ARTIGO']['@VOLUME'] ?? null,
                    'fasciculo' => $infoArtigoPublicado['DETALHAMENTO-DO-ARTIGO']['@FASCICULO'] ?? null,
                    'pagina_inicial' => $infoArtigoPublicado['DETALHAMENTO-DO-ARTIGO']['@PAGINA-INICIAL'] ?? null,
                    'pagina_final' => $infoArtigoPublicado['DETALHAMENTO-DO-ARTIGO']['@PAGINA-FINAL'] ?? null,
                    'local_publicacao' => $infoArtigoPublicado['DETALHAMENTO-DO-ARTIGO']['@LOCAL-DE-PUBLICACAO'] ?? null,
                ];

                $artigoPublicado = ArtigoPublicado::firstOrCreate($dadosArtigoPublicado);

                $coordenadas = ConversorController::buscarCoordenadas($artigoPublicado->pais);


                // Artigo Publicado - Palavras Chave
                if (isset($infoArtigoPublicado['PALAVRAS-CHAVE'])) {
                    $palavras = ConversorController::buscarPalavrasChave($infoArtigoPublicado['PALAVRAS-CHAVE']);
                    $artigoPublicado->palavrasChave()->sync($palavras);
                }

                // Aritgo Publicado - Autores
                $autores = [];

                $infoAutores = $infoArtigoPublicado['AUTORES'];

                if (!empty($infoAutores) && is_array($infoAutores)) {
                    if (is_string(reset($infoAutores))) $infoAutores = [$infoAutores];

                    foreach ($infoAutores as $infoAutor) {
                        $dadosAutor = [
                            'nome_completo' => $infoAutor['@NOME-COMPLETO-DO-AUTOR'] ?? null,
                            'nome_citacao' => $infoAutor['@NOME-PARA-CITACAO'] ?? null,
                            'id_cnpq' => $infoAutor['@NRO-ID-CNPQ'] ?? null,
                        ];

                        $autor = ConversorController::buscarAutor($dadosAutor);

                        $autores[$autor->id] = ['ordem_autoria' => $infoAutor['@ORDEM-DE-AUTORIA']];
                    }
                }

                $artigoPublicado->autores()->sync($autores);
            }
        }

        // Capitulo de Livro Publicados
        $infoCapDeLivrosPub = $producaoBibliografica['LIVROS-E-CAPITULOS']['CAPITULOS-DE-LIVROS-PUBLICADOS']['CAPITULO-DE-LIVRO-PUBLICADO'] ?? null;

        if (!empty($infoCapDeLivrosPub) && is_array($infoCapDeLivrosPub)) {
            if (is_string(reset($infoCapDeLivrosPub))) $infoCapDeLivrosPub = [$infoCapDeLivrosPub];

            foreach ($infoCapDeLivrosPub as $infoCapDeLivroPub) {
                $dadosCapDeLivrosPub = [
                    'lattes_id' => $lattesId ?? null,
                    'tipo' => $infoCapDeLivroPub['DADOS-BASICOS-DO-CAPITULO']['@TIPO'] ?? null,
                    'titulo_do_capitulo_do_livro' => $infoCapDeLivroPub['DADOS-BASICOS-DO-CAPITULO']['@TITULO-DO-CAPITULO-DO-LIVRO'] ?? null,
                    'ano' => $infoCapDeLivroPub['DADOS-BASICOS-DO-CAPITULO']['@ANO'] ?? null,
                    'pais_de_publicacao' => $infoCapDeLivroPub['DADOS-BASICOS-DO-CAPITULO']['@PAIS-DE-PUBLICACAO'] ?? null,
                    'idioma' => $infoCapDeLivroPub['DADOS-BASICOS-DO-CAPITULO']['@IDIOMA'] ?? null,
                    'meio_de_divulgacao' => $infoCapDeLivroPub['DADOS-BASICOS-DO-CAPITULO']['@MEIO-DE-DIVULGACAO'] ?? null,
                    'flag_relevancia' => $infoCapDeLivroPub['DADOS-BASICOS-DO-CAPITULO']['@FLAG-RELEVANCIA'] ?? null,
                    'flag_divulgacao_cientifica' => $infoCapDeLivroPub['DADOS-BASICOS-DO-CAPITULO']['@FLAG-DIVULGACAO-CIENTIFICA'] ?? null,
                    'titulo_do_livro' => $infoCapDeLivroPub['DETALHAMENTO-DO-CAPITULO']['@TITULO-DO-LIVRO'] ?? null,
                    'cidade_da_editora' => $infoCapDeLivroPub['DETALHAMENTO-DO-CAPITULO']['@CIDADE-DA-EDITORA'] ?? null,
                    'nome_da_editora' => $infoCapDeLivroPub['DETALHAMENTO-DO-CAPITULO']['@NOME-DA-EDITORA'] ?? null,
                ];

                $capDeLivroPub = CapituloDeLivroPublicado::firstOrCreate($dadosCapDeLivrosPub);

                $coordenadas = ConversorController::buscarCoordenadas($capDeLivroPub->pais);

                // Cap de Livros Pub - Palavras Chave
                if (isset($infoCapDeLivroPub['PALAVRAS-CHAVE'])) {
                    $palavras = ConversorController::buscarPalavrasChave($infoCapDeLivroPub['PALAVRAS-CHAVE']);
                    $capDeLivroPub->palavrasChave()->sync($palavras);
                }

                // Cap de Livros Pub - Autores
                $autores = [];

                $infoAutores = $infoCapDeLivroPub['AUTORES'];

                if (!empty($infoAutores) && is_array($infoAutores)) {
                    if (is_string(reset($infoAutores))) $infoAutores = [$infoAutores];

                    foreach ($infoAutores as $infoAutor) {
                        $dadosAutor = [
                            'nome_completo' => $infoAutor['@NOME-COMPLETO-DO-AUTOR'] ?? null,
                            'nome_citacao' => $infoAutor['@NOME-PARA-CITACAO'] ?? null,
                            'id_cnpq' => $infoAutor['@NRO-ID-CNPQ'] ?? null,
                        ];

                        $autor = ConversorController::buscarAutor($dadosAutor);

                        $autores[$autor->id] = ['ordem_autoria' => $infoAutor['@ORDEM-DE-AUTORIA']];
                    }
                }

                $capDeLivroPub->autores()->sync($autores);
            }
        }

        // Instituições
        $infoInstituicoes = $arrayData['DADOS-COMPLEMENTARES']['INFORMACOES-ADICIONAIS-INSTITUICOES']['INFORMACAO-ADICIONAL-INSTITUICAO'] ?? null;

        if (!empty($infoInstituicoes) && is_array($infoInstituicoes)) {
            if (is_string(reset($infoInstituicoes))) $infoInstituicoes = [$infoInstituicoes];

            foreach ($infoInstituicoes as $infoInstituicao)
            {
                $dadosInstituicao = [
                    'id' => $infoInstituicao['@CODIGO-INSTITUICAO'] ?? null,
                    'sigla' => $infoInstituicao['@SIGLA-INSTITUICAO'] ?? null,
                    'sigla_uf' => $infoInstituicao['@SIGLA-UF-INSTITUICAO'] ?? null,
                    'sigla_pais' => $infoInstituicao['@SIGLA-PAIS-INSTITUICAO'] ?? null,
                    'nome_pais' => $infoInstituicao['@NOME-PAIS-INSTITUICAO'] ?? null,
                    'flag_instituicao_ensino' => $infoInstituicao['@FLAG-INSTITUICAO-DE-ENSINO'] ?? null,
                ];

                if ($dadosInstituicao['id'] != null)
                    $instituicao = ConversorController::buscarInstituicao($dadosInstituicao);
            }
        }

        // Cursos
        $infoCursos = $arrayData['DADOS-COMPLEMENTARES']['INFORMACOES-ADICIONAIS-CURSOS']['INFORMACAO-ADICIONAL-CURSO'] ?? null;

        if (!empty($infoCursos) && is_array($infoCursos)) {
            if (is_string(reset($infoCursos))) $infoCursos = [$infoCursos];

            foreach ($infoCursos as $infoCurso)
            {
                $dadosCurso = [
                    'id' => $infoCurso['@CODIGO-CURSO'] ?? null,
                    'codigo_orgao' => $infoCurso['@CODIGO-ORGAO'] ?? null,
                    'nome_orgao' => $infoCurso['@NOME-ORGAO'] ?? null,
                    'codigo_instituicao' => $infoCurso['@CODIGO-INSTITUICAO'] ?? null,
                    'nome_instituicao' => $infoCurso['@NOME-INSTITUICAO'] ?? null,
                    'grande_area_conhecimento' => $infoCurso['@NOME-GRANDE-AREA-DO-CONHECIMENTO'] ?? null,
                    'area_conhecimento' => $infoCurso['@NOME-DA-AREA-DO-CONHECIMENTO'] ?? null,
                    'sub_area_conhecimento' => $infoCurso['@NOME-DA-SUB-AREA-DO-CONHECIMENTO'] ?? null,
                    'especialidade' => $infoCurso['@NOME-DA-ESPECIALIDADE'] ?? null,
                    'nivel_curso' => $infoCurso['@NIVEL-CURSO'] ?? null,
                ];

                if ($dadosCurso['id'] != null)
                    $curso = ConversorController::buscarCurso($dadosCurso);
            }
        }

        // Conclusão da adição de currículo
        return true;
    }

    private function buscarLattes($dadosLattes)
    {
        // Verifica se Lattes já existe, caso não, o cria
        $lattes = Lattes::find($dadosLattes['id']);

        if (!count($lattes)) $lattes = Lattes::create($dadosLattes);
        else {
            // Caso o Lattes exista verifica se precisa atualizar
            $atual = Carbon::createFromFormat('dmYHis', $lattes->data_atualizacao . $lattes->hora_atualizacao);
            $novo = Carbon::createFromFormat('dmYHis', $dadosLattes['data_atualizacao'] . $dadosLattes['hora_atualizacao']);

            $atualizar = $novo->diffInSeconds($atual) != 0;

            if ($atualizar) {
                $lattes->delete();
                $lattes = Lattes::create($dadosLattes);
            }
        }

        return $lattes;
    }

    private function buscarPalavrasChave($palavrasChave)
    {
        $palavras = [];

        for ($i = 1; $i <= 6; $i++)
        {
            $palavra = $palavrasChave['@PALAVRA-CHAVE-' . $i] ?? null;

            if (!empty($palavra)) {
                // Verifica se a Palavra Chave já existe, caso não, a cria
                $palavraChave = PalavraChave::where('palavra', $palavra)->first();
                if (!count($palavraChave)) $palavraChave = PalavraChave::create(['palavra' => $palavra]);

                array_push($palavras, $palavraChave->id);
            }
        }

        return $palavras;
    }

    private function buscarAutor($dadosAutor)
    {
        // Verifica se Autor já existe, caso não, o cria
        $autor = Autor::where('nome_completo', $dadosAutor['nome_completo'])->first();

        if (!count($autor)) $autor = Autor::create($dadosAutor);
        else if (empty($autor->id_cnpq) && !empty($dadosAutor['id_cnpq'])) {
            // Caso o Autor exista verifica se possui 'id_cnpq', caso não possua e tenha a informação, o atualiza
            $autor->id_cnpq = $dadosAutor['id_cnpq'];
            $autor->save();
        }

        return $autor;
    }

    private function buscarInstituicao($dadosInstituicao)
    {
        // Verifica se a Instituição já existe, caso não, a cria
        $instituicao = Instituicao::find($dadosInstituicao['id']);

        if (!count($instituicao)) $instituicao = Instituicao::create($dadosInstituicao);
        else {
            // Caso a Instituição exista verifica se precisa de atualizaçãp
            if (empty($instituicao->sigla)) $instituicao->sigla = $dadosInstituicao['sigla'];
            if (empty($instituicao->sigla_uf)) $instituicao->sigla_uf = $dadosInstituicao['sigla_uf'];
            if (empty($instituicao->sigla_pais)) $instituicao->sigla_pais = $dadosInstituicao['sigla_pais'];
            if (empty($instituicao->nome_pais)) $instituicao->nome_pais = $dadosInstituicao['nome_pais'];
            if (empty($instituicao->flag_instituicao_ensino)) $instituicao->flag_instituicao_ensino = $dadosInstituicao['flag_instituicao_ensino'];

            $instituicao->save();
        }

        $coordenadas = ConversorController::buscarCoordenadas($instituicao->coordenadas_nome);

        return $instituicao;
    }

    private function buscarCurso($dadosCurso)
    {
        // Verifica se Curso já existe, caso não, o cria
        $curso = Curso::find($dadosCurso['id']);

        if (!count($curso)) $curso = Curso::create($dadosCurso);
        else {
            // Caso a Curso exista verifica se precisa de atualizaçãp
            if (empty($curso->codigo_orgao)) $curso->codigo_orgao = $dadosCurso['codigo_orgao'];
            if (empty($curso->nome_orgao)) $curso->nome_orgao = $dadosCurso['nome_orgao'];
            if (empty($curso->codigo_instituicao)) $curso->codigo_instituicao = $dadosCurso['codigo_instituicao'];
            if (empty($curso->nome_instituicao)) $curso->nome_instituicao = $dadosCurso['nome_instituicao'];
            if (empty($curso->grande_area_conhecimento)) $curso->grande_area_conhecimento = $dadosCurso['grande_area_conhecimento'];
            if (empty($curso->area_conhecimento)) $curso->area_conhecimento = $dadosCurso['area_conhecimento'];
            if (empty($curso->sub_area_conhecimento)) $curso->sub_area_conhecimento = $dadosCurso['sub_area_conhecimento'];
            if (empty($curso->especialidade)) $curso->especialidade = $dadosCurso['especialidade'];
            if (empty($curso->nivel_curso)) $curso->nivel_curso = $dadosCurso['nivel_curso'];

            $curso->save();
        }

        $coordenadas = ConversorController::buscarCoordenadas($curso->nome_instituicao);

        return $curso;
    }

    private function buscarCoordenadas($nome)
    {
        if (empty($nome)) return null;

        // Verifica se as Coordenadas já existem, caso não, as cria
        $coordenadas = Coordenadas::where('nome', $nome)->first();

        if (!$coordenadas) {
            $result = Geocoder::geocode($nome)->limit(1)->get()->first();

            if (!$result) return null;

            $coordinates = $result->getCoordinates();

            $dados = [
                'nome' => $nome,
                'latitude' => $coordinates->getLatitude(),
                'longitude' => $coordinates->getLongitude(),
            ];

            $coordenadas = Coordenadas::create($dados);
        }

        return $coordenadas;
    }

    public function getCurso($curso, $centro)
    {
        return CursoFaculdade::whereHas('centrosFaculdade', function ($query) use ($centro) {
                    $query->where('sigla', $centro);
                })->where('nome', $curso)->get()->first()->id ?? null;
    }

    public function init()
    {
        $centrosFaculdade = [
            ['sigla' => 'CCS', 'nome' => 'Centro de Ciências da Saúde', 'tipo' => 'centro'],
            ['sigla' => 'CCT', 'nome' => 'Centro de Ciências e Tecnologia', 'tipo' => 'centro'],
            ['sigla' => 'CED', 'nome' => 'Centro de Educação', 'tipo' => 'centro'],
            ['sigla' => 'CESA', 'nome' => 'Centro de Estudos Sociais Aplicados', 'tipo' => 'centro'],
            ['sigla' => 'CH', 'nome' => 'Centro de Humanidade', 'tipo' => 'centro'],
            ['sigla' => 'CECITEC', 'nome' => 'Faculdade de Educação, Ciências e Letras dos Inhamuns', 'tipo' => 'faculdade'],
            ['sigla' => 'FACEDI', 'nome' => 'Faculdade de Educação de Itapipoca', 'tipo' => 'faculdade'],
            ['sigla' => 'FAEC', 'nome' => 'Faculdade de Educação de Crateús', 'tipo' => 'faculdade'],
            ['sigla' => 'FAFIDAM', 'nome' => 'Faculdade de Filosofia Dom Aureliano Matos', 'tipo' => 'faculdade'],
            ['sigla' => 'FAVET', 'nome' => 'Faculdade de Veterinária', 'tipo' => 'faculdade'],
            ['sigla' => 'FECLESC', 'nome' => 'Faculdade de Educação Ciências e Letras do Sertão Central', 'tipo' => 'faculdade'],
            ['sigla' => 'FECLI', 'nome' => 'Faculdade de Educação, Ciências e Letras de Iguatu', 'tipo' => 'faculdade'],
        ];

        $cursos = [
            'CCS'       => ['Ciências Biológicas', 'Educação Física', 'Enfermagem', 'Medicina', 'Nutricao'],
            'CCT'       => ['Ciência da Computação', 'Física', 'Geografia', 'Matemática', 'Química'],
            'CED'       => ['Pedagogia'],
            'CESA'      => ['Administração', 'Ciências Contábeis', 'Serviço Social'],
            'CH'        => ['Ciências Sociais', 'Filosofia', 'História', 'Letras', 'Música', 'Psicologia'],
            'CECITEC'   => ['Ciências Biológicas', 'Pedagogia', 'Química'],
            'FACEDI'    => ['Ciências Biológicas', 'Ciências Sociais', 'Pedagogia', 'Química'],
            'FAEC'      => ['Ciências Biológicas', 'Pedagogia', 'Química'],
            'FAFIDAM'   => ['Ciências Biológicas', 'Física', 'Geografia', 'História', 'Letras', 'Matemática', 'Pedagogia', 'Química'],
            'FAVET'     => ['Medicina Veterinária'],
            'FECLESC'   => ['Ciências Biológicas', 'Física', 'História', 'Letras', 'Matemática', 'Pedagogia', 'Química'],
            'FECLI'     => ['Ciências Biológicas', 'Física', 'Letras', 'Matemática', 'Pedagogia'],
        ];

        foreach ($centrosFaculdade as $centroFaculdade)
        {
            $inserirCentroFaculdade = CentroFaculdade::firstOrCreate($centroFaculdade);

            if (!$inserirCentroFaculdade) {
                $arrayMensagem = ['tipo' => 'erro', 'mensagem' => 'Erro ao inserir ' . $centroFaculdade['tipo'] . '!', 'submensagem' => 'Não foi possível inserir: ' . $centroFaculdade['nome']];

                return view('mensagem', compact(['arrayMensagem']));
            }

            // Insere cursos do Centro/Faculdade
            $dados = ['centro_faculdade_id' => $inserirCentroFaculdade->id];

            if (!empty($cursos[$centroFaculdade['sigla']])) {
                foreach ($cursos[$centroFaculdade['sigla']] as $curso) {
                    $dados['nome'] = $curso;

                    $insertCurso = CursoFaculdade::firstOrCreate($dados);

                    if (!$insertCurso) {
                        $arrayMensagem = ['tipo' => 'erro', 'mensagem' => 'Erro ao inserir curso!', 'submensagem' => 'Não foi possível inserir: ' . $centroFaculdade['nome']];

                        return view('mensagem', compact(['arrayMensagem']));
                    }
                }
            }
        }

        $tipo = 'info';
        $mensagem = "Inicializado com sucesso!";

        return view('mensagem', compact(['tipo', 'mensagem']));
    }

    public function teste()
    {
        // Adicionar Qualis no Artigo Publicado
        $artigos = ArtigoPublicado::leftJoin('qualis', 'qualis.issn', '=', 'artigos_publicados.issn')
            ->select('artigos_publicados.id', 'qualis.estrato')
            ->where('buscou_estrato', 0)
            ->limit(3000)
            ->get();

        foreach ($artigos as $artigo)
        {
            ArtigoPublicado::find($artigo->id)->update(['estrato' => $artigo->estrato, 'buscou_estrato' => 1]);
            echo $artigo->id . ' - ' . $artigo->estrato . '<br>';
        }

        dd('teste');
    }

}
