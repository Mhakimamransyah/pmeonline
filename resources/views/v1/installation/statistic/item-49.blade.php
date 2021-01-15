@extends('v1.layouts.list')

@section('content-header')

    <h1>{{ 'Statistik : ' . $parameter->name }}</h1>

@endsection

@section('content')

    <div class="nav-tabs-custom">
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">

                <div class="row">

                    <div class="col-xs-12 table-responsive">

                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr class="bg-aqua">
                                <th class="text-center">{{ 'Propinsi' }}</th>
                                <th class="text-center">{{ 'No.' }}</th>
                                <th class="text-center">{{ 'Peserta' }}</th>
                                <th class="text-center">{{ 'Kode Slide' }}</th>
                                <th class="text-center">{{ 'Hasil Pemeriksaan oleh Lab Peserta' }}</th>
                                <th class="text-center">{{ 'Hasil Pemeriksaan yang Seharusnya' }}</th>
                                <th class="text-center">{{ 'Skor' }}</th>
                                <th class="text-center">{{ 'Keterangan' }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($i = 0)
                            @foreach($statistic as $province)
                                @php($j = 0)
                                @php($score_current = 0)
                                @php($failed = false)
                                @php($average = 0)
                                <tr>
                                    <td rowspan="{{ count($province->data) * 3 }}" class="text-center bg-yellow" style="vertical-align: middle">{{ $province->name }}</td>
                                    <td rowspan="3" class="text-center bg-yellow" style="vertical-align: middle">{{ $i + 1}}</td>
                                    <td rowspan="3" class="text-center" style="vertical-align: middle"><a href="{{ '/installation/score/' . $province->data[$j]->score_id }}" target="_blank">{{ $province->data[0]->name }}</a></td>
                                    <td class="text-center" style="vertical-align: middle">{{ $province->data[$j]->input->kode_sediaan_0 }}</td>
                                    <td class="text-center" style="vertical-align: middle">{{ implode(", ", $province->data[$j]->input->hasil_0) }}</td>
                                    @if (isset($province->data[$j]['score']) && $province->data[$j]['score'] != null)
                                        <td class="text-center" style="vertical-align: middle">{{ $province->data[$j]['score']->isi_benar[0] }}</td>
                                    @else
                                        <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                    @endif
                                    @if (isset($province->data[$j]['score']->score) && $province->data[$j]['score']->score != null)
                                        @if (isset($province->data[$j]['score']->score_max) && $province->data[$j]['score']->score_max != null)
                                            <td class="text-center" style="vertical-align: middle">
                                                {{ $province->data[$j]['score']->score[0] }}
                                                @php($score_current += $province->data[$j]['score']->score[0])
                                            </td>
                                        @else
                                            <td class="text-center" style="vertical-align: middle">{{ '-' }}</td>
                                        @endif
                                    @else
                                        <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                    @endif
                                    @if (isset($province->data[$j]['score']->score) && $province->data[$j]['score']->score != null)
                                        @if (isset($province->data[$j]['score']->score_max) && $province->data[$j]['score']->score_max != null)
                                            <td rowspan="2" class="text-center" style="vertical-align: middle">
                                                @php($score = $province->data[$j]['score']->score ?: 0)
                                                @php($score_max = $province->data[$j]['score']->score_max ?: 1)
                                                @if ($score_max[0] != 0 && $score_max[1] != 0)
                                                    @php($average = ( ( $score[0] / $score_max[0] * 10 ) + ( $score[1] / $score_max[1] * 10 ) ) / 2 )
                                                    {{ number_format($average, 2)  }}
                                                @else
                                                    {{ '-' }}
                                                @endif
                                            </td>
                                        @else
                                            <td rowspan="2" class="text-center" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                        @endif
                                    @else
                                        <td rowspan="2" class="text-center bg-warning" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                    @endif
                                </tr>
                                @for($k = 1; $k <= 1; $k++)
                                    <tr>
                                        <td class="text-center" style="vertical-align: middle">{{ $province->data[$j]->input->{ 'kode_sediaan_' . $k } }}</td>
                                        <td class="text-center" style="vertical-align: middle">{{ implode(", ", $province->data[$j]->input->{ 'hasil_' . $k }) }}</td>
                                        @if (isset($province->data[$j]['score']) && $province->data[$j]['score'] != null)
                                            <td class="text-center" style="vertical-align: middle">{{ $province->data[$j]['score']->isi_benar[$k] }}</td>
                                        @else
                                            <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                        @endif
                                        @if (isset($province->data[$j]['score']->score) && $province->data[$j]['score']->score != null)
                                            @if (isset($province->data[$j]['score']->score_max) && $province->data[$j]['score']->score_max != null)
                                                <td class="text-center" style="vertical-align: middle">
                                                    {{ $province->data[$j]['score']->score[$k] }}
                                                    @php($score_current += $province->data[$j]['score']->score[$k])
                                                </td>
                                            @else
                                                <td class="text-center" style="vertical-align: middle">{{ '-' }}</td>
                                            @endif
                                        @else
                                            <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                        @endif
                                    </tr>
                                @endfor
                                <tr class="bg-aqua">
                                    <td colspan="3" class="text-center">Total</td>
                                    <td class="text-center"><b>{{ $score_current }}</b></td>
                                    @php($good = $average >= 6.0 && !$failed ? true : false)
                                    <td class="text-center"><b>{{ $good ? 'Lulus' : 'Tidak Lulus' }}</b></td>
                                </tr>
                                @php($j++)
                                @foreach(array_slice($province->data->toArray(), 1) as $laboratory)
                                    @php($i++)
                                    @php($score_current = 0)
                                    @php($average = 0)
                                    @php($failed = false)
                                    <tr>
                                        <td rowspan="3" class="text-center bg-yellow" style="vertical-align: middle">{{ $i + 1}}</td>
                                        <td rowspan="3" class="text-center" style="vertical-align: middle"><a href="{{ '/installation/score/' . $province->data[$j]->score_id }}" target="_blank">{{ $laboratory['name'] }}</a></td>
                                        <td class="text-center" style="vertical-align: middle">{{ $province->data[$j]->input->kode_sediaan_0 }}</td>
                                        <td class="text-center" style="vertical-align: middle">{{ implode(", ", $province->data[$j]->input->hasil_0) }}</td>
                                        @if (isset($province->data[$j]['score']) && $province->data[$j]['score'] != null)
                                            <td class="text-center" style="vertical-align: middle">{{ $province->data[$j]['score']->isi_benar[0] }}</td>
                                        @else
                                            <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                        @endif
                                        @if (isset($province->data[$j]['score']->score) && $province->data[$j]['score']->score != null)
                                            @if (isset($province->data[$j]['score']->score_max) && $province->data[$j]['score']->score_max != null)
                                                <td class="text-center" style="vertical-align: middle">
                                                    {{ $province->data[$j]['score']->score[0] }}
                                                    @php($score_current += $province->data[$j]['score']->score[0])
                                                </td>
                                            @else
                                                <td class="text-center" style="vertical-align: middle">{{ '-' }}</td>
                                            @endif
                                        @else
                                            <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                        @endif
                                        @if (isset($province->data[$j]['score']->score) && $province->data[$j]['score']->score != null)
                                            @if (isset($province->data[$j]['score']->score_max) && $province->data[$j]['score']->score_max != null)
                                                <td rowspan="2" class="text-center" style="vertical-align: middle">
                                                    @php($score = $province->data[$j]['score']->score ?: 0)
                                                    @php($score_max = $province->data[$j]['score']->score_max ?: 1)
                                                    @if ($score_max[0] != 0 && $score_max[1] != 0)
                                                        @php($average = ( ( $score[0] / $score_max[0] * 10 ) + ( $score[1] / $score_max[1] * 10 ) ) / 2 )
                                                        {{ number_format($average, 2)  }}
                                                    @else
                                                        {{ '-' }}
                                                    @endif
                                                </td>
                                            @else
                                                <td rowspan="2" class="text-center" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                            @endif
                                        @else
                                            <td rowspan="2" class="text-center bg-warning" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                        @endif
                                    </tr>
                                    @for($k = 1; $k <= 1; $k++)
                                        <tr>
                                            <td class="text-center" style="vertical-align: middle">{{ $province->data[$j]->input->{ 'kode_sediaan_' . $k } }}</td>
                                            <td class="text-center" style="vertical-align: middle">{{ implode(", ", $province->data[$j]->input->{ 'hasil_' . $k }) }}</td>
                                            @if (isset($province->data[$j]['score']) && $province->data[$j]['score'] != null)
                                                <td class="text-center" style="vertical-align: middle">{{ $province->data[$j]['score']->isi_benar[$k] }}</td>
                                            @else
                                                <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                            @endif
                                            @if (isset($province->data[$j]['score']->score) && $province->data[$j]['score']->score != null)
                                                @if (isset($province->data[$j]['score']->score_max) && $province->data[$j]['score']->score_max != null)
                                                    <td class="text-center" style="vertical-align: middle">
                                                        {{ $province->data[$j]['score']->score[$k] }}
                                                        @php($score_current += $province->data[$j]['score']->score[$k])
                                                    </td>
                                                @else
                                                    <td class="text-center" style="vertical-align: middle">{{ '-' }}</td>
                                                @endif
                                            @else
                                                <td class="text-center bg-warning" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                            @endif
                                        </tr>
                                    @endfor
                                    <tr class="bg-aqua">
                                        <td colspan="3" class="text-center">Total</td>
                                        <td class="text-center"><b>{{ $score_current }}</b></td>
                                        @php($good = $average >= 6.0 && !$failed ? true : false)
                                        <td class="text-center"><b>{{ $good ? 'Lulus' : 'Tidak Lulus' }}</b></td>
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
    </div>

@endsection
