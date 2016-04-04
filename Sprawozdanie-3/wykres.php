<?php // Kawalek kodu w widoku, odpowiadajacy za pobranie i wyswietlenie danych.
$js = <<< KONIEC
$(function () {
    $.getJSON('https://api.bluequeen.tk/v1/weather?chart=true', function (data) {
        // Create a timer
        var start = +new Date();
		
        // Create the chart
		Highcharts.setOptions({
			{$lang}
		});
		
        $('#CH-container').highcharts('StockChart', {
            chart: {
                events: {
                    load: function () {
                        if (!window.isComparing) {
                            this.setTitle(null, {
                                text: '{$builtIn} ' + (new Date() - start) + 'ms'
                            });
                        }
                    }
                },
                zoomType: 'x'
            },
            rangeSelector: {

                buttons: [{
                    type: 'day',
                    count: 1,
                    text: '1d'
                }, {
                    type: 'day',
                    count: 2,
                    text: '2d'
                }, {
                    type: 'day',
                    count: 3,
                    text: '3d'
                },{
                    type: 'day',
                    count: 5,
                    text: '5d'
                }, {
                    type: 'week',
                    count: 1,
                    text: '1w'
                }, {
                    type: 'month',
                    count: 1,
                    text: '1m'
                }, {
                    type: 'month',
                    count: 6,
                    text: '6m'
                }, {
                    type: 'year',
                    count: 1,
                    text: '1y'
                }, {
                    type: 'all',
                    text: 'All'
                }],
                selected: 2
            },

            yAxis: {
                title: {
                    text: 'Temperature (°C)'
                }
            },
			
			xAxis: {
				type: 'datetime',
			},

            subtitle: {
                text: 'Built chart in ...' // dummy text to reserve space for dynamic subtitle
            },

            series: [{
                name: 'Temperature',
                data: data,
                tooltip: {
                    valueDecimals: 2,
                    valueSuffix: '°C'
                }
            }]

        });
    });
});
KONIEC;

$this->registerJs($js, \yii\web\View::POS_END);