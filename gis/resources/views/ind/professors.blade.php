@extends('layout.page2')


@section('content')

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover dataTables">
            <thead>
            <tr>
                <th>Professor</th>
                <th>Citação</th>
                <th>Ultima Atualização</th>
                <th>Nacionalidade</th>
            </tr>
            </thead>
            <tbody>
            @foreach($professores as $professor)
                    <tr>
                        <td><a href="{{route('ind.professorDetails',$professor->id)}}">{{ $professor->nome_completo }}</a></td>
                        <td>{{ $professor->nome_citacao }}</td>
                        <td>{{ $professor->data_atualizacao }}</td>
                        <td>{{ $professor->nacionalidade }}</td>
                    </tr>

            @endforeach
            </tbody>
        </table>
    </div>


@endsection

