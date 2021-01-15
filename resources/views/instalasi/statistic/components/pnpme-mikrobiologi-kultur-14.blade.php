@php

    $data = [
            'cultures' => [
                '1' => ['Ampicilline', 'Gentamicin', 'Amikacin', 'Ciprifloxacine', 'Levofloxacine'],
                '2' => ['Ciprofloxaxine', 'Gentacimin', 'Levofloxacine', 'Penicilline', 'Erytrimicin'],
            ]
        ]

@endphp

<div class="medium-form" style="margin-top: 24px">

    <div class="medium-form-content">

        <div class="ui raised green segment">

            <a class="ui green ribbon label">{{ 'Rekap Data Mikrobiologi - Malaria' }}</a>

            <br/>
            <br/>

            <div style="overflow-x: scroll;">

                <table class="ui table structured celled" style="width: 1366px">
                    <thead>
                    <tr>
                        <th class="center aligned" rowspan="4">{{ 'No.' }}</th>
                        <th class="center aligned" rowspan="4">{{ 'Kode Peserta' }}</th>
                        <th class="center aligned" rowspan="4">{{ 'Nama Instansi' }}</th>
                        <th class="center aligned" colspan="4" rowspan="2">{{ 'Identifikasi Kultur' }}</th>
                        <th class="center aligned" colspan="13">{{ 'Kepekaan Nilai' }}</th>
                        <th class="center aligned" rowspan="4">{{ 'Metoda' }}</th>
                    </tr>
                    <tr>
                        <th class="center aligned" colspan="6">Kultur Nomor 1</th>
                        <th class="center aligned" colspan="6">Kultur Nomor 2</th>
                        <th class="center aligned" rowspan="3">Total Skor</th>
                    </tr>
                    <tr>
                        <th class="center aligned" rowspan="2">{{ 'Jawaban Peserta' }}</th>
                        <th class="center aligned" rowspan="2">{{ 'Hasil Seharusnya' }}</th>
                        <th class="center aligned" rowspan="2">{{ 'Skor' }}</th>
                        <th class="center aligned" rowspan="2">{{ 'Total Skor' }}</th>
                        @foreach($data['cultures'] as $culture)
                            @foreach(array_values($culture) as $obat)
                                <th class="center aligned"><i>{{ $obat }}</i></th>
                            @endforeach
                            <th class="center aligned" rowspan="2">Skor</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach($data['cultures'] as $culture)
                            @foreach(array_values($culture) as $obat)
                                <th class="center aligned"><i>{{ $obat }}</i></th>
                            @endforeach
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $index = 1;
                    @endphp
                    @foreach($submits as $submit)
                        @php
                            if ($submit->value != null) {
                                $submitValue = json_decode($submit->value);
                            } else {
                                $submitValue = null;
                            }

                            $score = \App\v3\Score::query()->where('order_id', '=', $submit->order_id)->get()->first();
                            if ($score != null && $score->value != null) {
                                $scoreValue = json_decode($score->value);
                            } else {
                                $scoreValue = null;
                            }
                        @endphp
                        @for ($i = 0; $i < 3; $i++)
                            <tr>
                                @if ($i == 0)
                                    <td class="center aligned" rowspan="3">{{ $index }}</td>
                                    <td class="center aligned" rowspan="3">{{ $submit->order->invoice->laboratory->participant_number }}</td>
                                    <td class="center aligned" rowspan="3">{{ $submit->order->invoice->laboratory->name }}</td>
                                @endif
                                @if ($submitValue != null)
                                    <td class="center aligned"><i>{{ $submitValue->{'hasil_identifikasi_' . ($i+1)} }}</i></td>
                                @else
                                    <td class="center aligned negative"><i>Tidak diisi</i></td>
                                @endif
                                @if ($scoreValue != null)
                                    <td class="center aligned"><i>{{ $scoreValue->{'rujukan'}[$i] }}</i></td>
                                    <td class="center aligned">{{ $scoreValue->score[$i] ?? 0 }}</td>
                                @else
                                    <td class="center aligned"><i style="color: red;">Tidak diisi</i></td>
                                    <td class="center aligned"><i style="color: red;">Tidak diisi</i></td>
                                @endif
                                @if ($i == 0)
                                    @if ($scoreValue != null)
                                        <td class="center aligned" rowspan="3">{{ array_sum($scoreValue->score) }}</td>
                                    @else
                                        <td class="center aligned"><i style="color: red;">Tidak diisi</i></td>
                                    @endif
                                @endif
                                @php
                                $totalScoreKepekaan = 0;
                                @endphp
                                @foreach($data['cultures'] as $cultureNumber => $culture)
                                    @php
                                        $currentScore = 0;
                                    @endphp
                                    @foreach(array_values($culture) as $obat)
                                        @php
                                            $userAnswer = substr($submitValue->{'hasil_kultur_'.$cultureNumber.'_obat_'.$obat}, 0, 1);
                                            $trueAnswer = substr($scoreValue->{'hasil_kultur_'.$cultureNumber.'_obat_'.$obat}, 0, 1);
                                            $thisScore = ($userAnswer == $trueAnswer) ? 1 : 0;
                                            $currentScore += $thisScore;
                                            $totalScoreKepekaan += $thisScore;
                                        @endphp
                                        @if ($i == 0)
                                            @if (isset($submitValue->{'hasil_kultur_'.$cultureNumber.'_obat_'.$obat}))
                                                <td class="center aligned @if ($thisScore >= 1) positive @else negative @endif">{{ $submitValue->{'hasil_kultur_'.$cultureNumber.'_obat_'.$obat} }}</td>
                                            @else
                                                <td class="center aligned negative">-</td>
                                            @endif
                                        @elseif ($i == 1)
                                            @if (isset($scoreValue->{'hasil_kultur_'.$cultureNumber.'_obat_'.$obat}))
                                                <td class="center aligned @if ($thisScore >= 1) positive @else negative @endif">{{ $scoreValue->{'hasil_kultur_'.$cultureNumber.'_obat_'.$obat} }}</td>
                                            @else
                                                <td class="center aligned negative">-</td>
                                            @endif
                                        @else
                                            <td class="center aligned @if ($thisScore >= 1) positive @else negative @endif">{{ $thisScore }}</td>
                                        @endif
                                    @endforeach
                                    @if ($i == 0)
                                        <td class="center aligned" rowspan="3">{{ $currentScore }}</td>
                                    @endif
                                @endforeach
                                @if ($i == 0)
                                    <td class="center aligned" rowspan="3">{{ $totalScoreKepekaan }}</td>
                                    <td class="center aligned" rowspan="3">{{ $submitValue->metode }}</td>
                                @endif
                            </tr>
                        @endfor
                        @php
                            $index += 1;
                        @endphp
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>