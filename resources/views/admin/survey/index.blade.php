@extends('layouts.dashboard')

@section('content')

    <div class="box box-success">

        <div class="box-header">
            <div class="box-title">
                <h4>Hasil Survey</h4>
            </div>
        </div>

        <div class="box-body">
            {{--<canvas id="myChart" width="400" height="400"></canvas>--}}

            <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="bg-aqua-active">
                <tr>
                    <th width="5%" class="text-center">#</th>
                    <th width="85%">Pertanyaan</th>
                    <th width="10%" class="text-center">Skor Rata-Rata</th>
                </tr>
                </thead>
                <tbody>
                @foreach($raw as $item)
                    <tr>
                        <td class="text-center" style="vertical-align: middle;">{{ $item->id }}</td>
                        <td>
                            <b>{{ $item->title }}</b><br/><br/>
                            <table class="table table-bordered">
                                <tr class="bg-aqua-active">
                                @foreach($item->options as $option)
                                    <th width="25%" class="text-center">{{ $option->title }}</th>
                                @endforeach
                                </tr>
                                <tr>
                                    @foreach($item->options as $option)
                                        <td width="25%" class="text-center">{{ $option->count }}</td>
                                    @endforeach
                                </tr>
                            </table>
                        </td>
                        <td class="text-center" style="vertical-align: middle;"><b>{{ $item->average }}</b></td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr class="bg-aqua-active">
                    <th colspan="2" class="text-right">Rata-Rata</th>
                    <th class="text-center"><b>{{ number_format($average, 2) }}</b></th>
                </tr>
                </tfoot>
            </table>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script src="{{ asset('dist/js/Chart.min.js') }}"></script>

    <script>
        let raw = '{!! $raw !!}';
        let rawData = JSON.parse(raw);
        console.log(rawData);

        let titles = rawData.map(function (item) {
            return item.id;
        });

        let averages = rawData.map(function (item) {
            return item.average;
        });
        console.log(averages);

        var ctx = document.getElementById("myChart");
        var data = {
            labels: titles,
            datasets: [
                {
                    label:  "Rata-Rata: ",
                    data: averages,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1.0)'
                }]
        };

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            beginAtZero: true,
            options: {
                responsive: true,
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Skor Rata-Rata Hasil Survey'
                },
                animation: {
                    animateScale: true
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function (value) { if (Number.isInteger(value)) { return value; } },
                            stepSize: 1
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            display: true //this will remove only the label
                        }
                    }]
                }
            }
        });
    </script>
@endsection