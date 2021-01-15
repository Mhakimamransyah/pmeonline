@php
    $useSelect2 = true;
    $useIcheck = true;
    $cycle = \App\Cycle::first();
    $kimia_klinik = "Kimia Air";
    $subject = \App\Subject::where('name', '=', $kimia_klinik)->first();
    $parameters = \App\Package::all()->first(function ($item) use ($cycle, $subject) {
        return $item->cycle_id == $cycle->id && $item->subject_id == $subject->id;
    })->parameters;
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
            Bidang {{ $kimia_klinik }}<br/>
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
                    <td>Kode Kemasan</td>
                    <th class="text-right">{{ $f->{ 'kode_bahan_kontrol' } or '' }}</th>
                </tr>
                <tr>
                    <td>Tanggal Penerimaan</td>
                    <th class="text-right">{{ $f->{ 'tanggal_penerimaan' } or '' }}</th>
                </tr>
                <tr>
                    <td>Tanggal Pemeriksaan</td>
                    <th class="text-right">{{ $f->{ 'tanggal_pemeriksaan' } or '' }}</th>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">

        <div class="col-xs-12">

            <table class="table table-bordered">

                <tr>
                    <th width="25%">{{ 'Kondisi Kemasan Luar' }}</th>
                    <th width="75%">{{ 'Deskripsi Kondisi Kemasan Luar' }}</th>
                </tr>

                <tr>
                    <td>{{ $f->kondisi_kemasan_luar or '' }}</td>
                    <td>{{ $f->deskripsi_kondisi_kemasan_luar or '' }}</td>
                </tr>

            </table>

        </div>

    </div>

    <div class="row">

        <div class="col-xs-12">

            <table class="table table-bordered">

                <tr>
                    <th width="25%">{{ 'Kondisi Bahan Uji' }}</th>
                    <th width="75%">{{ 'Deskripsi Kondisi Bahan Uji' }}</th>
                </tr>

                <tr>
                    <td>{{ $f->kondisi_bahan_uji or '' }}</td>
                    <td>{{ $f->deskripsi_kondisi_bahan_uji or '' }}</td>
                </tr>

            </table>

        </div>

    </div>

    <div class="row">

        <div class="col-xs-12">

            <table class="table table-bordered">

                <tr>
                    <th width="20%">{{ 'Parameter' }}</th>
                    <th width="20%">{{ 'Hasil Pengujian	' }}</th>
                    <th width="20%">{{ 'U* / Ketidakpastian' }}</th>
                    <th width="20%">{{ 'Satuan' }}</th>
                    <th width="20%">{{ 'Metode' }}</th>
                </tr>

                @foreach($parameters as $parameter)
                    <tr>
                        <th>{{ $parameter->name }}</th>
                        <td>{{ $f->{'hasil_pengujian_'.$parameter->name} or '' }}</td>
                        <td>{{ $f->{'ketidakpastian_'.$parameter->name} or '' }}</td>
                        <td>{{ $f->{'satuan_'.$parameter->name} or '' }}</td>
                        <td>{{ $f->{'metode_'.$parameter->name} or '' }}</td>
                    </tr>
                @endforeach

            </table>

        </div>

    </div>

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
