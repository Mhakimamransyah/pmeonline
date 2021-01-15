@php
    $useSelect2 = true;
    $useIcheck = true;
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
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
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
                            $metode_pemeriksaan = isset($f->{'metode_pemeriksaan'}) ? $f->{'metode_pemeriksaan'} : '';
                        @endphp
                        @if($metode_pemeriksaan == 'rapid')
                            {{ 'Rapid' }}
                        @elseif($metode_pemeriksaan == 'eia-elfa')
                            {{ 'EIA' }}
                        @else
                            {{ '-' }}
                        @endif
                    </td>
                    <td>
                        {{ $f->nama_reagen or '' }}
                    </td>
                    <td>
                        {{ $f->nama_produsen or '' }}
                    </td>
                    <td>
                        {{ $f->nama_lot_atau_batch or '' }}
                    </td>
                    <td>
                        {{ $f->tanggal_kadaluarsa or '' }}
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
                    <div class="form-group has-feedback">
                        <strong>{{ 'Panel ' . ($h + 1) }}</strong> : {{ $f->{'kode_bahan_kontrol_'.$h} or '' }}<br/>
                    </div>
                </div>

                <div class="col-md-11">

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th width="23%" class="text-center">{{ 'Abs atau OD (A) (Bila dengan EIA)' }}</th>
                            <th width="23%" class="text-center">{{ 'Cut off (B) (Bila dengan EIA)' }}</th>
                            <th width="23%" class="text-center">{{ 'S/CO (A:B) atau true value (TV) atau Indek (Bila dengan EIA)' }}</th>
                            <th width="16%" class="text-center">{{ 'Interpretasi Hasil' }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                {{ $f->{'abs_'.$h} or '' }}
                            </td>
                            <td>
                                {{ $f->{'cut_'.$h} or '' }}
                            </td>
                            <td>
                                {{ $f->{'sco_'.$h} or '' }}
                            </td>
                            <td>
                                @php
                                    $selected_hasil = isset($f->{'hasil_'.$h}) ? $f->{'hasil_'.$h} : '';
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
