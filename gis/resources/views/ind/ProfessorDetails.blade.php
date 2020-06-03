@extends('layout.page2')


@section('content')

    <h1><B>{{$professor->nome_completo}} </B></h1>
    <h5><I>{{$professor->nome_citacao}} </I></h5>
    <br>
    <div class="row">

        <div class="card card-primary col-md-3">
            <div class="info-box">

                <span class="info-box-icon bg-light-blue-active" ><i class="fa fa-graduation-cap"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">{{$centro->sigla}}</span>
                    <span class="info-box-number">{{$centro->nome}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>

        </div>

        <div class="card card-primary col-md-3">
            <div class="info-box">

                <span class="info-box-icon bg-light-blue-active" ><i class="fa fa-flask fa-fw" aria-hidden="true"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total de Artigos Publicados</span>
                    <span class="info-box-number">{{count($artigos)}} </span>
                </div>
                <!-- /.info-box-content -->
            </div>

        </div>
        <div class="card card-primary col-md-3">
            <div class="info-box ">

                <span class="info-box-icon bg-light-blue-active"><i class="fa fa-bus fa-fw" aria-hidden="true"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total de Trabalhos Em Eventos</span>
                    <span class="info-box-number">{{count($trabalhosEventos)}} </span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>

        <div class="card card-primary col-md-3">
            <div class="info-box">

                <span class="info-box-icon bg-light-blue-active"><i class="fa fa-book fa-fw" aria-hidden="true"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total de  Capítulos de Livros Publicados</span>
                    <span class="info-box-number"> {{count($capLivrosPub)}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>

    </div>


    <section class="content box box-default">

        <h3>Resumo</h3>
        <p>{{$professor->resumo_cv}} </p>

        <h3>Artigos Publicados</h3>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables">
                <thead>
                <tr>
                    <th>Título</th>
                    <th>ISSN</th>
                    <th>Periódico</th>
                    <th>Estrato</th>
                </tr>
                </thead>
                <tbody>
                @foreach($artigos as $artigo)
                    <tr>
                        <td>{{ $artigo->titulo_do_artigo }}</td>
                        <td>{{ $artigo->issn }}</td>
                        <td>{{ $artigo->titulo_periodico_revista }}</td>
                        <td>{{ $artigo->estrato }}</td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>

        <h3>Trabalhos em Eventos</h3>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables">
                <thead>
                <tr>
                    <th>Título</th>
                    <th>País</th>
                    <th>Editora</th>
                </tr>
                </thead>
                <tbody>
                @foreach($trabalhosEventos as $evento)
                    <tr>
                        <td>{{ $evento->titulo }}</td>
                        <td>{{ $evento->pais }}</td>
                        <td>{{ $evento->nome_editora }}</td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>

        <h3>Capítulos de Livros Publicados</h3>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables">
                <thead>
                <tr>
                    <th>Título do Capítulo do Livro</th>
                    <th>País</th>
                    <th>Livro</th>
                </tr>
                </thead>
                <tbody>
                @foreach($capLivrosPub as $capLivroPub)
                    <tr>
                        <td>{{ $capLivroPub->titulo_do_capitulo_do_livro }}</td>
                        <td>{{ $capLivroPub->pais_de_publicacao }}</td>
                        <td>{{ $capLivroPub->titulo_do_livro }}</td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>


    </section>

@endsection

@section('js')

@endsection


{{--{#256 ▼--}}
{{--+"id": "3997790160928747"--}}
{{--+"curso_faculdade_id": 5--}}
{{--+"data_atualizacao": "14022017"--}}
{{--+"hora_atualizacao": "174733"--}}
{{--+"nome_completo": "Abelardo Barbosa Moreira Lima Neto"--}}
{{--+"nome_citacao": "LIMA-NETO, A. B. M.;NETO, ABELARDO;LIMA-NETO, ABELARDO BARBOSA MOREIRA"--}}
{{--+"nacionalidade": "B"--}}
{{--+"pais_nacimento": "Brasil"--}}
{{--+"uf_nascimento": "CE"--}}
{{--+"cidade_nascimento": "Fortaleza"--}}
{{--+"sigla_pais_nacionalidade": "BRA"--}}
{{--+"pais_nacionalidade": "Brasil"--}}
{{--+"resumo_cv": """--}}
{{--Doutorando em Biotecnologia pela Rede Nordeste de Biotecnologia (RENORBIO), bacharel em Nutrição pela Universidade Estadual do Ceará - UECE, Pesquisador do Labo ▶--}}
{{--Membro Fundador da Liga Acadêmica de Terapia Nutricional Enteral e Parenteral - LATNEP.--}}
{{--"""--}}
{{--+"resumo_cv_ingles": "Has experience in Nutrition, focusing on Nutrition"--}}
{{--+"created_at": "2018-05-20 10:53:44"--}}
{{--+"updated_at": "2018-05-20 10:53:44"--}}
{{--}--}}


{{--+"id": 2--}}
{{--+"sigla": "CCT"--}}
{{--+"nome": "Centro de Ciências e Tecnologia"--}}
{{--+"tipo": "centro"--}}
{{--+"created_at": "2018-05-20 10:47:33"--}}
{{--+"updated_at": "2018-05-20 10:47:33"--}}

{{--+"id": 3302--}}
{{--+"lattes_id": "3997790160928747"--}}
{{--+"natureza": "COMPLETO"--}}
{{--+"titulo_do_artigo": "Gamma-oryzanol has an equivalent efficacy as a lipid-lowering agent compared with fibrate and statin in two dyslipidemia mice models"--}}
{{--+"titulo_do_artigo_ingles": null--}}
{{--+"ano_do_artigo": "2014"--}}
{{--+"pais_de_publicacao": null--}}
{{--+"idioma": "Inglês"--}}
{{--+"flag_relevancia": "NAO"--}}
{{--+"flag_divulgacao_cientifica": null--}}
{{--+"meio_de_divulgacao": null--}}
{{--+"titulo_periodico_revista": "International Journal of Pharmacy and Pharmaceutical Sciences"--}}
{{--+"issn": "09751491"--}}
{{--+"volume": "6"--}}
{{--+"fasciculo": ""--}}
{{--+"pagina_inicial": "61"--}}
{{--+"pagina_final": "64"--}}
{{--+"local_publicacao": ""--}}
{{--+"estrato": "C"--}}
{{--+"buscou_estrato": 1--}}
{{--+"created_at": "2018-06-04 23:21:25"--}}
{{--+"updated_at": "2018-11-03 17:00:31"--}}
{{--}--}}

{{--+"id": 12226--}}
{{--+"lattes_id": "7227955029154651"--}}
{{--+"natureza": "COMPLETO"--}}
{{--+"titulo": "RefaX: A Refactoring Framework Based on XML"--}}
{{--+"titulo_ingles": ""--}}
{{--+"ano": "2004"--}}
{{--+"pais": "Estados Unidos"--}}
{{--+"idioma": "Inglês"--}}
{{--+"meio_divulgacao": "IMPRESSO"--}}
{{--+"flag_relevancia": "SIM"--}}
{{--+"flag_divulgacao_cientifica": "NAO"--}}
{{--+"classificacao_evento": "INTERNACIONAL"--}}
{{--+"nome_evento": "20th. International Conference on Software Maintenance (ICSM'04)"--}}
{{--+"nome_evento_ingles": ""--}}
{{--+"cidade_evento": "Chicago"--}}
{{--+"ano_evento": "2004"--}}
{{--+"titulo_anais_ou_proceedings": "Proceedings of the ICSM'04"--}}
{{--+"volume": ""--}}
{{--+"fasciculo": ""--}}
{{--+"serie": ""--}}
{{--+"pagina_inicial": ""--}}
{{--+"pagina_final": ""--}}
{{--+"isbn": ""--}}
{{--+"nome_editora": "IEEE Computer Society Press"--}}
{{--+"cidade_editora": "Chicago"--}}
{{--+"created_at": "2018-05-20 10:54:56"--}}
{{--+"updated_at": "2018-05-20 10:54:56"--}}

{{--+"id": 1449--}}
{{--+"lattes_id": "0721071524157651"--}}
{{--+"tipo": "Capítulo de livro publicado"--}}
{{--+"titulo_do_capitulo_do_livro": "Introdução aos Padrões de Software"--}}
{{--+"ano": "2010"--}}
{{--+"pais_de_publicacao": "Brasil"--}}
{{--+"idioma": "Português"--}}
{{--+"meio_de_divulgacao": "IMPRESSO"--}}
{{--+"flag_relevancia": "NAO"--}}
{{--+"flag_divulgacao_cientifica": "NAO"--}}
{{--+"titulo_do_livro": "I Jornada de Atualização Tecnológica"--}}
{{--+"cidade_da_editora": "Fortaleza"--}}
{{--+"nome_da_editora": null--}}
{{--+"created_at": "2018-06-04 20:33:06"--}}
{{--+"updated_at": "2018-06-04 20:33:06"--}}