@extends('layout.page')

@section('content')

    <!-- MAP & BOX PANE -->
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Mapa de influências</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
            <div class="row">
                <div class="col-md-9 col-sm-8">
                    <div class="pad">
                        <!-- Map will be created here -->
                        <div id="world-map-markers" style="height: 325px;"></div>
                        <i class="fa fa-circle text-green"></i> Doutorado</span> &emsp;<i class="fa fa-circle text-red"></i> Pós-Doutorado</span>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-4">
                    <div class="pad box-pane-right bg-green" style="min-height: 280px">
                        <div class="description-block margin-bottom">
                            <div class="col-lg-6 col-md-6 col-sm-6 description-block">
                                <h5 class="description-header">{{ $total['doutorados'] }}</h5>
                                <span class="description-text">Doutorados</span>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 description-block">
                                <h5 class="description-header">{{ $total['posdoutorados'] }}</h5>
                                <span class="description-text">Pós-Doutorados</span>
                            </div>
                        </div>
                        <!-- /.description-block -->
                        <div class="description-block margin-bottom">
                            <div class="chart-responsive">
                                <canvas id="myChart" height="100"></canvas>
                            </div>
                            <!-- ./chart-responsive -->
                        </div>
                        <!-- /.description-block -->
                        <div class="description-block">
                            <h5 class="description-header">{{ $total['cadastros'] }}</h5>
                            <span class="description-text">Cadastros</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
@stop

@section('js')
    <script>
        var url = "<?php echo env('API_URL', 'http://127.0.0.1:8000/api/gis/v1/'); ?>";

        $.getJSON(url + 'busca', function(data) {
            $('#world-map-markers').vectorMap({
                map              : 'world_mill_en',
                normalizeFunction: 'polynomial',
                hoverOpacity     : 0.7,
                hoverColor       : false,
                backgroundColor  : 'transparent',
                regionStyle      : {
                    initial      : {
                        fill            : 'rgba(210, 214, 222, 1)',
                        'fill-opacity'  : 1,
                        stroke          : 'none',
                        'stroke-width'  : 0,
                        'stroke-opacity': 1
                    },
                    hover        : {
                        'fill-opacity': 0.7,
                        cursor        : 'pointer'
                    },
                    selected     : {
                        fill: 'yellow'
                    },
                    selectedHover: {}
                },
                markerStyle      : {
                    initial: {
                        fill  : '#00a65a',
                        stroke: '#111'
                    }
                },
                markers : data,
                onMarkerClick: function(event, index) {
                    alert(data[index].name);
                }
            });
        });

        var ctx = document.getElementById("myChart").getContext('2d');

        var myDoughnutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ["Doutorados", "Pós-doutorados", "Outros"],
                datasets : [
                    {
                        label: 'Player Score',
                        backgroundColor: [
                            'rgba(255, 255, 0, 0.75)',
                            'rgba(0, 255, 0, 0.75)',
                            'rgba(0, 0, 255, 0.75)'
                        ],
                        borderColor: [
                            'rgba(255, 255, 0, 0.75)',
                            'rgba(0, 255, 0, 0.75)',
                            'rgba(0, 0, 255, 0.75)'
                        ],
                        hoverBackgroundColor: [
                            'rgba(255, 255, 0, 0.75)',
                            'rgba(0, 255, 0, 0.75)',
                            'rgba(0, 0, 255, 0.75)'
                        ],
                        hoverBorderColor: 'rgba(0, 0, 0, 1)',
                        data: [658, 192, 69]
                    }
                ]
            },
            options: {
                legend: {
                    display: false
                }
            }
        });
    </script>
@stop