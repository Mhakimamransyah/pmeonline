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
                            <th colspan="6" width="24%" class="text-center" style="vertical-align: middle">{{ 'Hasil Jawaban' }}</th>
                            <th colspan="3" width="12%" class="text-center" style="vertical-align: middle">{{ 'Hasil Rujukan' }}</th>
                            <th rowspan="2" width="16%" class="text-center" style="vertical-align: middle">{{ 'Keterangan' }}</th>
                        </tr>
                        <tr>
                            <th class="text-center" style="vertical-align: middle">{{ '001-078' }}</th>
                            <th class="text-center" style="vertical-align: middle">{{ 'Kesesuaian Strategi' }}</th>
                            <th class="text-center" style="vertical-align: middle">{{ '079-156' }}</th>
                            <th class="text-center" style="vertical-align: middle">{{ 'Kesesuaian Strategi' }}</th>
                            <th class="text-center" style="vertical-align: middle">{{ '157-234' }}</th>
                            <th class="text-center" style="vertical-align: middle">{{ 'Kesesuaian Strategi' }}</th>
                            <th class="text-center" style="vertical-align: middle">{{ '001-078' }}</th>
                            <th class="text-center" style="vertical-align: middle">{{ '079-156' }}</th>
                            <th class="text-center" style="vertical-align: middle">{{ '157-234' }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($i = 0)
                        @foreach($statistic as $province)
                            @foreach($province->data as $laboratory)
                                <tr>
                                    <td rowspan="3" class="text-center bg-info" style="vertical-align: middle">{{ $i + 1 }}</td>
                                    <td rowspan="3" class="text-center bg-info" style="vertical-align: middle">
                                        @for($x = 0; $x < 3; $x++)
                                            {{ preg_replace('/[^0-9]/', '', isset($laboratory->input->{ 'kode_bahan_kontrol_' . $x }) ? $laboratory->input->{ 'kode_bahan_kontrol_' . $x } : '') }}
                                            @if ($x != 2)
                                                {{ '/' }}
                                            @endif
                                        @endfor
                                    </td>
                                    <td rowspan="3" class="text-center" style="vertical-align: middle;">
                                        <a href="{{ '/installation/score/' . $laboratory->score_id }}" target="_blank">{{ $laboratory->name }}</a>
                                    </td>
                                    <td class="text-center" style="vertical-align: middle">
                                        @if (isset($laboratory->input->reagen_tes1) && $laboratory->input->reagen_tes1 != null)
                                            @php($reagent = \App\Reagent::where('parameter_id', '=', 43)->where('value', '=', $laboratory->input->reagen_tes1)->first())
                                            {{ $reagent->text }}
                                        @else
                                            {{ '-' }}
                                        @endif
                                    </td>

                                    <td class="text-center" style="vertical-align: middle">{{ $laboratory->input->hasil_panel_0_tes_1 }}</td>
                                    @if (isset($laboratory->score) && $laboratory->score != null)
                                        <td class="text-center {{ $laboratory->score->sesuai[0] == 5 ? 'bg-success' : 'bg-danger' }}" style="vertical-align: middle" rowspan="3">{{ $laboratory->score->sesuai[0] == 5 ? 'Sesuai' : 'Tidak Sesuai' }}</td>
                                    @else
                                        <td class="text-center bg-warning" style="vertical-align: middle" rowspan="3">{{ 'Belum Dinilai' }}</td>
                                    @endif

                                    <td class="text-center" style="vertical-align: middle">{{ $laboratory->input->hasil_panel_1_tes_1 }}</td>
                                    @if (isset($laboratory->score) && $laboratory->score != null)
                                        <td class="text-center {{ $laboratory->score->sesuai[1] == 5 ? 'bg-success' : 'bg-danger' }}" style="vertical-align: middle" rowspan="3">{{ $laboratory->score->sesuai[1] == 5 ? 'Sesuai' : 'Tidak Sesuai' }}</td>
                                    @else
                                        <td class="text-center bg-warning" style="vertical-align: middle" rowspan="3">{{ 'Belum Dinilai' }}</td>
                                    @endif

                                    <td class="text-center" style="vertical-align: middle">{{ $laboratory->input->hasil_panel_2_tes_1 }}</td>
                                    @if (isset($laboratory->score) && $laboratory->score != null)
                                        <td class="text-center {{ $laboratory->score->sesuai[2] == 5 ? 'bg-success' : 'bg-danger' }}" style="vertical-align: middle" rowspan="3">{{ $laboratory->score->sesuai[2] == 5 ? 'Sesuai' : 'Tidak Sesuai' }}</td>
                                    @else
                                        <td class="text-center bg-warning" style="vertical-align: middle" rowspan="3">{{ 'Belum Dinilai' }}</td>
                                    @endif

                                    @if (isset($laboratory->score) && $laboratory->score != null)
                                        <td class="text-center" style="vertical-align: middle">{{ $laboratory->score->rujukan[0][0] }}</td>
                                        <td class="text-center" style="vertical-align: middle">{{ $laboratory->score->rujukan[1][0] }}</td>
                                        <td class="text-center" style="vertical-align: middle">{{ $laboratory->score->rujukan[2][0] }}</td>
                                        <td class="text-center" style="vertical-align: middle" rowspan="3">{{ $laboratory->score->saran }}</td>
                                    @else
                                        <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                        <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                        <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                        <td class="text-center bg-warning" style="vertical-align: middle" rowspan="3">{{ 'Belum Dinilai' }}</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td class="text-center" style="vertical-align: middle">
                                        @if (isset($laboratory->input->reagen_tes2) && $laboratory->input->reagen_tes2 != null)
                                            @php($reagent = \App\Reagent::where('parameter_id', '=', 43)->where('value', '=', $laboratory->input->reagen_tes2)->first())
                                            {{ $reagent->text }}
                                        @else
                                            {{ '-' }}
                                        @endif
                                    </td>
                                    <td class="text-center" style="vertical-align: middle">{{ $laboratory->input->hasil_panel_0_tes_2 }}</td>
                                    <td class="text-center" style="vertical-align: middle">{{ $laboratory->input->hasil_panel_1_tes_2 }}</td>
                                    <td class="text-center" style="vertical-align: middle">{{ $laboratory->input->hasil_panel_2_tes_2 }}</td>

                                    @if (isset($laboratory->score) && $laboratory->score != null)
                                        <td class="text-center" style="vertical-align: middle">{{ $laboratory->score->rujukan[0][1] }}</td>
                                        <td class="text-center" style="vertical-align: middle">{{ $laboratory->score->rujukan[1][1] }}</td>
                                        <td class="text-center" style="vertical-align: middle">{{ $laboratory->score->rujukan[2][1] }}</td>
                                    @else
                                        <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                        <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                        <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td class="text-center" style="vertical-align: middle">
                                        @if (isset($laboratory->input->reagen_tes3) && $laboratory->input->reagen_tes3 != null)
                                            @php($reagent = \App\Reagent::where('parameter_id', '=', 43)->where('value', '=', $laboratory->input->reagen_tes3)->first())
                                            {{ $reagent->text }}
                                        @else
                                            {{ '-' }}
                                        @endif
                                    </td>
                                    <td class="text-center" style="vertical-align: middle">{{ $laboratory->input->hasil_panel_0_tes_3 }}</td>
                                    <td class="text-center" style="vertical-align: middle">{{ $laboratory->input->hasil_panel_1_tes_3 }}</td>
                                    <td class="text-center" style="vertical-align: middle">{{ $laboratory->input->hasil_panel_2_tes_3 }}</td>

                                    @if (isset($laboratory->score) && $laboratory->score != null)
                                        <td class="text-center" style="vertical-align: middle">{{ $laboratory->score->rujukan[0][2] }}</td>
                                        <td class="text-center" style="vertical-align: middle">{{ $laboratory->score->rujukan[1][2] }}</td>
                                        <td class="text-center" style="vertical-align: middle">{{ $laboratory->score->rujukan[2][2] }}</td>
                                    @else
                                        <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                        <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                        <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
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
