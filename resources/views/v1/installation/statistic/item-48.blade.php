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
                        <thead>
                        <tr class="bg-aqua">
                            <th width="12%" class="text-center">{{ 'Propinsi' }}</th>
                            <th width="4%" class="text-center">{{ 'No.' }}</th>
                            <th width="20%" class="text-center">{{ 'Peserta' }}</th>
                            <th width="8%" class="text-center">{{ 'Kode Slide' }}</th>
                            <th width="20%" class="text-center">{{ 'Hasil Pemeriksaan oleh Lab Peserta' }}</th>
                            <th width="20%" class="text-center">{{ 'Hasil Pemeriksaan yang Seharusnya' }}</th>
                            <th width="8%" class="text-center">{{ 'Skor' }}</th>
                            <th width="8%" class="text-center">{{ 'Keterangan' }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($i = 0)
                        @foreach($statistic as $province)
                            @php($j = 0)
                            @php($score_current = 0)
                            @php($failed = false)
                            <tr>
                                <td rowspan="{{ count($province->data) * 11 }}" class="text-center bg-yellow" style="vertical-align: middle">{{ $province->name }}</td>
                                <td rowspan="11" class="text-center bg-yellow" style="vertical-align: middle">{{ $i + 1}}</td>
                                <td rowspan="11" class="text-center" style="vertical-align: middle"><a href="{{ '/installation/score/' . $province->data[$j]->score_id }}" target="_blank">{{ $province->data[0]->name }}</a></td>
                                <td class="text-center" style="vertical-align: middle">{{ $province->data[$j]->input->kode_0 }}</td>
                                <td class="text-center" style="vertical-align: middle">{{ $province->data[$j]->input->hasil_0 }}</td>
                                @if (isset($province->data[$j]['score']) && $province->data[$j]['score'] != null)
                                    <td class="text-center" style="vertical-align: middle">{{ $province->data[$j]['score']->isi_benar[0] }}</td>
                                @else
                                    <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Tidak Diisi' }}</td>
                                @endif
                                @if (isset($province->data[$j]['score']->total_seharusnya) && $province->data[$j]['score']->total_seharusnya != null)
                                    <td class="text-center" style="vertical-align: middle">
                                        {{ $province->data[$j]['score']->total_seharusnya[0] }}
                                    </td>
                                @else
                                    <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                @endif
                                @if (isset($province->data[$j]['score']->total_seharusnya[0]) && $province->data[$j]['score']->total_seharusnya[0] != null)
                                    @php($score = (float) $province->data[$j]['score']->total_seharusnya[0])
                                    @php($score_current += $score)
                                    @if ($score >= 2.5)
                                        <td class="text-center" style="vertical-align: middle">
                                            {{ 'Baik' }}
                                        </td>
                                    @else
                                        <td class="text-center" style="vertical-align: middle">
                                            {{ 'Tidak Baik' }}
                                        </td>
                                    @endif
                                @else
                                    <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                @endif
                            </tr>
                            @for($k = 1; $k <= 9; $k++)
                                <tr>
                                    <td class="text-center" style="vertical-align: middle">{{ $province->data[$j]->input->{ 'kode_' . $k } }}</td>
                                    <td class="text-center" style="vertical-align: middle">{{ $province->data[$j]->input->{ 'hasil_' . $k } }}</td>
                                    @if (isset($province->data[$j]['score']) && $province->data[$j]['score'] != null)
                                        <td class="text-center" style="vertical-align: middle">{{ $province->data[$j]['score']->isi_benar[$k] }}</td>
                                    @else
                                        <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Tidak Diisi' }}</td>
                                    @endif
                                    @if (isset($province->data[$j]['score']->total_seharusnya[$k]) && $province->data[$j]['score']->total_seharusnya[$k] != null)
                                        <td class="text-center" style="vertical-align: middle">
                                            {{ $province->data[$j]['score']->total_seharusnya[$k] }}
                                        </td>
                                    @else
                                        <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                    @endif
                                    @if (isset($province->data[$j]['score']->total_seharusnya[$k]) && $province->data[$j]['score']->total_seharusnya[$k] != null)
                                        @php($score = (float) $province->data[$j]['score']->total_seharusnya[$k])
                                        @php($score_current += $score)
                                        @if ($score >= 2.5)
                                            <td class="text-center" style="vertical-align: middle">
                                                {{ 'Baik' }}
                                            </td>
                                        @else
                                            <td class="text-center" style="vertical-align: middle">
                                                {{ 'Tidak Baik' }}
                                            </td>
                                        @endif
                                    @else
                                        <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                    @endif
                                </tr>
                            @endfor
                            <tr class="bg-aqua">
                                <td colspan="3" class="text-center">{{ 'Total' }}</td>
                                <td class="text-center"><b>{{ $score_current / 10 }}</b></td>
                                @php($good = $score_current >= 25.0 && !$failed ? true : false)
                                <td class="text-center"><b>{{ $good ? 'Baik' : 'Tidak Baik' }}</b></td>
                            </tr>
                            @php($j++)
                            @foreach(array_slice($province->data->toArray(), 1) as $laboratory)
                                @php($i++)
                                @php($score_current = 0)
                                @php($failed = false)
                                <tr>
                                    <td rowspan="11" class="text-center bg-yellow" style="vertical-align: middle">{{ $i + 1}}</td>
                                    <td rowspan="11" class="text-center" style="vertical-align: middle"><a href="{{ '/installation/score/' . $province->data[$j]->score_id }}" target="_blank">{{ $laboratory['name'] }}</a></td>
                                    <td class="text-center" style="vertical-align: middle">{{ $province->data[$j]->input->kode_0 }}</td>
                                    <td class="text-center" style="vertical-align: middle">{{ $province->data[$j]->input->hasil_0 }}</td>
                                    @if (isset($province->data[$j]['score']) && $province->data[$j]['score'] != null)
                                        <td class="text-center" style="vertical-align: middle">{{ $province->data[$j]['score']->isi_benar[0] }}</td>
                                    @else
                                        <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Tidak Diisi' }}</td>
                                    @endif
                                    @if (isset($province->data[$j]['score']->total_seharusnya[0]) && $province->data[$j]['score']->total_seharusnya[0] != null)
                                        <td class="text-center" style="vertical-align: middle">
                                            {{ $province->data[$j]['score']->total_seharusnya[0] }}
                                        </td>
                                    @else
                                        <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                    @endif
                                    @if (isset($province->data[$j]['score']->total_seharusnya[0]) && $province->data[$j]['score']->total_seharusnya[0] != null)
                                        @php($score = (float) $province->data[$j]['score']->total_seharusnya[0])
                                        @php($score_current += $score)
                                        @if ($score >= 2.5)
                                            <td class="text-center" style="vertical-align: middle">
                                                {{ 'Baik' }}
                                            </td>
                                        @else
                                            <td class="text-center" style="vertical-align: middle">
                                                {{ 'Tidak Baik' }}
                                            </td>
                                        @endif
                                    @else
                                        <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                    @endif
                                </tr>
                                @for($k = 1; $k <= 9; $k++)
                                    <tr>
                                        <td class="text-center" style="vertical-align: middle">{{ $province->data[$j]->input->{ 'kode_' . $k } }}</td>
                                        <td class="text-center" style="vertical-align: middle">{{ $province->data[$j]->input->{ 'hasil_' . $k } }}</td>
                                        @if (isset($province->data[$j]['score']) && $province->data[$j]['score'] != null)
                                            <td class="text-center" style="vertical-align: middle">{{ $province->data[$j]['score']->isi_benar[$k] }}</td>
                                        @else
                                            <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Tidak Diisi' }}</td>
                                        @endif
                                        @if (isset($province->data[$j]['score']->total_seharusnya[$k]) && $province->data[$j]['score']->total_seharusnya[$k] != null)
                                            <td class="text-center" style="vertical-align: middle">
                                                {{ $province->data[$j]['score']->total_seharusnya[$k] }}
                                            </td>
                                        @else
                                            <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                        @endif
                                        @if (isset($province->data[$j]['score']->total_seharusnya[$k]) && $province->data[$j]['score']->total_seharusnya[$k] != null)
                                            @php($score = (float) $province->data[$j]['score']->total_seharusnya[$k])
                                            @php($score_current += $score)
                                            @if ($score >= 2.5)
                                                <td class="text-center" style="vertical-align: middle">
                                                    {{ 'Baik' }}
                                                </td>
                                            @else
                                                <td class="text-center" style="vertical-align: middle">
                                                    {{ 'Tidak Baik' }}
                                                </td>
                                            @endif
                                        @else
                                            <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                        @endif
                                    </tr>
                                @endfor
                                <tr class="bg-aqua">
                                    <td colspan="3" class="text-center">{{ 'Skor Rata-Rata' }}</td>
                                    <td class="text-center"><b>{{ $score_current / 10 }}</b></td>
                                    @php($good = $score_current >= 25.0 && !$failed ? true : false)
                                    <td class="text-center"><b>{{ $good ? 'Baik' : 'Tidak Baik' }}</b></td>
                                </tr>
                                @php($j++)
                            @endforeach
                            @php($i++)
                        @endforeach
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>

@endsection
