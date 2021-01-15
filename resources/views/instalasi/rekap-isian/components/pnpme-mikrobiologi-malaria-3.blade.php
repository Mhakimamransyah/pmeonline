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

                                array_push($txt_answers, $txt_answer);
                                array_push($answerJumlahMalarias, $answerJumlahMalaria);
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