@php
    $useSelect2 = true;
    $useIcheck = true;
    $cycle = \App\Cycle::first();
    $kimia_klinik = "Kimia Klinik";
    $subject = \App\Subject::where('name', '=', $kimia_klinik)->first();
    $parameters = \App\Package::all()->first(function ($item) use ($cycle, $subject) {
        return $item->cycle_id == $cycle->id && $item->subject_id == $subject->id;
    })->parameters;
    $qualifications = \App\PersonQualification::all();
    $methods = \App\Method::all();
    $equipments = \App\Equipment::where('subject_id', '=', $subject->id)->get();
    $reagents = \App\Reagent::where('subject_id', '=', $subject->id)->get();

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
            Tahun 2018 Siklus 2</b>
    </h3>

    <br/>

    @for($bottle = 1; $bottle <= 2; $bottle++)

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
                    <td width="40%">Kode Bahan Kontrol</td>
                    <th class="text-right">{{ $f->{ 'kode_bahan_kontrol_' . $bottle } or '' }}</th>
                </tr>
                <tr>
                    <td>Tanggal Penerimaan</td>
                    <th class="text-right">{{ $f->{ 'tanggal_penerimaan_' . $bottle } or '' }}</th>
                </tr>
                <tr>
                    <td>Tanggal Pemeriksaan</td>
                    <th class="text-right">{{ $f->{ 'tanggal_pemeriksaan_' . $bottle } or '' }}</th>
                </tr>
                <tr>
                    @php
                        $quality = $f->{ 'kualitas_bahan_' . $bottle };
                    @endphp
                    <td>Kualitas Bahan</td>
                    <th class="text-right">
                        @if($quality == 'baik')
                            {{ 'Baik' }}
                        @elseif($quality == 'kurang_baik')
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

                    <th width="15%">{{ 'Parameter' }}</th>

                    <th width="17%">{{ 'Metode' }}</th>

                    <th width="17%">{{ 'Alat' }}</th>

                    <th width="17%">{{ 'Reagen' }}</th>

                    <th width="17%">{{ 'Kualifikasi Pemeriksa' }}</th>

                    <th width="17%">{{ 'Hasil Pengujian' }}</th>

                </tr>

                @foreach($parameters as $key => $parameter)
                <tr>
                    <td>
                        <strong>{{ $parameter->name }}</strong><br/>
                        <i>{{ $parameter->satuan }}</i>
                    </td>
                    <td>
                        @php
                            $methodId = $f->{ 'metode_pemeriksaan_' . $key . '_' . $bottle };
                            $method = $methods->filter(function ($item) use ($parameter, $methodId) {
                                return $item->parameter_id == $parameter->id && $item->value == $methodId;
                            })->first();
                        @endphp
                        {{ $methodId }} - {{ $method['text'] }}
                    </td>
                    <td>
                        @php
                            $equipmentId = $f->{ 'alat_' . $key . '_' . $bottle };
                            $equipment = $equipments->filter(function ($item) use ($equipmentId) {
                                return $item->private_value == $equipmentId;
                            })->first();
                        @endphp
                        {{ $equipment['value'] }} - {{ $equipment['text'] }}
                    </td>
                    <td>
                        @php
                            $reagentId = $f->{ 'reagen_' . $key . '_' . $bottle };
                            $reagent = $reagents->filter(function ($item) use ($reagentId) {
                                return $item->value == $reagentId;
                            })->first();
                        @endphp
                        {{ $reagentId }} - {{ $reagent['text'] }}
                    </td>
                    <td>
                        @php
                            $qualificationId = $f->{ 'qualification_' . $key . '_' . $bottle };
                            $qualification = $qualifications->filter(function ($item) use ($qualificationId) {
                                return $item->id == $qualificationId;
                            })->first();
                        @endphp
                        {{ $qualificationId }} - {{ $qualification['name'] }}
                    </td>
                    <td>
                        {{ $f->{ 'hasil_' . $key . '_' . $bottle } or '' }}
                    </td>
                </tr>
                @endforeach

            </table>

        </div>

    </div>

    <hr/>

    @endfor

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
