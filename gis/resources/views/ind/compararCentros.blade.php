@extends('layout.page2')


@section('content')

    <h1> Comparar Centros </h1>



        <div class=" row">

            <div class="col-md-6">

                <h2>{{$centro1}}</h2>

                <div class=" row">

                    <div class="card card-primary col-md-6">
                        <div class="info-box">

                            <span class="info-box-icon bg-light-blue-active" ><i class="fa fa-flask fa-fw" aria-hidden="true"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total de Artigos Publicados</span>
                                <span class="info-box-number">{{$artigosPub1}}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <div class="info-box">

                            <span class="info-box-icon bg-light-blue-active"><i class="fa fa-bus fa-fw" aria-hidden="true"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total de Trabalhos Em Eventos</span>
                                <span class="info-box-number">{{$trabEventos1}}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>

                    <div class="card card-primary col-md-6">
                        <div class="info-box">

                            <span class="info-box-icon bg-light-blue-active"><i class="fa fa-book fa-fw" aria-hidden="true"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total de  Capítulos de Livros Publicados</span>
                                <span class="info-box-number">{{$capLivros1}}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <div class="info-box">

                            <span class="info-box-icon bg-light-blue-active"><i class="fa fa-users fa-fw" aria-hidden="true"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total de Curriculos Lattes</span>
                                <span class="info-box-number">{{$numDeProfessores1}}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>


                    </div>


                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Artigos Publicados</h3>

                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="Artigos1" style="height: 481px; width: 963px;" width="963" height="481"></canvas>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Trabalhos em Eventos </h3>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="Eventos1" style="height: 481px; width: 963px;" width="963" height="481"></canvas>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>

                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Capítulos de Livros Publicados</h3>

                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="capLivros1" style="height: 481px; width: 963px;" width="963" height="481"></canvas>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Qualis - Artigos Publicados</h3>

                        <div class="card-tools">
                            </button>
                            <div  class="col-sm-4">
                                <select id="ano1" class="form-control col-sm-4">
                                    @foreach($anos1 as $ano)
                                        <option>{{ $ano }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div  id="buscar1" class="col-sm-4"><button type="button" class="btn btn-block btn-primary col-sm-4">Buscar Qualis Por Ano</button></div>
                            <a href="{{route('ind.qualis')}}">
                                <div  class="col-sm-4"><button  type="button" class="btn btn-block btn-primary col-sm-4" >Ver Mais</button></div>
                            </a>
                        </div>

                    </div>
                    <div class="card-body">
                        <canvas id="qualis1" style="height: 501px; width: 1003px;" width="1003" height="501"></canvas>
                    </div>
                    <!-- /.card-body -->
                </div>


            </div>

            <div class="col-md-6">

                <h2>{{$centro2}}</h2>

                <div class=" row">

                    <div class="card card-primary col-md-6">
                        <div class="info-box">

                            <span class="info-box-icon bg-light-blue-active" ><i class="fa fa-flask fa-fw" aria-hidden="true"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total de Artigos Publicados</span>
                                <span class="info-box-number">{{$artigosPub2}}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <div class="info-box">

                            <span class="info-box-icon bg-light-blue-active"><i class="fa fa-bus fa-fw" aria-hidden="true"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total de Trabalhos Em Eventos</span>
                                <span class="info-box-number">{{$trabEventos2}}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                    </div>

                    <div class="card card-primary col-md-6">
                        <div class="info-box">

                            <span class="info-box-icon bg-light-blue-active"><i class="fa fa-book fa-fw" aria-hidden="true"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total de  Capítulos de Livros Publicados</span>
                                <span class="info-box-number">{{$capLivros2}}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <div class="info-box">

                            <span class="info-box-icon bg-light-blue-active"><i class="fa fa-users fa-fw" aria-hidden="true"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Total de Curriculos Lattes</span>
                                <span class="info-box-number">{{$numDeProfessores2}}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>


                    </div>


                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Artigos Publicados</h3>

                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="Artigos2" style="height: 481px; width: 963px;" width="963" height="481"></canvas>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Trabalhos em Eventos </h3>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="Eventos2" style="height: 481px; width: 963px;" width="963" height="481"></canvas>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>

                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Capítulos de Livros Publicados</h3>

                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="capLivros2" style="height: 481px; width: 963px;" width="963" height="481"></canvas>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Qualis - Artigos Publicados</h3>

                        <div class="card-tools">
                            </button>
                            <div  class="col-sm-4">
                                <select id="ano2" class="form-control col-sm-4">
                                    @foreach($anos2 as $ano)
                                        <option>{{ $ano }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div  id="buscar2" class="col-sm-4"><button type="button" class="btn btn-block btn-primary col-sm-4">Buscar Qualis Por Ano</button></div>
                            <a href="{{route('ind.qualis')}}">
                                <div  class="col-sm-4"><button  type="button" class="btn btn-block btn-primary col-sm-4" >Ver Mais</button></div>
                            </a>
                        </div>

                    </div>
                    <div class="card-body">
                        <canvas id="qualis2" style="height: 501px; width: 1003px;" width="1003" height="501"></canvas>
                    </div>
                    <!-- /.card-body -->
                </div>

            </div>


        </div>




@endsection

@section('js')
    <script>

        var url = "<?php echo env('API_IND_URL', 'http://127.0.0.1:8000/api/ind/v1/'); ?>";



        $.post(url + 'getArtigosPubPorAnoCentro/{{$centro1_id}}', function(data) {
            var ctx = document.getElementById("Artigos1").getContext('2d');

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
        $.post(url + 'getArtigosPubPorAnoCentro/{{$centro2_id}}', function(data) {
            var ctx = document.getElementById("Artigos2").getContext('2d');

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

        $.post(url + 'getQuantEventosCentro/{{$centro1_id}}', function(data) {

            var ctx = document.getElementById("Eventos1").getContext('2d');

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
        $.post(url + 'getQuantEventosCentro/{{$centro2_id}}', function(data) {

            var ctx = document.getElementById("Eventos2").getContext('2d');

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

        $.post(url + 'getQuantCapLivrosCentro/{{$centro1_id}}', function(data) {

            var ctx = document.getElementById("capLivros1").getContext('2d');

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
        $.post(url + 'getQuantCapLivrosCentro/{{$centro2_id}}', function(data) {

            var ctx = document.getElementById("capLivros2").getContext('2d');

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


        var qualisChart;
        var e = document.getElementById("ano1");
        var strAno1= e.options[e.selectedIndex].value;
        var strId1 = '<?php echo $centro1_id; ?>';
        $.post(url + 'atualizaQualisCentro', { ano: strAno1, id: strId1 }, function(data) {
            console.log(data);
            var ctx = document.getElementById("qualis1").getContext('2d');
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
        $("#buscar1").click(function() {


            var e = document.getElementById("ano1");
            var strAno1= e.options[e.selectedIndex].value;
            var strId1 = '<?php echo $centro1_id; ?>';


            $.post(url + 'atualizaQualisCentro', { ano: strAno1, id: strId1 }, function(data)  {

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


        var qualisChart2;
        var e = document.getElementById("ano2");
        var strAno2= e.options[e.selectedIndex].value;
        var strId2 = '<?php echo $centro2_id; ?>';
        $.post(url + 'atualizaQualisCentro', { ano: strAno2, id: strId2 }, function(data) {
            console.log(data);
            var ctx = document.getElementById("qualis2").getContext('2d');
            qualisChart2 = new Chart(ctx, {
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
        $("#buscar2").click(function() {


            var e = document.getElementById("ano2");
            var strAno2= e.options[e.selectedIndex].value;
            var strId2 = '<?php echo $centro2_id; ?>';


            $.post(url + 'atualizaQualisCentro', { ano: strAno2, id: strId2 }, function(data)  {

                console.log(data);

                qualisChart2.data = {

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


                qualisChart2.update();




            }, 'json')
                .fail(function() {
                    // removeMapPoint();
                });


        });


    </script>

@endsection