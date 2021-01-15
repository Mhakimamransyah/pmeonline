{{--kimia klinik--}}
@php
    $cycle = \App\Cycle::first();
    $hematologi = "HEMATOLOGI";
    $orderPackage = \App\OrderPackage::findOrFail($order_package_id);
    $result_obj = json_decode($result);
@endphp

@extends('layouts.graph')

@section('style-override')

    @component('score.style-override')
    @endcomponent

@endsection

@section('content')

    @if(env("APP_DEBUG"))
    {!! $result !!}
    @endif

    @php
    $parameter_index = 0;
    @endphp
    @foreach($result_obj->result->parameters as $parameter)
    <h3>{{ $parameter->name }}</h3>

    <div class="row">

        <div class="col-xs-4">

            <h4>Seluruh Peserta</h4>

            <div class="chart">
                <canvas id="{{ 'chart-' . $parameter_index . '-all' }}" width="400" height="300" class="chartjs-render-monitor" style="display: block; width: 400px; height: 300px;"></canvas>
            </div>

        </div>

        <div class="col-xs-4">
            <h4>Kelompok Metode</h4>

            <div class="chart">
                <canvas id="{{ 'chart-' . $parameter_index . '-metode' }}" width="400" height="300" class="chartjs-render-monitor" style="display: block; width: 400px; height: 300px;"></canvas>
            </div>
        </div>

        <div class="col-xs-4">
            <h4>Kelompok Alat</h4>

            <div class="chart">
                <canvas id="{{ 'chart-' . $parameter_index . '-alat' }}" width="400" height="300" class="chartjs-render-monitor" style="display: block; width: 400px; height: 300px;"></canvas>
            </div>
        </div>

    </div>

    @php
    $parameter_index += 1;
    @endphp

    @endforeach

@endsection

@section('script')

    <script>
        $(function () {
            let data = JSON.parse('{!! $result !!}');
            console.log(data);
            let labels = [];
            let value = [];
            let colors = [];

            $.each(data.result.parameters, function(index, item) {
                console.log(item);
                labels.push(item.participant_number);
                value.push(item.kategori);
                if (item.kategori <= 1) {
                    colors.push('rgba(13, 230, 13, 0.2)'); // green
                } else if (item.kategori <= 2) {
                    colors.push('rgba(230, 230, 13, 0.2)'); // yellow
                } else {
                    colors.push('rgba(230, 13, 13, 0.2)'); // red
                }

                var ctx = document.getElementById('chart-1-all').getContext('2d');
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
                                    stepSize: 1
                                }
                            }]
                        }
                    }
                });
            });
        });
    </script>

@endsection