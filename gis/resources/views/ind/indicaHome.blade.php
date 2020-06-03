@extends('layout.page2')

@section('content')

        <div class="row">

            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>Visão Geral</h3>

                        <p>Visão Geral dos Indicadores</p>
                    </div>
                    <div class="icon">
                        <i class="ion-eye"></i>
                    </div>
                    <a href="{{ route('ind.general') }}" class="small-box-footer">
                        Ver <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>Centros</h3>

                        <p>Indicadores dos Centros</p>
                    </div>
                    <div class="icon">
                        <i class="ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('ind.centers') }}" class="small-box-footer">
                        Ver <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>



        </div>
        <div class="row">


            <!-- /.col -->
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>Professores</h3>

                        <p>Professores Cadastrados</p>
                    </div>
                    <div class="icon">
                        <i class="ion-university"></i>
                    </div>
                    <a href="{{ route('ind.professors') }}" class="small-box-footer">
                        Ver <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>Qualis - Artigos</h3>

                        <p>Qualis dos Artigos Publicados</p>
                    </div>
                    <div class="icon">
                        <i class="ion-trophy"></i>
                    </div>
                    <a href="{{ route('ind.qualis') }}" class="small-box-footer">
                        Ver <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>


        </div>
        <div class="row">


            <!-- /.col -->
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>Destaques</h3>

                        <p>Destaques de produção</p>
                    </div>
                    <div class="icon">
                        <i class="ion-star"></i>
                    </div>
                    <a href="{{ route('ind.destaques') }}" class="small-box-footer">
                        Ver <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="small-box bg-teal-active">
                    <div class="inner">
                        <h3>Comparar</h3>

                        <p>Comparar centros ou Professores</p>
                    </div>
                    <div class="icon">
                        <i class="ion-search"></i>
                    </div>
                    <a href="{{ route('ind.comparar') }}" class="small-box-footer">
                        Ver <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>


        </div>






@stop



