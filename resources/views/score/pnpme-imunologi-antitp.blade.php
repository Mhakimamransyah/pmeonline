{{--kimia klinik--}}
@php
    $useSelect2 = true;
    $useIcheck = true;
    $parameterName = 'Anti TP';
    $qualifications = \App\PersonQualification::all();
    $reagens = \App\Reagent::where('parameter_id', '=', 43)->get();
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
        'bidang' => 'IMUNOLOGI',
        'parameter' => 'ANTI TP',
    ])
    @endcomponent

    <div class="row">

        <div class="col-xs-12">

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th class="text-center" rowspan="2">{{ 'Panel' }}</th>
                    <th class="text-center" rowspan="2">{{ 'Metode Pemeriksaan' }}</th>
                    <th class="text-center" rowspan="2">{{ 'Nama Reagen' }}</th>
                    <th class="text-center" colspan="2">{{ 'Hasil Pemeriksaan' }}</th>
                    <th class="text-center" colspan="2">{{ 'Hasil Rujukan' }}</th>
                    <th class="text-center" colspan="2">{{ 'Nilai Keterangan Hasil' }}</th>
                </tr>
                <tr>
                    <th class="text-center">{{ 'Hasil' }}</th>
                    <th class="text-center">{{ 'Titer' }}</th>
                    <th class="text-center">{{ 'Hasil' }}</th>
                    <th class="text-center">{{ 'Titer' }}</th>
                    <th class="text-center">{{ 'Nilai' }}</th>
                    <th class="text-center">{{ 'Kategori' }}</th>
                </tr>
                </thead>
                <tbody>
                @for($h = 0; $h < 3; $h++)
                    <tr>
                        <td class="text-center">{{ preg_replace('/[^0-9]/', '', isset($f->{'kode_bahan_kontrol_'.$h}) ? $f->{'kode_bahan_kontrol_'.$h} : '') }}</td>
                        <td class="text-center">
                            @php
                                $metode_pemeriksaan = isset($f->{'metode'}) ? $f->{'metode'} : '';
                            @endphp
                            @if($metode_pemeriksaan == 'rapid')
                                {{ 'Rapid' }}
                            @elseif($metode_pemeriksaan == 'eia_elfa')
                                {{ 'EIA / ELFA' }}
                            @elseif($metode_pemeriksaan == 'algutinasi')
                                {{ 'Aglutinasi' }}
                            @else
                                {{ '-' }}
                            @endif
                        </td>
                        <td class="text-center">{{ $f->nama_reagen or '' }}</td>
                        <td class="text-center">
                            @php
                                $selected_hasil = isset($f->{'hasil_'.$h}) ? $f->{'hasil_'.$h} : '';
                            @endphp
                            @if($selected_hasil == 'reaktif')
                                {{ 'Reaktif' }}
                            @elseif($selected_hasil == 'nonreaktif')
                                {{ 'Non Reaktif' }}
                            @else
                                @php
                                $alternative_hasil = @isset($f->{'hasil_semi_kuantitatif_'.$h}) ? $f->{'hasil_semi_kuantitatif_'.$h} : '-';
                                @endphp
                                @if($alternative_hasil == 'reaktif')
                                    {{ 'Reaktif' }}
                                @elseif($alternative_hasil == 'nonreaktif')
                                    {{ 'Non Reaktif' }}
                                @else
                                    {{ $alternative_hasil }}
                                @endif
                            @endif
                        </td>
                        <td class="text-center">
                            {{ $f->{'semi_kuantitatif_tier_'.$h} or '' }}
                        </td>
                        <td class="text-center">
                            @php
                                $selected_hasil = isset($score->{'rujukan_hasil'}[$h]) ? $score->{'rujukan_hasil'}[$h] : '';
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
                            {{ $score->{'rujukan_titer'}[$h] or '' }}
                        </td>
                        <td class="text-center">
                            @php
                            $score_item = $score->{'score'}[$h] or '-';
                            if($score_item <= 4 && $score_item >= 0) {
                                $sum = (double) $sum + (double) $score_item;
                                $count++;
                            }
                            @endphp
                            @if ($score_item >= 0)
                                {{ $score_item }}
                            @endif
                            @if ($score_item == -1)
                                @php
                                $unfinished = true;
                                @endphp
                                <span style="color: red">{{ 'Belum dinilai.' }}</span>
                            @endif
                            @if ($score_item == -2)
                                {{ '-' }}
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($score_item == 4)
                                {{ 'Baik' }}
                            @endif
                            @if ($score_item < 4 && $score_item >= 0)
                                {{ 'Tidak Baik' }}
                            @endif
                            @if ($score_item == -1)
                                <span style="color: red">{{ 'Belum dinilai.' }}</span>
                            @endif
                            @if ($score_item == -2)
                                {{ '-' }}
                            @endif
                        </td>
                    </tr>
                @endfor
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="7" class="text-center">{{ 'Rata-Rata' }}</th>
                    <th class="text-center">
                        @if(isset($unfinished) || $count == 0)
                            <span style="color: red">{{ 'Belum selesai dinilai.' }}</span>
                        @else
                            @php
                            $average = $sum / $count;
                            $score_text = $average == 4 ? 'Baik' : 'Tidak Baik';
                            @endphp
                            {{ number_format($average, 2) }}
                        @endif
                    </th>
                    <th class="text-center">
                        @if(isset($unfinished) || $count == 0)
                            <span style="color: red">{{ 'Belum selesai dinilai.' }}</span>
                        @else
                            {{ $score_text }}
                        @endif
                    </th>
                </tr>
                </tfoot>
            </table>

        </div>

    </div>

    <div class="row">

        <div class="col-xs-12 form-group">
            <label>{{ 'Komentar' }}</label><br/>
            <p>{!! 'Ketepatan hasil pemeriksaan Anti TP dengan kategori <b>' . $score_text . '</b>.' !!}</p>
            {{ $score->saran or '' }}
        </div>

    </div>

    @component('score.signature')
    @endcomponent

@endsection
