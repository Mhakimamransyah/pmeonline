@php
    $cycle = \App\Cycle::first();
    $kimia_klinik = "KIMIA KLINIK";
    $orderPackage = \App\OrderPackage::findOrFail($order_package_id);
    $result_obj = json_decode($result);
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
        'orderPackage' => $orderPackage,
        'bidang' => $kimia_klinik,
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
                @foreach($result_obj->result->parameters as $parameter)
                    <tr>
                        <td>{{ $parameter_count }}</td>
                        <td>{{ $parameter->name }}</td>
                        @if($parameter->hasil != null)
                            @if($parameter->metode == null || $parameter->metode == '')
                                <td class="text-center">{{ '99' }}</td>
                            @else
                                <td class="text-center">{{ $parameter->metode }}</td>
                            @endif
                            @if($parameter->alat == null || $parameter->alat == '')
                                <td class="text-center">{{ '2699' }}</td>
                            @else
                                <td class="text-center">{{ $parameter->alat }}</td>
                            @endif
                            <td class="text-center hasil">{{ number_format($parameter->hasil, 2) }}</td>

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
                @endforeach
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
            let jsonString = '{!! str_replace('\"', '\\\"', $result) !!}'.replace(/\\n/g, "\\n")
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
                if (parameter.per_semua != null) {
                    let perSemuaLength = parameter.per_semua.length;
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
                                targetSemuaLabels[index].innerHTML = data.mean.toFixed(2);

                                let sdpa = data.standardDeviation;
                                let zscore = (hasil - data.mean) / sdpa;
                                if (sdpa === 0 || sdpa === 0.0) {
                                    zscore = (hasil - data.mean) / data.shorwitPatologi;
                                }

                                let abs = Math.abs(zscore.toFixed(3));
                                zScoreSemuaLabels[index].innerHTML = zscore.toFixed(2);
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
                }

                // hint ~> 'per metode'.
                if (parameter.per_metode != null) {
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
                                targetMetodeLabels[index].innerHTML = data.mean.toFixed(2);

                                let sdpa = data.standardDeviation;
                                let zscore = (hasil - data.mean) / sdpa;
                                if (sdpa === 0 || sdpa === 0.0) {
                                    zscore = (hasil - data.mean) / data.shorwitPatologi;
                                }

                                let abs = Math.abs(zscore.toFixed(3));
                                zScoreMetodeLabels[index].innerHTML = zscore.toFixed(2);
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
                }

                // hint ~> 'per alat'.
                if (parameter.per_alat != null) {
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
                                targetAlatLabels[index].innerHTML = data.mean.toFixed(2);

                                let sdpa = data.standardDeviation;
                                let zscore = (hasil - data.mean) / sdpa;
                                if (sdpa === 0 || sdpa === 0.0) {
                                    zscore = (hasil - data.mean) / data.shorwitPatologi;
                                }

                                let abs = Math.abs(zscore.toFixed(3));
                                zScoreAlatLabels[index].innerHTML = zscore.toFixed(2);
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
            element.innerHTML = 'Pertahankan Hasil Pemeriksaan Saudara.';
        }

        /**
         * Print advice for all doubtful result.
         * @param element: HTMLElement
         */
        function printAdviceForAllDoubtfulResult(element) {
            element.innerHTML = 'Tingkatkan Hasil Pemeriksaan Yang Meragukan.';
        }

        /**
         * Print advice for all unsatisfied result.
         * @param element: HTMLElement
         */
        function printAdviceForAllUnsatisfiedResult(element) {
            element.innerHTML = 'Lakukan Investigasi penyebab dan Tindakan Perbaikan Terhadap Hasil Pemeriksaan yang Kurang Memuaskan.';
        }

        /**
         * Print advice for OK and doubtful result.
         * @param element: HTMLElement
         */
        function printAdviceForOkAndDoubtfulResult(element) {
            element.innerHTML = 'Pertahankan Hasil pemeriksaan Saudara yang Memuaskan dan Tingkatkan Hasil Pemeriksaan Yang Meragukan.';
        }

        /**
         * Print advice for OK and unsatisfied result.
         * @param element: HTMLElement
         */
        function printAdviceForOkAndUnsatisfiedResult(element) {
            element.innerHTML = 'Pertahankan Hasil Pemeriksaan Saudara yang Memuaskan, Lakukan Investigasi penyebab dan Tindakan Perbaikan Terhadap Hasil Pemeriksaan yang Kurang Memuaskan.';
        }

        /**
         * Print advice for doubtful and unsatisfied result.
         * @param element: HTMLElement
         */
        function printAdviceForDoubtfulAndUnsatisfiedResult(element) {
            element.innerHTML = 'Lakukan Investigasi Penyebab dan Tindakan Perbaikan Terhadap Hasil Pemeriksaan yang Meragukan dan Kurang Memuaskan.';
        }

        /**
         * Print advice for OK, doubtful and unsatisfied result.
         * @param element: HTMLElement
         */
        function printAdviceForOkDoubtfulAndUnsatisifiedResult(element) {
            element.innerHTML = 'Pertahankan Hasil Pemeriksaan Saudara yang Memuaskan, Lakukan Investigasi penyebab dan Tindakan Perbaikan Terhadap Hasil Pemeriksaan yang Meragukan dan Kurang Memuaskan.';
        }

        /**
         * Calculation done.
         */
        function done() {
            document.getElementById('progress-alert').remove();
        }
    </script>
@endsection
