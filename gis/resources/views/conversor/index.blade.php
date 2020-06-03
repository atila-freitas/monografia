@extends('layout.page')

@section('content')

    <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
        @if (session('sucesso'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4 style="margin: 0;"><i class="icon fa fa-warning"></i> Currículos convertidos com sucesso!</h4>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-warning"></i> @if (!session('erro')) Atenção! @else Erro ao converter currículos! @endif</h4>
                <ul class="alert-list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{ Form::open(['url' => route('conversor.upload'), 'method' => 'post', 'files' => true, 'enctype' => 'multipart/form-data']) }}

            <div class="form-group">
                <label for="inputFile">Currículos Lattes em XML</label>
                <input type="file" name="files[]" id="inputFile" multiple>

                <p class="help-block">Converta até 10 currículos Lattes por vez para o sistema.</p>
            </div>

            <div class="form-group">
                <label>Selecione o Curso</label>
                {{ Form::select('curso', $cursos, null, ['class' => 'form-control', 'placeholder' => 'Escolha um dos cursos...']) }}
            </div>

            <button class="btn btn-primary">Converter</button>

        {{ Form::close() }}
    </div>

@stop