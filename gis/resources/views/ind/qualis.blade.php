@extends('layout.page2')


@section('content')

    @foreach($estratosCount as $estratoOne)
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-light-blue-active">
                <span class="info-box-icon">{{ $estratoOne->estrato }}</span>

                <div class="info-box-content">
                    <span class="info-box-text"> ARTIGOS PUBLICADOS</span>
                    <span class="info-box-number">{{ $estratoOne->count }}</span>

                    <div class="progress">
                        <div class="progress-bar" style="width: {{   $estratoOne->count * 100 / $totalArtigosPublicados }}%"></div>

                    </div>
                    <span class="progress-description">
                UECE
              </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
     @endforeach



    <div class="card-tools box box-default col-md-6 ">
            <div class="row">
                <div class="card card-primary col-md-6">
                    <div class="card-header">
                        <h3 class="card-title">Qualis - Artigos Publicados - Histórico Por Estrato</h3>

                            </button>
                            <div  class="col-sm-4">
                                <select id="estratoSelect" class="form-control col-sm-4">
                                    @foreach($estratos as $estrato)
                                        <option>{{ $estrato }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div  id="buscar" class="col-sm-4"><button type="button" class="btn btn-block btn-primary col-sm-4 col-md-offset-3">Buscar Estrato</button></div></i>
                            </div>


                           <div class="card-body">
                                <canvas id="barChart1" style="height: 501px; width: 1003px;" width="1003" height="501"></canvas>
                           </div>
                </div>
                    <!-- /.card-body -->

                <div class="card card-primary col-md-6">
                    <div class="card-header">
                        <h3 class="card-title">Qualis - Artigos Publicados - Histórico Por Ano</h3>

                        <div class="card-tools">
                            </button>
                            <div  class="col-sm-4">
                                <select id="ano" class="form-control col-sm-4">
                                    @foreach($anos as $ano)
                                        <option>{{ $ano }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div  id="buscar2" class="col-sm-4"><button type="button" class="btn btn-block btn-primary col-sm-4">Buscar Qualis Por Ano</button></div>
                        </div>

                    </div>
                    <div class="card-body">
                        <canvas id="barChart4" style="height: 501px; width: 1003px;" width="1003" height="501"></canvas>
                    </div>
            </div>
            <!-- /.card-body -->
        </div>


        <br>
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fa fa-ban"></i> Alert!</h5>
            {{$artigosSemQualis}} ARTIGOS ({{   $artigosSemQualis * 100 /$totalArtigosPublicados }}%) FORAM CADASTRADOS SEM ISSN E POR ISSO NÃO ESTÃO SENDO CONSIDERADOS
        </div>
    </div>






@endsection

@section('js')
    <script>
        var url = "<?php echo env('API_IND_URL', 'http://127.0.0.1:8000/api/ind/v1/'); ?>";
        $.getJSON(url + 'qualisPorEstrato', function(data) {

            console.log('url: ' + url);
            console.log(data);

            var ctx = document.getElementById("barChart1").getContext('2d');

            qualisChart = new Chart(ctx, {
                type: 'line',


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


            });;
        });
        $("#buscar").click(function() {
            var e = document.getElementById("estratoSelect");
            var strEstrato = e.options[e.selectedIndex].value;
            console.log(strEstrato);


            $.post(url + 'atualizaQualisPorEstrato', {
                estrato: strEstrato
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

        $.getJSON(url + 'qualisPorAno', function(data) {
            console.log('url: ' + data);


            var ctx = document.getElementById("barChart4").getContext('2d');

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
            var e = document.getElementById("ano");
            var strAno = e.options[e.selectedIndex].value;
            //console.log(strAno);


            $.post(url + 'atualizaQualis', {
                ano: strAno
            }, function(data) {

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