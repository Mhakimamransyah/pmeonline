@extends('layouts.preview')

@section('style-override')

    @component('score.style-override')
    @endcomponent

    <style>
        @page {
            margin: 50mm 16mm 35mm 16mm;
        }
    </style>

@endsection

@section('content')

    @component('score.header', [
        'orderPackage' => $orderPackage,
        'bidang' => 'MIKROBIOLOGI',
        'parameter' => 'KULTUR DAN RESISTENSI',
    ])
    @endcomponent

    <center><strong>{{ 'IDENTIFIKASI' }}</strong></center>
    <br/>

    <div class="row">

        <div class="col-xs-12">

            <table class="table table-bordered">

                <thead>
                <tr>
                    <th class="text-center">{{ 'Kultur' }}</th>
                    <th class="text-center">{{ 'Hasil Pemeriksaan oleh Lab. Peserta' }}</th>
                    <th class="text-center">{{ 'Hasil Pemeriksaan yang Seharusnya' }}</th>
                    <th class="text-center">{{ 'Skor Saudara' }}</th>
                    <th class="text-center">{{ 'Skor Maksimal' }}</th>
                </tr>
                </thead>
                <tbody>
                @php
                $average1 = [ 2.285714, 1.857142, 2.21428571 ]
                @endphp
                @for($i = 1; $i <= 3; $i++)
                    <tr>
                        <td class="text-center">{{ $i }}</td>
                        <td>{{ $data['statistic'][0]->data[0]->input->{'hasil_identifikasi_' . $i} }}</td>
                        <td>{{ $data['statistic'][0]->data[0]->score->isi_benar[$i - 1] }}</td>
                        <td class="text-center">{{ $data['statistic'][0]->data[0]->score->score[$i - 1] }}</td>
                        <td class="text-center">{{ '3' }}</td>
                    </tr>
                @endfor
                </tbody>
                <tfoot>
                <tr style="background-color: white">
                    <td colspan="3" class="text-center">{{ 'Jumlah' }}</td>
                    <td class="text-center">{{ $data['statistic'][0]->data[0]->score->score[0] + $data['statistic'][0]->data[0]->score->score[1] + $data['statistic'][0]->data[0]->score->score[2] }}</td>
                    <td class="text-center">{{ '9' }}</td>
                </tr>
                </tfoot>

            </table>

        </div>

    </div>

    <br/>
    <br/>
    <center><strong>{{ 'UJI KEPEKAAN' }}</strong></center>
    <br/>

    @php
    $totalScoreKepekaan = 0;
    @endphp

    <span>{{ 'Metode : ' }} @if($data['statistic'][0]->data[0]->metode != null) {{ $data['statistic'][0]->data[0]->metode }} @else {{ '-' }} @endif</span>
    <br/>
    <br/>

    <div class="row">

        <div class="col-xs-12">

            <table class="table table-bordered">

                <thead>
                <tr>
                    <th class="text-center">{{ 'Kultur' }}</th>
                    <th class="text-center" colspan="5">{{ 'Hasil Pemeriksaan oleh Lab. Peserta' }}</th>
                    <th class="text-center" colspan="5">{{ 'Hasil Pemeriksaan yang Seharusnya' }}</th>
                    <th class="text-center">{{ 'Skor Saudara' }}</th>
                    <th class="text-center">{{ 'Skor Maksimal' }}</th>
                </tr>
                </thead>
                <tbody>
                <tr style="background-color: white">
                    <th></th>
                    @for($i = 0; $i < 5; $i++)
                        <th class="text-center">{{ $data['cultures']['1'][$i] }}</th>
                    @endfor
                    @for($i = 0; $i < 5; $i++)
                        <th class="text-center">{{ $data['cultures']['1'][$i] }}</th>
                    @endfor
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <td class="text-center">{{ 1 }}</td>
                    @php
                    $score = 0;
                    @endphp
                    @for($i = 0; $i < 5; $i++)
                        @php
                        $userAnswer = substr($data['statistic'][0]->data[0]->input->{'hasil_kultur_1_obat_' . $data['cultures']['1'][$i]}, 0, 1);
                        $trueAnswer = substr($data['statistic'][0]->data[0]->score->kultur1_seharusnya->{$data['cultures']['1'][$i]}, 0, 1);
                        $score += ($userAnswer == $trueAnswer) ? 1 : 0;
                        $totalScoreKepekaan += ($userAnswer == $trueAnswer) ? 1 : 0;
                        @endphp
                    <td class="text-center @if($userAnswer == $trueAnswer) bg-success @endif">{{ $userAnswer }}</td>
                    @endfor
                    @for($i = 0; $i < 5; $i++)
                        @php
                            $userAnswer = substr($data['statistic'][0]->data[0]->input->{'hasil_kultur_1_obat_' . $data['cultures']['1'][$i]}, 0, 1);
                            $trueAnswer = substr($data['statistic'][0]->data[0]->score->kultur1_seharusnya->{$data['cultures']['1'][$i]}, 0, 1);
                        @endphp
                        <td class="text-center">{{ $trueAnswer }}</td>
                    @endfor
                    <td class="text-center">{{ $score }}</td>
                    <td class="text-center">{{ '5' }}</td>
                </tr>
                <tr>
                    <td colspan="13"></td>
                </tr>
                <tr style="background-color: white">
                    <th></th>
                    @for($i = 0; $i < 5; $i++)
                        <th class="text-center">{{ $data['cultures']['2'][$i] }}</th>
                    @endfor
                    @for($i = 0; $i < 5; $i++)
                        <th class="text-center">{{ $data['cultures']['2'][$i] }}</th>
                    @endfor
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <td class="text-center">{{ 2 }}</td>
                    @php
                        $score = 0;
                    @endphp
                    @for($i = 0; $i < 5; $i++)
                        @php
                            $userAnswer = substr($data['statistic'][0]->data[0]->input->{'hasil_kultur_2_obat_' . $data['cultures']['2'][$i]}, 0, 1);
                            $trueAnswer = substr($data['statistic'][0]->data[0]->score->kultur2_seharusnya->{$data['cultures']['2'][$i]}, 0, 1);
                            $score += ($userAnswer == $trueAnswer) ? 1 : 0;
                            $totalScoreKepekaan += ($userAnswer == $trueAnswer) ? 1 : 0;
                        @endphp
                        <td class="text-center @if($userAnswer == $trueAnswer) bg-success @endif">{{ $userAnswer }}</td>
                    @endfor
                    @for($i = 0; $i < 5; $i++)
                        @php
                            $userAnswer = substr($data['statistic'][0]->data[0]->input->{'hasil_kultur_2_obat_' . $data['cultures']['2'][$i]}, 0, 1);
                            $trueAnswer = substr($data['statistic'][0]->data[0]->score->kultur2_seharusnya->{$data['cultures']['2'][$i]}, 0, 1);
                        @endphp
                        <td class="text-center">{{ $trueAnswer }}</td>
                    @endfor
                    <td class="text-center">{{ $score }}</td>
                    <td class="text-center">{{ '5' }}</td>
                </tr>
                </tbody>
                <tfoot>
                <tr style="background-color: white">
                    <th class="text-center" colspan="11">{{ 'Jumlah' }}</th>
                    <th class="text-center">{{ $totalScoreKepekaan }}</th>
                    <th class="text-center">{{ '10' }}</th>
                </tr>
                </tfoot>

            </table>

        </div>

    </div>

    <div class="row">

        <div class="col-xs-12">

            <b>Catatan :</b><br/>
            <span>S : Sensitif</span><br/>
            <span>I : Intermediate</span><br/>
            <span>R : Resisten</span><br/>
            <span>- : Tidak melakukan uji kepekaan terhadap antibiotika.</span><br/>

        </div>

    </div>

    <br/>
    <br/>

    <div class="row">

        <div class="col-xs-12">

            <b>Komentar dan Saran :</b><br/>
            <span>{!! nl2br(e($data['statistic'][0]->data[0]->score->saran)) !!}</span>

        </div>

    </div>

    @component('score.signature')
    @endcomponent

@endsection
