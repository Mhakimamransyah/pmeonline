@php
    use Illuminate\Support\Facades\DB;

    $f = new stdClass();
    $order_id = request()->query('order_id');
    $filled_form = \App\Submit::query()->where('order_id', '=', $order_id)->get()->first();
    if ($filled_form->value != null) {
        $f = json_decode($filled_form->value);
    }

    $packageInjectData = \App\Package::query()->where('name', 'pnpme-imunologi-antihiv-3')->get()->first();
    $injects = $packageInjectData->injects()->get();

    $package = $filled_form->order->package;
    $parameters = $package->parameters;
    $parameterName = $package->label;
    $cycle = $package->cycle;

    $table_reagens = $injects->filter(function ($inject) { return $inject->name == 'Daftar Reagen'; })->first()->option->table_name;
    $reagens = DB::table($table_reagens)->get();

    $table_kualifikasi_pemeriksa = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualifikasi Pemeriksa'; })->first()->option->table_name;
    $qualifications = DB::table($table_kualifikasi_pemeriksa)->get();

    $table_kualitas_bahan = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualitas Bahan'; })->first()->option->table_name;
    $daftar_pilihan_kualitas_bahan = DB::table($table_kualitas_bahan)->get();

    $table_metode_pemeriksaan = $injects->filter(function ($inject) { return $inject->name == 'Daftar Metode Pemeriksaan'; })->first()->option->table_name;
    $daftar_pilihan_metode_pemeriksaan = DB::table($table_metode_pemeriksaan)->get();

    $table_interpretasi_hasil = $injects->filter(function ($inject) { return $inject->name == 'Daftar Interpretasi Hasil'; })->first()->option->table_name;
    $daftar_pilihan_interpretasi_hasil = DB::table($table_interpretasi_hasil)->get();
@endphp

<div class="ui warning message">
    <h4>Peringatan!</h4>

    <ul>
        <li>Diharapkan untuk mengisi kode panel dari yang terkecil hingga yang terbesar.</li>
        <li>Peserta DIWAJIBKANN melihat tabel evaluasi reagensia Anti HIV RSCM di Juknis imunologi sebelum input
            reagensia.
        </li>
    </ul>
</div>

<h3 class="ui horizontal divider header">
    Formulir Hasil Bidang Imunologi Parameter {{ $parameterName }}
</h3>

<form id="submit-form" class="ui form" method="post" action="{{ $route }}">

    @csrf

    <div class="ui two fields">

        <div class="field">
            <label>{{ 'Tanggal Penerimaan' }}</label>

            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input name="{{'tanggal_penerimaan'}}" value="{{$f->tanggal_penerimaan ?? ''}}"
                       class="form-control pull-right" id="tanggal_penerimaan" type="date">
            </div>
        </div>

        <div class="field">
            <label>{{ 'Tanggal Pemeriksaan' }}</label>

            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input name="tanggal_pemeriksaan" value="{{$f->tanggal_pemeriksaan ?? ''}}"
                       class="form-control pull-right" id="tanggal_pemeriksaan" type="date">
            </div>
        </div>

    </div>

    <table class="ui table celled">
        <thead>
        <tr>
            <th class="center aligned">{{ '#' }}</th>
            <th class="center aligned">{{ 'Kode Panel' }}</th>
            <th class="center aligned">{{ 'Kualitas Bahan' }}</th>
            <th class="center aligned">{{ 'Deskripsi Kualitas Bahan' }}</th>
        </tr>
        </thead>
        <tbody>
        @for($i = 0; $i < 3; $i++)
            <tr>
                <th class="center aligned" width="5%">{{ $i + 1 }}</th>
                <td class="center aligned" width="10%">
                    <div class="form-group has-feedback">
                        <input name="{{'kode_panel_'.$i}}" value="{{ $f->{'kode_panel_'.$i} ?? '' }}"
                               type="text" class="form-control">
                    </div>
                </td>

                <td class="center aligned" width="15%">
                    <div class="form-group">
                        @php
                            $kualitas_bahan = isset($f->{'kualitas_bahan_'.$i}) ? $f->{'kualitas_bahan_'.$i} : '';
                        @endphp
                        <select name="{{'kualitas_bahan_'.$i}}"
                                class="ui search fluid dropdown"
                                style="" tabindex="-1" aria-hidden="true">
                            <option selected="selected" value="">-- Pilih --</option>
                            @foreach($daftar_pilihan_kualitas_bahan as $pilihan_kualitas_bahan)
                                <option value="{{ $pilihan_kualitas_bahan->value }}" @if($kualitas_bahan == $pilihan_kualitas_bahan->value) selected @endif>{{ $pilihan_kualitas_bahan->text }}</option>
                            @endforeach
                        </select>
                    </div>
                </td>

                <td width="60%">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control"
                               name="{{'deskripsi_kualitas_bahan_'.$i}}"
                               value="{{ $f->{'deskripsi_kualitas_bahan_'.$i} ?? '' }}">
                    </div>
                </td>
            </tr>
        @endfor
        </tbody>
    </table>

    <table class="ui table celled">
        <thead>
        <tr>
            <th class="center aligned" width="12%">{{ 'Reagen' }}</th>
            <th class="center aligned" width="22%">{{ 'Metode Pemeriksaan' }}</th>
            <th class="center aligned" width="22%">{{ 'Nama Reagen' }}</th>
            <th class="center aligned" width="22%">{{ 'Nomor Lot / Batch' }}</th>
            <th class="center aligned" width="22%">{{ 'Tanggal Kadaluarsa' }}</th>
        </tr>
        </thead>
        <tbody>
        @for ($tes = 1; $tes <= 3; $tes++)
            <tr>
                <td class="center aligned">
                    <strong>Reagen @for($j = 0; $j < $tes; $j++){{ 'I' }}@endfor
                    </strong>
                </td>
                <td>
                    @php
                        $metode_pemeriksaan_tes = isset($f->{'metode_pemeriksaan_tes'.$tes}) ? $f->{'metode_pemeriksaan_tes'.$tes} : '';
                    @endphp
                    <select name="{{'metode_pemeriksaan_tes'.$tes}}"
                            class="ui search fluid dropdown" style="width: 100%;"
                            tabindex="-1" aria-hidden="true">
                        <option selected="selected" value="">-- Pilih --</option>
                        @foreach($daftar_pilihan_metode_pemeriksaan as $pilihan_metode_pemeriksaan)
                            <option value="{{ $pilihan_metode_pemeriksaan->value }}" @if($metode_pemeriksaan_tes == $pilihan_metode_pemeriksaan->value) selected @endif>{{ $pilihan_metode_pemeriksaan->text }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    @php
                        $reagen_tes = isset($f->{'reagen_tes'.$tes}) ? $f->{'reagen_tes'.$tes} : '';
                    @endphp
                    <select name="{{'reagen_tes'.$tes}}"
                            class="ui search fluid dropdown" style="width: 100%;"
                            tabindex="-1" aria-hidden="true">
                        <option selected="selected" value="">-- Pilih --</option>
                        @foreach($reagens as $reagen)
                            <option value="{{ $reagen->value }}"
                                    @if($reagen_tes == $reagen->value) selected @endif>{{ $reagen->value }}
                                - {{ $reagen->text }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control" name="{{'batch_tes'.$tes}}"
                           value="{{$f->{'batch_tes'.$tes} ?? ''}}">
                </td>
                <td>
                    <input class="form-control pull-right" id="tanggal_kadaluarsa_1" type="date"
                           name="{{'tanggal_kadaluarsa_tes'.$tes}}"
                           value="{{$f->{'tanggal_kadaluarsa_tes'.$tes} ?? ''}}">
                </td>
            </tr>
        @endfor
        </tbody>
    </table>

    @for($h = 0; $h < 3; $h++)

        <h4 class="ui horizontal divider header">
            {{ 'Panel ' . ($h + 1) }}
        </h4>

        <table class="table ui celled">
            <thead>
            <tr>
                <th width="15%" class="center aligned">{{ 'Reagen' }}</th>
                <th width="23%" class="center aligned">{{ 'Abs atau OD (A) (Bila dengan EIA)' }}</th>
                <th width="23%" class="center aligned">{{ 'Cut off (B) (Bila dengan EIA)' }}</th>
                <th width="23%"
                    class="center aligned">{{ 'S/CO (A:B) atau true value (TV) atau Indek (Bila dengan EIA)' }}</th>
                <th width="16%" class="center aligned">{{ 'Interpretasi Hasil' }}</th>
            </tr>
            </thead>
            <tbody>
            @for($i = 0; $i < 3; $i++)
                <tr>
                    <td class="center aligned">
                        <strong>Hasil Reagen @for($j = 0; $j < $i + 1; $j++){{ 'I' }}@endfor
                        </strong>
                    </td>

                    {{--Tes = j, Panel = h--}}

                    <td>
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control"
                                   name="{{'abs_panel_'.$h.'_tes_'.$j}}"
                                   value="{{ $f->{'abs_panel_'.$h.'_tes_'.$j} ?? '' }}">
                        </div>
                    </td>
                    <td>
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control"
                                   name="{{'cut_panel_'.$h.'_tes_'.$j}}"
                                   value="{{ $f->{'cut_panel_'.$h.'_tes_'.$j} ?? '' }}">
                        </div>
                    </td>
                    <td>
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control"
                                   name="{{'sco_panel_'.$h.'_tes_'.$j}}"
                                   value="{{ $f->{'sco_panel_'.$h.'_tes_'.$j} ?? '' }}">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            @php
                                $selected_hasil = isset($f->{'hasil_panel_'.$h.'_tes_'.$j}) ? $f->{'hasil_panel_'.$h.'_tes_'.$j} : '';
                            @endphp
                            <select class="ui search dropdown fluid"
                                    style="width: 100%;" tabindex="-1" aria-hidden="true"
                                    name="{{'hasil_panel_'.$h.'_tes_'.$j}}">
                                <option selected="selected" value="">-- Pilih --</option>
                                @foreach($daftar_pilihan_interpretasi_hasil as $pilihan_interpretasi_hasil)
                                    <option value="{{ $pilihan_interpretasi_hasil->value }}" @if($selected_hasil == $pilihan_interpretasi_hasil->value) selected @endif>{{ $pilihan_interpretasi_hasil->text }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                </tr>
            @endfor
            </tbody>
        </table>

    @endfor

    <div class="ui divider"></div>

    <div class="ui field">
        <label>{{ 'Keterangan' }}</label>
        <textarea class="form-control" rows="3" placeholder="Tulis keterangan"
                  name="{{'keterangan'}}">{{$f->keterangan ?? ''}}</textarea>
    </div>

    <div class="ui field">
        <label>{{ 'Saran' }}</label>
        <textarea class="form-control" rows="3" placeholder="Tulis saran"
                  name="{{'saran'}}">{{$f->saran ?? ''}}</textarea>
    </div>

    <div class="ui field">
        <label>{{ 'Nama Pemeriksa' }}</label>
        <input type="text" class="form-control" name="{{'nama_pemeriksa'}}"
               value="{{$f->nama_pemeriksa ?? ''}}">
    </div>

    <div class="ui field">
        @php

            $selected_qualification = isset($f->kualifikasi_pemeriksa) ? $f->kualifikasi_pemeriksa : '';

        @endphp

        <label>{{ 'Kualifikasi Pemeriksa' }}</label>
        <select name="{{'kualifikasi_pemeriksa'}}"
                class="ui search fluid dropdown" style="width: 100%;"
                tabindex="-1" aria-hidden="true">
            <option selected="selected" value="">-- Pilih --</option>
            @foreach($qualifications as $qualification)
                <option value="{{ $qualification->value }}"
                        @if($selected_qualification == $qualification->value) selected @endif>{{ $qualification->text }}</option>
            @endforeach
        </select>
    </div>

</form>