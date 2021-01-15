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
                                $kualitas_bahan = isset($submit->computed_value->{'kualtias_bahan_'.$i}) ? $submit->computed_value->{'kualtias_bahan_'.$i} : '';
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
                    <th width="20%">{{ 'Metode Pemeriksaan' }}</th>
                    <th width="20%">{{ 'Nama Reagen' }}</th>
                    <th width="20%">{{ 'Nama Produsen' }}</th>
                    <th width="20%">{{ 'Nama Lot / Batch' }}</th>
                    <th width="20%">{{ 'Tanggal Kadaluarsa' }}</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        @php
                            $metode_pemeriksaan = isset($submit->computed_value->{'metode'}) ? $submit->computed_value->{'metode'} : '';
                        @endphp
                        @if($metode_pemeriksaan == 'rapid')
                            {{ 'Rapid' }}
                        @elseif($metode_pemeriksaan == 'eia_elfa')
                            {{ 'EIA' }}
                        @elseif($metode_pemeriksaan == 'algutinasi')
                            {{ 'Aglutinasi' }}
                        @else
                            {{ $metode_pemeriksaan }}
                        @endif
                    </td>
                    <td>
                        {{ $submit->computed_value->nama_reagen ?? '' }}
                    </td>
                    <td>
                        {{ $submit->computed_value->nama_produsen_reagen ?? '' }}
                    </td>
                    <td>
                        {{ $submit->computed_value->lot_reagen ?? '' }}
                    </td>
                    <td>
                        {{ $submit->computed_value->tanggal_kadaluarsa ?? '' }}
                    </td>
                </tr>
                </tbody>
            </table>

        </div>

    </div>

    <hr/>

    <div class="row">

        <div class="col-xs-12">

            <h3 style="font-size: 14px;"><b>{{ 'Semi Kuantitatif' }}</b></h3>

            @for($h = 0; $h < 3; $h++)

                <div class="col-md-12"><hr/></div>

                <div class="col-md-1">
                    <div class="form-group has-feedback">
                        <strong>{{ 'Panel ' . ($h + 1) }}</strong> : {{ $submit->computed_value->{'kode_bahan_kontrol_'.$h} ?? '' }}<br/>
                    </div>
                </div>

                <div class="col-md-11">

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th width="23%" class="text-center">{{ 'Interpretasi Hasil' }}</th>
                            <th width="23%" class="text-center">{{ 'Titer' }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                @php
                                    $selected_hasil = isset($submit->computed_value->{'hasil_semi_kuantitatif_'.$h}) ? $submit->computed_value->{'hasil_semi_kuantitatif_'.$h} : '';
                                @endphp
                                @if($selected_hasil == 'reaktif')
                                    {{ 'Reaktif' }}
                                @elseif($selected_hasil == 'nonreaktif')
                                    {{ 'Nonreaktif' }}
                                @else
                                    {{ '-' }}
                                @endif
                            </td>
                            <td>
                                {{ $submit->computed_value->{'titer_'.$h} ?? '' }}
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>

            @endfor

        </div>

    </div>

    <hr/>

    <div class="row">

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
