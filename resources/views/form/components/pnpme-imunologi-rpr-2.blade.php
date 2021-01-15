@php
    use Illuminate\Support\Facades\DB;

    $parameterName = 'RPR';

    $f = new stdClass();
    $order_id = request()->query('order_id');
    $filled_form = \App\Submit::query()->where('order_id', '=', $order_id)->get()->first();
    if ($filled_form->value != null) {
        $f = json_decode($filled_form->value);
    }

    $injects = $filled_form->order->package->injects()->get();

    $table_kualifikasi_pemeriksa = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualifikasi Pemeriksa'; })->first()->option->table_name;
    $qualifications = DB::table($table_kualifikasi_pemeriksa)->get();

    $table_kualitas_bahan = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualitas Bahan'; })->first()->option->table_name;
    $daftar_pilihan_kualitas_bahan = DB::table($table_kualitas_bahan)->get();

    $table_daftar_pilihan_metode_rpr = $injects->filter(function ($inject) { return $inject->name == 'Daftar Pilihan Metode RPR'; })->first()->option->table_name;
    $daftar_pilihan_metode_rpr = DB::table($table_daftar_pilihan_metode_rpr)->get();

    $table_daftar_pilihan_interpretasi_hasil = $injects->filter(function ($inject) { return $inject->name == 'Daftar Pilihan Interpretasi Hasil'; })->first()->option->table_name;
    $daftar_pilihan_interpretasi_hasil = DB::table($table_daftar_pilihan_interpretasi_hasil)->get();

    $table_daftar_pilihan_titer_rpr = $injects->filter(function ($inject) { return $inject->name == 'Daftar Pilihan Titer RPR'; })->first()->option->table_name;
    $daftar_pilihan_titer_rpr = DB::table($table_daftar_pilihan_titer_rpr)->get();

@endphp

<div class="ui warning message">
    <h4>Peringatan!</h4>

    <ul>
        <li>Diharapkan untuk mengisi kode panel dari yang terkecil hingga yang terbesar.</li>
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
            <input name="tanggal_penerimaan" value="{{$f->tanggal_penerimaan ?? ''}}" class="form-control pull-right" id="tanggal_penerimaan" type="date">
        </div>

        <div class="field">
            <label>{{ 'Tanggal Pemeriksaan' }}</label>
            <input name="tanggal_pemeriksaan" value="{{$f->tanggal_pemeriksaan ?? ''}}" class="form-control pull-right" id="tanggal_pemeriksaan" type="date">
        </div>

    </div>

    <div class="ui divider"></div>

    <table class="table ui celled">
        <thead>
        <tr>
            <th class="ui center aligned">{{ '#' }}</th>
            <th class="ui center aligned">{{ 'Kode Panel' }}</th>
            <th class="ui center aligned">{{ 'Kualitas Bahan' }}</th>
            <th class="ui center aligned">{{ 'Deskripsi Kualitas Bahan' }}</th>
        </tr>
        </thead>
        <tbody>
        @for($i = 0; $i < 3; $i++)
            <tr>
                <th class="ui center aligned" width="5%">
                    {{ $i + 1 }}
                </th>

                <td width="10%">
                    <div class="form-group has-feedback">
                        <input name="{{'kode_panel_'.$i}}" value="{{ $f->{'kode_panel_'.$i} ?? '' }}" type="text" class="form-control">
                    </div>
                </td>

                <td width="15%">
                    <div class="form-group">
                        @php
                            $kualitas_bahan = isset($f->{'kualtias_bahan_'.$i}) ? $f->{'kualtias_bahan_'.$i} : '';
                        @endphp

                        <select name="{{'kualtias_bahan_'.$i}}" class="ui search fluid dropdown" style="width: 100%;" tabindex="-1" aria-hidden="true">
                            <option selected="selected" value="">-- Pilih --</option>
                            @foreach($daftar_pilihan_kualitas_bahan as $pilihan_kualitas_bahan)
                                <option value="{{ $pilihan_kualitas_bahan->value }}" @if($kualitas_bahan == $pilihan_kualitas_bahan->value) selected @endif>{{ $pilihan_kualitas_bahan->text }}</option>
                            @endforeach
                        </select>
                    </div>
                </td>

                <td width="60%">
                    <div class="form-group has-feedback">
                        <input name="{{'deskripsi_kualitas_bahan_'.$i}}" value="{{ $f->{'deskripsi_kualitas_bahan_'.$i} ?? '' }}" type="text" class="form-control">
                    </div>
                </td>
            </tr>
        @endfor
        </tbody>
    </table>

    <table class="table ui celled">
        <thead>
        <tr>
            <th class="ui center aligned" width="20%">{{ 'Metode Pemeriksaan' }}</th>
            <th class="ui center aligned" width="20%">{{ 'Nama Reagen' }}</th>
            <th class="ui center aligned" width="20%">{{ 'Nama Produsen' }}</th>
            <th class="ui center aligned" width="20%">{{ 'Nama Lot / Batch' }}</th>
            <th class="ui center aligned" width="20%">{{ 'Tanggal Kadaluarsa' }}</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <div class="form-group">

                    @php
                        $selected_metode = isset($f->metode_rpr) ? $f->metode_rpr : '';
                    @endphp
                    <select name="metode_rpr" class="ui search fluid dropdown" style="width: 100%;" tabindex="-1" aria-hidden="true">
                        <option selected="selected" value="">-- Pilih --</option>
                        @foreach($daftar_pilihan_metode_rpr as $pilihan_metode)
                            <option value="{{ $pilihan_metode->value }}" @if($selected_metode == $pilihan_metode->value) selected @endif>{{ $pilihan_metode->text }}</option>
                        @endforeach
                    </select>
                </div>
            </td>
            <td>
                <div class="form-group has-feedback">
                    <input title="Nama Reagen" type="text" class="form-control" name="{{ 'nama_reagen_rpr' }}" value="{{ $f->nama_reagen_rpr ?? '' }}">
                </div>
            </td>
            </td>
            <td>
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="{{'nama_produsen_reagen_rpr'}}" value="{{ $f->nama_produsen_reagen_rpr ?? '' }}">
                </div>
            </td>
            <td>
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="{{'lot_reagen_rpr'}}" value="{{$f->lot_reagen_rpr ?? ''}}">
                </div>
            </td>
            <td>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input name="{{'tanggal_kadaluarsa_rpr'}}" value="{{$f->tanggal_kadaluarsa_rpr ?? ''}}" class="form-control pull-right" id="tanggal_kadaluarsa" type="date">
                </div>
            </td>
        </tr>
        </tbody>
    </table>

    <table class="table ui celled">
        <thead>
        <tr>
            <th class="ui center aligned" width="4%">Panel</th>
            <th width="32%" class="ui center aligned">{{ 'Interpretasi Hasil' }}</th>
            <th width="32%" class="ui center aligned">{{ 'Titer' }}</th>
        </tr>
        </thead>
        <tbody>
        @for($i = 0; $i < 3; $i++)
            <tr>
                <th class="ui center aligned">{{ $i + 1 }}</th>
                <td>
                    <div class="form-group">
                        @php
                            $hasil = isset($f->{'hasil_semi_kuantitatif_'.$i}) ? $f->{'hasil_semi_kuantitatif_'.$i} : '';
                        @endphp
                        <select name="{{'hasil_semi_kuantitatif_'.$i}}" class="ui search dropdown fluid" style="width: 100%;" tabindex="-1" aria-hidden="true">
                            <option selected="selected" value="">-- Pilih --</option>
                            @foreach($daftar_pilihan_interpretasi_hasil as $pilihan_interpretasi_hasil)
                                <option value="{{ $pilihan_interpretasi_hasil->value }}" @if($hasil == $pilihan_interpretasi_hasil->value) selected @endif>{{ $pilihan_interpretasi_hasil->text }}</option>
                            @endforeach
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        @php
                            $titer = isset($f->{'titer_'.$i}) ? $f->{'titer_'.$i} : '';
                        @endphp
                        <select name="{{'titer_'.$i}}" class="ui search dropdown fluid" style="width: 100%;" tabindex="-1" aria-hidden="true">
                            <option selected="selected" value="">-- Pilih --</option>
                            @foreach($daftar_pilihan_titer_rpr as $pilihan_titer)
                                <option value="{{ $pilihan_titer->value }}" @if($titer == $pilihan_titer->value) selected @endif>{{ $pilihan_titer->text }}</option>
                            @endforeach
                        </select>
                    </div>
                </td>
            </tr>
        @endfor
        </tbody>
    </table>

    <div class="ui divider"></div>

    <div class="field">
        <label>{{ 'Saran' }}</label>
        <textarea class="form-control" rows="3" placeholder="Tulis saran" name="{{ 'saran' }}">{{ $f->saran ?? '' }}</textarea>
    </div>

    <div class="field">
        <label>{{ 'Nama Pemeriksa' }}</label>
        <input type="text" class="form-control" name="{{'nama_pemeriksa'}}" value="{{ $f->nama_pemeriksa ?? '' }}">
    </div>

    <div class="field">

        <label>{{ 'Kualifikasi Pemeriksa' }}</label>
        @php
            $kualifikasi_pemeriksa = isset($f->kualifikasi_pemeriksa) ? $f->kualifikasi_pemeriksa : '';
        @endphp
        <select name="{{'kualifikasi_pemeriksa'}}" class="ui search dropdown fluid" style="width: 100%;" tabindex="-1" aria-hidden="true">
            <option selected="selected" value="">-- Pilih --</option>
            @foreach($qualifications as $qualification)
                <option value="{{ $qualification->id }}" @if($kualifikasi_pemeriksa == $qualification->id) selected @endif>{{ $qualification->text }}</option>
            @endforeach
        </select>

    </div>

</form>