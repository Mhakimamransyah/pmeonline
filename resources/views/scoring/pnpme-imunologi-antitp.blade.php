{{--kimia klinik--}}
@php
    $useSelect2 = true;
    $useIcheck = true;
    $parameterName = 'Anti TP';
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
                                $kualitas_bahan = isset($f->{'kualtias_bahan_'.$i}) ? $f->{'kualtias_bahan_'.$i} : '';
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
                            $metode_pemeriksaan = isset($f->{'metode'}) ? $f->{'metode'} : '';
                        @endphp
                        @if($metode_pemeriksaan == 'rapid')
                            {{ 'Rapid' }}
                        @elseif($metode_pemeriksaan == 'eia_elfa')
                            {{ 'EIA / ELFA' }}
                        @elseif($metode_pemeriksaan == 'algutinasi')
                            {{ 'Aglutinasi' }}
                        @else
                            {{ '-' }}
                        @endif
                    </td>
                    <td>
                        {{ $f->nama_reagen or '' }}
                    </td>
                    <td>
                        {{ $f->nama_produsen_reagen or '' }}
                    </td>
                    <td>
                        {{ $f->lot_reagen or '' }}
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

            <h3 style="font-size: 14px;"><b>{{ 'Kualitatif' }}</b></h3>

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
                                {{ $f->{'kualitatif_abs_'.$h} or '' }}
                            </td>
                            <td>
                                {{ $f->{'kualitatif_cut_'.$h} or '' }}
                            </td>
                            <td>
                                {{ $f->{'kualitatif_sco_'.$h} or '' }}
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

            <h3 style="font-size: 14px;"><b>{{ 'Semi Kuantitatif' }}</b></h3>

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
                            <th width="23%" class="text-center">{{ 'Interpretasi Hasil' }}</th>
                            <th width="23%" class="text-center">{{ 'Titer' }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                @php
                                    $selected_hasil = isset($f->{'hasil_semi_kuantitatif_'.$h}) ? $f->{'hasil_semi_kuantitatif_'.$h} : '';
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
                                {{ $f->{'semi_kuantitatif_tier_'.$h} or '' }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            @endfor

        </div>

    </div>

    <div class="row">

        <div class="col-xs-12">

            <table class="table-bordered table">
                <thead>
                <tr>
                    <th rowspan="2" class="text-center" style="vertical-align: middle">{{ 'Panel' }}</th>
                    <th colspan="2" class="text-center" style="vertical-align: middle">{{ 'Hasil Rujukan' }}</th>
                    <th rowspan="2" class="text-center" style="vertical-align: middle">{{ 'Skor Peserta' }}</th>
                </tr>
                <tr>
                    <td class="text-center" style="vertical-align: middle">{{ 'Hasil' }}</td>
                    <td class="text-center" style="vertical-align: middle">{{ 'Titer' }}</td>
                </tr>
                </thead>
                <tbody>
                @for($h = 0; $h < 3; $h++)
                    <tr>
                        <td class="text-center">{{ $f->{'kode_bahan_kontrol_'.$h} or '' }}</td>
                        <td class="text-center">
                            @php
                                $hasil = isset($score->{'rujukan_hasil'}[$h]) ? $score->{'rujukan_hasil'}[$h] : '';
                            @endphp

                            <select name="{{'rujukan_hasil['.$h.']'}}" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option selected="selected" value="">-- Pilih --</option>
                                <option value="reaktif" @if($hasil == 'reaktif') selected @endif>Reaktif</option>
                                <option value="nonreaktif" @if($hasil == 'nonreaktif') selected @endif>Nonreaktif</option>
                            </select>
                        </td>
                        <td class="text-center">
                            <input type="text" name="{{ 'rujukan_titer['.$h.']' }}" value="{{ $score->{'rujukan_titer'}[$h] or '' }}" class="form-control"/>
                        </td>
                        <td class="text-center">
                            @php
                                $score_h = isset($score->{'score'}[$h]) ? $score->{'score'}[$h] : '';
                            @endphp
                            <div class="form-group has-feedback text-right">
                                <select class="form-control" title="{{ 'Penilaian Hasil Panel ' . ($h + 1) }}" name="{{ 'score[' . $h . ']' }}">
                                    <option value="-1" @if($score_h == '-1') selected @endif>{{ '-- Belum Dinilai --' }}</option>
                                    <option value="-2" @if($score_h == '-2') selected @endif>{{ '-- Tidak Dinilai --' }}</option>
                                    <option value="0" @if($score_h == '0') selected @endif>{{ '0 - Tidak Baik' }}</option>
                                    <option value="4" @if($score_h == '4') selected @endif>{{ '4 - Baik' }}</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                @endfor
                </tbody>
            </table>

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
