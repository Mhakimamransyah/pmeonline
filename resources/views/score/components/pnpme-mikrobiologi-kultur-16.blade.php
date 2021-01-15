@php

    $parameterName = 'Kultur dan Uji Kepekaan Mikro Organisme';

    $submitValue = json_decode($submit->value);

    $score = $submit->order->score;

    $scoreValue = json_decode($score->value);

    $package = $submit->order->package;
    $parameters = $package->parameters;
    $cycle = $package->cycle;

    $data = [
        'cultures' => [
            '1' => ['Gentacimin', 'Levofloxacine', 'Amikacin', 'Ciprofloxacine', 'Co-trimoxazole'],
            '2' => ['Ampicilline', 'Ciprifloxacine', 'Co-trimoxazole', 'Tetracyclin', 'Cefazolin'],
        ]
    ]

@endphp

<h3 class="text-center"><b>PROGRAM NASIONAL PEMANTAPAN MUTU EKSTERNAL BIDANG MIKROBIOLOGI<br/>
        HASIL EVALUASI PARAMETER {{ strtoupper($parameterName) }}<br/>
        {{ strtoupper($cycle->name) }}</b>
</h3>

<br/>

@component('score.identity-header', [
    'submit' => $submit,
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
            @for($i = 1; $i <= 3; $i++)
                <tr>
                    <td class="text-center"><b>{{ $i }}</b></td>
                    <td class="text-center">{{ $submitValue->{'hasil_identifikasi_' . $i} }}</td>
                    <td class="text-center">{{ $scoreValue->{'rujukan'}[$i-1] }}</td>
                    <td class="text-center">{{ $scoreValue->score[$i - 1] ?? 0 }}</td>
                    <td class="text-center">{{ '2' }}</td>
                </tr>
            @endfor
            </tbody>
            <tfoot>
            <tr style="background-color: white">
                <th colspan="3" class="text-center">{{ 'Jumlah' }}</th>
                <th class="text-center">{{ array_sum($scoreValue->score) }}</th>
                <th class="text-center">{{ '6' }}</th>
            </tr>
            </tfoot>

        </table>

    </div>

</div>

<br/>

<div class="row">

    <div class="col-xs-12">

        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="text-center">{{ 'Total Skor' }}</th>
                <th class="text-center">{{ 'Kriteria' }}</th>
                <th class="text-center" width="60%">{{ 'Komentar atau Saran' }}</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="text-center">6</td>
                <td class="text-center">Baik</td>
                <td rowspan="3">
                    @if(array_sum($scoreValue->score) == 6)
                        <p>{{ __('Peserta mampu melakukan identifikasi semua isolate sampai tingkat spesies dengan benar') }}</p>
                    @elseif(array_sum($scoreValue->score) >= 4)
                        <p>{{ __('Peserta mampu melakukan identifikasi sampai tingkat genus atau sampai spesies namun ada spesies salah') }}</p>
                    @else
                        <p>{{ __('Peserta melakukan lebih dari satu kesalahan identifikasi') }}</p>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="text-center">4 - 5</td>
                <td class="text-center">Kurang Baik</td>
            </tr>
            <tr>
                <td class="text-center">0 - 3</td>
                <td class="text-center">Kurang</td>
            </tr>
            </tbody>
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

<span>{{ 'Metode : ' }} @if($submitValue->metode != null) {{ $submitValue->metode }} @else {{ '-' }} @endif</span>
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
                        $userAnswer = substr($submitValue->{'hasil_kultur_1_obat_' . $data['cultures']['1'][$i]}, 0, 1);
                        $trueAnswer = substr($scoreValue->{'hasil_kultur_1_obat_'.$data['cultures']['1'][$i]}, 0, 1);
                        if ($userAnswer == $trueAnswer) {
                            $totalScoreKepekaan += 2;
                            $score += 2;
                        } else if ($userAnswer == 'I' || $trueAnswer == 'I') {
                            $totalScoreKepekaan += 1;
                            $score += 1;
                        }
                    @endphp
                    <td class="text-center @if($userAnswer == $trueAnswer) bg-success @endif">{{ $userAnswer }}</td>
                @endfor
                @for($i = 0; $i < 5; $i++)
                    @php
                        $userAnswer = substr($submitValue->{'hasil_kultur_1_obat_' . $data['cultures']['1'][$i]}, 0, 1);
                        $trueAnswer = substr($scoreValue->{'hasil_kultur_1_obat_'.$data['cultures']['1'][$i]}, 0, 1);
                    @endphp
                    <td class="text-center">{{ $trueAnswer }}</td>
                @endfor
                <td class="text-center">{{ $score }}</td>
                <td class="text-center">{{ '10' }}</td>
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
                        $userAnswer = substr($submitValue->{'hasil_kultur_2_obat_' . $data['cultures']['2'][$i]}, 0, 1);
                        $trueAnswer = substr($scoreValue->{'hasil_kultur_2_obat_'.$data['cultures']['2'][$i]}, 0, 1);
                        if ($userAnswer == $trueAnswer) {
                            $totalScoreKepekaan += 2;
                            $score += 2;
                        } else if ($userAnswer == 'I' || $trueAnswer == 'I') {
                            $totalScoreKepekaan += 1;
                            $score += 1;
                        }
                    @endphp
                    <td class="text-center @if($userAnswer == $trueAnswer) bg-success @endif">{{ $userAnswer }}</td>
                @endfor
                @for($i = 0; $i < 5; $i++)
                    @php
                        $userAnswer = substr($submitValue->{'hasil_kultur_2_obat_' . $data['cultures']['2'][$i]}, 0, 1);
                        $trueAnswer = substr($scoreValue->{'hasil_kultur_2_obat_'.$data['cultures']['2'][$i]}, 0, 1);
                    @endphp
                    <td class="text-center">{{ $trueAnswer }}</td>
                @endfor
                <td class="text-center">{{ $score }}</td>
                <td class="text-center">{{ '10' }}</td>
            </tr>
            </tbody>
            <tfoot>
            <tr style="background-color: white">
                <th class="text-center" colspan="11">{{ 'Rata-Rata' }}</th>
                <th class="text-center">{{ $totalScoreKepekaan / 2 }}</th>
                <th class="text-center">{{ '10' }}</th>
            </tr>
            </tfoot>

        </table>

    </div>

</div>

<br/>

<div class="row">

    <div class="col-xs-12">

        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="text-center">Rata-Rata Skor</th>
                <th class="text-center">Kriteria</th>
                <th class="text-center" width="60%">Komentar atau Saran</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="text-center">10</td>
                <td class="text-center">Baik</td>
                <td rowspan="3">
                    @if($totalScoreKepekaan / 2 == 10)
                        <p>{{ __('Peserta mampu melakukan uji kepekaan dengan benar terhadap semua isolate yang diuji') }}</p>
                    @elseif($totalScoreKepekaan / 2 >= 8)
                        <p>{{ __('Peserta mampu melakukan uji kepekaan namun masih ada satu atau dua kesalahan') }}</p>
                    @else
                        <p>{{ __('Peserta melakukan uji kepekaan lebih dari 2 kesalahan') }}</p>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="text-center">8 - 9</td>
                <td class="text-center">Kurang Baik</td>
            </tr>
            <tr>
                <td class="text-center">1 - 7</td>
                <td class="text-center">Kurang</td>
            </tr>
            </tbody>
        </table>

    </div>

</div>

<br/>

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
        <span>{!! nl2br(e($scoreValue->saran ?? '-')) !!}</span>

    </div>

</div>

<br/>
<br/>

@component('score.signature', [
    'submit' => $submit
])
@endcomponent
