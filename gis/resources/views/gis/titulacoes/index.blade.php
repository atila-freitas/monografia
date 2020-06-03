@extends('layout.page')

@section('content')

    <form id="filterForm">
        <div class="row equal-panels">
            <div class="col-md-3 col-sm-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <i class="fa fa-file-text"></i>
                        <h3 class="box-title">Exibir</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <h3 class="center" style="margin-top: 0;">Titulações</h3>

                        <p class="center pointer" id="selectTitulacoes"><i class="fa fa-check"></i> Selecionar todos</p>

                        <div class="form-group">
                            @foreach($titulacoes as $key => $titulacao)
                                <div class="checkbox">
                                    <label>
                                        <input name="titulacoes[]" type="checkbox" value="{{ $key }}"><span class="checkbox-text">{{ $titulacao }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>

            <div class="col-md-9 col-sm-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <i class="fa fa-search"></i>
                        <h3 class="box-title">Filtros</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="col-md-4 col-sm-12 no-padding">
                            <h3 class="center" style="margin-top: 0;">Centros</h3>

                            <p class="center pointer" id="selectCentros"><i class="fa fa-check"></i> Selecionar todos</p>

                            <div class="form-group">
                                @foreach($centros as $key => $centro)
                                    <div class="checkbox">
                                        <label>
                                            <input name="centros[]" type="checkbox" value="{{ $key }}"><span class="checkbox-text">{{ $centro }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-7 col-md-offset-1 col-sm-12">
                            <h3 class="center" style="margin-top: 0;">Cursos</h3>

                            <p class="center pointer" id="selectCursos"><i class="fa fa-check"></i> Selecionar todos</p>
                            <div class="form-group">
                                <div class="row">
                                    @foreach ($cursosNomes as $curso)
                                        <div class="col-md-6 col-sm-12 no-padding">
                                            <div class="checkbox" style="margin-top: 0; margin-bottom: 5px;">
                                                <label>
                                                    <input name="cursos[]" type="checkbox" value="{{ $curso }}"><span class="checkbox-text">{{ $curso }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

        <div class="form-group" style="text-align: center;">
            <button id="atualizar" type="button" class="btn btn-primary">Atualizar</button>
        </div>
    </form>

    <!-- MAP & BOX PANE -->
    <div class="box box-success" id="box-map">
        <div class="box-header with-border">
            <h3 class="box-title">Mapa de Informações Geográficas</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body no-padding">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="pad">
                        <!-- Map will be created here -->
                        <div id="map" style="height: 325px;"></div>
                        <span class="map-legend"><i class="fa fa-circle" style="color: RoyalBlue;"></i> Graduação</span>
                        <span class="map-legend"><i class="fa fa-circle" style="color: MediumVioletRed;"></i> Aperfeiçoamento &nbsp;</span>
                        <span class="map-legend"><i class="fa fa-circle" style="color: DarkOrange;"></i> Especialização</span>
                        <span class="map-legend"><i class="fa fa-circle" style="color: Yellow;"></i> Mestrado</span>
                        <span><i class="fa fa-circle" style="color: Purple;"></i> Mestrado Profissionalizante</span><br>
                        <span class="map-legend"><i class="fa fa-circle" style="color: LightGreen;"></i> Doutorado</span>
                        <span class="map-legend"><i class="fa fa-circle" style="color: DarkGoldenRod;"></i> Residência Médica</span>
                        <span class="map-legend"><i class="fa fa-circle" style="color: CornflowerBlue;"></i> Livre Docência</span>
                        <span><i class="fa fa-circle" style="color: LightSeaGreen;"></i> Pós-Doutorado</span>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Titulações</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="chart-responsive">
                        <canvas id="pieChart" height="100"></canvas>
                    </div>
                    <!-- ./chart-responsive -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                    <ul class="chart-legend clearfix">
                        <li><i class="fa fa-circle-o" style="color: #16a45f;"></i> Graduação</li>
                        <li><i class="fa fa-circle-o" style="color: #f29b33;"></i> Mestrado</li>
                        <li><i class="fa fa-circle-o" style="color: #408cb8;"></i> Doutorado</li>
                        <li><i class="fa fa-circle-o" style="color: #f46a59;"></i> Pós-doutorado</li>
                        <li><i class="fa fa-circle-o" style="color: #1abeec;"></i> Sem graduação</li>
                    </ul>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer no-padding">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Título</th>
                        <th>Quantidade</th>
                        <th>Porcentagem</th>
                    </tr>
                    </thead>
                    <tbody id="titulacoesChartDesc">
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.footer -->
    </div>
    <!-- /.box -->
    
@endsection

@section('js')
    <script>
        var gis_app = "<?php echo env('GIS_URL', 'https://gis.com/gis/'); ?>";
        console.log('gis url: ' + gis_app);

        var url = "<?php echo env('API_URL', 'http://127.0.0.1:8000/api/gis/v1/'); ?>";
        console.log('url: ' + url);

        var dataMarkers;

        $('#map').vectorMap({
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
            markers: [],
            markerStyle      : {
                initial: {
                    fill  : '#00a65a',
                    stroke: '#111'
                }
            },
            onRegionClick: function(event, code) {
                window.location.href = 'http://127.0.0.1:8000/gis/titulacoes/pais/' + code;
            },
            onMarkerClick: function(event, code) {
                window.location.href = 'http://127.0.0.1:8000/gis/titulacoes/instituicao/' + dataMarkers[code].name;
            }
        });

        $("#atualizar").click(function() {
            $.post(url + 'filter', $("#filterForm").serialize(), function(data) {
                dataMarkers = data;
                removeMapPoint();
                var map = $('#map').vectorMap('get', 'mapObject');
                map.addMarkers(data, []);

                $('html, body').animate({
                    scrollTop: ($('#box-map').offset().top - 45)
                }, 500);
            }, 'json')
            .fail(function() {
                removeMapPoint();
            });
        });

        function removeMapPoint(){
            var map = $('#map').vectorMap('get', 'mapObject');
            map.removeAllMarkers();
        }

        var selectTitulacoes = false;

        $("#selectTitulacoes").click(function() {
            selectTitulacoes = !selectTitulacoes;
            $("input[name='titulacoes[]']").each( function () {
                $(this).prop('checked', selectTitulacoes);
                $(this).iCheck('update');
            });
        });

        var selectCentros = false;

        $("#selectCentros").click(function() {
            selectCentros = !selectCentros;
            $("input[name='centros[]']").each( function () {
                $(this).prop('checked', selectCentros);
                $(this).iCheck('update');
            });
        });

        var selectCursos = false;

        $("#selectCursos").click(function() {
            selectCursos = !selectCursos;
            $("input[name='cursos[]']").each( function () {
                $(this).prop('checked', selectCursos);
                $(this).iCheck('update');
            });
        });

        $.getJSON(url + 'totais', function(data) {
            var labels = ["Graduações", "Mestrados", "Doutorados", "Pós-doutorados", "Sem graduação"];
            var dados = [data['graduacao'], data['mestrado'] + data['mestradoProfissionalizante'], data['doutorado'], data['posDoutorados']];
            var total = Math.max.apply(null, dados);
            var semGraduacao = data['cadastros'] - total;
            total = data['cadastros'];
            dados.push(semGraduacao);

            var colors = ['#16a45f', '#f29b33', '#408cb8', '#f46a59', '#1abeec'];

            var ctx = document.getElementById("pieChart").getContext('2d');

            var myDoughnutChart = new Chart(ctx, {
                type: 'doughnut',
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
                            position: 'outside',
                            arc: true,
                            render: function (args) {
                                return (args.value * 100 / total).toFixed(1) + '%';
                            }
                        },
                        datalabels: {
                            color: 'black',
                            display: function (context) {
                                return false;
                                //return context.dataset.data[context.dataIndex] > 0;
                            },
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            anchor: 'center',
                            clamp: true
                        }
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        custom: function (tooltip) {
                            if (!tooltip) return;
                            // disable displaying the color box;
                            tooltip.displayColors = false;
                            tooltip.bodyFontSize = 14;
                            tooltip.xPadding = 5;
                            tooltip.yPadding = 4;
                        }
                    }
                }
            });

            $.each(dados, function(key, value) {
                $("#titulacoesChartDesc").append('<tr><td>' + labels[key] + '</td><td>' + value + '</td><td>' + (value * 100 / total).toFixed(2) +'%</td></tr>');
            });

            $("#titulacoesChartDesc").append('<tr><td><strong>Total</strong></td><td colspan="2"><strong>' + total + '</strong></td></tr>');
        });
    </script>
@endsection