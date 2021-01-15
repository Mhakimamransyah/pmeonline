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
            Bidang Imunologi - Parameter {{ $submit->order->package->label }}<br/>
            Tahun 2019 Siklus 1</b>
    </h3>

    <br/>

    <div class="row">
        <div class="col-xs-6">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td width="40%">Kode Peserta</td>
                    <th class="text-right">{{ $submit->order->id }}</th>
                </tr>
                <tr>
                    <td>Instansi</td>
                    <th class="text-right">{{ $submit->order->invoice->laboratory->name }}</th>
                </tr>
                <tr>
                    <td>Personil Penghubung</td>
                    <th class="text-right">{{ $submit->order->invoice->laboratory->user->name }}</th>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="col-xs-6">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td>Tanggal Penerimaan</td>
                    <th class="text-right">{{ $submit->computed_value->{ 'tanggal_penerimaan' } ?? '' }}</th>
                </tr>
                <tr>
                    <td>Tanggal Pemeriksaan</td>
                    <th class="text-right">{{ $submit->computed_value->{ 'tanggal_pemeriksaan' } ?? '' }}</th>
                </tr>
                <tr>
                    <td>Kualifikasi Pemeriksa</td>
                    <th class="text-right">{{ $submit->computed_value->{'kualifikasi_pemeriksa'} }}</th>
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
                            {{ $submit->computed_value->{'kode_panel_'.$i} ?? '' }}
                        </th>
                        <td>
                            @php
                                $kualitas_bahan = isset($submit->computed_value->{'kualitas_bahan_'.$i}) ? $submit->computed_value->{'kualitas_bahan_'.$i} : '';
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
                            {{ $submit->computed_value->{'deskripsi_kualitas_bahan_'.$i} ?? '' }}
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
                            $metode_pemeriksaan_tes1 = isset($submit->computed_value->metode_pemeriksaan_tes1) ? $submit->computed_value->metode_pemeriksaan_tes1 : '';
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
                            $metode_pemeriksaan_tes2 = isset($submit->computed_value->metode_pemeriksaan_tes2) ? $submit->computed_value->metode_pemeriksaan_tes2 : '';
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
                            $metode_pemeriksaan_tes3 = isset($submit->computed_value->metode_pemeriksaan_tes3) ? $submit->computed_value->metode_pemeriksaan_tes3 : '';
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
                            $reagen_tes1 = isset($submit->computed_value->reagen_tes1) ? $submit->computed_value->reagen_tes1 : '';
                        @endphp
                        {{ $reagen_tes1 }}
                    </td>
                    <td>
                        @php
                            $reagen_tes2 = isset($submit->computed_value->reagen_tes2) ? $submit->computed_value->reagen_tes2 : '';
                        @endphp
                        {{ $reagen_tes2 }}
                    </td>
                    <td>
                        @php
                            $reagen_tes3 = isset($submit->computed_value->reagen_tes3) ? $submit->computed_value->reagen_tes3 : '';
                        @endphp
                        {{ $reagen_tes3 }}
                    </td>
                </tr>
                <tr>
                    <th style="vertical-align: middle">
                        {{ 'Nomor Lot/Batch' }}
                    </th>
                    <td>
                        {{ $submit->computed_value->batch_tes1 ?? '' }}
                    </td>
                    <td>
                        {{ $submit->computed_value->batch_tes2 ?? '' }}
                    </td>
                    <td>
                        {{ $submit->computed_value->batch_tes3 ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th style="vertical-align: middle">
                        {{ 'Tanggal Kadaluarsa' }}
                    </th>
                    <td>
                        {{ $submit->computed_value->tanggal_kadaluarsa_tes1 ?? '' }}
                    </td>
                    <td>
                        {{ $submit->computed_value->tanggal_kadaluarsa_tes2 ?? '' }}
                    </td>
                    <td>
                        {{ $submit->computed_value->tanggal_kadaluarsa_tes3 ?? '' }}
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
                    <strong>{{ 'Panel ' . ($h + 1) }}</strong> : {{ $submit->computed_value->{'kode_bahan_kontrol_'.$h} ?? '' }}<br/>
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
                                    {{ $submit->computed_value->{'abs_panel_'.$h.'_tes_'.$j} ?? '' }}
                                </td>
                                <td>
                                    {{ $submit->computed_value->{'cut_panel_'.$h.'_tes_'.$j} ?? '' }}
                                </td>
                                <td>
                                    {{ $submit->computed_value->{'sco_panel_'.$h.'_tes_'.$j} ?? '' }}
                                </td>
                                <td>
                                    @php
                                        $selected_hasil = isset($submit->computed_value->{'hasil_panel_'.$h.'_tes_'.$j}) ? $submit->computed_value->{'hasil_panel_'.$h.'_tes_'.$j} : '';
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
            {{ $submit->computed_value->keterangan ?? '' }}<br/><br/>
        </div>

        <div class="col-xs-12">
            <label>{{ 'Saran' }}</label><br/>
            {{ $submit->computed_value->saran ?? '' }}<br/><br/>
        </div>

        <div class="col-xs-12">
            <label>{{ 'Nama Pemeriksa' }}</label><br/>
            {{ $submit->computed_value->nama_pemeriksa ?? '' }}<br/><br/>
        </div>

    </div>

    <hr/>

    <p>{{ date('Y/m/d H:i:s') }}</p>

    <p class="text-right"><i>{{ 'Menghemat kertas menyelamatkan pohon.' }}</i></p>

@endsection
