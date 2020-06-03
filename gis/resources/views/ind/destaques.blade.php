@extends('layout.page2')


@section('content')


<h1> Destaques </h1>

<div class="content box box-default" >
    <h2>Artigos Publicados</h2>

    <div id = 'dtBasicExample' class="table-responsive ">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Professor</th>
                <th>Número de Artigos Publicados</th>

            </tr>
            </thead>
            <tbody>
            @foreach($profArtigos as $profArtigo)
                <tr>
                    <td><a href="{{route('ind.professorDetails',$profArtigo->lattes_id)}}">{{ $profArtigo->name }}</a></td>
                    <td>{{ $profArtigo->ART }}</td>

                </tr>

            @endforeach
            </tbody>
        </table>
    </div>



    <h2>Trabalhos em Eventos</h2>

    <div id = 'dtBasicExample' class="table-responsive ">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Professor</th>
                <th>Número de Trabalhos em Eventos</th>

            </tr>
            </thead>
            <tbody>
            @foreach($profEventos as $profEvento)
                <tr>
                    <td><a href="{{route('ind.professorDetails',$profEvento->lattes_id)}}">{{ $profEvento->name }}</a></td>
                    <td>{{ $profEvento->ART }}</td>

                </tr>

            @endforeach
            </tbody>
        </table>
    </div>


    <h2>Capítulos de Livros</h2>

    <div id = 'dtBasicExample' class="table-responsive ">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>Professor</th>
                <th>Número de Capítulos de Livros</th>

            </tr>
            </thead>
            <tbody>
            @foreach($profCapLivros as $profCapLivro)
                <tr>
                    <td><a href="{{route('ind.professorDetails',$profCapLivro->lattes_id)}}">{{ $profCapLivro->name }}</a></td>
                    <td>{{ $profCapLivro->ART }}</td>

                </tr>

            @endforeach
            </tbody>
        </table>
    </div>



</div>




@endsection

@section('js')
    <script>


    </script>



@endsection