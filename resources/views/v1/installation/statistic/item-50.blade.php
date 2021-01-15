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
                            <thead class="bg-aqua">
                            <tr>
                                <th rowspan="4" class="text-center" style="vertical-align: middle">{{ 'No.' }}</th>
                                <th rowspan="4" class="text-center" style="vertical-align: middle">{{ 'Peserta' }}</th>
                                <th colspan="4" class="text-center" style="vertical-align: middle">{{ 'Hasil Jawaban Peserta dan Nilai Identifikasi' }}</th>
                                <th colspan="15" class="text-center" style="vertical-align: middle">{{ 'Hasil Uji Kepekaan Nilai' }}</th>
                                <th rowspan="4" class="text-center" style="vertical-align: middle">{{ 'Metode' }}</th>
                            </tr>
                            <tr>
                                <th colspan="4" class="text-center" style="vertical-align: middle">{{ 'Kultur No. 1, 2, 3' }}</th>
                                <th colspan="7" class="text-center" style="vertical-align: middle">{{ 'Kultur Nomor 1' }}</th>
                                <th colspan="7" class="text-center" style="vertical-align: middle">{{ 'Kultur Nomor 2' }}</th>
                                <th rowspan="2" class="text-center" style="vertical-align: middle">{{ 'Total Skor' }}</th>
                            </tr>
                            <tr>
                                <th rowspan="2" class="text-center" style="vertical-align: middle">{{ 'Jawaban Peserta' }}</th>
                                <th rowspan="2" class="text-center" style="vertical-align: middle">{{ 'Hasil Seharusnya' }}</th>
                                <th rowspan="2" class="text-center" style="vertical-align: middle">{{ 'Skor' }}</th>
                                <th rowspan="2" class="text-center" style="vertical-align: middle">{{ 'Total Skor' }}</th>
                                <th style="vertical-align: middle" class="text-center"><i class="fa fa-certificate" aria-hidden="true"></i></th>
                                @foreach($cultures['1'] as $culture)
                                <th class="text-center" style="vertical-align: middle">{{ $culture }}</th>
                                @endforeach
                                <th class="text-center" style="vertical-align: middle">{{ 'Skor' }}</th>
                                <th style="vertical-align: middle" class="text-center"><i class="fa fa-certificate" aria-hidden="true"></i></th>
                                @foreach($cultures['2'] as $culture)
                                    <th class="text-center" style="vertical-align: middle">{{ $culture }}</th>
                                @endforeach
                                <th class="text-center" style="vertical-align: middle">{{ 'Skor' }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <td colspan="22" class=""></td>
                            @php($i = 1)
                            @foreach($statistic as $provinces)
                                @foreach($provinces->data as $laboratory)
                                    <tr>
                                        <td rowspan="3" class="text-center bg-info" style="vertical-align: middle">{{ $i }}</td>
                                        <td rowspan="3" class="text-center bg-info" style="vertical-align: middle">{{ $laboratory->name }}</td>
                                        <td class="text-center" style="vertical-align: middle">{{ $laboratory->input->hasil_identifikasi_1 }}</td>
                                        @if ($laboratory->score != null)
                                            <td class="text-center" style="vertical-align: middle">{{ $laboratory->score->isi_benar[0] }}</td>
                                            <td class="text-center" style="vertical-align: middle">{{ $laboratory->score->score[0] }}</td>
                                            <td rowspan="3" class="text-center bg-info" style="vertical-align: middle"><b>{{ $laboratory->score->score[0] + $laboratory->score->score[1] + $laboratory->score->score[2] }}</b></td>
                                        @else
                                            <td class="text-center" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                            <td class="text-center" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                            <td class="text-center bg-info" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                        @endif
                                        <td class="text-center" style="vertical-align: middle"><i class="fa fa-pencil"></i></td>
                                        @foreach($cultures['1'] as $culture)
                                            <td class="text-center" style="vertical-align: middle">{{ $laboratory->input->{ 'hasil_kultur_1_obat_' . $culture } }}</td>
                                        @endforeach
                                        <td rowspan="3" class="text-center bg-info" style="vertical-align: middle">
                                        @php($subscore = 0)
                                        @foreach($cultures['1'] as $culture)
                                            @if ($laboratory->score->kultur1_seharusnya->{$culture} == $laboratory->input->{ 'hasil_kultur_1_obat_' . $culture})
                                                @php($subscore += 1)
                                            @endif
                                        @endforeach
                                        @php($sub1 = $subscore)
                                        {{ $subscore }}
                                        </td>
                                        <td class="text-center" style="vertical-align: middle"><i class="fa fa-pencil"></i></td>
                                        @foreach($cultures['2'] as $culture)
                                            <td class="text-center" style="vertical-align: middle">{{ $laboratory->input->{ 'hasil_kultur_2_obat_' . $culture } }}</td>
                                        @endforeach
                                        <td rowspan="3" class="text-center bg-info" style="vertical-align: middle">
                                            @php($subscore = 0)
                                            @foreach($cultures['2'] as $culture)
                                                @if ($laboratory->score->kultur2_seharusnya->{$culture} == $laboratory->input->{ 'hasil_kultur_2_obat_' . $culture})
                                                    @php($subscore += 1)
                                                @endif
                                            @endforeach
                                            @php($sub2 = $subscore)
                                            {{ $subscore }}
                                        </td>
                                        <td rowspan="3" class="text-center bg-info" style="vertical-align: middle"><b>{{ $sub1 + $sub2 }}</b></td>
                                        <td rowspan="3" class="text-center bg-info" style="vertical-align: middle">{{ $laboratory->input->metode }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" style="vertical-align: middle">{{ $laboratory->input->hasil_identifikasi_2 }}</td>
                                        @if ($laboratory->score != null)
                                            <td class="text-center" style="vertical-align: middle">{{ $laboratory->score->isi_benar[1] }}</td>
                                            <td class="text-center" style="vertical-align: middle">{{ $laboratory->score->score[1] }}</td>
                                        @else
                                            <td class="text-center" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                            <td class="text-center" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                        @endif
                                        <td class="text-center" style="vertical-align: middle"><i class="fa fa-check"></i></td>
                                        @foreach($cultures['1'] as $culture)
                                            <td class="text-center" style="vertical-align: middle">{{ $laboratory->score->kultur1_seharusnya->{$culture} }}</td>
                                        @endforeach
                                        <td class="text-center" style="vertical-align: middle"><i class="fa fa-check"></i></td>
                                        @foreach($cultures['2'] as $culture)
                                            <td class="text-center" style="vertical-align: middle">{{ $laboratory->score->kultur2_seharusnya->{$culture} }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="text-center" style="vertical-align: middle">{{ $laboratory->input->hasil_identifikasi_3 }}</td>
                                        @if ($laboratory->score != null)
                                            <td class="text-center" style="vertical-align: middle">{{ $laboratory->score->isi_benar[2] }}</td>
                                            <td class="text-center" style="vertical-align: middle">{{ $laboratory->score->score[2] }}</td>
                                        @else
                                            <td class="text-center" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                            <td class="text-center" style="vertical-align: middle">{{ 'Belum Dinilai' }}</td>
                                        @endif
                                        <td class="text-center" style="vertical-align: middle"><i class="fa fa-star"></i></td>
                                        @foreach($cultures['1'] as $culture)
                                            @if ($laboratory->score->kultur1_seharusnya->{$culture} == $laboratory->input->{ 'hasil_kultur_1_obat_' . $culture})
                                                <td class="text-center" style="vertical-align: middle">{{ '1' }}</td>
                                            @else
                                                <td class="text-center" style="vertical-align: middle">{{ '0' }}</td>
                                            @endif
                                        @endforeach
                                        <td class="text-center" style="vertical-align: middle"><i class="fa fa-star"></i></td>
                                        @foreach($cultures['2'] as $culture)
                                            @if ($laboratory->score->kultur2_seharusnya->{$culture} == $laboratory->input->{ 'hasil_kultur_2_obat_' . $culture})
                                                <td class="text-center" style="vertical-align: middle">{{ '1' }}</td>
                                            @else
                                                <td class="text-center" style="vertical-align: middle">{{ '0' }}</td>
                                            @endif
                                        @endforeach
                                    </tr>
                                    @php($i++)
                                    <td colspan="22" class=""></td>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection