@php
    $cycle = \App\Cycle::first();
    $parameter = "Mikrobiologi - Parameter BTA";
    $f = new stdClass();
    if ($filled_form->value != null) {
        $f = json_decode($filled_form->value);
    }

    $qualifications = \App\PersonQualification::all();

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
                        $quality = $f->{ 'kualitas_bahan' };
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

                    <th width="5%">{{ '#' }}</th>

                    <th width="15%">{{ 'Kode Sediaan' }}</th>

                    <th width="30%">{{ 'Hasil Pemeriksaan oleh Lab Peserta' }}</th>

                    <th width="30%" style="color: red">{{ 'Hasil Pemeriksaan yang Seharusnya' }}</th>

                    <th width="20%" style="color: red">{{ 'Kualifikasi' }}</th>

                </tr>

                @for ($i = 0; $i < 10; $i++)

                    <tr>

                        <td>{{ $i + 1 }}</td>

                        <td>
                            {{ $f->{'kode_sediaan_' . $i} or '' }}
                        </td>

                        <td>
                            @php
                                $hasil = isset($f->{'hasil_'.$i}) ? $f->{'hasil_'.$i} : '';
                            @endphp
                            {{ $hasil }}
                        </td>

                        <td>
                            @php
                                $hasil_seharusnya = isset($score->hasil_seharusnya) ? $score->{'hasil_seharusnya'}[$i] : '';
                            @endphp
                            <select class="form-control" style="width: 100%;" tabindex="-1" aria-hidden="true" name="{{ 'hasil_seharusnya['.$i.']' }}" title="Hasil Pemeriksaan yang Seharusnya">
                                <option value="null" @if($hasil_seharusnya == 'null') selected @endif>{{ '-- Belum Dipilih --' }}</option>
                                <option value="negatif" @if($hasil_seharusnya == 'negatif') selected @endif>Negatif</option>
                                <option value="1+" @if($hasil_seharusnya == '1+') selected @endif>1+</option>
                                <option value="2+" @if($hasil_seharusnya == '2+') selected @endif>2+</option>
                                <option value="3+" @if($hasil_seharusnya == '3+') selected @endif>3+</option>
                                <option value="scanty" @if($hasil_seharusnya == 'scanty') selected @endif>{{ 'Scanty' }}</option>
                                @for($ii = 1; $ii < 10; $ii++)
                                    @php
                                        $value = $ii . ' BTA';
                                    @endphp
                                    <option value="{{ $value }}" @if($hasil_seharusnya == $value) selected @endif>{{ $value }}</option>
                                @endfor
                            </select>
                        </td>

                        <td>
                            @php
                                $kualifikasi = isset($score->kualifikasi) ? $score->{'kualifikasi'}[$i] : '';
                            @endphp
                            <select class="form-control" style="width: 100%;" tabindex="-1" aria-hidden="true" name="{{ 'kualifikasi['.$i.']' }}" title="Kualifikasi">
                                <option value="null" @if($kualifikasi == 'null') selected @endif>{{ '-- Belum Diisi --' }}</option>
                                <option value="benar" @if($kualifikasi == 'benar') selected @endif>Benar</option>
                                <option value="kh" @if($kualifikasi == 'kh') selected @endif>Kesalahan Hitung</option>
                                <option value="ppr" @if($kualifikasi == 'ppr') selected @endif>Positif Palsu Rendah</option>
                                <option value="npr" @if($kualifikasi == 'npr') selected @endif>Negatif Palsu Rendah</option>
                                <option value="ppt" @if($kualifikasi == 'ppt') selected @endif>Positif Palsu Tinggi</option>
                                <option value="npt" @if($kualifikasi == 'npt') selected @endif>Negatif Palsu Tinggi</option>
                                <option value="tm" @if($kualifikasi == 'tm') selected @endif>Tidak Menjawab</option>
                            </select>
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

    <span class="hidden">
    @if(isset($score->kualifikasi) && !in_array('null', $score->kualifikasi))
        @php
            $total_score = 0;
            $failed = false;
            foreach ($score->kualifikasi as $value) {
                if($value == 'benar') {
                    $total_score += 10;
                }
                if($value == 'kh') {
                    $total_score += 5;
                }
                if($value == 'ppr') {
                    $total_score += 5;
                }
                if($value == 'npr') {
                    $total_score += 5;
                }
                if($value == 'ppt') {
                    $total_score += 0;
                    $failed = true;
                }
                if($value == 'npt') {
                    $total_score += 0;
                    $failed = true;
                }
                if($value == 'tm') {
                    $total_score += 0;
                }
            }
            $good = $total_score >= 80.0 && !$failed ? true : false;
        @endphp
        <div class="alert alert-warning">
            <h4>Hasil Penilaian</h4>
            <p>{{ 'Total Nilai : ' }}<strong>{{ $total_score }}</strong></p>
            <p>{{ 'Kategori : ' }}<strong>{{ $good ? 'Lulus' : 'Tidak Lulus' }}</strong></p>
        </div>
    @else
        <div class="alert alert-warning">
            <h4>Hasil Penilaian</h4>
            <i>Penilaian belum lengkap.</i>
        </div>
    @endif
    </span>

</form>

@endsection
