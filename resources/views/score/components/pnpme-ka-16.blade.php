@php
    $parameterName = "KIMIA AIR";
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

    $package = $submit->order->package;
    $parameters = $package->parameters;
    $cycle = $package->cycle;

    $okCount = 0;
    $meragukanCount = 0;
    $kurangMemuaskanCount = 0;
@endphp

<h3 class="text-center"><b>PROGRAM NASIONAL PEMANTAPAN MUTU EKSTERNAL BIDANG KIMIA KESEHATAN<br/>
        HASIL EVALUASI PARAMETER {{ strtoupper($parameterName) }}<br/>
        {{ strtoupper($cycle->name) }}</b>
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
                <th class="text-center">{{ 'No' }}</th>
                <th class="text-center">{{ 'Parameter' }}</th>
                <th class="text-center">{{ 'Hasil Lab Saudara' }}</th>
                <th class="text-center">{{ 'U*' }}</th>
                <th class="text-center">{{ 'Nilai Evaluasi' }}</th>
                <th class="text-center">{{ 'SDPA' }}</th>
                <th class="text-center">{{ 'Z Score' }}</th>
                <th class="text-center">{{ 'Kategori' }}</th>
                <th class="text-center">{{ 'Kesimpulan' }}</th>
            </tr>
            </thead>

            <tbody>
            @php
            $counter = 1;
            @endphp
            @foreach($submit->order->package->parameters as $parameter)
                @php
                    $hasil = $f->{'hasil_pengujian_'.str_replace(' ', '_', $parameter->label)};
                    $method = $f->{'metode_'.str_replace(' ', '_', $parameter->label)} ?? '-';
                    $ketidakpastian = $f->{'ketidakpastian_'.str_replace(' ', '_', $parameter->label)} ?? '-';

                    $collection = \Illuminate\Support\Collection::make($scoreValue);
                    $parameterScore = $collection->first(function ($segment) use ($parameter) { return $segment->parameter->id == $parameter->id; });
                    $bottleResult = \Illuminate\Support\Collection::make($parameterScore->results)->first(function ($result) { return $result->bottleNumber == "1"; });

                    $sdpa = $bottleResult->byParameters->resultByHorwitz;

                    if ($sdpa == 0.0) {
                        $zScore = ($hasil - $bottleResult->byParameters->mean) / $bottleResult->byParameters->standardDeviation;
                    } else {
                        $zScore = ($hasil - $bottleResult->byParameters->mean) / $sdpa;
                    }

                    $_zScore = abs($zScore);

                    if ($_zScore < 2.0 && $hasil != null) {
                        $kategori = "OK";
                        $keterangan = "Memuaskan";
                        $okCount += 1;
                    } else if ($_zScore < 3.0 && $hasil != null) {
                        $kategori = "$";
                        $keterangan = "Meragukan";
                        $meragukanCount += 1;
                    } else if ($hasil != null) {
                        $kategori = "$$";
                        $keterangan = "Kurang Memuaskan";
                        $kurangMemuaskanCount += 1;
                    }
                @endphp
                <tr>
                    @if($hasil != null)
                    <td class="text-center">{{ $counter }}</td>
                    <td class="text-center">{{ $parameter->label }}</td>
                    <td class="text-center">{{ number_format($hasil, 3) }}</td>
                    <td class="text-center">{{ $ketidakpastian }}</td>
                    <td class="text-center">
                        @if(isset($bottleResult->byParameters->mean))
                        {{ number_format($bottleResult->byParameters->mean, 3) }}
                        @else
                        {{ '-' }}
                        @endif
                    </td>
                    <td class="text-center">
                        @if(isset($sdpa))
                        {{ number_format($sdpa, 3) }}
                        @else
                        {{ '-' }}
                        @endif
                    </td>
                    <td class="text-center">
                        @if(isset($zScore))
                        {{ number_format($zScore, 3) }}
                        @else
                        {{ '-' }}
                        @endif
                    </td>
                    <td class="text-center">
                        @if(isset($kategori))
                        {{ $kategori }}
                        @else
                        {{ '-' }}
                        @endif
                    </td>
                    <td class="text-center">
                        @if(isset($keterangan))
                        {{ $keterangan }}
                        @else
                        {{ '-' }}
                        @endif
                    </td>
                    @else
                        <td class="text-center">{{ $counter }}</td>
                        <td class="text-center">{{ $parameter->label }}</td>
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
                $counter = $counter + 1;
                @endphp
            @endforeach
            </tbody>

        </table>

    </div>

</div>

<div class="row">

    @php
        $saran = "";
        if ($meragukanCount == 0 && $kurangMemuaskanCount == 0) {
            $saran = "Pertahankan hasil pemeriksaan saudara.";
        }

        if ($okCount == 0 && $meragukanCount == 0) {
            $saran = "Tingkatkan hasil pemeriksaan yang Meragukan.";
        }

        if ($okCount == 0 && $kurangMemuaskanCount == 0) {
            $saran = "Lakukan investigasi penyebab dan tindakan perbaikan terhadap hasil pemeriksaan yang Kurang Memuaskan.";
        }

        if ($okCount > 0 && $meragukanCount > 0 && $kurangMemuaskanCount === 0) {
            $saran = "Pertahankan hasil pemeriksaan saudara yang Memuaskan dan tingkatkan hasil pemeriksaan yang Meragukan.";
        }

        if ($okCount > 0 && $meragukanCount === 0 && $kurangMemuaskanCount > 0) {
            $saran = "Pertahankan hasil pemeriksaan saudara yang Memuaskan, Lakukan investigasi penyebab dan tindakan perbaikan terhadap hasil pemeriksaan yang Kurang Memuaskan.";
        }

        if ($okCount === 0 && $meragukanCount > 0 && $kurangMemuaskanCount > 0) {
            $saran = "Lakukan investigasi penyebab dan tindakan perbaikan terhadap hasil pemeriksaan yang Meragukan dan Kurang Memuaskan.";
        }

        if ($okCount > 0 && $meragukanCount > 0 && $kurangMemuaskanCount > 0) {
            $saran = "Pertahankan hasil pemeriksaan saudara yang Memuaskan, Lakukan investigasi penyebab dan tindakan perbaikan terhadap hasil pemeriksaan yang Meragukan dan Kurang Memuaskan.";
        }
    @endphp

    <div class="col-xs-12 form-group">
        <br/>
        <b><label>{{ 'Komentar / Saran' }}</label></b>
        <br/>
        {{ $saran }}
    </div>

</div>

<br/>
<br/>

@component('score.signature', [
    'submit' => $submit
])
@endcomponent
