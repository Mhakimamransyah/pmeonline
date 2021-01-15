{{--kimia klinik--}}
@php
    $useSelect2 = true;
    $useIcheck = true;
    $cycle = \App\Cycle::first();
    $parameter = "Mikrobiologi - Parameter Malaria";
    $malarias = ['Plasmodium falciparum', 'Plasmodium vivax', 'Plasmodium malariae', 'Plasmodium ovale'];
    $stadiums = ['Ring', 'Tropozoit', 'Schizont', 'Gametosit'];
    $qualifications = \App\PersonQualification::all();
    $definedOptions = array();

    $user = Auth::user();
    $contactPerson = $user->contactPerson;
    $orderPackage = \App\OrderPackage::findOrFail($order_package_id);

    $f = $filled_form;

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
                    <th class="text-right">{{ $f->{ 'bahan_kontrol' } or '' }}</th>
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
                        $quality = $f->{ 'kondisi_bahan' };
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

                    <th width="3%">{{ '#' }}</th>

                    <th width="7%">{{ 'Kode Sediaan' }}</th>

                    <th width="30%">{{ 'Hasil Pemeriksaan oleh Lab Peserta' }}</th>

                    <th width="30%" style="color: red">{{ 'Hasil Pemeriksaan yang Seharusnya' }}</th>

                    <th width="30%" style="color: red">{{ 'Score' }}</th>

                </tr>

                @for ($i = 0; $i < 10; $i++)

                    <tr>

                        <td>{{ $i + 1 }}</td>

                        <td>
                            {{ $f->{'kode_' . $i} or '' }}
                        </td>

                        <td>
                            @php
                                $hasil = isset($f->{'hasil_'.$i}) ? $f->{'hasil_'.$i} : '';
                            @endphp
                            @if ($hasil != "")
                                <ul>
                                @foreach(explode(',', $hasil) as $item)
                                    <li>{{$item}}</li>
                                @endforeach
                                </ul>
                            @endif
                        </td>

                        <td>
                            <div class="col-xs-12 form-group">
                                <textarea title="Hasil Pemeriksaan yang Seharusnya" name="{{ 'isi_benar['.$i.']' }}" class="form-control" rows="9">{{ $score->isi_benar[$i] or '' }}</textarea>
                            </div>
                        </td>

                        <td>
                            @php
                                $score_h = isset($score->{'genus'}[$i]) ? $score->{'genus'}[$i] : '';
                            @endphp
                            <div class="form-group has-feedback text-right">
                                <select class="form-control" title="{{ 'Ketepatan Genus dan Spesies' }}" name="{{ 'genus[' . $i . ']' }}">
                                    <option value="-1" @if($score_h == '-1') selected @endif>{{ '-- Belum Dinilai --' }}</option>
                                    <option value="gbsb" @if($score_h == 'gbsb') selected @endif>{{ '2 - Genus Benar, Spesies Benar' }}</option>
                                    <option value="gbss" @if($score_h == 'gbss') selected @endif>{{ '0 - Genus Benar, Spesies Salah' }}</option>
                                    <option value="gssb" @if($score_h == 'gssb') selected @endif>{{ '0 - Genus Salah, Spesies Benar' }}</option>
                                    <option value="gsss" @if($score_h == 'gsss') selected @endif>{{ '0 - Genus Salah, Spesies Salah' }}</option>
                                </select>
                            </div>

                            @php
                                $score_h = isset($score->{'stadium'}[$i]) ? $score->{'stadium'}[$i] : '';
                            @endphp
                            <div class="form-group has-feedback text-right">
                                <select class="form-control" title="{{ 'Ketepatan Stadium' }}" name="{{ 'stadium[' . $i . ']' }}">
                                    <option value="-1" @if($score_h == '-1') selected @endif>{{ '-- Belum Dinilai --' }}</option>
                                    <option value="0" @if($score_h == '0') selected @endif>{{ '0 - Salah Semua' }}</option>
                                    <option value="4" @if($score_h == '4') selected @endif>{{ '4 - Benar 1 Stadium' }}</option>
                                    <option value="8" @if($score_h == '8') selected @endif>{{ '8 - Benar 2 Stadium' }}</option>
                                    <option value="12" @if($score_h == '12') selected @endif>{{ '12 - Benar 3 Stadium' }}</option>
                                </select>
                            </div>

                            <span style="color: red">Total Nilai Seharusnya : </span>
                            <input type="text" name="{{ 'total_seharusnya['.$i.']' }}" title="Total Nilai Seharusnya" value="{{ $score->total_seharusnya[$i] or '' }}" class="form-control">
                            <br/><br/>
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
            {{ $f->deskripsi_kondisi_bahan or '' }}<br/><br/>
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
