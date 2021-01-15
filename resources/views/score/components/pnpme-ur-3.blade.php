@php
    $parameterName = "URINALISA";
    $f = new stdClass();
    $order_id = request()->query('order_id');
    $submit = \App\Submit::query()->where('order_id', '=', $order_id)->get()->first();
    if ($submit->value != null) {
        $f = json_decode($submit->value);
    }
    $score = \App\v3\Score::query()->where('order_id', '=', $order_id)->get()->first();
    if ($score->value != null) {
        $scoreValue = json_decode($score->value);
    }
    $parameters = $submit->order->package->parameters;
    $isBad = false;
    $isGood = false;

    $okCount = 0;
    $meragukanCount = 0;
    $kurangMemuaskanCount = 0;
@endphp

@for($bottle = 1; $bottle <= 2; $bottle++)

<h3 class="text-center"><b>PROGRAM NASIONAL PEMANTAPAN MUTU EKSTERNAL BIDANG PATOLOGI<br/>
        HASIL EVALUASI PARAMETER {{ strtoupper($parameterName) }} BOTOL @for($i = 1; $i <= $bottle; $i++){{ 'I' }}@endfor<br/>
        SIKLUS II - TAHUN 2019</b>
</h3>

<br/>

@component('score.identity-header', [
    'submit' => $submit,
])
@endcomponent

<br/>

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
                        $parameter = $parameters[$i];
                        $method = $f->{'method_'.$i.'_bottle_'.$bottle} ?? '99';
                        $equipment = $f->{'equipment_'.$i.'_bottle_'.$bottle} ?? '99';
                        $hasil = $f->{'hasil_pemeriksaan_'.$i.'_bottle_'.$bottle};
                    @endphp
                    <td>{{ $parameter->label }}</td>
                    @if($hasil != null)
                        <td class="text-center">{{ $method }}</td>
                        @if($equipment == null || $equipment == '')
                            <td class="text-center">{{ '99' }}</td>
                        @else
                            <td class="text-center">{{ $equipment }}</td>
                        @endif

                        @if($parameter->label == 'PH')
                            @if($hasil % abs($hasil) == 0.0)
                            <td class="text-center hasil">{{ number_format($hasil, 1) }}</td>
                            @else
                            <td class="text-center hasil">{{ number_format($hasil, 3) }}</td>
                            @endif
                        @else
                            <td class="text-center hasil">{{ number_format($hasil, 3) }}</td>
                        @endif

                        @php
                            $collection = \Illuminate\Support\Collection::make($scoreValue);
                            $parameterScore = $collection->first(function ($segment) use ($parameter) { return $segment->parameter->id == $parameter->id; });
                            $bottleResult = \Illuminate\Support\Collection::make($parameterScore->results)->first(function ($result) use ($bottle) { return $result->bottleNumber == $bottle; });

                            $sdpa = $bottleResult->byParameters->standardDeviation;

                            if ($sdpa == 0.0) {
                                $zScore = ($hasil - $bottleResult->byParameters->mean) / $bottleResult->byParameters->resultByHorwitz;
                            } else {
                                $zScore = ($hasil - $bottleResult->byParameters->mean) / $sdpa;
                            }

                            $_zScore = abs($zScore);

                            if ($_zScore < 2.0) {
                                $kategori = "OK";
                                $keterangan = "Memuaskan";
                                $okCount += 1;
                            } else if ($_zScore < 3.0) {
                                $kategori = "$";
                                $keterangan = "Meragukan";
                                $meragukanCount += 1;
                            } else if ($hasil != null) {
                                $kategori = "$$";
                                $keterangan = "Kurang Memuaskan";
                                $kurangMemuaskanCount += 1;
                            }
                        @endphp
                        <td class="text-center per-semua-n">{{ $bottleResult->byParameters->n }}</td>
                        <td class="text-center per-semua-target">{{ number_format($bottleResult->byParameters->mean, 3) }}</td>
                        <td class="text-center per-semua-zscore">{{ number_format($zScore, 3) }}</td>
                        <td class="text-center per-semua-kategori">{{ $kategori }}</td>
                        <td class="text-center per-semua-keterangan">{{ $keterangan }}</td>

                        @php
                            $byMethodResult = \Illuminate\Support\Collection::make($bottleResult->byMethods)->first(function ($byMethod) use ($method) {
                                return isset($byMethod->first) && $method == $byMethod->first;
                            });

                            if ($byMethodResult != null) {
                                $sdpa = $byMethodResult->second->standardDeviation;

                                if ($sdpa == 0.0) {
                                    if ($byMethodResult->second->resultByHorwitz == 0.0) {
                                        $zScore = 0;
                                    } else {
                                        $zScore = ($hasil - $byMethodResult->second->mean) / $byMethodResult->second->resultByHorwitz;
                                    }
                                } else {
                                    $zScore = ($hasil - $byMethodResult->second->mean) / $sdpa;
                                }

                                $_zScore = abs($zScore);

                                if ($_zScore < 2.0) {
                                    $kategori = "OK";
                                    $keterangan = "Memuaskan";
                                    $okCount += 1;
                                } else if ($_zScore < 3.0) {
                                    $kategori = "$";
                                    $keterangan = "Meragukan";
                                    $meragukanCount += 1;
                                } else if ($hasil != null) {
                                    $kategori = "$$";
                                    $keterangan = "Kurang Memuaskan";
                                    $kurangMemuaskanCount += 1;
                                }
                            }
                        @endphp
                        @if ($byMethodResult != null && $byMethodResult->second->n >= 6)
                            <td class="text-center per-metode-n">{{ $byMethodResult->second->n }}</td>
                            <td class="text-center per-metode-target">{{ number_format($byMethodResult->second->mean, 3) }}</td>
                            <td class="text-center per-metode-zscore">{{ number_format($zScore, 3) }}</td>
                            <td class="text-center per-metode-kategori">{{ $kategori }}</td>
                            <td class="text-center per-metode-keterangan">{{ $keterangan }}</td>
                        @else
                            <td class="text-center per-metode-n">{{ '-' }}</td>
                            <td class="text-center per-metode-target">{{ '-' }}</td>
                            <td class="text-center per-metode-zscore">{{ '-' }}</td>
                            <td class="text-center per-metode-kategori">{{ '-' }}</td>
                            <td class="text-center per-metode-keterangan">{{ '-' }}</td>
                        @endif

                        @php
                            $byEquipmentResult = \Illuminate\Support\Collection::make($bottleResult->byEquipments)->first(function ($byEquipment) use ($equipment) {
                                return isset($byEquipment->first) && $equipment == $byEquipment->first;
                            });

                            if ($byEquipmentResult != null) {
                                $sdpa = $byEquipmentResult->second->standardDeviation;

                                if ($sdpa == 0.0) {
                                    if ($byEquipmentResult->second->resultByHorwitz == 0.0) {
                                        $zScore = 0;
                                    } else {
                                        $zScore = ($hasil - $byEquipmentResult->second->mean) / $byEquipmentResult->second->resultByHorwitz;
                                    }
                                } else {
                                    $zScore = ($hasil - $byEquipmentResult->second->mean) / $sdpa;
                                }

                                $_zScore = abs($zScore);

                                if ($_zScore < 2.0) {
                                    $kategori = "OK";
                                    $keterangan = "Memuaskan";
                                    $okCount += 1;
                                } else if ($_zScore < 3.0) {
                                    $kategori = "$";
                                    $keterangan = "Meragukan";
                                    $meragukanCount += 1;
                                } else if ($hasil != null) {
                                    $kategori = "$$";
                                    $keterangan = "Kurang Memuaskan";
                                    $kurangMemuaskanCount += 1;
                                }
                            }
                        @endphp
                        @if ($byEquipmentResult != null && $byEquipmentResult->second->n >= 6)
                            <td class="text-center per-metode-n">{{ $byEquipmentResult->second->n }}</td>
                            <td class="text-center per-metode-target">{{ number_format($byEquipmentResult->second->mean, 3) }}</td>
                            <td class="text-center per-metode-zscore">{{ number_format($zScore, 3) }}</td>
                            <td class="text-center per-metode-kategori">{{ $kategori }}</td>
                            <td class="text-center per-metode-keterangan">{{ $keterangan }}</td>
                        @else
                            <td class="text-center per-alat-n">{{ '-' }}</td>
                            <td class="text-center per-alat-target">{{ '-' }}</td>
                            <td class="text-center per-alat-zscore">{{ '-' }}</td>
                            <td class="text-center per-alat-kategori">{{ '-' }}</td>
                            <td class="text-center per-alat-keterangan">{{ '-' }}</td>
                        @endif
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

        <br/>

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
                        $parameter = $parameters[$i];
                        $method = $f->{'method_'.$i.'_bottle_'.$bottle} ?? '99';
                        $equipment = $f->{'equipment_'.$i.'_bottle_'.$bottle} ?? '99';
                        $hasil = $f->{'hasil_pemeriksaan_'.$i.'_bottle_'.$bottle};

                        $collection = \Illuminate\Support\Collection::make($scoreValue);
                        $parameterScore = $collection->first(function ($segment) use ($parameter) { return $segment->parameter->id == $parameter->id; });
                        $bottleResult = \Illuminate\Support\Collection::make($parameterScore->results)->first(function ($result) use ($bottle) { return $result->bottleNumber == $bottle; });
                    @endphp
                    <td>
                        {{ $parameter->label }}
                    </td>
                    @if($hasil != null)
                        <td class="text-center">{{ $method }}</td>
                        @if($equipment == null || $equipment == '')
                            <td class="text-center">{{ '99' }}</td>
                        @else
                            <td class="text-center">{{ $equipment }}</td>
                        @endif
                        <td class="text-center hasil">
                            @if ($hasil == null)
                                {{ '-' }}
                            @elseif ($hasil == 'negatif')
                                {{ 'Negatif' }}
                            @elseif ($hasil == 'positif')
                                {{ 'Positif' }}
                            @else
                                {{ $hasil }}
                            @endif
                        </td>

                        <td class="text-center per-semua-n-2">{{ $bottleResult->byParameters->nRaw }}</td>
                        <td class="text-center per-semua-target-2">
                            @if ($bottleResult->byParameters->mode == null)
                                {{ 'N/A' }}
                            @elseif ($bottleResult->byParameters->mode == 'negatif')
                                {{ 'Negatif' }}
                            @elseif ($bottleResult->byParameters->mode == 'positif')
                                {{ 'Positif' }}
                            @else
                                {{ $bottleResult->byParameters->mode }}
                            @endif
                        </td>
                        <td class="text-center per-semua-zscore-2">
                            @if ($bottleResult->byParameters->mode == null)
                                {{ 'N/A' }}
                            @elseif ($bottleResult->byParameters->mode == $hasil)
                                {{ '4' }}
                            @else
                                @php
                                    $pos_value_peserta = (int) mb_substr($hasil, 1, 1);
                                    if ($bottleResult->byParameters->mode != 'negatif') {
                                        $pos_value_target = (int) mb_substr($bottleResult->byParameters->mode, 1, 1);
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
                        </td>
                        <td class="text-center per-semua-kategori-2">
                            @if ($bottleResult->byParameters->mode == null)
                                {{ 'N/A' }}
                            @elseif ($bottleResult->byParameters->mode == $hasil)
                                {{ 'Baik' }}
                                @php
                                    $isGood = true;
                                @endphp
                            @else
                                @php
                                    $pos_value_peserta = (int) mb_substr($hasil, 1, 1);
                                    if ($bottleResult->byParameters->mode != 'negatif') {
                                        $pos_value_target = (int) mb_substr($bottleResult->byParameters->mode, 1, 1);
                                    } else {
                                        $pos_value_target = 0;
                                    }
                                    $selisih = abs($pos_value_peserta - $pos_value_target);
                                    $isBad = true;
                                @endphp
                                @if($selisih == 1)
                                    {{ 'Cukup' }}
                                @elseif($selisih == 2)
                                    {{ 'Kurang' }}
                                @else
                                    {{ 'Buruk' }}
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

    @php
        $saran = "";
        if ($meragukanCount == 0 && $kurangMemuaskanCount == 0) {
            $saran = "Pertahankan hasil pemeriksaan saudara.";
            if ($isBad) {
                $saran = "Pertahankan kualitas hasil pemeriksaan Laboratorium Saudara yang Baik dan lakukan investigasi terhadap hasil pemeriksaan yang Cukup / Kurang / Buruk.";
            }
        }

        if ($okCount == 0 && $meragukanCount == 0) {
            $saran = "Tingkatkan hasil pemeriksaan yang Meragukan.";
            if ($isBad) {
                $saran = "Tingkatkan hasil pemeriksaan yang Meragukan. Lakukan investigasi penyebab dan tindakan perbaikan terhadap hasil pemeriksaan yang Kurang Memuaskan / Cukup / Kurang / Buruk.";
            } else if ($isGood) {
                $saran = "Pertahankan kualitas hasil pemeriksaan Laboratorium Saudara yang Baik dan lakukan investigasi terhadap hasil pemeriksaan yang Cukup / Kurang / Buruk.";
            }
        }

        if ($okCount == 0 && $kurangMemuaskanCount == 0) {
            $saran = "Lakukan investigasi penyebab dan tindakan perbaikan terhadap hasil pemeriksaan yang Kurang Memuaskan.";
            if ($isBad) {
                $saran = "Tingkatkan hasil pemeriksaan yang Meragukan. Lakukan investigasi penyebab dan tindakan perbaikan terhadap hasil pemeriksaan yang Kurang Memuaskan / Cukup / Kurang / Buruk.";
            } else if ($isGood) {
                $saran = "Pertahankan kualitas hasil pemeriksaan Laboratorium Saudara yang Baik dan lakukan investigasi terhadap hasil pemeriksaan yang Cukup / Kurang / Buruk.";
            }
        }

        if ($okCount > 0 && $meragukanCount > 0 && $kurangMemuaskanCount === 0) {
            $saran = "Pertahankan hasil pemeriksaan saudara yang Memuaskan dan tingkatkan hasil pemeriksaan yang Meragukan.";
        }

        if ($okCount > 0 && $meragukanCount === 0 && $kurangMemuaskanCount > 0) {
            $saran = "Pertahankan hasil pemeriksaan saudara yang Memuaskan. Lakukan investigasi penyebab dan tindakan perbaikan terhadap hasil pemeriksaan yang Kurang Memuaskan.";
        }

        if ($okCount === 0 && $meragukanCount > 0 && $kurangMemuaskanCount > 0) {
            $saran = "Lakukan investigasi penyebab dan tindakan perbaikan terhadap hasil pemeriksaan yang Meragukan dan Kurang Memuaskan.";
            if ($isBad) {
                $saran = "Tingkatkan hasil pemeriksaan yang Meragukan dan Kurang Memuaskan. Lakukan investigasi penyebab dan tindakan perbaikan terhadap hasil pemeriksaan yang Kurang Memuaskan / Cukup / Kurang / Buruk.";
            } else if ($isGood) {
                $saran = "Pertahankan kualitas hasil pemeriksaan Laboratorium Saudara yang Baik dan lakukan investigasi terhadap hasil pemeriksaan yang Cukup / Kurang / Buruk.";
            }
        }

        if ($okCount > 0 && $meragukanCount > 0 && $kurangMemuaskanCount > 0) {
            $saran = "Pertahankan hasil pemeriksaan saudara yang Memuaskan. Lakukan investigasi penyebab dan tindakan perbaikan terhadap hasil pemeriksaan yang Meragukan dan Kurang Memuaskan.";
        }
    @endphp

    <br/>
    <div class="col-xs-12 form-group">
        <label><b>{{ 'Komentar / Saran' }}</b></label>
        <p>{{ $saran }}</p>
    </div>

</div>

<br/>
<br/>

<div style="page-break-after:always;">
    @component('score.signature', [
        'submit' => $submit
    ])
    @endcomponent
</div>

@endfor
