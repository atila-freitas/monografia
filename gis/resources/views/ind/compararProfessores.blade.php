@extends('layout.page2')


@section('content')

    <h1> Comparar Professores </h1>



        <div class=" row">



            <div class="col-md-6">
                <h1><B>{{$professor1->nome_completo}} </B></h1>
                <h5><I>{{$professor1->nome_citacao}} </I></h5>
                <div class="card card-primary col-md-6">
                    <div class="info-box">

                        <span class="info-box-icon bg-light-blue-active" ><i class="fa fa-graduation-cap"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{$centro1->sigla}}</span>
                            <span class="info-box-number">{{$centro1->nome}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>

                </div>

                <div class="card card-primary col-md-6">
                    <div class="info-box">

                        <span class="info-box-icon bg-light-blue-active" ><i class="fa fa-flask fa-fw" aria-hidden="true"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total de Artigos Publicados</span>
                            <span class="info-box-number">{{count($artigos1)}} </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>

                </div>
                <div class="card card-primary col-md-6">
                    <div class="info-box ">

                        <span class="info-box-icon bg-light-blue-active"><i class="fa fa-bus fa-fw" aria-hidden="true"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total de Trabalhos Em Eventos</span>
                            <span class="info-box-number">{{count($trabalhosEventos1)}} </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>

                <div class="card card-primary col-md-6">
                    <div class="info-box">

                        <span class="info-box-icon bg-light-blue-active"><i class="fa fa-book fa-fw" aria-hidden="true"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total de  Capítulos de Livros Publicados</span>
                            <span class="info-box-number"> {{count($capLivrosPub1)}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>



            </div>

            <div class="col-md-6">

                <h1><B>{{$professor2->nome_completo}} </B></h1>
                <h5><I>{{$professor2->nome_citacao}} </I></h5>
                <div class="card card-primary col-md-6">
                    <div class="info-box">

                        <span class="info-box-icon bg-light-blue-active" ><i class="fa fa-graduation-cap"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{$centro2->sigla}}</span>
                            <span class="info-box-number">{{$centro2->nome}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>

                </div>

                <div class="card card-primary col-md-6">
                    <div class="info-box">

                        <span class="info-box-icon bg-light-blue-active" ><i class="fa fa-flask fa-fw" aria-hidden="true"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total de Artigos Publicados</span>
                            <span class="info-box-number">{{count($artigos2)}} </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>

                </div>
                <div class="card card-primary col-md-6">
                    <div class="info-box ">

                        <span class="info-box-icon bg-light-blue-active"><i class="fa fa-bus fa-fw" aria-hidden="true"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total de Trabalhos Em Eventos</span>
                            <span class="info-box-number">{{count($trabalhosEventos2)}} </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>

                <div class="card card-primary col-md-6">
                    <div class="info-box">

                        <span class="info-box-icon bg-light-blue-active"><i class="fa fa-book fa-fw" aria-hidden="true"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total de  Capítulos de Livros Publicados</span>
                            <span class="info-box-number"> {{count($capLivrosPub2)}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </div>






            </div>


        </div>




@endsection

@section('js')
    <script>


    </script>

@endsection