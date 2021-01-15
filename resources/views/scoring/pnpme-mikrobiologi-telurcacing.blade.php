@php
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

    $score_value = \App\ScoreInput::where('order_package_id', '=', $order_package_id)->first()->value;
    $score = json_decode($score_value);
@endphp

@extends('layouts.preview')

@section('style-override')
@endsection

@section('content')

    <br/>

    @component('form.components.success-message')
    @endcomponent

<form method="post" action="{{ route('installation.scoring.post', ['id' => $order_package_id]) }}">

    @csrf

    <h3 class="text-center" style="font-size: 14px"><b>Program Nasional Pemantapan Mutu Eksternal<br/>
            Bidang {{ $parameter }}<br/>
            Tahun 2018 Siklus 2</b>
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
                    <td width="40%">Kode Bahan Kontrol</td>
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

                    <th width="15%">{{ 'Kode Sediaan' }}</th>

                    <th width="30%">{{ 'Hasil Pemeriksaan oleh Lab Peserta' }}</th>

                    <th width="30%" style="color: red">{{ 'Hasil Pemeriksaan yang Seharusnya' }}</th>

                    <th width="20%" style="color: red">{{ 'Nilai' }}</th>

                </tr>

                @for ($i = 0; $i < 3; $i++)

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

                        <td>
                            <div class="col-xs-12 form-group">
                                <textarea title="Hasil Pemeriksaan yang Seharusnya" name="{{ 'isi_benar['.$i.']' }}" class="form-control" rows="5">{{ $score->isi_benar[$i] or '' }}</textarea>
                            </div>
                        </td>

                        <td>
                            @php
                                $score_h = isset($score->{'score'}[$i]) ? $score->{'score'}[$i] : '';
                            @endphp
                            <div class="form-group has-feedback text-right">
                                <label for="score" style="color: red">{{ 'Skor Peserta :' }}</label>
                                <input id="score" class="form-control" type="number" name="{{ 'score[' . $i . ']' }}" value="{{ $score->score[$i] or '0' }}">
                            </div>

                            @php
                                $score_max = isset($score->{'score_max'}[$i]) ? $score->{'score_max'}[$i] : '';
                            @endphp
                            <div class="form-group has-feedback text-right">
                                <label for="score" style="color: red">{{ 'Skor Maksimal :' }}</label>
                                <input id="score" class="form-control" type="number" name="{{ 'score_max[' . $i . ']' }}" value="{{ $score->score_max[$i] or '0' }}">
                            </div>
                        </td>

                    </tr>

                @endfor

            </table>

            <p style="color: red">{{ 'Item dengan skor maksimal nol akan diabaikan dalam perhitungan rata-rata.' }}</p>

        </div>

    </div>

    <hr/>

    <div class="row">

        <div class="col-xs-12">
            <label>{{ 'Deskripsi Kondisi Bahan' }}</label><br/>
            {{ $f->deskripsi_keterangan_bahan or '' }}<br/><br/>
        </div>

        <div class="col-xs-12">
            <label>{{ 'Saran dari Peserta' }}</label><br/>
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
            {{ $qualificationId }} - {{ $qualification['name'] }}<br/><br/>
        </div>

        <div class="col-xs-12 form-group">
            <label style="color: red;">{{ 'Saran untuk Peserta' }}</label><br/>
            <textarea title="Saran untuk Peserta" name="saran" class="form-control" rows="5">{{ $score->saran or '' }}</textarea>
        </div>

    </div>

    <div class="text-right">

        <button class="btn btn-info" type="submit">{{ 'Simpan Nilai' }}</button>

    </div>

    <hr/>

</form>

@endsection
