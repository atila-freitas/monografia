$(function(){
    var url = 'http://127.0.0.1:8000/api/gis/v1/';

    

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
});