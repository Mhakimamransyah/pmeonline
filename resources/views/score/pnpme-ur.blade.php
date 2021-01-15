@php
$isBad = false;
$isGood = false;
@endphp

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

    <div class="row" id="progress-alert" style="margin-top: 36px">
        <div class="alert alert-warning" role="alert">Proses perhitungan belum selesai ...</div>
    </div>

    @component('score.header3', [
        'orderPackage' => $order_package,
        'bidang' => $order_package->package->subject->name,
        'bottle_number' => $bottle_number,
        'bottle_string' => $bottle_string,
    ])
    @endcomponent

    <div class="row">

        <div class="col-xs-12">

            <table class="table table-bordered">

                <thead>
                <tr>
                    <th rowspan="2" class="text-center">No</th>
                    <th rowspan="2" class="text-center">Parameter</th>
                    <th colspan="2" class="text-center">Kode</th>
                    <th rowspan="2" class="text-center">Hasil Saudara</th>
                    <th colspan="5" class="text-center">Seluruh Peserta</th>
                    <th colspan="5" class="text-center">Kelompok Metode</th>
                    <th colspan="5" class="text-center">Kelompok Alat</th>
                </tr>
                <tr>
                    <th class="text-center">Metode</th>
                    <th class="text-center">Alat</th>
                    <th class="text-center">n</th>
                    <th class="text-center">Target</th>
                    <th class="text-center">Z Score</th>
                    <th class="text-center">Kategori</th>
                    <th class="text-center">Keterangan</th>
                    <th class="text-center">n</th>
                    <th class="text-center">Target</th>
                    <th class="text-center">Z Score</th>
                    <th class="text-center">Kategori</th>
                    <th class="text-center">Keterangan</th>
                    <th class="text-center">n</th>
                    <th class="text-center">Target</th>
                    <th class="text-center">Z Score</th>
                    <th class="text-center">Kategori</th>
                    <th class="text-center">Keterangan</th>
                </tr>
                </thead>

                <tbody>
                @php
                    $parameter_count = 1;
                @endphp
                @for ($i = 0; $i < 2; $i++)
                    <tr>
                        <td>{{ $parameter_count }}</td>
                        @php
                            $parameter = $data->result->parameters[$i]
                        @endphp
                        <td>{{ $parameter->name }}</td>
                        @if($parameter->hasil != null)
                            <td class="text-center">{{ $parameter->metode }}</td>
                            @if($parameter->alat == null || $parameter->alat == '')
                                <td class="text-center">{{ '99' }}</td>
                            @else
                                <td class="text-center">{{ $parameter->alat }}</td>
                            @endif

                            @if($parameter->name == 'PH')
                                @if($parameter->hasil % abs($parameter->hasil) == 0.0)
                                <td class="text-center hasil">{{ number_format($parameter->hasil, 1) }}</td>
                                @else
                                <td class="text-center hasil">{{ number_format($parameter->hasil, 3) }}</td>
                                @endif
                            @else
                                <td class="text-center hasil">{{ number_format($parameter->hasil, 3) }}</td>
                            @endif

                            <td class="text-center per-semua-n">{{ '-' }}</td>
                            <td class="text-center per-semua-target">{{ '-' }}</td>
                            <td class="text-center per-semua-zscore">{{ '-' }}</td>
                            <td class="text-center per-semua-kategori">{{ '-' }}</td>
                            <td class="text-center per-semua-keterangan">{{ '-' }}</td>

                            <td class="text-center per-metode-n">{{ '-' }}</td>
                            <td class="text-center per-metode-target">{{ '-' }}</td>
                            <td class="text-center per-metode-zscore">{{ '-' }}</td>
                            <td class="text-center per-metode-kategori">{{ '-' }}</td>
                            <td class="text-center per-metode-keterangan">{{ '-' }}</td>

                            <td class="text-center per-alat-n">{{ '-' }}</td>
                            <td class="text-center per-alat-target">{{ '-' }}</td>
                            <td class="text-center per-alat-zscore">{{ '-' }}</td>
                            <td class="text-center per-alat-kategori">{{ '-' }}</td>
                            <td class="text-center per-alat-keterangan">{{ '-' }}</td>
                        @else
                            <td class="text-center">{{ '-' }}</td>
                            <td class="text-center">{{ '-' }}</td>
                            <td class="text-center hasil">{{ '-' }}</td>

                            <td class="text-center per-semua-n">{{ '-' }}</td>
                            <td class="text-center per-semua-target">{{ '-' }}</td>
                            <td class="text-center per-semua-zscore">{{ '-' }}</td>
                            <td class="text-center per-semua-kategori">{{ '-' }}</td>
                            <td class="text-center per-semua-keterangan">{{ '-' }}</td>

                            <td class="text-center per-metode-n">{{ '-' }}</td>
                            <td class="text-center per-metode-target">{{ '-' }}</td>
                            <td class="text-center per-metode-zscore">{{ '-' }}</td>
                            <td class="text-center per-metode-kategori">{{ '-' }}</td>
                            <td class="text-center per-metode-keterangan">{{ '-' }}</td>

                            <td class="text-center per-alat-n">{{ '-' }}</td>
                            <td class="text-center per-alat-target">{{ '-' }}</td>
                            <td class="text-center per-alat-zscore">{{ '-' }}</td>
                            <td class="text-center per-alat-kategori">{{ '-' }}</td>
                            <td class="text-center per-alat-keterangan">{{ '-' }}</td>
                        @endif
                    </tr>
                    @php
                        $parameter_count += 1;
                    @endphp
                @endfor
                </tbody>

            </table>

            <table class="table table-bordered">

                <thead>
                <tr>
                    <th rowspan="2" class="text-center">No</th>
                    <th rowspan="2" class="text-center">Parameter</th>
                    <th colspan="2" class="text-center">Kode</th>
                    <th rowspan="2" class="text-center">Hasil Saudara</th>
                    <th colspan="4" class="text-center">Seluruh Peserta</th>
                </tr>
                <tr>
                    <th class="text-center">Metode</th>
                    <th class="text-center">Alat</th>
                    <th class="text-center">n</th>
                    <th class="text-center">Target</th>
                    <th class="text-center">Score</th>
                    <th class="text-center">Kriteria</th>
                </tr>
                </thead>

                <tbody>
                @php
                    $parameter_count = 1;
                @endphp
                @for ($i = 2; $i < 11; $i++)
                    <tr>
                        <td class="text-center">{{ $parameter_count }}</td>
                        @php
                            $parameter = $data->result->parameters[$i]
                        @endphp
                        <td>
                            @if ($parameter->name == 'Urobilirubin')
                                {{ 'Urobilinogen' }}
                            @else
                                {{ $parameter->name }}
                            @endif
                        </td>
                        @if($parameter->hasil_raw != null)
                            <td class="text-center">{{ $parameter->metode }}</td>
                            @if($parameter->alat == null || $parameter->alat == '')
                                <td class="text-center">{{ '99' }}</td>
                            @else
                                <td class="text-center">{{ $parameter->alat }}</td>
                            @endif
                            <td class="text-center hasil">
                                @if($bottle_number == 1)
                                    {{ $parameter->hasil_raw }}
                                @else
                                    @if ($parameter->hasil_raw == null)
                                        {{ '-' }}
                                    @elseif ($parameter->hasil_raw == '-')
                                        {{ 'Negatif' }}
                                    @elseif ($parameter->hasil_raw == '+')
                                        {{ 'Positif' }}
                                    @else
                                        {{ $parameter->hasil_raw }}
                                    @endif
                                @endif
                            </td>

                            <td class="text-center per-semua-n-2">{{ count($parameter->per_semua_raw) }}</td>
                            <td class="text-center per-semua-target-2">
                                @if($bottle_number == 1)
                                    {{ 'Negatif' }}
                                @else
                                    @if ($parameter->per_semua_raw_target == null)
                                        {{ 'N/A' }}
                                    @elseif ($parameter->per_semua_raw_target == '-')
                                        {{ 'Negatif' }}
                                    @elseif ($parameter->per_semua_raw_target == '+')
                                        {{ 'Positif' }}
                                    @else
                                        {{ $parameter->per_semua_raw_target }}
                                    @endif
                                @endif
                            </td>
                            <td class="text-center per-semua-zscore-2">
                                @if($bottle_number == 1)
                                    @if(str_contains(strtolower($parameter->hasil_raw), 'neg'))
                                        {{ '4' }}
                                    @elseif ($parameter->hasil_raw == '1+')
                                        {{ '3' }}
                                    @elseif ($parameter->hasil_raw == '2+')
                                        {{ '2' }}
                                    @elseif ($parameter->hasil_raw == '3+')
                                        {{ '1' }}
                                    @else
                                        {{ '0' }}
                                    @endif
                                @else
                                    @if ($parameter->per_semua_raw_target == null)
                                        {{ 'N/A' }}
                                    @elseif ($parameter->per_semua_raw_target == $parameter->hasil_raw)
                                        {{ '4' }}
                                    @else
                                        @php
                                        $pos_value_peserta = (int) mb_substr($parameter->hasil_raw, 0, 1);
                                        if ($parameter->per_semua_raw_target != '-') {
                                            $pos_value_target = (int) mb_substr($parameter->per_semua_raw_target, 0, 1);
                                        } else {
                                            $pos_value_target = 0;
                                        }
                                        $selisih = abs($pos_value_peserta - $pos_value_target);
                                        @endphp
                                        @if($selisih == 1)
                                            {{ '3' }}
                                        @elseif($selisih == 2)
                                            {{ '2' }}
                                        @else
                                            {{ '1' }}
                                        @endif
                                    @endif
                                @endif
                            </td>
                            <td class="text-center per-semua-kategori-2">
                                @if($bottle_number == 1)
                                    @if(str_contains(strtolower($parameter->hasil_raw), 'neg'))
                                        @php
                                            $isGood = true;
                                        @endphp
                                        {{ 'Baik' }}
                                    @elseif ($parameter->hasil_raw == '1+')
                                        @php
                                            $isBad = true;
                                        @endphp
                                        {{ 'Cukup' }}
                                    @elseif ($parameter->hasil_raw == '2+')
                                        @php
                                            $isBad = true;
                                        @endphp
                                        {{ 'Kurang' }}
                                    @elseif ($parameter->hasil_raw == '3+')
                                        @php
                                            $isBad = true;
                                        @endphp
                                        {{ 'Buruk' }}
                                    @else
                                        @php
                                            $isBad = true;
                                        @endphp
                                        {{ 'Buruk' }}
                                    @endif
                                @else
                                    @if ($parameter->per_semua_raw_target == null)
                                        {{ 'N/A' }}
                                    @elseif ($parameter->per_semua_raw_target == $parameter->hasil_raw)
                                        @php
                                        $isGood = true;
                                        @endphp
                                        {{ 'Baik' }}
                                    @else
                                        @php
                                        $pos_value_peserta = (int) mb_substr($parameter->hasil_raw, 0, 1);
                                        if ($parameter->per_semua_raw_target != '-') {
                                            $pos_value_target = (int) mb_substr($parameter->per_semua_raw_target, 0, 1);
                                        } else {
                                            $pos_value_target = 0;
                                        }
                                        $selisih = abs($pos_value_peserta - $pos_value_target);
                                        @endphp
                                        @if($selisih == 1)
                                            @php
                                                $isBad = true;
                                            @endphp
                                            {{ 'Cukup' }}
                                        @elseif($selisih == 2)
                                            @php
                                                $isBad = true;
                                            @endphp
                                            {{ 'Kurang' }}
                                        @else
                                            @php
                                                $isBad = true;
                                            @endphp
                                            {{ 'Buruk' }}
                                        @endif
                                    @endif
                                @endif
                            </td>

                        @else
                            <td class="text-center">{{ '-' }}</td>
                            <td class="text-center">{{ '-' }}</td>
                            <td class="text-center">{{ '-' }}</td>
                            <td class="text-center">{{ '-' }}</td>
                            <td class="text-center">{{ '-' }}</td>
                            <td class="text-center">{{ '-' }}</td>
                            <td class="text-center">{{ '-' }}</td>
                        @endif
                    </tr>
                    @php
                        $parameter_count += 1;
                    @endphp
                @endfor
                </tbody>

            </table>

        </div>

    </div>

    <div class="row">

        <div class="col-xs-12 form-group">
            <label>{{ 'Komentar / Saran' }}</label><br/>
            <p id="result_text"></p>
        </div>

    </div>

    @component('score.signature')
    @endcomponent

@endsection

@section('body-bottom')
    <script>
        let semuaHasil = [];
        let totalPromise = 0;
        let promiseDone = 0;

        $(document).ready(function() {
            calculate();
        });

        function calculate() {
            let jsonString = '{!! str_replace('\"', '\\\"', json_encode($data)) !!}'.replace(/\\n/g, "\\n")
                .replace(/\\'/g, "\\'")
                .replace(/\\"/g, '\\"')
                .replace(/\\&/g, "\\&")
                .replace(/\\r/g, "\\r")
                .replace(/\\t/g, "\\t")
                .replace(/\\b/g, "\\b")
                .replace(/\\f/g, "\\f");
            console.log(jsonString);
            let json = JSON.parse(jsonString);
            let parameters = json.result.parameters;

            // hint ~> 'hasil peserta'.
            let hasilLabels = document.getElementsByClassName('hasil');

            // hint ~> 'per semua'.
            let nSemuaLabels = document.getElementsByClassName('per-semua-n');
            let targetSemuaLabels = document.getElementsByClassName('per-semua-target');
            let zScoreSemuaLabels = document.getElementsByClassName('per-semua-zscore');
            let kategoriSemuaLabels = document.getElementsByClassName('per-semua-kategori');
            let keteranganSemuaLabels = document.getElementsByClassName('per-semua-keterangan');

            // hint ~> 'per metode'.
            let nMetodeLabels = document.getElementsByClassName('per-metode-n');
            let targetMetodeLabels = document.getElementsByClassName('per-metode-target');
            let zScoreMetodeLabels = document.getElementsByClassName('per-metode-zscore');
            let kategoriMetodeLabels = document.getElementsByClassName('per-metode-kategori');
            let keteranganMetodeLabels = document.getElementsByClassName('per-metode-keterangan');

            // hint ~> 'per alat'.
            let nAlatLabels = document.getElementsByClassName('per-alat-n');
            let targetAlatLabels = document.getElementsByClassName('per-alat-target');
            let zScoreAlatLabels = document.getElementsByClassName('per-alat-zscore');
            let kategoriAlatLabels = document.getElementsByClassName('per-alat-kategori');
            let keteranganAlatLabels = document.getElementsByClassName('per-alat-keterangan');

            $.each(parameters, function (index, parameter) {
                console.log(parameter);

                // hint ~> 'per semua'.
                let perSemuaLength = parameter.per_semua.length;
                console.log(parameter.per_semua);
                if (perSemuaLength > 5) {
                    totalPromise++;
                    nSemuaLabels[index].innerHTML = perSemuaLength;
                    $.ajax({
                        type: 'POST',
                        url: 'http://35.240.172.178:8522/find-algorithm-a',
                        data: JSON.stringify({
                            items: parameter.per_semua,
                        }),
                        contentType: "application/json; charset=utf-8",
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
                            let hasil = parseFloat(hasilLabels[index].innerHTML);

                            console.log("hasil : " + hasil);

                            if (data.mean.toFixed(3) % 1 === 0.0) {
                                targetSemuaLabels[index].innerHTML = data.mean.toFixed(1);
                            } else {
                                targetSemuaLabels[index].innerHTML = data.mean.toFixed(3);
                            }

                            let sdpa = data.shorwitPatologi;
                            let zscore = (hasil - data.mean) / sdpa;
                            if (sdpa === 0 || sdpa === 0.0) {
                                zscore = (hasil - data.mean) / 0.01;
                            }

                            console.log('data.mean : ' + data.mean.toFixed(3));
                            console.log('sdpa : ' + sdpa);
                            console.log('zscore : ' + zscore);

                            let abs = Math.abs(zscore.toFixed(3));
                            if (zscore.toFixed(3) % 1 === 0.0) {
                                zScoreSemuaLabels[index].innerHTML = zscore.toFixed(1);
                            } else {
                                zScoreSemuaLabels[index].innerHTML = zscore.toFixed(3);
                            }
                            if (abs < 2.0) {
                                kategoriSemuaLabels[index].innerHTML = 'OK';
                                keteranganSemuaLabels[index].innerHTML = 'Memuaskan';
                                calculateResult('OK');
                            } else if (abs < 3.0) {
                                kategoriSemuaLabels[index].innerHTML = '$';
                                keteranganSemuaLabels[index].innerHTML = 'Meragukan';
                                calculateResult('$')
                            } else {
                                kategoriSemuaLabels[index].innerHTML = '$$';
                                keteranganSemuaLabels[index].innerHTML = 'Kurang Memuaskan';
                                calculateResult('$$')
                            }
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                } else {
                    nSemuaLabels[index].innerHTML = '-';
                }

                // hint ~> 'per metode'.
                let perMetodeLength = parameter.per_metode.length;
                if (perMetodeLength > 5) {
                    totalPromise++;
                    nMetodeLabels[index].innerHTML = perMetodeLength;
                    $.ajax({
                        type: 'POST',
                        url: 'http://35.240.172.178:8522/find-algorithm-a',
                        data: JSON.stringify({
                            items: parameter.per_metode,
                        }),
                        contentType: "application/json; charset=utf-8",
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
                            let hasil = parseFloat(hasilLabels[index].innerHTML);

                            if (data.mean.toFixed(3) % 1 === 0.0) {
                                targetMetodeLabels[index].innerHTML = data.mean.toFixed(1);
                            } else {
                                targetMetodeLabels[index].innerHTML = data.mean.toFixed(3);
                            }

                            let sdpa = data.shorwitPatologi;
                            let zscore = (hasil - data.mean) / sdpa;
                            if (sdpa === 0 || sdpa === 0.0) {
                                zscore = (hasil - data.mean) / 0.01;
                            }

                            let abs = Math.abs(zscore.toFixed(3));
                            if (zscore.toFixed(3) % 1 === 0.0) {
                                zScoreMetodeLabels[index].innerHTML = zscore.toFixed(1);
                            } else {
                                zScoreMetodeLabels[index].innerHTML = zscore.toFixed(3);
                            }
                            if (abs < 2.0) {
                                kategoriMetodeLabels[index].innerHTML = 'OK';
                                keteranganMetodeLabels[index].innerHTML = 'Memuaskan';
                                calculateResult('OK');
                            } else if (abs < 3.0) {
                                kategoriMetodeLabels[index].innerHTML = '$';
                                keteranganMetodeLabels[index].innerHTML = 'Meragukan';
                                calculateResult('$')
                            } else {
                                kategoriMetodeLabels[index].innerHTML = '$$';
                                keteranganMetodeLabels[index].innerHTML = 'Kurang Memuaskan';
                                calculateResult('$$')
                            }
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                } else {
                    nMetodeLabels[index].innerHTML = '-';
                }

                // hint ~> 'per alat'.
                let perAlatLength = parameter.per_alat.length;
                if (perAlatLength > 5) {
                    totalPromise++;
                    nAlatLabels[index].innerHTML = perAlatLength;
                    $.ajax({
                        type: 'POST',
                        url: 'http://35.240.172.178:8522/find-algorithm-a',
                        data: JSON.stringify({
                            items: parameter.per_alat,
                        }),
                        contentType: "application/json; charset=utf-8",
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
                            let hasil = parseFloat(hasilLabels[index].innerHTML);

                            if (data.mean.toFixed(3) % 1 === 0) {
                                targetAlatLabels[index].innerHTML = data.mean.toFixed(1);
                            } else {
                                targetAlatLabels[index].innerHTML = data.mean.toFixed(3);
                            }

                            let sdpa = data.shorwitPatologi;
                            let zscore = (hasil - data.mean) / sdpa;
                            if (sdpa === 0 || sdpa === 0.0) {
                                zscore = (hasil - data.mean) / 0.01;
                            }

                            let abs = Math.abs(zscore.toFixed(3));
                            if (zscore.toFixed(3) % 1 === 0.0) {
                                zScoreAlatLabels[index].innerHTML = zscore.toFixed(1);
                            } else {
                                zScoreAlatLabels[index].innerHTML = zscore.toFixed(3);
                            }
                            if (abs < 2.0) {
                                kategoriAlatLabels[index].innerHTML = 'OK';
                                keteranganAlatLabels[index].innerHTML = 'Memuaskan';
                                calculateResult('OK');
                            } else if (abs < 3.0) {
                                kategoriAlatLabels[index].innerHTML = '$';
                                keteranganAlatLabels[index].innerHTML = 'Meragukan';
                                calculateResult('$')
                            } else {
                                kategoriAlatLabels[index].innerHTML = '$$';
                                keteranganAlatLabels[index].innerHTML = 'Kurang Memuaskan';
                                calculateResult('$$')
                            }
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                } else {
                    nAlatLabels[index].innerHTML = '-';
                }

                console.log(semuaHasil);
            });
            console.log(json);
        }

        /**
         * Calculate result to determine comment or advice to participants.
         * @param result: String ('OK' or '$' or '$$')
         */
        function calculateResult(result) {
            promiseDone++;

            let resultTextView = document.getElementById('result_text');

            semuaHasil.push(result);

            let okCount = semuaHasil.filter(function (item, index, list) {
                return item === 'OK';
            }).length;

            let doubtfulCount = semuaHasil.filter(function (item, index, list) {
                return item === '$';
            }).length;

            let unsatisfiedCount = semuaHasil.filter(function (item, index, list) {
                return item === '$$';
            }).length;

            if (okCount === result.length) {
                printAdviceForAllOkResult(resultTextView);
            }

            if (doubtfulCount === result.length) {
                printAdviceForAllDoubtfulResult(resultTextView);
            }

            if (unsatisfiedCount === result.length) {
                printAdviceForAllUnsatisfiedResult(resultTextView);
            }

            if (okCount > 0 && doubtfulCount > 0 && unsatisfiedCount === 0) {
                printAdviceForOkAndDoubtfulResult(resultTextView);
            }

            if (okCount > 0 && doubtfulCount === 0 && unsatisfiedCount > 0) {
                printAdviceForOkAndUnsatisfiedResult(resultTextView);
            }

            if (okCount === 0 && doubtfulCount > 0 && unsatisfiedCount > 0) {
                printAdviceForDoubtfulAndUnsatisfiedResult(resultTextView);
            }

            if (okCount > 0 && doubtfulCount > 0 && unsatisfiedCount > 0) {
                printAdviceForOkDoubtfulAndUnsatisifiedResult(resultTextView);
            }

            if (promiseDone === totalPromise && promiseDone !== 0 && totalPromise !== 0) {
                done();
            }
        }

        /**
         * Print advice for all OK result.
         * @param element: HTMLElement
         */
        function printAdviceForAllOkResult(element) {
            @if (!$isBad) // -
            element.innerHTML = 'Pertahankan kualitas hasil pemeriksaan laboratorium saudara.';
            @else
            element.innerHTML = 'Pertahankan kualitas hasil pemeriksaan Laboratorium Saudara yang Baik dan lakukan investigasi terhadap hasil pemeriskaan yang cukup / kurang / buruk.';
            @endif
        }

        /**
         * Print advice for all doubtful result.
         * @param element: HTMLElement
         */
        function printAdviceForAllDoubtfulResult(element) {
            @if ($isBad)
            element.innerHTML = 'Tingkatkan Hasil Pemeriksaan Yang Meragukan. Lakukan Investigasi penyebab dan Tindakan Perbaikan Terhadap Hasil Pemeriksaan yang Kurang Memuaskan / Cukup / Kurang / Buruk.';
            @elseif ($isGood)
            element.innerHTML = 'Pertahankan kualitas hasil pemeriksaan Laboratorium Saudara yang Baik dan lakukan investigasi terhadap hasil pemeriskaan yang cukup / kurang / buruk.';
            @else
            element.innerHTML = 'Tingkatkan Hasil Pemeriksaan Yang Meragukan.';
            @endif
        }

        /**
         * Print advice for all unsatisfied result.
         * @param element: HTMLElement
         */
        function printAdviceForAllUnsatisfiedResult(element) {
            @if ($isBad)
                element.innerHTML = 'Tingkatkan Hasil Pemeriksaan Yang Meragukan. Lakukan Investigasi penyebab dan Tindakan Perbaikan Terhadap Hasil Pemeriksaan yang Kurang Memuaskan / Cukup / Kurang / Buruk.';
            @elseif ($isGood)
                element.innerHTML = 'Pertahankan kualitas hasil pemeriksaan Laboratorium Saudara yang Baik dan lakukan investigasi terhadap hasil pemeriskaan yang cukup / kurang / buruk.';
            @else
                element.innerHTML = 'Lakukan Investigasi penyebab dan Tindakan Perbaikan Terhadap Hasil Pemeriksaan yang Kurang Memuaskan.';
            @endif
        }

        /**
         * Print advice for OK and doubtful result.
         * @param element: HTMLElement
         */
        function printAdviceForOkAndDoubtfulResult(element) {
            element.innerHTML = 'Pertahankan kualitas hasil pemeriksaan Laboratorium Saudara yang Baik dan lakukan investigasi terhadap hasil pemeriskaan yang cukup / kurang / buruk / meragukan.';
        }

        /**
         * Print advice for OK and unsatisfied result.
         * @param element: HTMLElement
         */
        function printAdviceForOkAndUnsatisfiedResult(element) {
            element.innerHTML = 'Pertahankan kualitas hasil pemeriksaan Laboratorium Saudara yang Baik dan lakukan investigasi terhadap hasil pemeriskaan yang cukup / kurang / buruk / kurang memuaskan.';
        }

        /**
         * Print advice for doubtful and unsatisfied result.
         * @param element: HTMLElement
         */
        function printAdviceForDoubtfulAndUnsatisfiedResult(element) {
            @if ($isBad)
                element.innerHTML = 'Tingkatkan Hasil Pemeriksaan Yang Meragukan dan Kurang Memuaskan. Lakukan Investigasi penyebab dan Tindakan Perbaikan Terhadap Hasil Pemeriksaan yang Kurang Memuaskan / Cukup / Kurang / Buruk.';
            @elseif ($isGood)
                element.innerHTML = 'Pertahankan kualitas hasil pemeriksaan Laboratorium Saudara yang Baik dan lakukan investigasi terhadap hasil pemeriskaan yang cukup / kurang / buruk.';
            @else
                element.innerHTML = 'Lakukan Investigasi Penyebab dan Tindakan Perbaikan Terhadap Hasil Pemeriksaan yang Meragukan dan Kurang Memuaskan.';
            @endif
        }

        /**
         * Print advice for OK, doubtful and unsatisfied result.
         * @param element: HTMLElement
         */
        function printAdviceForOkDoubtfulAndUnsatisifiedResult(element) {
            element.innerHTML = 'Pertahankan kualitas hasil pemeriksaan Laboratorium Saudara yang Baik dan lakukan investigasi terhadap hasil pemeriskaan yang cukup / kurang / buruk / kurang memuaskan / meragukan.';
        }

        /**
         * Calculation done.
         */
        function done() {
            document.getElementById('progress-alert').remove();
        }
    </script>
@endsection
