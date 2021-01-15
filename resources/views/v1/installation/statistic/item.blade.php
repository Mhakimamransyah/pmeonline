@extends('v1.layouts.list')

@section('content-header')

    <h1>{{ 'Statistik : ' . $parameter->name }}</h1>

@endsection

@section('content')

    <div id="progress-alert">
        <div class="alert alert-warning" role="alert">Proses perhitungan belum selesai ...</div>
    </div>

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            @for($i = 0; $i < $bottle_total; $i++)
            <li class="@if($bottle_id == $i) active @endif"><a href="{{ route('installation.statistic', ['parameter_id' => $parameter->id, 'bottle_id' => $i,]) }}">Botol {{ $i + 1 }}</a></li>
            @endfor
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">

                <div class="row">

                    <div class="col-xs-12 table-responsive">

                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr class="bg-aqua">
                                <th class="text-center">{{ '#' }}</th>
                                <th class="text-center">{{ 'No. Peserta' }}</th>
                                <th class="text-center">{{ $parameter->name }}</th>
                                <th class="text-center">{{ 'U*' }}</th>
                                <th class="text-center">{{ 'Nilai Evaluasi' }}</th>
                                <th class="text-center">{{ 'SDPA' }}</th>
                                <th class="text-center">{{ 'Z-Score' }}</th>
                                <th class="text-center">{{ 'Kategori' }}</th>
                                <th class="text-center">{{ 'Kesimpulan' }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($i = 1)
                            @foreach($statistic as $item)
                                @if($item->bottle->parameter->hasil_raw != null || $item->bottle->parameter->hasil_raw != "")
                                    <tr class="@if($item->bottle->parameter->hasil == null) bg-gray-light @endif" id="{{ 'row-' . $item->id }}">
                                        <td class="text-center @if($item->bottle->parameter->hasil != null) bg-aqua @else bg-gray @endif" id="{{ 'id-' . $item->id }}">{{ $i }}</td>
                                        <td class="text-center @if($item->bottle->parameter->hasil != null) bg-info @endif" id="{{ 'participant_number-' . $item->id }}">{{ $item->participant_number }}</td>
                                            @if($item->bottle->parameter->hasil != null)
                                                <td class="text-center">{{ $item->bottle->parameter->hasil }}</td>
                                            @else
                                                <td class="text-center">{{ $item->bottle->parameter->hasil_raw }}</td>
                                            @endif
                                        <td class="text-center">{{ $item->bottle->parameter->ketidakpastian }}</td>
                                        @if($item->bottle->parameter->hasil != null)
                                            <td class="text-center mean">{{ '-' }}</td>
                                            <td class="text-center sdpa">{{ '-' }}</td>
                                        @else
                                            <td class="text-center">{{ '-' }}</td>
                                            <td class="text-center">{{ '-' }}</td>
                                        @endif
                                        <td class="text-center" id="{{ 'z_score-' . $item->id }}">{{ '-' }}</td>
                                        <td class="text-center" id="{{ 'kategori-' . $item->id }}">{{ '-' }}</td>
                                        <td class="text-center" id="{{ 'kesimpulan-' . $item->id }}">{{ '-' }}</td>
                                    </tr>
                                    @php($i++)
                                @endif
                            @endforeach
                            </tbody>
                        </table>

                    </div>

                </div>

                <hr/>

                <div class="row">

                    <div class="col-xs-12">

                        <h3 class="text-center">Grafik Kategori</h3>

                        <div class="chart">
                            <canvas id="chart-1" width="1115" height="557" class="chartjs-render-monitor" style="display: block; width: 1115px; height: 557px;"></canvas>
                        </div>

                    </div>

                </div>

                <hr/>

                <div class="row">

                    <div class="col-xs-12">

                        <h3 class="text-center">Grafik Z-Score</h3>

                        <div class="chart">
                            <canvas id="chart-2" width="1115" height="557" class="chartjs-render-monitor" style="display: block; width: 1115px; height: 557px;"></canvas>
                        </div>

                    </div>

                </div>

                <hr/>

                <div class="row">

                    <div class="col-xs-12">

                        <h3 class="text-center">Grafik SDPA</h3>

                        <div class="chart">
                            <canvas id="chart-3" width="1115" height="557" class="chartjs-render-monitor" style="display: block; width: 1115px; height: 557px;"></canvas>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection

@section('body-bottom')

    @if(isset($statistic) && $statistic != null)

        <script>
            $(function () {
                let jsonString = '{!! json_encode($statistic) !!}'.replace(/\\n/g, "\\n")
                    .replace(/\\'/g, "\\'")
                    .replace(/\\"/g, '\\"')
                    .replace(/\\&/g, "\\&")
                    .replace(/\\r/g, "\\r")
                    .replace(/\\t/g, "\\t")
                    .replace(/\\b/g, "\\b")
                    .replace(/\\f/g, "\\f");
                let statistic = JSON.parse(jsonString);
                let countable = statistic.filter(function (item) {
                    return item.bottle.parameter.hasil != null;
                });
                let results = countable.map(function (item) {
                    return item.bottle.parameter.hasil;
                });
                $.ajax({
                    type: 'POST',
                    url: 'http://35.240.172.178:8522/find-algorithm-a',
                    data: JSON.stringify({
                        items: results,
                    }),
                    contentType: "application/json; charset=utf-8",
                    dataType: 'json',
                    success: function (data) {
                        calculate(data, countable);
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            });

            function calculate(data, countable) {
                let meanLabels = document.getElementsByClassName('mean');
                $.each(meanLabels, function (index, item) {
                    item.innerHTML = data.mean.toFixed(3);
                });

                let sdpa = data.shorwit;
                let sdpaLabels = document.getElementsByClassName('sdpa');
                $.each(sdpaLabels, function (index, item) {
                    item.innerHTML = sdpa.toFixed(3);
                });

                let labels = [];
                let categoryValue = [];
                let values = [];
                let colors = [];
                let zScores = [];

                $.each(countable, function (index, item) {
                    let z_score = (item.bottle.parameter.hasil - data.mean) / sdpa;
                    let zScoreLabel = document.getElementById('z_score-' + item.id);
                    zScoreLabel.innerHTML = z_score.toFixed(3);

                    let category = (Math.abs(z_score) <= 2) ? 'OK' : (Math.abs(z_score) < 3) ? '$' : '$$';
                    let categoryLabel = document.getElementById('kategori-' + item.id);
                    categoryLabel.innerHTML = category;

                    let conclution = (Math.abs(z_score) <= 2) ? 'Memuaskan' : (Math.abs(z_score) < 3) ? 'Meragukan' : 'Kurang Memuaskan';
                    let conclutionLabel = document.getElementById('kesimpulan-' + item.id);
                    conclutionLabel.innerHTML = conclution;

                    let backgroundClass = (Math.abs(z_score) <= 2) ? '' : (Math.abs(z_score) < 3) ? 'bg-warning' : 'bg-danger';
                    let backgroundClass2 = (Math.abs(z_score) <= 2) ? '' : (Math.abs(z_score) < 3) ? 'bg-yellow' : 'bg-red';
                    let row = document.getElementById('row-' + item.id);
                    let idLabel = document.getElementById('id-' + item.id);
                    let participantNumberLabel = document.getElementById('participant_number-' + item.id);
                    if (backgroundClass !== '' && backgroundClass2 !== '') {
                        row.classList.add(backgroundClass);
                        idLabel.classList.remove('bg-aqua');
                        idLabel.classList.add(backgroundClass2);
                        participantNumberLabel.classList.remove('bg-info');
                        participantNumberLabel.classList.add(backgroundClass);
                    }

                    labels.push(item.participant_number);
                    categoryValue.push((Math.abs(z_score) <= 2) ? 0.5 : (Math.abs(z_score) < 3) ? 1.5 : 2.5);
                    colors.push((Math.abs(z_score) <= 2) ? 'rgba(13, 230, 13, 0.2)' : (Math.abs(z_score) < 3) ? 'rgba(230, 230, 13, 0.2)' : 'rgba(230, 13, 13, 0.2)');
                    zScores.push(z_score);
                    values.push(item.bottle.parameter.hasil);
                });

                drawChartCategory(labels, categoryValue, colors);
                drawChartZScore(labels, zScores, colors);
                drawChartSdpa(data.mean, sdpa, labels, values);
                done();
            }

            function done() {
                document.getElementById('progress-alert').remove();
            }

            function drawChartCategory(labels, value, colors) {
                var ctx = document.getElementById('chart-1').getContext('2d');
                var chart = new Chart(ctx, {
                    // The type of chart we want to create
                    type: 'bar',

                    // The data for our dataset
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Kategori',
                            backgroundColor: colors,
                            borderColor: colors,
                            data: value,
                        }]
                    },

                    // Configuration options go here
                    options: {
                        responsive: true,
                        legend: {
                            display: false
                        },
                        title: {
                            display: false,
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    callback: function (value) { if (Number.isInteger(value)) { return value; } },
                                    stepSize: 1,
                                    max: 3,
                                }
                            }],
                            xAxes: [{
                                ticks: {
                                }
                            }]
                        }
                    }
                });
            }

            function drawChartZScore(labels, value, colors) {
                var ctx = document.getElementById('chart-2').getContext('2d');
                var chart = new Chart(ctx, {
                    // The type of chart we want to create
                    type: 'bar',

                    // The data for our dataset
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Z-Score',
                            backgroundColor: colors,
                            borderColor: colors,
                            data: value,
                        }]
                    },

                    // Configuration options go here
                    options: {
                        responsive: true,
                        legend: {
                            display: false
                        },
                        title: {
                            display: false,
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    callback: function (value) { if (Number.isInteger(value)) { return value; } },
                                    stepSize: 1,
                                }
                            }],
                            xAxes: [{
                                ticks: {
                                }
                            }]
                        }
                    }
                });
            }

            function drawChartSdpa(mean, sdpa, labels, value) {
                let sdpas2p = [];
                let sdpas3p = [];
                let sdpas2m = [];
                let sdpas3m = [];
                $.each(labels, function (index, item) {
                    sdpas2p.push(mean + (2 * sdpa));
                    sdpas3p.push(mean + (3 * sdpa));
                    sdpas2m.push(mean - (2 * sdpa));
                    sdpas3m.push(mean - (3 * sdpa));
                });
                var ctx = document.getElementById('chart-3').getContext('2d');
                var chart = new Chart(ctx, {
                    // The type of chart we want to create
                    type: 'line',

                    // The data for our dataset
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'sdpa 2p',
                            borderColor: 'rgba(230, 230, 13, 0.2)',
                            data: sdpas2p,
                            fill: false,
                        }, {
                            label: 'sdpa 3p',
                            borderColor: 'rgba(230, 13, 13, 0.2)',
                            data: sdpas3p,
                            fill: false,
                        }, {
                            label: 'sdpa 2m',
                            borderColor: 'rgba(230, 230, 13, 0.2)',
                            data: sdpas2m,
                            fill: false,
                        }, {
                            label: 'sdpa 3m',
                            borderColor: 'rgba(230, 13, 13, 0.2)',
                            data: sdpas3m,
                            fill: false,
                        }, {
                            label: 'hasil',
                            data: value,
                            fill: false,
                        }]
                    },

                    // Configuration options go here
                    options: {
                        responsive: true,
                        legend: {
                            display: false
                        },
                        title: {
                            display: false,
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    stepSize: 1,
                                }
                            }],
                            xAxes: [{
                                ticks: {
                                }
                            }]
                        }
                    }
                });
            }
        </script>

    @endif

@endsection