@php
    use Illuminate\Support\Facades\DB;

    $parameterName = 'Kultur dan Uji Kepekaan Mikro Organisme';

    $f = new stdClass();
    $order_id = request()->query('order_id');
    $filled_form = \App\Submit::query()->where('order_id', '=', $order_id)->get()->first();
    if ($filled_form->value != null) {
        $f = json_decode($filled_form->value);
    }

    $packageInjectData = \App\Package::query()->where('name', 'pnpme-mikrobiologi-kultur-3')->get()->first();
    $injects = $packageInjectData->injects()->get();

    $package = $filled_form->order->package;
    $parameters = $package->parameters;
    $cycle = $package->cycle;

    $table_kualifikasi_pemeriksa = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualifikasi Pemeriksa'; })->first()->option->table_name;
    $qualifications = DB::table($table_kualifikasi_pemeriksa)->get();

    $hint_methods = ['Kirby Bauer'];
    $hint_discs = ['Difco', 'Oxoid', 'Merck', 'Biomerioux'];
    $scores = ['Sensitif', 'Resisten', 'Intermediet'];

    //$kultur1_items = ['Ampicillin', 'Co-trimoxazole', 'Cefepime', 'Meropenem', 'Gentamicin'];
    // $kultur1_items = ['Meropenem', 'Amikacin', 'Gentamycin', 'Co-trimoxazole', 'Ciprofloxacine'];
    $kultur1_items = ['Ampicilline', 'Gentamicin', 'Amikacin', 'Ciprifloxacine', 'Levofloxacine'];

    // $kultur2_items = ['Cefepime', 'Co-trimoxazole', 'Meropenem', 'Gentamicin', 'Ciproflixacine'];
    // $kultur2_items = $kultur1_items;
    $kultur2_items = ['Ciprofloxaxine', 'Gentacimin', 'Levofloxacine', 'Penicilline', 'Erytrimicin'];

@endphp

<div class="ui warning message">
    <h4>Peringatan!</h4>

    <ul>
        <li>Diharapkan untuk mengisi kode bahan kontrol dari yang terkecil hingga yang terbesar.</li>
    </ul>
</div>

<h3 class="ui horizontal divider header">
    Formulir Hasil Bidang Mikrobiologi Parameter {{ $parameterName }}
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
                <input name="{{'tanggal_penerimaan'}}" value="{{ $f->tanggal_penerimaan ?? '' }}" class="form-control pull-right" id="tanggal_penerimaan" type="date">
            </div>
        </div>

        <div class="ui field">
            <label>{{ 'Tanggal Pemeriksaan' }}</label>

            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input name="{{'tanggal_pemeriksaan'}}" value="{{ $f->tanggal_pemeriksaan ?? '' }}" class="form-control pull-right" id="tanggal_pemeriksaan" type="date">
            </div>
        </div>

    </div>

    <div class="ui two fields">

        <div class="ui field">
            @php
                $kondisi_bahan = isset($f->kondisi_bahan) ? $f->kondisi_bahan : '';
            @endphp
            <label>{{ 'Kondisi Bahan' }}</label>
            <select name="{{'kondisi_bahan'}}" class="ui select search fluid dropdown" style="width: 100%;" tabindex="-1" aria-hidden="true">
                <option selected="selected" value="">Pilih Kondisi Bahan</option>
                <option value="baik" @if($kondisi_bahan == 'baik') selected @endif>Baik</option>
                <option value="kering" @if($kondisi_bahan == 'kering') selected @endif>Kering</option>
                <option value="pecah" @if($kondisi_bahan == 'pecah') selected @endif>Pecah</option>
                <option value="kontaminasi" @if($kondisi_bahan == 'kontamintasi') selected @endif>Kontamintasi</option>
            </select>
        </div>

        <div class="ui field">
            <label>{{ 'Deskripsi Keterangan Bahan' }}</label>
            <input placeholder="Deskripsi Keterangan Bahan" name="{{'deskripsi_keterangan_bahan'}}" value="{{$f->deskripsi_keterangan_bahan ?? ''}}" type="text" class="form-control">
        </div>

    </div>

    <div class="ui divider"></div>

    <div class="ui field">
        @php
            $selected_method = isset($f->metode_kultur) ? $f->metode_kultur : '';
        @endphp
        <label>{{ 'Metode Kultur' }}</label>
        <input type="text" class="form-control" name="{{ 'metode_kultur' }}" value="{{ $f->metode_kultur ?? '' }}">
    </div>

    <table class="ui table">

        <thead>

        <tr>

            <th width="4%" class="center aligned"></th>

            <th width="20%" class="center aligned">Kode Kultur</th>

            <th class="center aligned">Hasil Identifikasi</th>

        </tr>

        </thead>

        <tbody>

        <tr>

            <th class="center aligned">01</th>

            <td>
                <input placeholder="Kode Kultur" type="text" class="form-control" name="{{ 'kode_kultur_1' }}" value="{{ $f->kode_kultur_1  ?? '' }}">
            </td>

            <td>
                <input placeholder="Hasil Identifikasi" type="text" class="form-control" name="{{ 'hasil_identifikasi_1' }}" value="{{ $f->hasil_identifikasi_1 ?? '' }}">
            </td>

        </tr>
        <tr>

            <th class="center aligned">02</th>

            <td>
                <input placeholder="Kode Kultur" type="text" class="form-control" name="{{ 'kode_kultur_2' }}" value="{{ $f->kode_kultur_2 ?? '' }}">
            </td>

            <td>
                <input placeholder="Hasil Identifikasi" type="text" class="form-control" name="{{ 'hasil_identifikasi_2' }}" value="{{ $f->hasil_identifikasi_2 ?? '' }}">
            </td>

        </tr>
        <tr>

            <th class="center aligned">03</th>

            <td>
                <input placeholder="Kode Kultur" type="text" class="form-control" name="{{ 'kode_kultur_3' }}" value="{{ $f->kode_kultur_3 ?? '' }}">
            </td>

            <td>
                <input placeholder="Hasil Identifikasi" type="text" class="form-control" name="{{ 'hasil_identifikasi_3' }}" value="{{ $f->hasil_identifikasi_3 ?? '' }}">
            </td>

        </tr>

        </tbody>

    </table>

    <div class="ui divider"></div>

    <div class="ui two fields">
        <div class="ui field">
            @php
                $selected_method = isset($f->metode) ? $f->metode : '';
            @endphp
            <label>{{ 'Metode Resistensi' }}</label>
            <input type="text" class="form-control" name="{{ 'metode' }}" value="{{ $f->metode ?? '' }}">
        </div>

        <div class="ui field">
            @php
                $selected_disk = isset($f->disk) ? $f->disk : '';
            @endphp
            <label>{{ 'Disk Antibiotik yang Digunakan' }}</label>
            <select name="{{ 'disk' }}" class="ui select search fluid dropdown" style="width: 100%;" tabindex="-1" aria-hidden="true">
                <option selected="selected" value="">-- Pilih atau tuliskan --</option>
                @foreach($hint_discs as $disc)
                    <option>{{ $disc }}</option>
                @endforeach
                @if(in_array($selected_disk, $hint_discs))
                    <option selected>{{ $selected_disk }}</option>
                @endif
            </select>
        </div>
    </div>

    <div class="ui divider"></div>

    <div class="ui grid">

        <div class="ui eight wide column">

            <table class="ui table">
                <thead>
                <tr>
                    <th colspan="2">Hasil Uji Kepekaan Kultur 01</th>
                </tr>
                </thead>
                <tbody>
                @foreach($kultur1_items as $item)
                    <tr>
                        <td width="40%">{{ $item }}</td>
                        <td>
                            @php

                                $selected_score = isset($f->{'hasil_kultur_1_obat_'.$item}) ? $f->{'hasil_kultur_1_obat_'.$item} : '';

                            @endphp

                            <select name="{{'hasil_kultur_1_obat_'.$item }}" class="ui select search fluid dropdown" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option selected="selected" value="">-- Pilih --</option>
                                @foreach($scores as $score)
                                    <option @if($selected_score == $score) selected @endif>{{ $score }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>

        <div class="ui eight wide column">

            <table class="ui table">
                <thead>
                <tr>
                    <th colspan="2">Hasil Uji Kepekaan Kultur 02</th>
                </tr>
                </thead>
                <tbody>
                @foreach($kultur2_items as $item)
                    <tr>
                        <td width="40%">{{ $item }}</td>
                        <td>
                            @php

                                $selected_score = isset($f->{'hasil_kultur_2_obat_'.$item}) ? $f->{'hasil_kultur_2_obat_'.$item} : '';

                            @endphp

                            <select name="{{'hasil_kultur_2_obat_'.$item }}" class="ui select search fluid dropdown" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option selected="selected" value="">-- Pilih --</option>
                                @foreach($scores as $score)
                                    <option @if($selected_score == $score) selected @endif>{{ $score }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>

    </div>

    <div class="ui divider"></div>

    <div class="ui field">
        <label>{{ 'Saran' }}</label>
        <textarea class="form-control" rows="3" placeholder="Tulis saran" name="{{ 'saran' }}">{{ $f->saran ?? '' }}</textarea>
    </div>

    <div class="ui field">
        <label>{{ 'Nama Pemeriksa' }}</label>
        <input placeholder="Tulis nama pemeriksa" type="text" class="form-control" name="{{ 'nama_pemeriksa' }}" value="{{ $f->nama_pemeriksa ?? '' }}">
    </div>

    <div class="ui field">
        @php
            $kualifikasi_pemeriksa = isset($f->kualifikasi_pemeriksa) ? $f->kualifikasi_pemeriksa : '';
        @endphp
        <label>{{ 'Kualifikasi Pemeriksa' }}</label>
        <select class="ui select search dropdown fluid" style="width: 100%;" tabindex="-1" aria-hidden="true" name="kualifikasi_pemeriksa">
            <option selected="selected" value="">Pilih Kualifikasi Pemeriksa</option>
            @foreach($qualifications as $qualification)
                <option value="{{ $qualification->id }}" @if($kualifikasi_pemeriksa == $qualification->id) selected @endif>{{ $qualification->text }}</option>
            @endforeach
        </select>
    </div>

</form>
