{{--kimia klinik--}}
@php
    $parameterName = 'Anti HIV';
    $qualifications = \App\PersonQualification::all();
    $reagens = \App\Reagent::where('parameter_id', '=', 43)->get();
    $f = new stdClass();
    if ($filled_form->value != null) {
        $f = json_decode($filled_form->value);
    }

    $user = Auth::user();
    $contactPerson = $user->contactPerson;
    $orderPackage = \App\OrderPackage::findOrFail($order_package_id);

    $sub_scores = [];
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
        'parameter' => 'HIV',
    ])
    @endcomponent

    <div class="row">

        <div class="col-xs-12">

            <table class="table table-bordered">

                <thead>
                <tr>
                    <th rowspan="2" style="vertical-align: middle" class="text-center">Panel</th>
                    <th rowspan="2" style="vertical-align: middle" class="text-center">Tes</th>
                    <th rowspan="2" style="vertical-align: middle" class="text-center">Metode Pemeriksaan</th>
                    <th rowspan="2" style="vertical-align: middle" class="text-center">Nama Reagen</th>
                    <th rowspan="2" style="vertical-align: middle" class="text-center">Hasil Pemeriksaan</th>
                    <th rowspan="2" style="vertical-align: middle" class="text-center">Hasil Rujukan</th>
                    <th rowspan="1" colspan="3" style="vertical-align: middle" class="text-center">Ketepatan Hasil</th>
                    <th rowspan="1" colspan="2" style="vertical-align: middle" class="text-center">Kesesuaian Strategi</th>
                </tr>
                <tr>
                    <th class="text-center">Nilai</th>
                    <th class="text-center">Rata2</th>
                    <th class="text-center">Kategori</th>
                    <th class="text-center">Nilai</th>
                    <th class="text-center">Kategori</th>
                </tr>
                </thead>
                <tbody>
                @for($h = 0; $h < 3; $h++)
                <tr>
                    <td rowspan="3" class="text-center">
                        {{ preg_replace('/[^0-9]/', '', isset($f->{'kode_bahan_kontrol_'.$h}) ? $f->{'kode_bahan_kontrol_'.$h} : '') }}
                    </td>
                    <td class="text-center">{{ 'Tes 1' }}</td>
                    <td class="text-center">
                        @php
                            $metode_pemeriksaan_tes1 = isset($f->metode_pemeriksaan_tes1) ? $f->metode_pemeriksaan_tes1 : '';
                        @endphp
                        @if($metode_pemeriksaan_tes1 == 'baik')
                            {{ 'Rapid' }}
                        @elseif($metode_pemeriksaan_tes1 == 'keruh')
                            {{ 'EIA / ELFA' }}
                        @else
                            {{ '-' }}
                        @endif
                    </td>
                    <td class="text-center">
                        @php
                            $reagen_tes1 = isset($f->reagen_tes1) ? $f->reagen_tes1 : '';
                            $reagen_tes_name1 = $reagens->filter(function ($item) use ($reagen_tes1) {
                                return $item->value == $reagen_tes1;
                            })->first();
                        @endphp
                        {{ $reagen_tes_name1['text'] }}
                    </td>
                    <td class="text-center">
                        @php
                            $selected_hasil = isset($f->{'hasil_panel_'.$h.'_tes_1'}) ? $f->{'hasil_panel_'.$h.'_tes_1'} : '';
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
                            $rujukan = isset($score->{'rujukan'}[$h][0]) ? $score->{'rujukan'}[$h][0] : '';
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
                            $score_h = isset($score->{'hasil'}[$h][0]) ? $score->{'hasil'}[$h][0] : '';
                        @endphp
                        @if($score_h >= 0)
                            {{ $score_h }}
                        @endif
                    </td>
                    <td rowspan="3" class="text-center">
                        @php
                            $value = $score->{'hasil'}[$h];
                            $total_data_per_panel = 0;
                            $total_score_per_panel = 0;
                            foreach ($value as $item) {
                                if ($item >= 0) {
                                    $total_data_per_panel++;
                                    $total_score_per_panel += $item;
                                }
                            }
                            if ($total_data_per_panel != 0) {
                                $score_per_panel = $total_score_per_panel / $total_data_per_panel;
                            } else {
                                $score_per_panel = 0;
                            }
                            array_push($sub_scores, $score_per_panel);
                        @endphp
                        {{ number_format($score_per_panel, 2) }}
                    </td>
                    <td rowspan="3" class="text-center">
                        @if($score_per_panel == 4.0)
                            {{ 'Baik' }}
                        @else
                            {{ 'Tidak Baik' }}
                        @endif
                    </td>
                    <td rowspan="3" class="text-center">
                        @php
                            $score_h = isset($score->{'sesuai'}[$h]) ? $score->{'sesuai'}[$h] : '';
                        @endphp
                        {{ $score_h }}
                    </td>
                    <td rowspan="3" class="text-center">
                        @if($score_h == 5.0)
                            {{ 'Sesuai' }}
                        @else
                            {{ 'Tidak Sesuai' }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="text-center">{{ 'Tes 2' }}</td>
                    <td class="text-center">
                        @php
                            $metode_pemeriksaan_tes2 = isset($f->metode_pemeriksaan_tes2) ? $f->metode_pemeriksaan_tes2 : '';
                        @endphp
                        @if($metode_pemeriksaan_tes2 == 'baik')
                            {{ 'Rapid' }}
                        @elseif($metode_pemeriksaan_tes2 == 'keruh')
                            {{ 'EIA / ELFA' }}
                        @else
                            {{ '-' }}
                        @endif
                    </td>
                    <td class="text-center">
                        @php
                            $reagen_tes2 = isset($f->reagen_tes2) ? $f->reagen_tes2 : '';
                            $reagen_tes_name2 = $reagens->filter(function ($item) use ($reagen_tes2) {
                                return $item->value == $reagen_tes2;
                            })->first();
                        @endphp
                        {{ $reagen_tes_name2['text'] }}
                    </td>
                    <td class="text-center">
                        @php
                            $selected_hasil = isset($f->{'hasil_panel_'.$h.'_tes_2'}) ? $f->{'hasil_panel_'.$h.'_tes_2'} : '';
                        @endphp
                        @if($selected_hasil == 'reaktif')
                            {{ 'Reaktif' }}
                        @elseif($selected_hasil == 'nonreaktif')
                            {{ 'Nonreaktif' }}
                        @else
                            {{ '-' }}
                        @endif
                    </td>
                    <td class="text-center">
                        @php
                            $rujukan = isset($score->{'rujukan'}[$h][1]) ? $score->{'rujukan'}[$h][1] : '';
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
                            $score_h = isset($score->{'hasil'}[$h][1]) ? $score->{'hasil'}[$h][1] : '';
                        @endphp
                        @if($score_h >= 0)
                            {{ $score_h }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="text-center">{{ 'Tes 3' }}</td>
                    <td class="text-center">
                        @php
                            $metode_pemeriksaan_tes3 = isset($f->metode_pemeriksaan_tes3) ? $f->metode_pemeriksaan_tes3 : '';
                        @endphp
                        @if($metode_pemeriksaan_tes3 == 'baik')
                            {{ 'Rapid' }}
                        @elseif($metode_pemeriksaan_tes3 == 'keruh')
                            {{ 'EIA / ELFA' }}
                        @else
                            {{ '-' }}
                        @endif
                    </td>
                    <td class="text-center">
                        @php
                            $reagen_tes3 = isset($f->reagen_tes3) ? $f->reagen_tes3 : '';
                            $reagen_tes_name3 = $reagens->filter(function ($item) use ($reagen_tes3) {
                                return $item->value == $reagen_tes3;
                            })->first();
                        @endphp
                        {{ $reagen_tes_name3['text'] or '' }}
                    </td>
                    <td class="text-center">
                        @php
                            $selected_hasil = isset($f->{'hasil_panel_'.$h.'_tes_3'}) ? $f->{'hasil_panel_'.$h.'_tes_3'} : '';
                        @endphp
                        @if($selected_hasil == 'reaktif')
                            {{ 'Reaktif' }}
                        @elseif($selected_hasil == 'nonreaktif')
                            {{ 'Nonreaktif' }}
                        @else
                            {{ '-' }}
                        @endif
                    </td>
                    <td class="text-center">
                        @php
                            $rujukan = isset($score->{'rujukan'}[$h][2]) ? $score->{'rujukan'}[$h][2] : '';
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
                            $score_h = isset($score->{'hasil'}[$h][2]) ? $score->{'hasil'}[$h][2] : '';
                        @endphp
                        @if($score_h >= 0)
                            {{ $score_h }}
                        @endif
                    </td>
                </tr>
                @endfor
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="7" class="text-center">{{ 'Rata-Rata' }}</th>
                    <th class="text-center">
                        @php
                            $total_score = 0;
                            $item_count = 0;
                            foreach ($sub_scores as $sub_score) {
                                $total_score += $sub_score;
                                $item_count++;
                            }
                            $final_score = 0;
                            if ($item_count > 0) {
                                $final_score = $total_score / $item_count;
                            }
                        @endphp
                        {{ number_format($final_score, 2) }}
                    </th>
                    <th class="text-center">
                        @php
                            if($final_score == 4.0)
                                $ketepatan_text = 'Baik';
                            else
                                $ketepatan_text = 'Tidak Baik';
                        @endphp
                        {{ $ketepatan_text }}
                    </th>
                    <th class="text-center">
                        @php
                            $total_score = 0;
                            $item_count = 0;
                            foreach ($score->sesuai as $item) {
                                $total_score += $item;
                                $item_count++;
                            }
                            $final_score = 0;
                            if ($item_count > 0) {
                                $final_score = $total_score / $item_count;
                            }
                        @endphp
                        {{ number_format($final_score, 0) }}
                    </th>
                    <th class="text-center">
                        @php
                            if($final_score == 5.0)
                                $kesesuaian_text = 'Sesuai';
                            else
                                $kesesuaian_text = 'Tidak Sesuai';
                        @endphp
                        {{ $kesesuaian_text }}
                    </th>
                </tr>
                </tfoot>
            </table>

        </div>

    </div>

    <div class="row">

        <div class="col-xs-12 form-group">
            <label>{{ 'Komentar' }}</label><br/>
            <p>{!! 'Kategori ketepatan hasil parameter HIV, <b>' . $ketepatan_text . '</b>. Kategori kesesuaian strategi,
            <b>' . $kesesuaian_text . '</b>.' !!}</p>
            {{ $score->saran or '' }}
        </div>

    </div>

    @component('score.signature')
    @endcomponent

@endsection
