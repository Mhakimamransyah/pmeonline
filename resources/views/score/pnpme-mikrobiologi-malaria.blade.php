{{--kimia klinik--}}
@php
    $useSelect2 = true;
    $useIcheck = true;
    $cycle = \App\Cycle::first();
    $parameter = "Mikrobiologi - Parameter Malaria";
    $malarias = ['Plasmodium falciparum', 'Plasmodium vivax', 'Plasmodium malariae', 'Plasmodium ovale'];
    $stadiums = ['Ring', 'Tropozoit', 'Schizont', 'Gametosit'];
    $qualifications = \App\PersonQualification::all();
    $definedOptions = array();

    $user = Auth::user();
    $contactPerson = $user->contactPerson;
    $orderPackage = \App\OrderPackage::findOrFail($order_package_id);

    $f = $filled_form;

    $sumarize = 0;
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

    @component('score.header-no-margin', [
        'orderPackage' => $orderPackage,
        'bidang' => 'MIKROBIOLOGI',
        'parameter' => 'MIKROSKOPIS MALARIA',
    ])
    @endcomponent

    <div class="row">

        <div class="col-xs-12">

            <table class="table table-bordered">

                <thead>
                <tr>
                    <th class="text-center">{{ 'Kode Sediaan' }}</th>
                    <th class="text-center">{{ 'Hasil Pemeriksaan oleh Laboratorium Peserta' }}</th>
                    <th class="text-center">{{ 'Hasil Pemeriksaan yang Seharusnya' }}</th>
                    <th class="text-center">{{ 'Skor' }}</th>
                </tr>
                </thead>

                <tbody>
                @for ($i = 0; $i < 10; $i++)

                    <tr>

                        <td class="text-center">
                            {{ $f->{'kode_' . $i} or '' }}
                        </td>

                        <td class="text-center">
                            @php
                                $hasil = isset($f->{'hasil_'.$i}) ? $f->{'hasil_'.$i} : '';
                            @endphp
                            @if ($hasil != "")
                                @foreach(explode(',', $hasil) as $item)
                                    {{$item}}<br/>
                                @endforeach
                            @endif
                        </td>

                        <td class="text-center">
                            {{ $score->isi_benar[$i] or '' }}
                        </td>

                        <td class="text-center">
                            @php
                                $score_max = isset($score->total_seharusnya[$i]) ? $score->total_seharusnya[$i] : -1;
                            @endphp
                            @if($score_max < 0)
                                @php
                                $unfinished = true;
                                @endphp
                                <span style="color: red;">Belum selesai dinilai.</span>
                            @else
                                @php
                                $item_score = number_format($score_max, 2);
                                $sumarize = (double) $sumarize + (double) $item_score;
                                @endphp
                                {{ $item_score }}
                            @endif
                        </td>

                    </tr>

                @endfor
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="3" class="text-center">{{ 'Skor Rata-Rata' }}</th>
                    <th class="text-center">
                        @if(isset($unfinished))
                            <span style="color: red;">Belum selesai diperiksa</span>
                        @else
                            @php
                                $rata_rata = $sumarize / 10;
                            @endphp
                            {{ number_format($rata_rata, 2) }}</th>
                        @endif
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
                        $lulus_text = $sumarize / 10 >= 2.5 ? 'Lulus' : 'Tidak Lulus';
                        if (isset($unfinished)) {
                            $lulus_text = '<span style="color: red;">belum selesai diperiksa</span>';
                        }
                    @endphp
                    <td class="text-center">&ge;2,5</td>
                    <td class="text-center">Lulus</td>
                    <td rowspan="2">
                        Hasil PME parameter mikroskopis Malaria laboratorium saudara masuk dalam skor rata-rata dengan kriteria
                        <b>{!! $lulus_text or '<span style="color: red;">belum selesai diperiksa</span>' !!}.</b><br/>
                        {{ $score->saran or '' }}
                    </td>
                </tr>
                <tr>
                    <td class="text-center">&lt;2,5</td>
                    <td class="text-center">Tidak Lulus</td>
                </tr>
                </tbody>
            </table>

        </div>

    </div>

    @component('score.signature')
    @endcomponent

@endsection
