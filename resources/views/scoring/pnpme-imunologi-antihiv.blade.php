{{--kimia klinik--}}
@php
    $parameterName = 'Anti HIV';
    $qualifications = \App\PersonQualification::all();
    $reagens = \App\Reagent::where('parameter_id', '=', 43)->get();
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
            Bidang Imunologi - Parameter {{ $parameterName }}<br/>
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
                    <th width="20%">{{ 'Kode Bahan Kontrol' }}</th>
                    <th width="15%">{{ 'Kualitas Bahan' }}</th>
                    <th width="60%">{{ 'Deskripsi Kualitas Bahan' }}</th>
                </tr>
                @for($i = 0; $i < 3; $i++)
                    <tr>
                        <th>
                            {{ $i + 1 }}
                        </th>
                        <td>
                            {{ $f->{'kode_bahan_kontrol_'.$i} or '' }}
                        </td>
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
                    <th width="25%">{{ 'Keterangan' }}</th>
                    <th width="25%">{{ 'Tes I' }}</th>
                    <th width="25%">{{ 'Tes II' }}</th>
                    <th width="25%">{{ 'Tes III' }}</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th style="vertical-align: middle">
                        {{ 'Metode Pemeriksaan' }}
                    </th>
                    <td>
                        @php
                            $metode_pemeriksaan_tes1 = isset($f->metode_pemeriksaan_tes1) ? $f->metode_pemeriksaan_tes1 : '';
                        @endphp
                        @if($metode_pemeriksaan_tes1 == 'baik')
                            {{ 'Rapid' }}
                        @elseif($metode_pemeriksaan_tes1 == 'keruh')
                            {{ 'EIA / ELFA' }}
                        @else
                            {{ '-' }}
                        @endif
                    </td>
                    <td>
                        @php
                            $metode_pemeriksaan_tes2 = isset($f->metode_pemeriksaan_tes2) ? $f->metode_pemeriksaan_tes2 : '';
                        @endphp
                        @if($metode_pemeriksaan_tes2 == 'baik')
                            {{ 'Rapid' }}
                        @elseif($metode_pemeriksaan_tes2 == 'keruh')
                            {{ 'EIA / ELFA' }}
                        @else
                            {{ '-' }}
                        @endif
                    </td>
                    <td>
                        @php
                            $metode_pemeriksaan_tes3 = isset($f->metode_pemeriksaan_tes3) ? $f->metode_pemeriksaan_tes3 : '';
                        @endphp
                        @if($metode_pemeriksaan_tes3 == 'baik')
                            {{ 'Rapid' }}
                        @elseif($metode_pemeriksaan_tes3 == 'keruh')
                            {{ 'EIA / ELFA' }}
                        @else
                            {{ '-' }}
                        @endif
                    </td>

                </tr>
                <tr>
                    <th style="vertical-align: middle">
                        {{ 'Nama Reagen' }}
                    </th>
                    <td>
                        @php
                            $reagen_tes1 = isset($f->reagen_tes1) ? $f->reagen_tes1 : '';
                            $reagen_tes_name1 = $reagens->filter(function ($item) use ($reagen_tes1) {
                                return $item->value == $reagen_tes1;
                            })->first();
                        @endphp
                        {{ $reagen_tes1 }} - {{ $reagen_tes_name1['text'] }}
                    </td>
                    <td>
                        @php
                            $reagen_tes2 = isset($f->reagen_tes2) ? $f->reagen_tes2 : '';
                            $reagen_tes_name2 = $reagens->filter(function ($item) use ($reagen_tes2) {
                                return $item->value == $reagen_tes2;
                            })->first();
                        @endphp
                        {{ $reagen_tes2 }} - {{ $reagen_tes_name2['text'] }}
                    </td>
                    <td>
                        @php
                            $reagen_tes3 = isset($f->reagen_tes3) ? $f->reagen_tes3 : '';
                            $reagen_tes_name3 = $reagens->filter(function ($item) use ($reagen_tes3) {
                                return $item->value == $reagen_tes3;
                            })->first();
                        @endphp
                        {{ $reagen_tes3 }} - {{ $reagen_tes_name3['text'] or '' }}
                    </td>
                </tr>
                <tr>
                    <th style="vertical-align: middle">
                        {{ 'Nomor Lot/Batch' }}
                    </th>
                    <td>
                        {{ $f->batch_tes1 or '' }}
                    </td>
                    <td>
                        {{ $f->batch_tes2 or '' }}
                    </td>
                    <td>
                        {{ $f->batch_tes3 or '' }}
                    </td>
                </tr>
                <tr>
                    <th style="vertical-align: middle">
                        {{ 'Tanggal Kadaluarsa' }}
                    </th>
                    <td>
                        {{ $f->tanggal_kadaluarsa_tes1 or '' }}
                    </td>
                    <td>
                        {{ $f->tanggal_kadaluarsa_tes2 or '' }}
                    </td>
                    <td>
                        {{ $f->tanggal_kadaluarsa_tes3 or '' }}
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

                <div class="col-md-12">
                    <strong>{{ 'Panel ' . ($h + 1) }}</strong> : {{ $f->{'kode_bahan_kontrol_'.$h} or '' }}<br/>
                </div>

                <div class="col-md-12">

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th width="5%" class="text-center">{{ 'Tes' }}</th>
                            <th width="20%" class="text-center">{{ 'Abs atau OD (A) (Bila dengan EIA)' }}</th>
                            <th width="20%" class="text-center">{{ 'Cut off (B) (Bila dengan EIA)' }}</th>
                            <th width="20%" class="text-center">{{ 'S/CO (A:B) atau true value (TV) atau Indek (Bila dengan EIA)' }}</th>
                            <th width="10%" class="text-center">{{ 'Interpretasi Hasil' }}</th>
                            <th width="25%" class="text-center" style="color: red">{{ 'Isian Penyelenggara' }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @for($i = 0; $i < 3; $i++)
                            <tr>
                                <td class="text-center">
                                    <strong>Tes @for($j = 0; $j < $i + 1; $j++){{ 'I' }}@endfor </strong>
                                </td>

                                {{--Tes = j, Panel = h--}}

                                <td>
                                    {{ $f->{'abs_panel_'.$h.'_tes_'.$j} or '' }}
                                </td>
                                <td>
                                    {{ $f->{'cut_panel_'.$h.'_tes_'.$j} or '' }}
                                </td>
                                <td>
                                    {{ $f->{'sco_panel_'.$h.'_tes_'.$j} or '' }}
                                </td>
                                <td>
                                    @php
                                        $selected_hasil = isset($f->{'hasil_panel_'.$h.'_tes_'.$j}) ? $f->{'hasil_panel_'.$h.'_tes_'.$j} : '';
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
                                    @php
                                        $score_h = isset($score->{'hasil'}[$h][$i]) ? $score->{'hasil'}[$h][$i] : '';
                                    @endphp
                                    <div class="form-group has-feedback text-right">
                                        <label for="hasil" style="color: red;">{{ 'Penilaian Hasil Panel ' . ($h + 1) . ' Tes ' . ($i + 1) }}</label>
                                        <select id="hasil" class="form-control" title="{{ 'Penilaian Hasil Panel ' . ($h + 1) . ' Tes ' . ($i + 1) }}" name="{{ 'hasil[' . $h . '][' . $i . ']' }}">
                                            <option value="-1" @if($score_h == '-1') selected @endif>{{ '-- Belum Dinilai --' }}</option>
                                            <option value="-2" @if($score_h == '-2') selected @endif>{{ '-- Tidak Dinilai --' }}</option>
                                            <option value="0" @if($score_h == '0') selected @endif>{{ '0 - Tidak Baik' }}</option>
                                            <option value="4" @if($score_h == '4') selected @endif>{{ '4 - Baik' }}</option>
                                        </select>
                                    </div>

                                    @php
                                        $rujukan = isset($score->{'rujukan'}[$h][$i]) ? $score->{'rujukan'}[$h][$i] : '-';
                                    @endphp
                                    <div class="form-group has-feedback text-right">
                                        <label for="rujukan" style="color: red;">{{ 'Rujukan Hasil Panel ' . ($h + 1) . ' Tes ' . ($i + 1) }}</label>
                                        <select id="rujukan" class="form-control" title="{{ 'Rujukan Hasil Panel ' . ($h + 1) . ' Tes ' . ($i + 1) }}" name="{{ 'rujukan[' . $h . '][' . $i . ']' }}">
                                            <option value="-" @if($rujukan == '-') selected @endif>-</option>
                                            <option value="reaktif" @if($rujukan == 'reaktif') selected @endif>Reaktif</option>
                                            <option value="nonreaktif" @if($rujukan == 'nonreaktif') selected @endif>Non Reaktif</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>

                    @php
                        $score_h = isset($score->{'sesuai'}[$h]) ? $score->{'sesuai'}[$h] : '';
                    @endphp
                    <div class="row">
                        <div class="col-xs-3 col-xs-offset-9">
                            <div class="form-group has-feedback text-right">
                                <label style="color: red;">{{ 'Nilai Kesesuaian Pemeriksaan Panel ' . ($h + 1) . ' :' }}</label>
                                <select class="form-control" title="{{ 'Nilai Kesesuaian Pemeriksaan Panel ' . ($h + 1) }}" name="{{ 'sesuai[' . $h . ']' }}">
                                    <option value="-1" @if($score_h == '-1') selected @endif>{{ '-- Belum Dinilai --' }}</option>
                                    <option value="-2" @if($score_h == '-2') selected @endif>{{ '-- Tidak Dinilai --' }}</option>
                                    <option value="0" @if($score_h == '0') selected @endif>{{ '0 - Tidak Sesuai' }}</option>
                                    <option value="5" @if($score_h == '5') selected @endif>{{ '5 - Sesuai' }}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

            @endfor

        </div>

    </div>

    <hr/>

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

        <div class="col-xs-12 form-group">
            <label style="color: red;">{{ 'Saran untuk Peserta' }}</label><br/>
            <textarea title="Saran untuk Peserta" name="saran" class="form-control" rows="5">{{ $score->saran or '' }}</textarea>
        </div>

    </div>

    <hr/>

    <div class="text-right">

        <button class="btn btn-info" type="submit">{{ 'Simpan Nilai' }}</button>

    </div>

    <hr/>

</form>

@endsection
