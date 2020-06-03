@extends('layout.page')

@section('content')

    @foreach ($dados as $titulo => $name)
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title text-light-blue">{{ $titulo }}</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="padding-top: 0;">
                <div class="row">
                    <div class="col-lg-6" style="padding-top: 15px;">
                        <div class="chart-responsive">
                            <canvas id="{{ $name }}" height="60"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="chart-responsive">
                            <canvas id="{{ $name }}Geral" height="80"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    @endforeach

@endsection

@section('js')
    <script>
        var url = "<?php echo env('API_URL', 'http://127.0.0.1:8000/api/gis/v1/'); ?>";
        console.log('url: ' + url);

        var colors = [
            '#16A45F', '#408CB8', '#f46A59', '#1ABEEC', '#F29B33',
            '#3F51B5', '#FFEB3B', '#2196F3', '#009688', '#03A9F4',
            '#CDDC39', '#4CAF50', '#FFC107', '#8BC34A', '#FF5722',
            '#9C27B0', '#673AB7', '#78909C', '#4DD0E1', '#8D6E63',
            '#F06292', '#BDBDBD', '#F44336', '#4DB6AC', '#E91E63'
        ];

        $.getJSON(url + 'estatisticas', function(data) {
            $.each(data, function(key, value) {
                var labels = [];
                var dados = [];

                $.each(value, function(pais, quantidade) {
                    labels.push(pais);
                    dados.push(quantidade);
                });

                var scale = {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }],
                    xAxes: [{
                        maxBarThickness : 100
                    }]
                };

                var type = 'bar';
                var displayTitle = false;

                if (~key.indexOf("Geral")) {
                    type = 'doughnut';
                    displayTitle = true;
                    scale = {};
                }

                var ctx = document.getElementById(key).getContext('2d');

                var myChart = new Chart(ctx, {
                    type: type,
                    data: {
                        labels: labels,
                        datasets : [
                            {
                                backgroundColor: colors,
                                hoverBackgroundColor: colors,
                                borderWidth: 0,
                                data: dados
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            labels: {
                                //render: 'value',
                                showZero: true,
                                fontSize: 14,
                                fontColor: 'black',
                                fontStyle: 'bold',
                                render: function (args) {
                                    if (args.value < 5)
                                        return args.value;
                                    return '';
                                }
                            },
                            datalabels: {
                                color: 'black',
                                display: function(context) {
                                    return context.dataset.data[context.dataIndex] > 5;
                                },
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                },
                                anchor: 'center',
                                clamp: true
                            }
                        },
                        scales: scale,
                        legend: {
                            display: false
                        },
                        title: {
                            display: displayTitle,
                            text: 'Brasil vs Exterior'
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
        });
    </script>
@endsection