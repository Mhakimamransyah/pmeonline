@php
    $useSelect2 = true;
    $useIcheck = true;
    $cycle = \App\Cycle::first();
    $parameter = "Mikrobiologi - Parameter Telur Cacing";
    $cacings = [''];
    // $cacings = ['negatif', 'Telur cacing Ascaris lumbricoides (+)', 'Telur cacing Trichuris trichiura (+)', 'Telur cacing Tambang (+)'];
    $qualifications = \App\PersonQualification::all();
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
            Bidang {{ $parameter }}<br/>
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
                    @php
                        $quality = isset($f->{ 'kondisi_bahan' }) ? $f->{ 'kondisi_bahan' } : '';
                    @endphp
                    <td>Kondisi Bahan</td>
                    <th class="text-right">
                        @if($quality == 'baik')
                            {{ 'Baik' }}
                        @elseif($quality == 'kurang')
                            {{ 'Kurang Baik' }}
                        @else
                            {{ '-' }}
                        @endif
                    </th>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">

        <div class="col-xs-12">

            <table class="table table-bordered">

                <tr>

                    <th width="5%">{{ '#' }}</th>

                    <th width="20%">{{ 'Kode Sediaan' }}</th>

                    <th width="75%">{{ 'Hasil Pemeriksaan oleh Lab Peserta' }}</th>

                </tr>

                @for ($i = 0; $i < 2; $i++)

                    <tr>

                        <td>{{ $i + 1 }}</td>

                        <td>
                            {{ $f->{'kode_sediaan_' . $i} or '' }}
                        </td>

                        <td>
                            @php
                                $hasil = isset($f->{'hasil_'.$i}) ? $f->{'hasil_'.$i} : '';
                            @endphp
                            @if ($hasil != "")
                                <ul>
                                    @foreach($hasil as $item)
                                        <li>{{$item}}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>

                    </tr>

                @endfor


            </table>

        </div>

    </div>

    <hr/>

    <div class="row">

        <div class="col-xs-12">
            <label>{{ 'Deskripsi Kondisi Bahan' }}</label><br/>
            {{ $f->deskripsi_keterangan_bahan or '' }}<br/><br/>
        </div>

        <div class="col-xs-12">
            <label>{{ 'Saran' }}</label><br/>
            {{ $f->saran or '' }}<br/><br/>
        </div>

        <div class="col-xs-12">
            <label>{{ 'Nama Pemeriksa' }}</label><br/>
            {{ $f->nama_pemeriksa or '' }}<br/><br/>
        </div>

        <div class="col-xs-12">
            <label>{{ 'Kualifikasi Pemeriksa' }}</label><br/>
            @php
                $qualificationId = isset($f->{ 'kualifikasi_pemeriksa' }) ? $f->{ 'kualifikasi_pemeriksa' } : '';
                $qualification = $qualifications->filter(function ($item) use ($qualificationId) {
                    return $item->id == $qualificationId;
                })->first();
            @endphp
            {{ $qualificationId }} - {{ $qualification['name'] }}
        </div>

    </div>

    <hr/>

    <p>{{ date('Y/m/d H:i:s') }}</p>

    <p class="text-right"><i>{{ 'Menghemat kertas menyelamatkan pohon.' }}</i></p>

@endsection
