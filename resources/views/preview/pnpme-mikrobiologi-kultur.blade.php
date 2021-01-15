{{--kimia klinik--}}
@php
    $useSelect2 = true;
    $useIcheck = true;
    $cycle = \App\Cycle::first();
    $parameter = "Mikrobiologi - Parameter Kultur dan Resistansi MO";
    $hint_methods = ['Kirby Bauer'];
    $hint_discs = ['Difco', 'Oxoid', 'Merck', 'Biomerioux'];
    $scores = ['Sensitif', 'Resisten', 'Intermediet'];
    $kultur1_items = ['Meropenem', 'Amikacin', 'Gentamycin', 'Co-trimoxazole', 'Ciprofloxacine'];
    $kultur2_items = $kultur1_items;
    // $kultur1_items = ['Ampicillin', 'Co-trimoxazole', 'Cefepime', 'Meropenem', 'Gentamicin'];
    // $kultur2_items = ['Cefepime', 'Co-trimoxazole', 'Meropenem', 'Gentamicin', 'Ciproflixacine'];

    $f = new stdClass();
    if ($filled_form->value != null) {
        $f = json_decode($filled_form->value);
    }

    $user = Auth::user();
    $contactPerson = $user->contactPerson;
    $orderPackage = \App\OrderPackage::findOrFail($order_package_id);

    $qualifications = \App\PersonQualification::all();
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
                        @elseif($quality == 'kering')
                            {{ 'Kering' }}
                        @elseif($quality == 'pecah')
                            {{ 'Pecah' }}
                        @elseif($quality == 'kontaminasi')
                            {{ 'Kontamintasi' }}
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

                    <th width="20%">{{ 'Kode Kultur' }}</th>

                    <th width="75%">{{ 'Hasil Identifikasi' }}</th>

                </tr>

                @for ($i = 1; $i < 4; $i++)

                    <tr>

                        <td>{{ $i }}</td>

                        <td>
                            {{ $f->{'kode_kultur_' . $i} or '' }}
                        </td>

                        <td>
                            @php
                                $hasil = isset($f->{'hasil_identifikasi_'.$i}) ? $f->{'hasil_identifikasi_'.$i} : '';
                            @endphp
                            {{ $hasil }}
                        </td>

                    </tr>

                @endfor


            </table>

        </div>

    </div>

    <div class="row">

        <div class="col-xs-12">

            <table class="table table-bordered">

                <tr>

                    <th width="50%">{{ 'Metode yang Digunakan' }}</th>
                    <th width="50%">{{ 'Disk Antibiotik yang Digunakan' }}</th>

                </tr>

                <tr>

                    <td>{{ $f->metode or '' }}</td>
                    <td>{{ $f->disk or '' }}</td>

                </tr>

            </table>

        </div>

    </div>

    <div class="row">

        <div class="col-xs-6">

            <h3 style="font-size: 13px;">Hasil Uji Kepekaan Kultur 1</h3>

            <table class="table table-bordered">

                @foreach($kultur1_items as $item)

                <tr>

                    <th width="50%">{{ $item }}</th>

                    <td width="50%">{{ $f->{'hasil_kultur_1_obat_'.$item} or '' }}</td>

                </tr>

                @endforeach

            </table>

        </div>

        <div class="col-xs-6">

            <h3 style="font-size: 13px;">Hasil Uji Kepekaan Kultur 2</h3>

            <table class="table table-bordered">

                @foreach($kultur2_items as $item)

                    <tr>

                        <th width="50%">{{ $item }}</th>

                        <td width="50%">{{ $f->{'hasil_kultur_2_obat_'.$item} or '' }}</td>

                    </tr>

                @endforeach

            </table>

        </div>

    </div>

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
