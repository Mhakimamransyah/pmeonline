@php
    $useSelect2 = true;
    $useIcheck = true;
    $parameterName = 'Hbs Ag';
    $qualifications = \App\PersonQualification::all();
    $f = new stdClass();
    if ($filled_form->value != null) {
        $f = json_decode($filled_form->value);
    }
    $reagens = \App\Reagent::where('parameter_id', '=', 43)->get();

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
                            $metode_pemeriksaan = isset($f->{'metode_pemeriksaan'}) ? $f->{'metode_pemeriksaan'} : '';
                        @endphp
                        @if($metode_pemeriksaan == 'rapid')
                            {{ 'Rapid' }}
                        @elseif($metode_pemeriksaan == 'eia')
                            {{ 'EIA / ELFA' }}
                        @else
                            {{ '-' }}
                        @endif
                    </td>
                    <td>
                        {{ $f->nama_reagen or '' }}
                    </td>
                    <td>
                        {{ $f->nama_produsen or '' }}
                    </td>
                    <td>
                        {{ $f->nama_lot_atau_batch or '' }}
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
                                {{ $f->{'abs_'.$h} or '' }}
                            </td>
                            <td>
                                {{ $f->{'cut_'.$h} or '' }}
                            </td>
                            <td>
                                {{ $f->{'sco_'.$h} or '' }}
                            </td>
                            <td>
                                @php
                                    $selected_hasil = isset($f->{'hasil_'.$h}) ? $f->{'hasil_'.$h} : '';
                                @endphp
                                @if($selected_hasil == 'reaktif')
                                    {{ 'Reaktif' }}
                                @elseif($selected_hasil == 'nonreaktif')
                                    {{ 'Non Reaktif' }}
                                @else
                                    {{ '-' }}
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    @php
                        $score_h = isset($score->{'hasil'}[$h]) ? $score->{'hasil'}[$h] : '';
                        $rujukan = isset($score->{'rujukan'}[$h]) ? $score->{'rujukan'}[$h] : '-';
                    @endphp
                    <div class="row">
                        <div class="col-xs-3 col-xs-offset-6">
                            <div class="form-group has-feedback text-right">
                                <label style="color: red;">{{ 'Hasil Rujukan Panel ' . ($h + 1) . ' :' }}</label>
                                <select class="form-control" title="{{ 'Penilaian Hasil Panel ' . ($h + 1) }}" name="{{ 'rujukan[' . $h . ']' }}">
                                    <option value="-" @if($rujukan == '-') selected @endif>-</option>
                                    <option value="reaktif" @if($rujukan == 'reaktif') selected @endif>Reaktif</option>
                                    <option value="nonreaktif" @if($rujukan == 'nonreaktif') selected @endif>Non Reaktif</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-xs-3">
                            <div class="form-group has-feedback text-right">
                                <label style="color: red;">{{ 'Penilaian Hasil Panel ' . ($h + 1) . ' :' }}</label>
                                <select class="form-control" title="{{ 'Penilaian Hasil Panel ' . ($h + 1) }}" name="{{ 'hasil[' . $h . ']' }}">
                                    <option value="-1" @if($score_h == '-1') selected @endif>{{ '-- Belum Dinilai --' }}</option>
                                    <option value="-2" @if($score_h == '-2') selected @endif>{{ '-- Tidak Dinilai --' }}</option>
                                    <option value="0" @if($score_h == '0') selected @endif>{{ '0 - Tidak Baik' }}</option>
                                    <option value="4" @if($score_h == '4') selected @endif>{{ '4 - Baik' }}</option>
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

    <div class="hidden">
    @if(isset($score->hasil) && !in_array('-1', $score->hasil))
        @php
            $total_data = 0;
            $total_score = 0;
            foreach ($score->hasil as $value) {
                if($value >= 0) {
                    $total_score += $value;
                    $total_data++;
                }
            }
            $average = $total_score / $total_data;
            $good = $average == 4.0 ? true : false;
        @endphp
        <div class="alert alert-warning">
            <h4>Hasil Penilaian</h4>
            <p>{{ 'Nilai Rata-Rata : ' }}<strong>{{ $average }}</strong></p>
            <p>{{ 'Kategori : ' }}<strong>{{ $good ? 'Baik' : 'Tidak Baik' }}</strong></p>
        </div>
    @else
        <div class="alert alert-warning">
            <h4>Hasil Penilaian</h4>
            <i>Penilaian belum lengkap.</i>
        </div>
    @endif
    </div>

</form>

@endsection
