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
                        <th class="center aligned">{{ 'No.' }}</th>
                        <th class="center aligned">{{ 'Kode Peserta' }}</th>
                        <th class="center aligned">{{ 'Nama Instansi' }}</th>
                        <th class="center aligned">{{ 'Kode Sediaan' }}</th>
                        <th class="center aligned">{{ 'Hasil Pemeriksaan oleh Laboratorium Peserta' }}</th>
                        <th class="center aligned">{{ 'Hasil Pemeriksaan yang Seharusnya' }}</th>
                        <th class="center aligned">{{ 'Skor' }}</th>
                        <th class="center aligned">{{ 'Rata-Rata' }}</th>
                        <th class="center aligned">{{ 'Kesimpulan' }}</th>
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

                            $scores = [];

                            if ($submitValue != null && $scoreValue != null) {
                                for($i = 0; $i < 3; $i++) {
                                    $answers = $submitValue->{'hasil_'.$i};
                                    $countAnswers = count($answers);

                                    $expected = $scoreValue->{'hasil_'.$i};
                                    $countExpected = count($expected);

                                    $intersect = array_intersect($answers, $expected);
                                    $countIntersect = count($intersect);

                                    $score = 10 * $countIntersect / $countExpected;

                                    array_push($scores, $score);
                                }
                            }
                        @endphp
                        @for ($i = 0; $i < 3; $i++)
                            <tr>
                                @if ($i == 0)
                                    <td class="center aligned" rowspan="3">{{ $index }}</td>
                                    <td class="center aligned" rowspan="3">{{ $submit->order->invoice->laboratory->participant_number }}</td>
                                    <td class="center aligned" rowspan="3">{{ $submit->order->invoice->laboratory->name }}</td>
                                @endif
                                <td class="center aligned">
                                    @if ($submitValue != null)
                                        {{ $submitValue->{'kode_sediaan_'.$i} }}
                                    @else
                                        <i style="color: red">Tidak diisi</i>
                                    @endif
                                </td>
                                <td class="center aligned">
                                    @if ($submitValue != null)
                                        {{ implode(", ", $submitValue->{'hasil_'.$i}) }}
                                    @else
                                        <i style="color: red">Tidak diisi</i>
                                    @endif
                                </td>
                                <td class="center aligned">
                                    @if ($scoreValue != null)
                                        {{ implode(", ", $scoreValue->{'hasil_'.$i}) }}
                                    @else
                                        <i style="color: red">Tidak diisi</i>
                                    @endif
                                </td>
                                <td class="center aligned">
                                    @if (count($scores) == 3)
                                        {{ number_format($scores[$i], 0) }}
                                    @else
                                        <i style="color: red">Tidak diisi</i>
                                    @endif
                                </td>
                                @if ($i == 0)
                                    <td class="center aligned" rowspan="3">
                                        @if (count($scores) == 3)
                                            @php
                                                $avg = array_sum($scores) / count($scores);
                                            @endphp
                                            {{ number_format($avg, 0) }}
                                        @else
                                            <i style="color: red">Tidak diisi</i>
                                        @endif
                                    </td>
                                    @if (count($scores) == 3)
                                        <td class="center aligned @if($avg >= 6) positive @else negative @endif" rowspan="3">
                                            @if($avg >= 6) Lulus @else Tidak Lulus @endif
                                        </td>
                                    @else
                                        <td class="center aligned" rowspan="3">
                                            <i style="color: red">Tidak diisi</i>
                                        </td>
                                    @endif
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