@extends('layout.page')

@section('content')

    <div class="center">
        <h3 style="margin: 0 0 15px 0;">{{ $pais }}</h3>
    </div>

    @if (empty($dados))
        <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12 col-lg-offset-2 col-md-offset-3" style="margin-top: 20px;">
            <div class="alert alert-warning">
                <h4 style="@if (empty($submensagem)) margin: 0; @endif "><i class="icon fa fa-warning"></i> Nenhum dado encontrado desse país</h4>
            </div>
        </div>
    @else
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                @foreach ($dados as $key => $value)
                    <li @if ($loop->first) class="active" @endif><a href="#tab_{{ $key }}" data-toggle="tab">{{ str_replace('_', ' ', $key) }}</a></li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach ($dados as $key => $value)
                    <div class="tab-pane @if ($loop->first) active @endif" id="tab_{{ $key }}">
                        <div class="box-body table-responsive">
                            <table class="table table-striped table-bordered dataTables">
                                <thead>
                                    <tr>
                                        <th>Nome Completo</th>
                                        <th>Instituição</th>
                                        <th>Curso</th>
                                        <th>Ano de Conclusão</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($value as $info)
                                        <tr>
                                            <td>{{ ((object) $info)->nome }}</td>
                                            <td>{{ ((object) $info)->nome_instituicao}}</td>
                                            <td>{{ ((object) $info)->curso }}</td>
                                            <td>{{ ((object) $info)->ano }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="chart-responsive">
                                <canvas id="graph_{{ $key }}" height="60"></canvas>
                            </div>

                            @if ($key != "Livre_Docência")
                                <div class="chart-responsive">
                                    <canvas id="graph_{{ $key }}Status" height="80"></canvas>
                                </div>
                            @endif
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.tab-pane -->
                @endforeach
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- nav-tabs-custom -->
    @endif

@endsection

@section('js')
    <script>
        var url = "<?php echo env('API_URL', 'http://127.0.0.1:8000/api/gis/v1/'); ?>";
        console.log('url: ' + url);

        var sigla = "<?php echo $siglaBusca; ?>";
        console.log('sigla: ' + sigla);

        var colors = [
            '#16A45F', '#408CB8', '#f46A59', '#1ABEEC', '#F29B33',
            '#3F51B5', '#FFEB3B', '#2196F3', '#009688', '#03A9F4',
            '#CDDC39', '#4CAF50', '#FFC107', '#8BC34A', '#FF5722',
            '#9C27B0', '#673AB7', '#78909C', '#4DD0E1', '#8D6E63',
            '#F06292', '#BDBDBD', '#F44336', '#4DB6AC', '#E91E63'
        ];

        $.post(url + 'pais', { sigla: sigla }, function(data) {
            $.each(data, function(key, value) {
                var labels = [];
                var dados = [];

                $.each(value, function(label, quantidade) {
                    if (label === "CONCLUIDO") label = "Concluído";
                    else if (label === "EM_ANDAMENTO") label = "Em Andamento";
                    else if (label === "INCOMPLETO") label = "Incompleto";

                    labels.push(label);
                    dados.push(quantidade);
                });

                var scale = {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        },
                        maxBarThickness : 30
                    }],
                    xAxes: [{
                        maxBarThickness : 200
                    }]
                };

                var type = 'horizontalBar';
                var displayTitle = false;
                var displayLegend = false;

                if (~key.indexOf("Status")) {
                    type = 'doughnut';
                    displayTitle = true;
                    displayLegend = true;
                    scale = {};
                }

                var ctx = document.getElementById("graph_" + key).getContext('2d');

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
                        plugins: {
                            labels: {
                                //render: 'value',
                                showZero: true,
                                fontSize: 14,
                                fontColor: 'black',
                                fontStyle: 'bold',
                                render: function (args) {
                                    if (args.value < 3)
                                        return args.value;
                                    return '';
                                }
                            },
                            datalabels: {
                                color: 'black',
                                display: function(context) {
                                    return context.dataset.data[context.dataIndex] > 3;
                                },
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                },
                                anchor: 'center',
                                align: 'center',
                                clamp: false
                            }
                        },
                        scales: scale,
                        legend: {
                            display: displayLegend,
                            position: 'bottom'
                        },
                        title: {
                            display: displayTitle,
                            text: 'Situação do Curso'
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