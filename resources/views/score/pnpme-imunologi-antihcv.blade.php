@php
    $parameterName = 'Anti HCV';
    $qualifications = \App\PersonQualification::all();
    $f = new stdClass();
    if ($filled_form->value != null) {
        $f = json_decode($filled_form->value);
    }
    $reagens = \App\Reagent::where('parameter_id', '=', 43)->get();

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
        'bidang' => 'IMUNOLOGI',
        'parameter' => 'ANTI HCV',
    ])
    @endcomponent

    <div class="row">

        <div class="col-xs-12">

            <table class="table table-bordered">

                <thead>
                <tr>
                    <th rowspan="2" class="text-center">{{ 'Panel' }}</th>
                    <th rowspan="2" class="text-center">{{ 'Metode Pemeriksaan' }}</th>
                    <th rowspan="2" class="text-center">{{ 'Reagen' }}</th>
                    <th rowspan="2" class="text-center">{{ 'Hasil Pemeriksaan' }}</th>
                    <th rowspan="2" class="text-center">{{ 'Hasil Rujukan' }}</th>
                    <th colspan="2" class="text-center">{{ 'Ketepatan Hasil' }}</th>
                </tr>
                <tr>
                    <th class="text-center">{{ 'Nilai' }}</th>
                    <th class="text-center">{{ 'Kategori' }}</th>
                </tr>
                </thead>

                <tbody>
                @for($h = 0; $h < 3; $h++)
                    <tr>
                        <td class="text-center">
                            {{ preg_replace('/[^0-9]/', '', isset($f->{'kode_bahan_kontrol_'.$h}) ? $f->{'kode_bahan_kontrol_'.$h} : '') }}
                        </td>
                        <td class="text-center">
                            @php
                                $metode_pemeriksaan = isset($f->{'metode_pemeriksaan'}) ? $f->{'metode_pemeriksaan'} : '';
                            @endphp
                            @if($metode_pemeriksaan == 'rapid')
                                {{ 'Rapid' }}
                            @elseif($metode_pemeriksaan == 'eia')
                                {{ 'EIA / ELFA' }}
                            @else
                                {{ '-' }}
                            @endif
                        </td>
                        <td class="text-center">
                            {{ $f->nama_reagen or '' }}
                        </td>
                        <td class="text-center">
                            @php
                                $selected_hasil = isset($f->{'hasil_'.$h}) ? $f->{'hasil_'.$h} : '';
                            @endphp
                            @if($selected_hasil == 'reaktif')
                                {{ 'Reaktif' }}
                            @elseif($selected_hasil == 'nonreaktif')
                                {{ 'Non Reaktif' }}
                            @else
                                {{ '-' }}
                            @endif
                        </td>
                        <td class="text-center">
                            @php
                                $rujukan = isset($score->{'rujukan'}[$h]) ? $score->{'rujukan'}[$h] : '';
                            @endphp
                            @if($rujukan == 'reaktif')
                                {{ 'Reaktif' }}
                            @elseif($rujukan == 'nonreaktif')
                                {{ 'Non Reaktif' }}
                            @else
                                {{ '-' }}
                            @endif
                        </td>
                        <td class="text-center">
                            @php
                                $score_h = isset($score->{'hasil'}[$h]) ? $score->{'hasil'}[$h] : '';
                            @endphp
                            @if($score_h >= 0)
                                {{ $score_h }}
                            @elseif($score_h == -1)
                                <span style="color: red">{{ 'Belum dinilai' }}</span>
                            @elseif($score_h == -2)
                                {{ '-' }}
                            @endif
                        </td>
                        <td class="text-center">
                            @if($score_h == 4)
                                {{ 'Baik' }}
                            @elseif($score_h == -1)
                                <span style="color: red">{{ 'Belum dinilai' }}</span>
                            @elseif($score_h == -2)
                                {{ '-' }}
                            @else
                                {{ 'Tidak Baik' }}
                            @endif
                        </td>
                    </tr>
                @endfor
                </tbody>
                <tfoot>
                <tr>
                    <th class="text-center" colspan="5">{{ 'Rata-Rata' }}</th>
                    <th class="text-center">
                        @if(isset($score->hasil) && !in_array('-1', $score->hasil))
                            @php
                                $total_data = 0;
                                $total_score = 0;
                                foreach ($score->hasil as $value) {
                                    if($value >= 0) {
                                        $total_score += $value;
                                        $total_data++;
                                    }
                                }
                                $average = $total_score / $total_data;
                                $good = $average == 4.0 ? true : false;
                            @endphp
                            {{ number_format($average, 2) }}
                        @else
                            <span style="color: red">{{ 'Belum selesai dinilai.' }}</span>
                        @endif
                    </th>
                    <th class="text-center">
                        @php
                            if(isset($score->hasil) && !in_array('-1', $score->hasil))
                                $score_text = $good ? 'Baik' : 'Tidak Baik';
                            else
                                $score_text = '<span style="color: red">Belum selesai dinilai.</span>';
                        @endphp
                        {!! $score_text !!}
                    </th>
                </tr>
                </tfoot>

            </table>

        </div>

    </div>

    <div class="row">

        <div class="col-xs-12 form-group">
            <label>{{ 'Komentar' }}</label><br/>
            <p>{!! 'Ketepatan hasil pemeriksaan Anti HCV dengan kategori <b>' . $score_text . '</b>.' !!}</p>
            {{ $score->saran or '' }}
        </div>

    </div>

    @component('score.signature')
    @endcomponent

@endsection
