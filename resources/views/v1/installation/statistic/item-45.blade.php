@extends('v1.layouts.list')

@section('content-header')

    <h1>{{ 'Statistik : ' . $parameter->name }}</h1>

@endsection

@section('content')

    <div class="box box-default">
        <div class="box-body">

            <div class="row">

                <div class="col-xs-12 table-responsive">

                    <table class="table table-bordered table-hover">
                        <thead class="bg-aqua">
                        <tr>
                            <th rowspan="2" width="4%" class="text-center" style="vertical-align: middle">{{ 'No.' }}</th>
                            <th rowspan="2" width="8%" class="text-center" style="vertical-align: middle">{{ 'Kode Sampel' }}</th>
                            <th rowspan="2" width="16%" class="text-center" style="vertical-align: middle">{{ 'Peserta' }}</th>
                            <th rowspan="2" width="20%" class="text-center" style="vertical-align: middle">{{ 'Nama Reagen yang Digunakan' }}</th>
                            <th colspan="3" width="20%" class="text-center" style="vertical-align: middle">{{ 'Hasil Jawaban' }}</th>
                            <th colspan="3" width="16%" class="text-center" style="vertical-align: middle">{{ 'Hasil Rujukan' }}</th>
                            <th rowspan="2" width="20%" class="text-center" style="vertical-align: middle">{{ 'Keterangan' }}</th>
                        </tr>
                        <tr>
                            <th class="text-center" style="vertical-align: middle">{{ '001-062' }}</th>
                            <th class="text-center" style="vertical-align: middle">{{ '063-124' }}</th>
                            <th class="text-center" style="vertical-align: middle">{{ '125-186' }}</th>
                            <th class="text-center" style="vertical-align: middle">{{ '001-062' }}</th>
                            <th class="text-center" style="vertical-align: middle">{{ '063-124' }}</th>
                            <th class="text-center" style="vertical-align: middle">{{ '125-186' }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($i = 0)
                        @foreach($statistic as $province)
                            @foreach($province->data as $laboratory)
                                <tr>
                                    <td rowspan="1" class="text-center bg-info" style="vertical-align: middle">{{ $i + 1 }}</td>
                                    <td rowspan="1" class="text-center bg-info" style="vertical-align: middle">
                                        @for($x = 0; $x < 3; $x++)
                                            {{ preg_replace('/[^0-9]/', '', isset($laboratory->input->{ 'kode_bahan_kontrol_' . $x }) ? $laboratory->input->{ 'kode_bahan_kontrol_' . $x } : '') }}
                                            @if ($x != 2)
                                                {{ '/' }}
                                            @endif
                                        @endfor
                                    </td>
                                    <td rowspan="1" class="text-center" style="vertical-align: middle;">
                                        <a href="{{ '/installation/score/' . $laboratory->score_id }}" target="_blank">{{ $laboratory->name }}</a>
                                    </td>
                                    <td class="text-center" style="vertical-align: middle">
                                        @if (isset($laboratory->input->nama_reagen) && $laboratory->input->nama_reagen != null)
                                            {{ $laboratory->input->nama_reagen }}
                                        @else
                                            {{ '-' }}
                                        @endif
                                    </td>

                                    <td class="text-center" style="vertical-align: middle">{{ $laboratory->input->hasil_0 }}</td>
                                    <td class="text-center" style="vertical-align: middle">{{ $laboratory->input->hasil_1 }}</td>
                                    <td class="text-center" style="vertical-align: middle">{{ $laboratory->input->hasil_2 }}</td>

                                    @if (isset($laboratory->score) && $laboratory->score != null)
                                        <td class="text-center" style="vertical-align: middle">{{ $laboratory->score->rujukan[0] }}</td>
                                        <td class="text-center" style="vertical-align: middle">{{ $laboratory->score->rujukan[1] }}</td>
                                        <td class="text-center" style="vertical-align: middle">{{ $laboratory->score->rujukan[2] }}</td>
                                        <td class="text-center" style="vertical-align: middle" rowspan="1">{{ $laboratory->score->saran }}</td>
                                    @else
                                        <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                        <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                        <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                        <td class="text-center bg-warning" style="vertical-align: middle" rowspan="1">{{ 'Belum Dinilai' }}</td>
                                    @endif
                                </tr>
                                @php($i++)
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>

@endsection
