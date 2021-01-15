@php
    $cycle = \App\Cycle::first();
    $parameter = "Mikrobiologi - Parameter Kultur dan Resistansi MO";
    $hint_methods = ['Kirby Bauer'];
    $hint_discs = ['Difco', 'Oxoid', 'Merck', 'Biomerioux'];
    $scores = ['Sensitif', 'Resisten', 'Intermediet'];
    $kultur1_items = ['Ampicillin', 'Co-trimoxazole', 'Cefepime', 'Meropenem', 'Gentamicin'];
    $kultur2_items = ['Cefepime', 'Co-trimoxazole', 'Meropenem', 'Gentamicin', 'Ciproflixacine'];

    $f = new stdClass();
    if ($filled_form->value != null) {
        $f = json_decode($filled_form->value);
    }

    $user = Auth::user();
    $contactPerson = $user->contactPerson;
    $orderPackage = \App\OrderPackage::findOrFail($order_package_id);

    $qualifications = \App\PersonQualification::all();

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

                    <th width="15%">{{ 'Kode Kultur' }}</th>

                    <th width="30%">{{ 'Hasil Identifikasi oleh Peserta' }}</th>

                    <th width="30%" style="color: red">{{ 'Hasil Identifikasi yang Seharusnya' }}</th>

                    <th width="20%" style="color: red">{{ 'Score' }}</th>

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

                        <td>
                            <div class="col-xs-12 form-group">
                                <textarea title="Hasil Identifikasi yang Seharusnya" name="{{ 'isi_benar['.($i - 1).']' }}" class="form-control" rows="5">{{ $score->isi_benar[($i - 1)] or '' }}</textarea>
                            </div>
                        </td>

                        <td>
                            @php
                                $score_h = isset($score->{'score'}[$i - 1]) ? $score->{'score'}[$i - 1] : '';
                            @endphp
                            <div class="form-group has-feedback text-right">
                                <select class="form-control" title="{{ 'Penilaian Hasil Panel ' . ($i) }}" name="{{ 'score[' . ($i - 1) . ']' }}">
                                    <option value="-1" @if($score_h == '-1') selected @endif>{{ '-- Belum Dinilai --' }}</option>
                                    <option value="-2" @if($score_h == '-2') selected @endif>{{ '-- Tidak Dinilai --' }}</option>
                                    <option value="0" @if($score_h == '0') selected @endif>{{ '0' }}</option>
                                    <option value="1" @if($score_h == '1') selected @endif>{{ '1' }}</option>
                                    <option value="2" @if($score_h == '2') selected @endif>{{ '2' }}</option>
                                    <option value="3" @if($score_h == '3') selected @endif>{{ '3' }}</option>
                                </select>
                            </div>
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

                <thead>

                <tr>

                    <th width="40%"></th>
                    <th width="20%">Hasil Peserta</th>
                    <th width="40%" style="color: red">Hasil Seharusnya</th>

                </tr>

                </thead>

                @foreach($kultur1_items as $item)

                <tr>

                    <th>{{ $item }}</th>

                    <td>{{ $f->{'hasil_kultur_1_obat_'.$item} or '' }}</td>

                    <td>
                        @php
                            $selected_score = isset($score->kultur1_seharusnya) ? $score->kultur1_seharusnya->{$item} : '';
                        @endphp
                        <select title="Hasil yang Seharusnya" name="{{'kultur1_seharusnya['.$item.']' }}" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                            <option selected="selected" value="">-- Pilih --</option>
                            @foreach($scores as $score_input)
                                <option @if($selected_score == $score_input) selected @endif>{{ $score_input }}</option>
                            @endforeach
                        </select>
                    </td>

                </tr>

                @endforeach

            </table>

        </div>

        <div class="col-xs-6">

            <h3 style="font-size: 13px;">Hasil Uji Kepekaan Kultur 2</h3>

            <table class="table table-bordered">

                <thead>

                <tr>

                    <th width="40%"></th>
                    <th width="20%">Hasil Peserta</th>
                    <th width="40%" style="color: red">Hasil Seharusnya</th>

                </tr>

                </thead>

                @foreach($kultur2_items as $item)

                    <tr>

                        <th>{{ $item }}</th>

                        <td>{{ $f->{'hasil_kultur_2_obat_'.$item} or '' }}</td>

                        <td>
                            @php
                                $selected_score = isset($score->kultur2_seharusnya) ? $score->kultur2_seharusnya->{$item} : '';
                            @endphp
                            <select title="Hasil yang Seharusnya" name="{{'kultur2_seharusnya['.$item.']' }}" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option selected="selected" value="">-- Pilih --</option>
                                @foreach($scores as $score_input)
                                    <option @if($selected_score == $score_input) selected @endif>{{ $score_input }}</option>
                                @endforeach
                            </select>
                        </td>

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
