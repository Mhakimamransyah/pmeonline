@php
    $cycle = \App\Cycle::first();
    $parameter = "Mikrobiologi - Parameter BTA";
    $f = new stdClass();
    if ($filled_form->value != null) {
        $f = json_decode($filled_form->value);
    }

    $qualifications = \App\PersonQualification::all();

    $user = Auth::user();
    $contactPerson = $user->contactPerson;
    $orderPackage = \App\OrderPackage::findOrFail($order_package_id);
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
        'parameter' => 'MIKROSKOPIS BTA',
    ])
    @endcomponent

    <div class="row">

        <div class="col-xs-12">

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th class="text-center">{{ 'Kode Sediaan' }}</th>
                    <th class="text-center">{{ 'Hasil Pemeriksaan oleh Lab. Peserta' }}</th>
                    <th class="text-center">{{ 'Hasil Pemeriksaan yang Seharusnya' }}</th>
                    <th class="text-center">{{ 'Kualifikasi Penilaian' }}</th>
                    <th class="text-center">{{ 'Skor' }}</th>
                </tr>
                </thead>
                <tbody>
                @for ($i = 0; $i < 10; $i++)
                    <tr>
                        <td class="text-center">{{ $f->{'kode_sediaan_' . $i} or '' }}</td>
                        <td class="text-center">
                            @php
                                $hasil = isset($f->{'hasil_'.$i}) ? $f->{'hasil_'.$i} : '';
                            @endphp
                            {{ $hasil }}
                        </td>
                        <td class="text-center">
                            @php
                                $hasil_seharusnya = isset($score->hasil_seharusnya[$i]) ? $score->{'hasil_seharusnya'}[$i] : '';
                            @endphp
                            @if($hasil_seharusnya == 'null')
                                <span style="color: red;">Belum diisi.</span>
                            @else
                            {!! $hasil_seharusnya or '<span style="color: red;">Belum diisi.</span>' !!}
                            @endif
                        </td>
                        <td class="text-center">
                            @php
                                $kualifikasi = isset($score->kualifikasi) ? $score->{'kualifikasi'}[$i] : '';
                            @endphp
                            @if($kualifikasi == 'benar')
                                {{ 'Benar' }}
                            @elseif($kualifikasi == 'kh')
                                {{ 'Kesalahan Hitung' }}
                            @elseif($kualifikasi == 'ppr')
                                {{ 'Positif Palsu Rendah' }}
                            @elseif($kualifikasi == 'npr')
                                {{ 'Negatif Palsu Rendah' }}
                            @elseif($kualifikasi == 'ppt')
                                {{ 'Positif Palsu Tinggi' }}
                            @elseif($kualifikasi == 'npt')
                                {{ 'Negatif Palsu Tinggi' }}
                            @elseif($kualifikasi == 'tm')
                                {{ 'Tidak Menjawab' }}
                            @else
                                <span style="color: red;">Belum diisi.</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @php
                                $kualifikasi = isset($score->kualifikasi) ? $score->{'kualifikasi'}[$i] : '';
                            @endphp
                            @if($kualifikasi == 'benar')
                                {{ '10' }}
                            @elseif($kualifikasi == 'kh')
                                {{ '5' }}
                            @elseif($kualifikasi == 'ppr')
                                {{ '5' }}
                            @elseif($kualifikasi == 'npr')
                                {{ '5' }}
                            @elseif($kualifikasi == 'ppt')
                                {{ '0' }}
                            @elseif($kualifikasi == 'npt')
                                {{ '0' }}
                            @elseif($kualifikasi == 'tm')
                                {{ '0' }}
                            @else
                                <span style="color: red;">Belum diisi.</span>
                            @endif
                        </td>
                    </tr>
                @endfor
                </tbody>
                <tfoot>
                @if(isset($score->kualifikasi) && !in_array('null', $score->kualifikasi))
                    @php
                        $total_score = 0;
                        $failed = false;
                        foreach ($score->kualifikasi as $value) {
                            if($value == 'benar') {
                                $total_score += 10;
                            }
                            if($value == 'kh') {
                                $total_score += 5;
                            }
                            if($value == 'ppr') {
                                $total_score += 5;
                            }
                            if($value == 'npr') {
                                $total_score += 5;
                            }
                            if($value == 'ppt') {
                                $total_score += 0;
                                $failed = true;
                            }
                            if($value == 'npt') {
                                $total_score += 0;
                                $failed = true;
                            }
                            if($value == 'tm') {
                                $total_score += 0;
                            }
                        }
                        $good = $total_score >= 80.0 && !$failed ? true : false;
                        $lulus_text = $good ? 'Lulus' : 'Tidak Lulus';
                    @endphp
                @else
                    @php($unfinished = true)
                @endif
                <tr>
                    <th class="text-center" colspan="4">{{ 'Total' }}</th>
                    <th class="text-center">
                        @if(isset($unfinished))
                            <span style="color: red;">Belum selesai dinilai.</span>
                        @else
                            {{ $total_score }}
                        @endif
                    </th>
                </tr>
                </tfoot>
            </table>

        </div>

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
                    <td class="text-center">&ge;80 dan tanpa NPT / PPT</td>
                    <td class="text-center">Lulus</td>
                    <td rowspan="2">
                        Hasil PME parameter mikroskopis BTA laboratorium saudara masuk dalam kriteria
                        <b>{!! $lulus_text or '<span style="color: red;">belum selesai diperiksa</span>' !!}.</b><br/>
                        {{ $score->saran or '' }}
                    </td>
                </tr>
                <tr>
                    <td class="text-center">&lt;80 atau ada NPT / PPT</td>
                    <td class="text-center">Tidak Lulus</td>
                </tr>
                </tbody>
            </table>

        </div>

    </div>

    @component('score.signature')
    @endcomponent

@endsection
