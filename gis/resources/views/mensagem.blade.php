@extends('layout.page')

@section('content')

    <?php
        if (!empty($arrayMensagem)) {
            $tipo = $arrayMensagem['tipo'] ?? null;
            $mensagem = $arrayMensagem['mensagem'] ?? null;
            $submensagem = $arrayMensagem['submensagem'] ?? null;
            $submensagemlist = $arrayMensagem['submensagemlist'] ?? null;
        }

        if (empty($tipo)) $tipo = 'observacao';

        switch ($tipo)
        {
            case 'erro':
                $tipo = 'danger';
                $icone = 'ban';
                break;
            case 'info':
                $tipo = $icone = 'info';
                break;
            case 'sucesso':
                $tipo = 'success';
                $icone = 'check';
                break;
            default:
                $tipo = $icone = 'warning';
        }
    ?>

    <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12 col-lg-offset-2 col-md-offset-3" style="margin-top: 40px;">
        <div class="alert alert-{{ $tipo }}">
            <h4 style="@if (empty($submensagem)) margin: 0; @endif "><i class="icon fa fa-{{ $icone }}"></i> {{ $mensagem }}</h4>
            @if (!empty($submensagem)) {{ $submensagem }} @endif
            @if (!empty($submensagemlist))
                <ul class="alert-list">
                    @foreach($submensagemlist as $submensagemitem)
                        <li>{{ $submensagemitem }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

@stop