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
                        <th class="center aligned" style="width: 120px">{{ 'Hasil Kepadatan Parasit oleh Laboratorium Peserta' }}</th>
                        <th class="center aligned">{{ 'Hasil Pemeriksaan yang Seharusnya' }}</th>
                        <th class="center aligned" style="width: 120px">{{ 'Hasil Kepadatan Parasit yang Seharusnya' }}</th>
                        <th class="center aligned">{{ 'Skor' }}</th>
                        <th class="center aligned">{{ 'Total' }}</th>
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

                            $txt_answers = [];
                            $answerJumlahMalarias = [];
                            $expecteds = [];
                            $txt_expecteds = [];
                            $expectedJumlahMalarias = [];
                            $min_expectedJumlahMalarias = [];
                            $max_expectedJumlahMalarias = [];
                            $scores = [];
                            for($i = 0; $i < 10; $i++) {

                                // Submit
                                $answer = isset($submitValue->{'hasil_'.$i}) ? $submitValue->{'hasil_'.$i} : array();
                                $answerJumlahMalaria = isset($submitValue->{'jumlah_malaria_'.$i}) ? $submitValue->{'jumlah_malaria_'.$i} : 0;

                                $answerPlasmodiums = [];
                                $answerStadiums = [];

                                $txt_answer = "";

                                if(count($answer) > 0) {
                                    if($answer == ["Negatif"])
                                        $txt_answer = implode(', ', $answer);
                                    else {
                                        foreach ($answer as $item) {
                                            array_push($answerPlasmodiums, explode(" ",$item)[1]);
                                            $answerStadium = explode(" ",$item)[3];
                                            if ($answerStadium == "Skizon") {
                                                $answerStadium = "Schizont";
                                            }
                                            array_push($answerStadiums, $answerStadium);
                                        }
                                        $answerPlasmodiums = array_unique($answerPlasmodiums);
                                        $answerStadiums = array_unique($answerStadiums);
                                        $txt_plasmodiums = implode(', ', $answerPlasmodiums);
                                        $txt_stadiums = implode(', ', $answerStadiums);
                                        $txt_answer = "Positif<br><b>Plasmodium : </b>$txt_plasmodiums<br/><b>Stadium : </b>$txt_stadiums";
                                    }
                                } else {
                                    $txt_answer = "<i style='color: red;'>Tidak diisi</i>";
                                }

                                // Score
                                $expected = isset($scoreValue->{'hasil_'.$i}) ? $scoreValue->{'hasil_'.$i} : array();
                                $expectedJumlahMalaria = isset($scoreValue->{'jumlah_malaria_'.$i}) ? $scoreValue->{'jumlah_malaria_'.$i} : 0;

                                $expectedPlasmodiums = [];
                                $expectedStadiums = [];
                                $duaPuluhLimaPersen = $expectedJumlahMalaria / 4;
                                $minJumlahMalaria = $expectedJumlahMalaria - $duaPuluhLimaPersen;
                                $maxJumlahMalaria = $expectedJumlahMalaria + $duaPuluhLimaPersen;

                                $txt_expected = "";

                                if (count($expected) > 0) {
                                    if ($expected == ["Negatif"]) {
                                        $txt_expected = implode(', ', $expected);
                                    } else {
                                        foreach ($expected as $item) {
                                            array_push($expectedPlasmodiums, explode(" ",$item)[1]);
                                            array_push($expectedStadiums, explode(" ",$item)[3]);
                                        }
                                        $expectedPlasmodiums = array_unique($expectedPlasmodiums);
                                        $expectedStadiums = array_unique($expectedStadiums);
                                        $txt_plasmodiums = implode(', ', $expectedPlasmodiums);
                                        $txt_stadiums = implode(', ', $expectedStadiums);
                                        $txt_expected = "Positif<br><b>Plasmodium : </b>$txt_plasmodiums<br/><b>Stadium : </b>$txt_stadiums";
                                    }
                                } else {
                                    $txt_expected = "<i style='color: red;'>Tidak diisi</i>";
                                }

                                array_push($txt_answers, $txt_answer);
                                array_push($answerJumlahMalarias, $answerJumlahMalaria);
                                array_push($txt_expecteds, $txt_expected);
                                array_push($expecteds, $expected);
                                array_push($expectedJumlahMalarias, $expectedJumlahMalaria);
                                array_push($min_expectedJumlahMalarias, $minJumlahMalaria);
                                array_push($max_expectedJumlahMalarias, $maxJumlahMalaria);

                                // Counting Score
                                $currentScore = 0;
                                if (count($expected) == 1 && $expected[0] == 'Negatif') {
                                    if (count($answer) == 1 && $answer[0] == 'Negatif') {
                                        $currentScore = 10;
                                    } else {
                                        $currentScore = 0;
                                    }
                                } else {
                                    sort($answerPlasmodiums);
                                    sort($expectedPlasmodiums);
                                    sort($answerStadiums);
                                    sort($expectedStadiums);
                                    if ($answerPlasmodiums == $expectedPlasmodiums && $answerStadiums == $expectedStadiums && $answerJumlahMalaria >= $minJumlahMalaria && $answerJumlahMalaria <= $maxJumlahMalaria) {
                                        $currentScore = 10;
                                    } elseif ($answerPlasmodiums == $expectedPlasmodiums && $answerStadiums == $expectedStadiums) {
                                        $currentScore = 8;
                                    } elseif ($answerPlasmodiums == $expectedPlasmodiums && count(array_intersect($answerStadiums, $expectedStadiums)) > 0 && $answerJumlahMalaria >= $minJumlahMalaria && $answerJumlahMalaria <= $maxJumlahMalaria) {
                                        $currentScore = 8;
                                    } elseif ($answerPlasmodiums == $expectedPlasmodiums && count(array_intersect($answerStadiums, $expectedStadiums)) > 0) {
                                        $currentScore = 6;
                                    } elseif (count(array_intersect($answerStadiums, $expectedStadiums)) > 0 && $answerJumlahMalaria >= $minJumlahMalaria && $answerJumlahMalaria <= $maxJumlahMalaria) {
                                        $currentScore = 5;
                                    } elseif (count($answer) == 1 && $answer[0] == 'Negatif') {
                                        $currentScore = 0;
                                    } else {
                                        $currentScore = 3;
                                    }
                                }

                                array_push($scores, $currentScore);
                            }
                            $avg = 0;
                            if (count($scores) > 0) {
                                $avg = array_sum($scores);
                            } else {
                                $avg = 0;
                            }
                        @endphp
                        @for ($i = 0; $i < 10; $i++)
                            <tr>
                                @if ($i == 0)
                                    <td class="center aligned" rowspan="10">{{ $index }}</td>
                                    <td class="center aligned" rowspan="10">{{ $submit->order->invoice->laboratory->participant_number }}</td>
                                    <td class="center aligned" rowspan="10">{{ $submit->order->invoice->laboratory->name }}</td>
                                @endif
                                <td class="center aligned">{{ $submitValue->{'kode_'.$i} }}</td>
                                <td class="center aligned">

                                    {!! $txt_answers[$i] !!}

                                </td>
                                <td class="center aligned">

                                    {!! number_format($answerJumlahMalarias[$i], 0, ",", ".") !!}

                                </td>
                                <td class="center aligned">

                                    {!! $txt_expecteds[$i] !!}

                                </td>
                                <td class="center aligned">

                                    @if(count($expecteds[$i]) > 0)

                                        @if ($expectedJumlahMalarias[$i] == 0)

                                            {{ '0' }}

                                        @else

                                            {!! number_format($min_expectedJumlahMalarias[$i], 0, ",", ".") !!} - {{ number_format(($max_expectedJumlahMalarias[$i]), 0, ",", ".") }}

                                        @endif

                                    @else

                                        <i style="color: red;">Tidak diisi</i>

                                    @endif

                                </td>
                                <td class="center aligned">

                                    @if(count($expecteds[$i]) > 0)
                                        {{ $scores[$i] }}
                                    @else
                                        <i style="color: red;">Tidak diisi</i>
                                    @endif

                                </td>
                                @if ($i == 0)
                                    <td rowspan="10" class="center aligned">
                                        @if(count($expecteds[$i]) > 0)
                                            {{ $avg }}
                                        @else
                                            <i style="color: red;">Tidak diisi</i>
                                        @endif
                                    </td>
                                    @if(count($expecteds[$i]) > 0)
                                        <td rowspan="10" class="center aligned @if($avg >= 90) positive @elseif($avg >= 80) positive @elseif($avg >= 70) warning @else negative @endif">
                                            @if($avg >= 90) Sempurna @elseif($avg >= 80) Sangat Baik @elseif($avg >= 70) Baik @else Buruk @endif
                                        </td>
                                    @else
                                        <td rowspan="10" class="center aligned">
                                            <i style="color: red;">Tidak diisi</i>
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