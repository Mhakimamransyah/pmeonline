@php

    $matrixScore = [
        ['Benar', 'PPR', 'PPT', 'PPT', 'PPT'],
        ['NPR', 'Benar', 'Benar', 'KH', 'KH'],
        ['NPT', 'Benar', 'Benar', 'Benar', 'KH'],
        ['NPT', 'KH', 'Benar', 'Benar', 'Benar'],
        ['NPT', 'KH', 'KH', 'Benar', 'Benar'],
    ];

    $matrixValue = [
        [10, 5, 0, 0, 0],
        [5, 10, 10, 5, 5],
        [0, 10, 10, 10, 5],
        [0, 5, 10, 10, 10],
        [0, 5, 5, 10, 10],
    ];

@endphp

<div class="medium-form" style="margin-top: 24px">

    <div class="medium-form-content">

        <div class="ui raised green segment">

            <a class="ui green ribbon label">{{ 'Rekap Data Mikrobiologi - BTA' }}</a>

            <br/>
            <br/>

            <div style="overflow-x: scroll;">

                <table class="ui table structured celled" style="width: 1366px">
                    <thead>
                    <tr>
                        <th class="center aligned" rowspan="2">No.</th>
                        <th class="center aligned" rowspan="2">Kode Peserta</th>
                        <th class="center aligned" rowspan="2">Nama Instansi</th>
                        <th class="center aligned" rowspan="2">Kode Sediaan</th>
                        @for($sediaan = 0; $sediaan < 10; $sediaan++)
                            <th class="center aligned" colspan="3">Sediaan {{ $sediaan + 1 }}</th>
                        @endfor
                        <th class="center aligned" rowspan="2">Total Skor</th>
                        <th class="center aligned" rowspan="2">Kategori</th>
                        <th class="center aligned" rowspan="2" hidden></th>
                    </tr>
                    <tr>
                        @for($sediaan = 0; $sediaan < 10; $sediaan++)
                            <th class="center aligned">Jawab</th>
                            <th class="center aligned">Hasil</th>
                            <th class="center aligned warning">Skor</th>
                        @endfor
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
                        <tr>
                            <td class="center aligned">{{ $index }}</td>
                            <td class="center aligned">{{ $submit->order->invoice->laboratory->participant_number ?? '-' }}</td>
                            <td class="center aligned">{{ $submit->order->invoice->laboratory->name ?? '-' }}</td>
                            <td class="center aligned">
                                @php
                                    $firstSediaan = str_replace(".", "-", $submitValue->{'kode_sediaan_0'});
                                    $lastSediaan = str_replace(".", "-", $submitValue->{'kode_sediaan_9'});
                                    try {
                                        $prefix = explode("-", $firstSediaan)[0];
                                        $suffix0 = explode("-", $firstSediaan)[1];
                                        $suffix1 = explode("-", $lastSediaan)[1];
                                    } catch(Exception $exception) {
                                        $prefix = '';
                                        $suffix0 = $firstSediaan;
                                        $suffix1 = $lastSediaan;
                                    }
                                    $scoreItems = [];
                                    $autoFail = false;
                                @endphp
                                {{ $prefix }}-({{ $suffix0 }} - {{ $suffix1 }})
                            </td>
                            @for($sediaan = 0; $sediaan < 10; $sediaan++)
                                <td class="center aligned">{{ ucfirst($submitValue->{'hasil_'.$sediaan}) }}</td>
                                @if ($scoreValue == null)
                                    <td class="center aligned"><i>Belum dinilai</i></td>
                                    <td class="center aligned"><i>Belum dinilai</i></td>
                                @else
                                    @php
                                        $panelNumber = $submitValue->{'kode_sediaan_'.$sediaan} ?? null;
                                        $userAnswer = $submitValue->{'hasil_'.$sediaan} ?? null;
                                        $expectedAnswer = $scoreValue->{'rujukan'}[$sediaan] ?? '';

                                        $userMatrix = -1;
                                        if ($userAnswer == 'negatif') {
                                            $userMatrix = 0;
                                        } elseif ($userAnswer == 'scanty') {
                                            $userMatrix = 1;
                                        } elseif ($userAnswer == '1+') {
                                            $userMatrix = 2;
                                        } elseif ($userAnswer == '2+') {
                                            $userMatrix = 3;
                                        } elseif ($userAnswer == '3+') {
                                            $userMatrix = 4;
                                        }

                                        $expectedMatrix = -1;
                                        if ($expectedAnswer == 'negatif') {
                                            $expectedMatrix = 0;
                                        } elseif ($expectedAnswer == 'scanty') {
                                            $expectedMatrix = 1;
                                        } elseif ($expectedAnswer == '1+') {
                                            $expectedMatrix = 2;
                                        } elseif ($expectedAnswer == '2+') {
                                            $expectedMatrix = 3;
                                        } elseif ($expectedAnswer == '3+') {
                                            $expectedMatrix = 4;
                                        }

                                        $predicate = null;
                                        $predicateScore = -1;
                                        if ($userMatrix != -1 && $expectedMatrix != -1) {
                                            $predicate = $matrixScore[$expectedMatrix][$userMatrix];
                                            $predicateScore = $matrixValue[$expectedMatrix][$userMatrix];
                                            array_push($scoreItems, $predicateScore);
                                            if ($predicateScore == 0) {
                                                $autoFail = true;
                                            }
                                        }
                                    @endphp
                                    <td class="center aligned">{{ ucfirst($scoreValue->rujukan[$sediaan]) }}</td>
                                    @if ($predicate == null)
                                        <td class="center aligned error">
                                            <i>Tidak dapat dinilai ({{ $userMatrix }}, {{ $expectedMatrix }})</i>
                                        </td>
                                    @else
                                        <td class="center aligned @if ($predicateScore == 10) positive @elseif ($predicateScore == 5) warning @else error @endif">
                                            {{ $predicate }}
                                        </td>
                                    @endif
                                @endif
                            @endfor
                            <td class="center aligned">{{ array_sum($scoreItems) }}</td>
                            <td class="center aligned @if(array_sum($scoreItems) >= 80 && !$autoFail) positive @else negative @endif">
                                @if(array_sum($scoreItems) >= 80 && !$autoFail) Lulus @else Tidak Lulus @endif
                            </td>
                            <td hidden>
                                <a class="circular ui icon button" href="{{ route('installation.scoring.show', ['order_id' => $submit->order_id]) }}" target="_blank">
                                    <i class="icon edit"></i>
                                </a>
                            </td>
                        </tr>
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