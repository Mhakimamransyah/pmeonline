@extends('v1.layouts.dashboard')

@section('content')

    @php($role_id = \Illuminate\Support\Facades\Auth::user()->roles->first()->id)

    @if($role_id == 5)
        @php($col_class = 'col-xs-3')
    @elseif($role_id == 7)
        @php($col_class = 'col-xs-4')
    @else
        @php($col_class = 'col-xs-4')
    @endif

    <form method="get" action="{{ route('installation.graph') }}">

        <div class="box box-success">

            <div class="box-body">

                <div class="row">

                    <div class="col-xs-3 col-xs-offset-4">

                        <div class="form-group">
                            <label for="parameter_select">{{ 'Pilih Parameter :' }}</label>
                            <select id="parameter_select" class="form-control select2" style="width: 100%;" tabindex="-1" name="parameter">

                                @if($role_id == 5)
                                @php($packages = \App\Package::all()->whereIn('id', [1, 2, 3, 4]))
                                @elseif($role_id == 7)
                                @php($packages = \App\Package::all()->whereIn('id', [13]))
                                @else
                                @php($packages = \App\Package::all()->whereIn('id', []))
                                @endif

                                @php($selected_parameter = request()->get('parameter'))

                                @foreach($packages as $package)
                                <optgroup label="{{ $package->subject->name }}">
                                    @foreach($package->parameters as $parameter)
                                    <option @if($selected_parameter == $parameter->name) selected @endif>{{ $parameter->name }}</option>
                                    @endforeach
                                </optgroup>
                                @endforeach

                            </select>
                        </div>

                    </div>

                    @if($role_id == 5)

                    <div class="col-xs-1">

                        <div class="form-group">
                            @php($selected_bottle = request()->get('bottle'))
                            <label for="bottle_select">{{ 'Pilih Botol :' }}</label>
                            <select id="bottle_select" class="form-control select2" style="width: 100%;" tabindex="-1" name="bottle">
                                <option value="0" @if($selected_bottle == 0) selected @endif>1</option>
                                <option value="1" @if($selected_bottle == 1) selected @endif>2</option>
                            </select>
                        </div>

                    </div>

                    @elseif($role_id == 7)

                    <input hidden="" title="bottle" value="0" name="bottle">

                    @else

                    @endif

                </div>

            </div>

            <div class="box-footer">

                <div class="text-right">

                    <button type="submit" class="btn btn-info">{{ 'Grafik Laporan Hasil Pemeriksaan Peserta' }}</button>

                </div>

            </div>

        </div>

    </form>

    @if(request()->get('parameter') != null)

        <div class="box box-success">

            <div class="box-body">

                <progress id="chart-1-progress"></progress>

                <div class="chart">
                    <canvas id="chart-1" width="1115" height="557" class="chartjs-render-monitor" style="display: block; width: 1115px; height: 557px;"></canvas>
                </div>

            </div>

        </div>

    @endif

@endsection


@section('body-bottom')

    @if(request()->get('parameter') != null)

        <script>
            $(function () {
                $.ajax({
                    type: 'GET',
                    url: 'http://pme.bblkpalembang.com/pme-scoring/public/statistic-overall',
                    data: {
                        bottle_id: '{{ request()->get('bottle') }}',
                        parameter_name: '{{ request()->get('parameter') }}'
                    },
                    dataType: 'json',
                    success: function (data) {
                        $('#chart-1-progress').hide();
                        console.log(data);
                        let labels = [];
                        let value = [];
                        let colors = [];

                        $.each(data, function(index, item) {
                            console.log(item);
                            labels.push(item.participant_number);
                            value.push(item.kategori - 0.5);
                            if (item.kategori <= 1) {
                                colors.push('rgba(13, 230, 13, 0.2)'); // green
                            } else if (item.kategori <= 2) {
                                colors.push('rgba(230, 230, 13, 0.2)'); // yellow
                            } else {
                                colors.push('rgba(230, 13, 13, 0.2)'); // red
                            }
                        });

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
                    },
                    error: function (data) {
                        $('#chart-1-progress').hide();
                        console.log('Error:', data);
                    }
                });
            });
        </script>

    @endif

@endsection