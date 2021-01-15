{{--kimia klinik--}}
@php
    $useSelect2 = true;
    $useIcheck = true;
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
@endphp

@extends('layouts.preview')

@section('style-override')
    <style>
        body {
            background-color: white;
            font-size: 11px;
        }
    </style>
@endsection

@section('content')

    <h3 class="text-center" style="font-size: 14px"><b>Program Nasional Pemantapan Mutu Eksternal<br/>
            Bidang Imunologi - Parameter {{ $parameterName }}<br/>
            Tahun 2019 Siklus 1</b>
    </h3>

    <br/>

    <div class="row">
        <div class="col-xs-6">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td width="40%">Kode Peserta</td>
                    <th class="text-right">{{ $orderPackage->order->participant->number }}</th>
                </tr>
                <tr>
                    <td>Instansi</td>
                    <th class="text-right">{{ $orderPackage->laboratoryName() }}</th>
                </tr>
                <tr>
                    <td>Personil Penghubung</td>
                    <th class="text-right">{{ Auth::user()->name }}</th>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="col-xs-6">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td>Tanggal Penerimaan</td>
                    <th class="text-right">{{ $f->{ 'tanggal_penerimaan' } or '' }}</th>
                </tr>
                <tr>
                    <td>Tanggal Pemeriksaan</td>
                    <th class="text-right">{{ $f->{ 'tanggal_pemeriksaan' } or '' }}</th>
                </tr>
                <tr>
                    <td>Kualifikasi Pemeriksa</td>
                    @php
                        $qualificationId = $f->{ 'kualifikasi_pemeriksa' };
                        $qualification = $qualifications->filter(function ($item) use ($qualificationId) {
                            return $item->id == $qualificationId;
                        })->first();
                    @endphp
                    <th class="text-right">{{ $qualificationId }} - {{ $qualification['name'] }}</th>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">

        <div class="col-xs-12">

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th width="5%">{{ 'Panel' }}</th>
                    <th width="15%">{{ 'Kualitas Bahan' }}</th>
                    <th width="60%">{{ 'Deskripsi Kualitas Bahan' }}</th>
                </tr>
                @for($i = 0; $i < 3; $i++)
                    <tr>
                        <th>
                            {{ $f->{'kode_panel_'.$i} or '' }}
                        </th>
                        <td>
                            @php
                                $kualitas_bahan = isset($f->{'kualitas_bahan_'.$i}) ? $f->{'kualitas_bahan_'.$i} : '';
                            @endphp
                            @if($kualitas_bahan == 'baik')
                                {{ 'Baik' }}
                            @elseif($kualitas_bahan == 'keruh')
                                {{ 'Keruh' }}
                            @elseif($kualitas_bahan == 'lain-lain')
                                {{ 'Lain-Lain' }}
                            @else
                                {{ '-' }}
                            @endif
                        </td>
                        <td>
                            {{ $f->{'deskripsi_kualitas_bahan_'.$i} or '' }}
                        </td>
                    </tr>
                @endfor
                </thead>
            </table>

        </div>

    </div>

    <div class="row">

        <div class="col-xs-12">

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th width="25%">{{ 'Keterangan' }}</th>
                    <th width="25%">{{ 'Tes I' }}</th>
                    <th width="25%">{{ 'Tes II' }}</th>
                    <th width="25%">{{ 'Tes III' }}</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th style="vertical-align: middle">
                        {{ 'Metode Pemeriksaan' }}
                    </th>
                    <td>
                        @php
                            $metode_pemeriksaan_tes1 = isset($f->metode_pemeriksaan_tes1) ? $f->metode_pemeriksaan_tes1 : '';
                        @endphp
                        @if($metode_pemeriksaan_tes1 == 'rapid')
                            {{ 'Rapid' }}
                        @elseif($metode_pemeriksaan_tes1 == 'eia')
                            {{ 'EIA' }}
                        @else
                            {{ '-' }}
                        @endif
                    </td>
                    <td>
                        @php
                            $metode_pemeriksaan_tes2 = isset($f->metode_pemeriksaan_tes2) ? $f->metode_pemeriksaan_tes2 : '';
                        @endphp
                        @if($metode_pemeriksaan_tes2 == 'rapid')
                            {{ 'Rapid' }}
                        @elseif($metode_pemeriksaan_tes2 == 'eia')
                            {{ 'EIA' }}
                        @else
                            {{ '-' }}
                        @endif
                    </td>
                    <td>
                        @php
                            $metode_pemeriksaan_tes3 = isset($f->metode_pemeriksaan_tes3) ? $f->metode_pemeriksaan_tes3 : '';
                        @endphp
                        @if($metode_pemeriksaan_tes3 == 'rapid')
                            {{ 'Rapid' }}
                        @elseif($metode_pemeriksaan_tes3 == 'eia')
                            {{ 'EIA' }}
                        @else
                            {{ '-' }}
                        @endif
                    </td>

                </tr>
                <tr>
                    <th style="vertical-align: middle">
                        {{ 'Nama Reagen' }}
                    </th>
                    <td>
                        @php
                            $reagen_tes1 = isset($f->reagen_tes1) ? $f->reagen_tes1 : '';
                            $reagen_tes_name1 = $reagens->filter(function ($item) use ($reagen_tes1) {
                                return $item->value == $reagen_tes1;
                            })->first();
                        @endphp
                        {{ $reagen_tes1 }} - {{ $reagen_tes_name1['text'] }}
                    </td>
                    <td>
                        @php
                            $reagen_tes2 = isset($f->reagen_tes2) ? $f->reagen_tes2 : '';
                            $reagen_tes_name2 = $reagens->filter(function ($item) use ($reagen_tes2) {
                                return $item->value == $reagen_tes2;
                            })->first();
                        @endphp
                        {{ $reagen_tes2 }} - {{ $reagen_tes_name2['text'] }}
                    </td>
                    <td>
                        @php
                            $reagen_tes3 = isset($f->reagen_tes3) ? $f->reagen_tes3 : '';
                            $reagen_tes_name3 = $reagens->filter(function ($item) use ($reagen_tes3) {
                                return $item->value == $reagen_tes3;
                            })->first();
                        @endphp
                        {{ $reagen_tes3 }} - {{ $reagen_tes_name3['text'] or '' }}
                    </td>
                </tr>
                <tr>
                    <th style="vertical-align: middle">
                        {{ 'Nomor Lot/Batch' }}
                    </th>
                    <td>
                        {{ $f->batch_tes1 or '' }}
                    </td>
                    <td>
                        {{ $f->batch_tes2 or '' }}
                    </td>
                    <td>
                        {{ $f->batch_tes3 or '' }}
                    </td>
                </tr>
                <tr>
                    <th style="vertical-align: middle">
                        {{ 'Tanggal Kadaluarsa' }}
                    </th>
                    <td>
                        {{ $f->tanggal_kadaluarsa_tes1 or '' }}
                    </td>
                    <td>
                        {{ $f->tanggal_kadaluarsa_tes2 or '' }}
                    </td>
                    <td>
                        {{ $f->tanggal_kadaluarsa_tes3 or '' }}
                    </td>
                </tr>
                </tbody>
            </table>

        </div>

    </div>

    <div class="row">

        <div class="col-xs-12">

            @for($h = 0; $h < 3; $h++)

                <div class="col-md-12"><hr/></div>

                <div class="col-md-1">
                    <strong>{{ 'Panel ' . ($h + 1) }}</strong> : {{ $f->{'kode_bahan_kontrol_'.$h} or '' }}<br/>
                </div>

                <div class="col-md-11">

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th width="15%" class="text-center">{{ 'Tes' }}</th>
                            <th width="23%" class="text-center">{{ 'Abs atau OD (A) (Bila dengan EIA)' }}</th>
                            <th width="23%" class="text-center">{{ 'Cut off (B) (Bila dengan EIA)' }}</th>
                            <th width="23%" class="text-center">{{ 'S/CO (A:B) atau true value (TV) atau Indek (Bila dengan EIA)' }}</th>
                            <th width="16%" class="text-center">{{ 'Interpretasi Hasil' }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @for($i = 0; $i < 3; $i++)
                            <tr>
                                <td class="text-center">
                                    <strong>Tes @for($j = 0; $j < $i + 1; $j++){{ 'I' }}@endfor </strong>
                                </td>

                                {{--Tes = j, Panel = h--}}

                                <td>
                                    {{ $f->{'abs_panel_'.$h.'_tes_'.$j} or '' }}
                                </td>
                                <td>
                                    {{ $f->{'cut_panel_'.$h.'_tes_'.$j} or '' }}
                                </td>
                                <td>
                                    {{ $f->{'sco_panel_'.$h.'_tes_'.$j} or '' }}
                                </td>
                                <td>
                                    @php
                                        $selected_hasil = isset($f->{'hasil_panel_'.$h.'_tes_'.$j}) ? $f->{'hasil_panel_'.$h.'_tes_'.$j} : '';
                                    @endphp
                                    @if($selected_hasil == 'reaktif')
                                        {{ 'Reaktif' }}
                                    @elseif($selected_hasil == 'nonreaktif')
                                        {{ 'Nonreaktif' }}
                                    @else
                                        {{ '-' }}
                                    @endif
                                </td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>

                </div>

            @endfor

        </div>

    </div>

    <hr/>

    <div class="row">

        <div class="col-xs-12">
            <label>{{ 'Keterangan' }}</label><br/>
            {{ $f->keterangan or '' }}<br/><br/>
        </div>

        <div class="col-xs-12">
            <label>{{ 'Saran' }}</label><br/>
            {{ $f->saran or '' }}<br/><br/>
        </div>

        <div class="col-xs-12">
            <label>{{ 'Nama Pemeriksa' }}</label><br/>
            {{ $f->nama_pemeriksa or '' }}<br/><br/>
        </div>

    </div>

    <hr/>

    <p>{{ date('Y/m/d H:i:s') }}</p>

    <p class="text-right"><i>{{ 'Menghemat kertas menyelamatkan pohon.' }}</i></p>

@endsection
