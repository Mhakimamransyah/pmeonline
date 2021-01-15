@php
    $cycle = \App\Cycle::first();
    $parameter = "Mikrobiologi - Parameter Telur Cacing";
    $cacings = [''];
    // $cacings = ['negatif', 'Telur cacing Ascaris lumbricoides (+)', 'Telur cacing Trichuris trichiura (+)', 'Telur cacing Tambang (+)'];
    $qualifications = \App\PersonQualification::all();
    $f = new stdClass();
    if ($filled_form->value != null) {
        $f = json_decode($filled_form->value);
    }

    $user = Auth::user();
    $contactPerson = $user->contactPerson;
    $orderPackage = \App\OrderPackage::findOrFail($order_package_id);

    $sum = 0;
    $count = 0;
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

    @component('score.header', [
        'orderPackage' => $orderPackage,
        'bidang' => 'MIKROBIOLOGI',
        'parameter' => 'MIKROSKOPIS PARASIT SALURAN PENCERNAAN',
    ])
    @endcomponent

    <div class="row">

        <div class="col-xs-12">

            <table class="table table-bordered">

                <thead>
                <tr>
                    <th class="text-center">{{ 'Kode Sample' }}</th>
                    <th class="text-center">{{ 'Hasil Pemeriksaan oleh Lab. Peserta' }}</th>
                    <th class="text-center">{{ 'Hasil Pemeriksaan Seharusnya' }}</th>
                    <th class="text-center">{{ 'Skor' }}</th>
                </tr>
                </thead>
                <tbody>
                @for ($i = 0; $i < 3; $i++)
                    <tr>
                    <td class="text-center">
                        {{ $f->{'kode_sediaan_' . $i} or '' }}
                    </td>

                    <td class="text-center">
                        @php
                            $hasil = isset($f->{'hasil_'.$i}) ? $f->{'hasil_'.$i} : '';
                        @endphp
                        @if ($hasil != "")
                            @foreach($hasil as $item)
                                {{$item}}<br/>
                            @endforeach
                        @endif
                    </td>

                    <td class="text-center">
                        {{ $score->isi_benar[$i] or '' }}
                    </td>

                    <td class="text-center">
                        @php
                            $score_h = isset($score->{'score'}[$i]) ? $score->{'score'}[$i] : '';
                            $score_max = isset($score->{'score_max'}[$i]) ? $score->{'score_max'}[$i] : '';
                        @endphp
                        @if($score_max == 0)
                            {{ '-' }}
                        @else
                            @php
                            $score_item = (double) $score_h / (double) $score_max * 10;
                            $sum = (double) $sum + (double) $score_item;
                            $count += 1;
                            @endphp
                            {{ number_format($score_item, 2) }}
                        @endif
                    </td>
                    </tr>
                @endfor
                </tbody>
                <tfoot>
                <tr>
                    <th class="text-center" colspan="3">{{ 'Skor Rata-Rata' }}</th>
                    @php
                    $average = 0;
                    if ($count > 0) {
                        $average = $sum / $count;
                    }
                    @endphp
                    <th class="text-center">{{ number_format($average, 2) }}</th>
                </tr>
                </tfoot>

            </table>

        </div>

    </div>

    <div class="row">

        <div class="col-xs-12">

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th class="text-center">{{ 'Total Skor' }}</th>
                    <th class="text-center">{{ 'Kriteria' }}</th>
                    <th class="text-center" width="60%">{{ 'Komentar atau Saran' }}</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    @php
                        $lulus_text = $average >= 6 ? 'Lulus' : 'Tidak Lulus';
                        if (isset($unfinished)) {
                            $lulus_text = '<span style="color: red;">belum selesai diperiksa</span>';
                        }
                    @endphp
                    <td class="text-center">&ge;6</td>
                    <td class="text-center">Lulus</td>
                    <td rowspan="2">
                        Hasil PME parameter mikroskopis parasit saluran pencernaan laboratorium saudara masuk dalam skor rata-rata dengan kriteria
                        <b>{!! $lulus_text or '<span style="color: red;">belum selesai diperiksa</span>' !!}.</b><br/>
                        {{ $score->saran or '' }}
                    </td>
                </tr>
                <tr>
                    <td class="text-center">&lt;6</td>
                    <td class="text-center">Tidak Lulus</td>
                </tr>
                </tbody>
            </table>

        </div>

    </div>

    @component('score.signature')
    @endcomponent

@endsection
