@extends('layout.page2')

@section('content')

    <h1>Indicadores Gerais da UECE </h1>

    <div class="row ">

        <div class="card card-primary col-md-3">
        <table class="table table-striped table-bordered table-hover dataTables box box-default">
            <tbody>
                    <tr>
                        <td>Quantidade de Professores da UECE</td>
                        <td>1000</td>
                    </tr>
                    <tr>
                        <td>Quantidade de Professores da UECE com Lattes</td>
                        <td>{{$numDeProfessores}}</td>
                    </tr>
                    <tr>
                        <td>Unidades Cadastradas</td>
                        <td>{{$qtdUnidades}}</td>
                    </tr>
                    <tr>
                        <td>Quantidades de Cursos</td>
                        <td>{{$qtdCursos}}</td>
                    </tr>
                    <tr>
                        <td>Período</td>
                        <td> 1970 - 2017 </td>
                    </tr>

            </tbody>
        </table>
        </div>
        <div class="card card-primary col-md-3">
        <div class="chart box box-default">
            <canvas id="DoughnutChart1"  height="200"></canvas>
        </div>


        </div>

        <div class="card card-primary col-md-3">
            <div class="info-box">

            <span class="info-box-icon bg-light-blue-active" ><i class="fa fa-flask fa-fw" aria-hidden="true"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total de Artigos Publicados</span>
                    <span class="info-box-number">{{$artigosPub}}</span>
                </div>
            <!-- /.info-box-content -->
            </div>
            <div class="info-box">

                <span class="info-box-icon bg-light-blue-active"><i class="fa fa-bus fa-fw" aria-hidden="true"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total de Trabalhos Em Eventos</span>
                    <span class="info-box-number">{{$trabEventos}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>

        <div class="card card-primary col-md-3">
            <div class="info-box">

                <span class="info-box-icon bg-light-blue-active"><i class="fa fa-book fa-fw" aria-hidden="true"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total de  Capítulos de Livros Publicados</span>
                    <span class="info-box-number">{{$capLivros}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <div class="info-box">

                <span class="info-box-icon bg-light-blue-active"><i class="fa fa-users fa-fw" aria-hidden="true"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total de Curriculos Lattes</span>
                    <span class="info-box-number">{{$numDeProfessores}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>


        </div>


    </div>


    <section class="content box box-default">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <!-- AREA CHART -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Artigos Publicados</h3>

                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="barChart1" style="height: 481px; width: 963px;" width="963" height="481"></canvas>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- DONUT CHART -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Qualis - Artigos Publicados</h3>

                            <div class="card-tools">
                                </button>
                                <div  class="col-sm-4">
                                    <select id="ano" class="form-control col-sm-4">
                                        @foreach($anos as $ano)
                                            <option>{{ $ano }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div  id="buscar" class="col-sm-4"><button type="button" class="btn btn-block btn-primary col-sm-4">Buscar Qualis Por Ano</button></div>
                                <a href="{{route('ind.qualis')}}">
                                    <div  class="col-sm-4"><button  type="button" class="btn btn-block btn-primary col-sm-4" >Ver Mais</button></div>
                                </a>
                            </div>

                        </div>
                        <div class="card-body">
                            <canvas id="barChart4" style="height: 501px; width: 1003px;" width="1003" height="501"></canvas>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col (LEFT) -->
                <div class="col-md-6">
                    <!-- LINE CHART -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Trabalhos em Eventos </h3>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="barChart2" style="height: 481px; width: 963px;" width="963" height="481"></canvas>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- BAR CHART -->
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Capítulos de Livros Publicados</h3>

                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="barChart3" style="height: 481px; width: 963px;" width="963" height="481"></canvas>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col (RIGHT) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->



@endsection

@section('js')
    <script>
        var url = "<?php echo env('API_IND_URL', 'http://127.0.0.1:8000/api/ind/v1/'); ?>";
        var qualisChart;
        console.log('url: ' + url);
        $.getJSON(url + 'quantArtigos', function(data) {


            var ctx = document.getElementById("barChart1").getContext('2d');

            var myDoughnutChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data['labels'],
                    datasets : [
                        {
                            backgroundColor: '#408cb8',
                            hoverBackgroundColor: '#16a45f',
                            borderWidth: 0,
                            data: data['values']
                        }
                    ]
                },
                options: {
                    plugins: {
                        labels: {
                            //render: 'value',
                            showZero: true,
                            fontSize: 14,
                            fontColor: 'black',
                            fontStyle: 'bold',
                            render: function () {
                                return '';
                            }
                        },
                        datalabels: {
                            color: 'black',
                            display: false,
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            anchor: 'top',
                            clamp: true
                        }
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }],
                        xAxes: [{
                            maxBarThickness : 200
                        }]
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        custom: function (tooltip) {
                            if (!tooltip) return;
                            tooltip.displayColors = false;
                            tooltip.bodyFontSize = 14;
                            tooltip.xPadding = 5;
                            tooltip.yPadding = 4;
                        }
                    }
                }
            });
        });
        $.getJSON(url + 'quantCapLivros', function(data) {


            var ctx = document.getElementById("barChart3").getContext('2d');

            var myDoughnutChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data['labels'],
                    datasets : [
                        {
                            backgroundColor: '#408cb8',
                            hoverBackgroundColor: '#16a45f',
                            borderWidth: 0,
                            data: data['values']
                        }
                    ]
                },
                options: {
                    plugins: {
                        labels: {
                            //render: 'value',
                            showZero: true,
                            fontSize: 14,
                            fontColor: 'black',
                            fontStyle: 'bold',
                            render: function () {
                                return '';
                            }
                        },
                        datalabels: {
                            color: 'black',
                            display: false,
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            anchor: 'top',
                            clamp: true
                        }
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }],
                        xAxes: [{
                            maxBarThickness : 200
                        }]
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        custom: function (tooltip) {
                            if (!tooltip) return;
                            tooltip.displayColors = false;
                            tooltip.bodyFontSize = 14;
                            tooltip.xPadding = 5;
                            tooltip.yPadding = 4;
                        }
                    }
                }
            });
        });
        $.getJSON(url + 'quantEventos', function(data) {


            var ctx = document.getElementById("barChart2").getContext('2d');

            var myDoughnutChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data['labels'],
                    datasets : [
                        {
                            backgroundColor: '#408cb8',
                            hoverBackgroundColor: '#16a45f',
                            borderWidth: 0,
                            data: data['values']
                        }
                    ]
                },
                options: {
                    plugins: {
                        labels: {
                            //render: 'value',
                            showZero: true,
                            fontSize: 14,
                            fontColor: 'black',
                            fontStyle: 'bold',
                            render: function () {
                                return '';
                            }
                        },
                        datalabels: {
                            color: 'black',
                            display: false,
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            anchor: 'top',
                            clamp: true
                        }
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }],
                        xAxes: [{
                            maxBarThickness : 200
                        }]
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        custom: function (tooltip) {
                            if (!tooltip) return;
                            tooltip.displayColors = false;
                            tooltip.bodyFontSize = 14;
                            tooltip.xPadding = 5;
                            tooltip.yPadding = 4;
                        }
                    }
                }
            });
        });


        $.getJSON(url + 'qualisPorAno', function(data) {
            console.log('url: ' + data);


            var ctx = document.getElementById("barChart4").getContext('2d');

             qualisChart = new Chart(ctx, {
                type: 'bar',


                data: {
                    labels: data['labels'],
                    datasets : [
                        {
                            backgroundColor: '#408cb8',
                            hoverBackgroundColor: '#16a45f',
                            borderWidth: 0,
                            data: data['values']
                        }
                    ]
                },

                 title: {
                     display: true,
                     text: '2017'
                 },


                 options: {
                     plugins: {
                         labels: {
                             //render: 'value',
                             showZero: true,
                             fontSize: 14,
                             fontColor: 'black',
                             fontStyle: 'bold',
                             render: function () {
                                 return '';
                             }
                         },
                         datalabels: {
                             color: 'black',
                             display: false,
                             font: {
                                 size: 14,
                                 weight: 'bold'
                             },
                             anchor: 'top',
                             clamp: true
                         }
                     },
                     scales: {
                         yAxes: [{
                             ticks: {
                                 beginAtZero: true
                             }
                         }],
                         xAxes: [{
                             maxBarThickness : 200
                         }]
                     },
                     legend: {
                         display: false
                     },
                     tooltips: {
                         custom: function (tooltip) {
                             if (!tooltip) return;
                             tooltip.displayColors = false;
                             tooltip.bodyFontSize = 14;
                             tooltip.xPadding = 5;
                             tooltip.yPadding = 4;
                         }
                     }
                 }


            });
        });

        $("#buscar").click(function() {
            var e = document.getElementById("ano");
            var strAno = e.options[e.selectedIndex].value;
            //console.log(strAno);


            $.post(url + 'atualizaQualis', {
                ano: strAno
            }, function(data) {

                console.log(data);

                qualisChart.data = {

                        labels: data['labels'],
                        datasets : [
                            {
                                backgroundColor: '#408cb8',
                                hoverBackgroundColor: '#16a45f',
                                borderWidth: 0,
                                data: data['values']
                            }
                        ]

                }


               qualisChart.update();




            }, 'json')
                .fail(function() {
                    // removeMapPoint();
                });


        });


        var ctx = document.getElementById("DoughnutChart1").getContext('2d');
        var myDoughnutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    'COM LATTES',
                    'SEM LATTES'

                ],

                datasets : [
                    {
                        backgroundColor: ['#28a744', '#dc3644'],
                        hoverBackgroundColor: '#18a2b8',

                        borderWidth: 0,
                        data: [{{$numDeProfessores}}, 1000 - ({{$numDeProfessores}})]
                    }
                ]
            },

            options: {
                plugins: {
                    labels: {

                        showZero: true,
                        fontSize: 14,
                        fontColor: 'black',
                        fontStyle: 'bold',
                        render: ''
                    },
                    datalabels: {
                        color: 'black',
                        display: '',
                        font: {
                            size: 14,
                            weight: 'bold'
                        },
                        anchor: 'top',
                        clamp: true
                    }
                },

                legend: {
                    display: true,
                    position: 'bottom'
                },
                tooltips: {
                    custom: function (tooltip) {
                        if (!tooltip) return;
                        tooltip.displayColors = false;
                        tooltip.bodyFontSize = 14;
                        tooltip.xPadding = 5;
                        tooltip.yPadding = 4;
                    }
                },
                title: {
                    display: true,
                    fontsize: 14,
                    text: 'Professores que possuem Lattes'
                }
            }

        });

    </script>
@endsection