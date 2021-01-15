@php

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
                            <th class="center aligned" rowspan="2" colspan="1">Sediaan {{ $sediaan + 1 }}</th>
                        @endfor
                        <th class="center aligned" rowspan="2" hidden></th>
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
                            @endfor
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