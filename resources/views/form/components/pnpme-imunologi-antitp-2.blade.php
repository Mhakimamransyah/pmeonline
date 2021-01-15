@php
    use Illuminate\Support\Facades\DB;

    $parameterName = 'Anti TP';

    $f = new stdClass();
    $order_id = request()->query('order_id');
    $filled_form = \App\Submit::query()->where('order_id', '=', $order_id)->get()->first();
    if ($filled_form->value != null) {
        $f = json_decode($filled_form->value);
    }

    $injects = $filled_form->order->package->injects()->get();

    $table_kualifikasi_pemeriksa = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualifikasi Pemeriksa'; })->first()->option->table_name;
    $qualifications = DB::table($table_kualifikasi_pemeriksa)->get();

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
        <div class="ui field">
            <label>{{ 'Tanggal Penerimaan' }}</label>

            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input name="tanggal_penerimaan" value="{{$f->tanggal_penerimaan ?? ''}}" class="form-control pull-right" id="tanggal_penerimaan" type="date">
            </div>
        </div>

        <div class="ui field">
            <label>{{ 'Tanggal Pemeriksaan' }}</label>

            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input name="tanggal_pemeriksaan" value="{{$f->tanggal_pemeriksaan ?? ''}}" class="form-control pull-right" id="tanggal_pemeriksaan" type="date">
            </div>
        </div>
    </div>

    <table class="ui table">
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
                <th width="5%" class="center aligned">
                    {{ $i + 1 }}
                </th>

                <td width="10%" class="center aligned">
                    <div class="form-group has-feedback">
                        <input placeholder="Kode Panel" name="{{'kode_panel_'.$i}}" value="{{ $f->{'kode_panel_'.$i} ?? '' }}" type="text" class="form-control">
                    </div>
                </td>

                <td width="15%" class="center aligned">
                    <div class="form-group">
                        @php
                            $kualitas_bahan = isset($f->{'kualtias_bahan_'.$i}) ? $f->{'kualtias_bahan_'.$i} : '';
                        @endphp

                        <select name="{{'kualtias_bahan_'.$i}}" class="ui select search dropdown fluid" style="width: 100%;" tabindex="-1" aria-hidden="true">
                            <option selected="selected" value="">Kualitas Bahan</option>
                            <option value="baik" @if($kualitas_bahan == 'baik') selected @endif>Baik</option>
                            <option value="keruh" @if($kualitas_bahan == 'keruh') selected @endif>Keruh</option>
                            <option value="lain-lain" @if($kualitas_bahan == 'lain-lain') selected @endif>Lain-Lain</option>
                        </select>
                    </div>
                </td>

                <td width="60%" class="center aligned">
                    <div class="form-group has-feedback">
                        <input placeholder="Deskripsi Kualitas Bahan" name="{{'deskripsi_kualitas_bahan_'.$i}}" value="{{ $f->{'deskripsi_kualitas_bahan_'.$i} ?? '' }}" type="text" class="form-control">
                    </div>
                </td>
            </tr>
        @endfor
        </tbody>
    </table>

    <table class="ui table">
        <thead>
        <tr>
            <th width="20%" class="center aligned">{{ 'Metode Pemeriksaan' }}</th>
            <th width="20%" class="center aligned">{{ 'Nama Reagen' }}</th>
            <th width="20%" class="center aligned">{{ 'Nama Produsen' }}</th>
            <th width="20%" class="center aligned">{{ 'Nama Lot / Batch' }}</th>
            <th width="20%" class="center aligned">{{ 'Tanggal Kadaluarsa' }}</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="center aligned">
                <div class="form-group">

                    @php
                        $selected_metode = isset($f->metode) ? $f->metode : '';
                    @endphp
                    <select name="metode" class="ui select search fluid dropdown" style="width: 100%;" tabindex="-1" aria-hidden="true">
                        <option selected="selected" value="">Metode Pemeriksaan</option>
                        <option value="rapid" @if($selected_metode == 'rapid') selected @endif>Rapid</option>
                        <option value="eia_elfa" @if($selected_metode == 'eia_elfa') selected @endif>EIA</option>
                        <option value="algutinasi" @if($selected_metode == 'algutinasi') selected @endif>Aglutinasi</option>
                    </select>
                </div>
            </td>
            <td class="center aligned">
                <div class="form-group has-feedback">
                    <input placeholder="Nama Reagen" type="text" class="form-control" name="{{ 'nama_reagen' }}" value="{{ $f->nama_reagen ?? '' }}">
                </div>
            </td>
            <td class="center aligned">
                <div class="form-group has-feedback">
                    <input  placeholder="Nama Produsen" type="text" class="form-control" name="{{'nama_produsen_reagen'}}" value="{{ $f->nama_produsen_reagen ?? '' }}">
                </div>
            </td>
            <td class="center aligned">
                <div class="form-group has-feedback">
                    <input placeholder="Nama Lot / Batch" type="text" class="form-control" name="{{'lot_reagen'}}" value="{{$f->lot_reagen ?? ''}}">
                </div>
            </td>
            <td class="center aligned">
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input name="{{'tanggal_kadaluarsa'}}" value="{{$f->tanggal_kadaluarsa ?? ''}}" class="form-control pull-right" id="tanggal_kadaluarsa" type="date">
                </div>
            </td>
        </tr>
        </tbody>
    </table>

    <h4 class="ui divider horizontal header">Kualitatif</h4>

    <table class="ui table">
        <thead>
        <tr>
            <th width="4%" class="center aligned">Panel</th>
            <th width="19%" class="center aligned">{{ 'Abs atau OD (A) (Bila dengan EIA)' }}</th>
            <th width="19%" class="center aligned">{{ 'Cut off (B) (Bila dengan EIA)' }}</th>
            <th width="19%" class="center aligned">{{ 'S/CO (A:B) atau true value (TV) atau Indek (Bila dengan EIA)' }}</th>
            <th class="center aligned">{{ 'Interpretasi Hasil' }}</th>
        </tr>
        </thead>
        <tbody>
        @for($i = 0; $i < 3; $i++)
            <tr>
                <th>{{ $i + 1 }}</th>
                <td>
                    <div class="form-group has-feedback">
                        <input name="{{'kualitatif_abs_'. $i}}" value="{{ $f->{'kualitatif_abs_'. $i} ?? '' }}" type="text" class="form-control">
                    </div>
                </td>
                <td>
                    <div class="form-group has-feedback">
                        <input name="{{'kualitatif_cut_'. $i}}" value="{{ $f->{'kualitatif_cut_'. $i} ?? '' }}" type="text" class="form-control">
                    </div>
                </td>
                <td>
                    <div class="form-group has-feedback">
                        <input name="{{'kualitatif_sco_'. $i}}" value="{{ $f->{'kualitatif_sco_'. $i} ?? '' }}" type="text" class="form-control">
                    </div>
                </td>
                <td>
                    <div class="form-group">

                        @php

                            $hasil = isset($f->{'hasil_'. $i}) ? $f->{'hasil_'. $i} : '';

                        @endphp
                        <select name="{{'hasil_'.$i}}" class="ui select search fluid dropdown" style="width: 100%;" tabindex="-1" aria-hidden="true">
                            <option selected="selected" value="">Interpretasi Hasil</option>
                            <option value="reaktif" @if($hasil == 'reaktif') selected @endif>Reaktif</option>
                            <option value="nonreaktif" @if($hasil == 'nonreaktif') selected @endif>Nonreaktif</option>
                        </select>
                    </div>
                </td>
            </tr>
        @endfor
        </tbody>
    </table>

    <h4 class="ui divider horizontal header">Semi Kuantitatif</h4>

    <table class="ui table">
        <thead>
        <tr>
            <th width="4%" class="center aligned">Panel</th>
            <th width="32%" class="center aligned">{{ 'Interpretasi Hasil' }}</th>
            <th width="32%" class="center aligned">{{ 'Titer' }}</th>
        </tr>
        </thead>
        <tbody>
        @for($i = 0; $i < 3; $i++)
            <tr>
                <th class="center aligned">{{ $i + 1 }}</th>
                <td>
                    <div class="form-group">
                        @php
                            $hasil = isset($f->{'hasil_semi_kuantitatif_'.$i}) ? $f->{'hasil_semi_kuantitatif_'.$i} : '';
                        @endphp
                        <select name="{{'hasil_semi_kuantitatif_'.$i}}" class="ui select search fluid dropdown" style="width: 100%;" tabindex="-1" aria-hidden="true">
                            <option selected="selected" value="">Interpretasi Hasil</option>
                            <option value="reaktif" @if($hasil == 'reaktif') selected @endif>Reaktif</option>
                            <option value="nonreaktif" @if($hasil == 'nonreaktif') selected @endif>Nonreaktif</option>
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        @php
                            $titer = isset($f->{'titer_'.$i}) ? $f->{'titer_'.$i} : '';
                            $optionsTiter = ['1/80', '1/160', '1/320', '1/640', '1/1280', '1/2560', '1/5120', '1/10240'];
                        @endphp
                        <select name="{{'titer_'.$i}}" class="ui select search fluid dropdown" style="width: 100%;" tabindex="-1" aria-hidden="true">
                            <option selected="selected" value="">Titer</option>
                            @foreach($optionsTiter as $itemTiter)
                                <option value="{{ $itemTiter }}" @if($titer == $itemTiter) selected @endif>{{ $itemTiter }}</option>
                            @endforeach
                        </select>
                    </div>
                </td>
            </tr>
        @endfor
        </tbody>
    </table>

    <div class="ui divider horizontal"></div>

    <div class="ui field">
        <label>{{ 'Saran' }}</label>
        <textarea class="form-control" rows="3" placeholder="Tulis saran" name="{{ 'saran' }}">{{ $f->saran ?? '' }}</textarea>
    </div>

    <div class="ui field">
        <label>{{ 'Nama Pemeriksa' }}</label>
        <input placeholder="Nama Pemeriksa" type="text" class="form-control" name="{{'nama_pemeriksa'}}" value="{{ $f->nama_pemeriksa ?? '' }}">
    </div>

    <div class="ui field">
        <label>{{ 'Kualifikasi Pemeriksa' }}</label>
        @php
            $kualifikasi_pemeriksa = isset($f->kualifikasi_pemeriksa) ? $f->kualifikasi_pemeriksa : '';
        @endphp
        <select name="{{'kualifikasi_pemeriksa'}}" class="ui select search fluid dropdown" style="width: 100%;" tabindex="-1" aria-hidden="true">
            <option selected="selected" value="">Kualifikasi Pemeriksa</option>
            @foreach($qualifications as $qualification)
                <option value="{{ $qualification->id }}" @if($kualifikasi_pemeriksa == $qualification->id) selected @endif>{{ $qualification->text }}</option>
            @endforeach
        </select>
    </div>

</form>
