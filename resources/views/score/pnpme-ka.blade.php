@php
    $orderPackage = \App\OrderPackage::findOrFail($order_package_id);

    $score_obj = json_decode($score);

    $oks = [];
    $not_oks = [];
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

    @component('score.header2', [
        'orderPackage' => $orderPackage,
        'bidang' => 'KIMIA AIR',
    ])
    @endcomponent

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
                @foreach($score_obj->result->parameters as $parameter)
                    @php
                    if (isset($parameter->per_semua->kategori)) {
                        if ($parameter->per_semua->kategori == 'OK') {
                            array_push($oks, $parameter->name);
                        } else {
                            array_push($not_oks, $parameter->name);
                        }
                    }
                    @endphp
                    <tr>
                        <td class="text-center">{{ $counter }}</td>
                        <td class="text-center">{{ $parameter->name }}</td>
                        <td class="text-center">{{ $parameter->hasil }}</td>
                        <td class="text-center">{{ $parameter->ketidakpastian }}</td>
                        <td class="text-center">
                            @if(isset($parameter->per_semua->target))
                            {{ number_format($parameter->per_semua->target, 3) }}
                            @else
                            {{ '-' }}
                            @endif
                        </td>
                        <td class="text-center">
                            @if(isset($parameter->per_semua->sdpa))
                            {{ number_format($parameter->per_semua->sdpa, 3) }}
                            @else
                            {{ '-' }}
                            @endif
                        </td>
                        <td class="text-center">
                            @if(isset($parameter->per_semua->z_score))
                            {{ number_format($parameter->per_semua->z_score, 3) }}
                            @else
                            {{ '-' }}
                            @endif
                        </td>
                        <td class="text-center">
                            @if(isset($parameter->per_semua->kategori))
                            {{ $parameter->per_semua->kategori }}
                            @else
                            {{ '-' }}
                            @endif
                        </td>
                        <td class="text-center">
                            @if(isset($parameter->per_semua->keterangan))
                            {{ $parameter->per_semua->keterangan }}
                            @else
                            {{ '-' }}
                            @endif
                        </td>
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

        <div class="col-xs-12 form-group">
            <label>{{ 'Komentar / Saran' }}</label><br/>
            <p id="result_text">
            @if($oks > 0)
            {{ 'Diharapkan saudara mempertahankan hasil pemeriksaan ' }} @foreach($oks as $ok) {{ 'parameter ' . $ok . ', ' }} @endforeach
            @endif
            @if($not_oks > 0)
            {{ 'Perbaiki hasil pemeriksaan ' }} @foreach($not_oks as $not_ok) {{ 'parameter ' . $not_ok . ', ' }} @endforeach {{ ' dengan meneliti kembali cara kerja dan reagen yang digunakan.' }}
            @endif
            </p>
        </div>

    </div>

    @component('score.signature')
    @endcomponent

@endsection
