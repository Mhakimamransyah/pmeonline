@php
    $submit = \App\Submit::query()->where('order_id', '=', request('order_id'))->get()->first();

    $injects = $submit->order->package->injects()->get();

    $package = $submit->order->package;
    $parameters = $package->parameters;
    $parameterName = $package->label;
    $cycle = $package->cycle;

    $table_kualifikasi_pemeriksa = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualifikasi Pemeriksa'; })->first()->option->table_name;
    $qualifications = DB::table($table_kualifikasi_pemeriksa)->get();

    $f = new stdClass();
    if ($submit->value != null) {
        $f = json_decode($submit->value);
    }
@endphp

<h3 class="ui horizontal divider header">
    Formulir Hasil Bidang {{ $parameterName }}
</h3>

<form id="submit-form" class="ui form" method="post" action="{{ $route }}">

    @csrf

    <div class="ui three fields">
        <div class="ui field">
            <label>{{ 'Kode Kemasan' }}</label>
            <input placeholder="Tulis kode kemasan" name="{{'kode_bahan_kontrol'}}" value="{{ $f->kode_bahan_kontrol ?? '' }}" type="text" class="form-control">
        </div>

        <div class="ui field">
            <label>{{ 'Tanggal Penerimaan' }}</label>
            <input name="{{'tanggal_penerimaan'}}" value="{{ $f->tanggal_penerimaan ?? '' }}" class="form-control pull-right" id="tanggal_penerimaan" type="date">
        </div>

        <div class="ui field">
            <label>{{ 'Tanggal Pemeriksaan' }}</label>
            <input name="{{'tanggal_pemeriksaan'}}" value="{{ $f->tanggal_pemeriksaan ?? '' }}" class="form-control pull-right" id="tanggal_pemeriksaan" type="date">
        </div>
    </div>

    <div class="ui two fields">

        <div class="ui field">
            @php
                $kondisi_kemasan_luar = isset($f->kondisi_kemasan_luar) ? $f->kondisi_kemasan_luar : ''
            @endphp
            <label>{{ 'Kondisi Kemasan Luar' }}</label>
            <select name="{{'kondisi_kemasan_luar'}}" class="ui select search field dropdown" style="width: 100%;" tabindex="-1" aria-hidden="true">
                <option selected="selected" value="">Kondisi kemasan luar</option>
                <option value="baik" @if($kondisi_kemasan_luar == 'baik') selected @endif>Baik</option>
                <option value="bocor" @if($kondisi_kemasan_luar == 'bocor') selected @endif>Bocor</option>
                <option value="basah" @if($kondisi_kemasan_luar == 'basah') selected @endif>Basah</option>
            </select>
        </div>

        <div class="ui field">
            @php
                $kondisi_bahan_uji = isset($f->kondisi_bahan_uji) ? $f->kondisi_bahan_uji : ''
            @endphp
            <label>{{ 'Kondisi Bahan Uji' }}</label>
            <select name="{{ 'kondisi_bahan_uji' }}" class="ui select search dropdown field" style="width: 100%;" tabindex="-1" aria-hidden="true">
                <option selected="selected" value="">Kondisi Bahan Uji</option>
                <option value="baik" @if($kondisi_bahan_uji == 'baik') selected @endif>Baik</option>
                <option value="bocor" @if($kondisi_bahan_uji == 'bocor') selected @endif>Bocor</option>
                <option value="basah" @if($kondisi_bahan_uji == 'basah') selected @endif>Basah</option>
            </select>
        </div>

    </div>

    <table class="ui table">

        <thead>

        <tr>

            <th width="25%" class="center aligned">Parameter</th>

            <th width="25%" class="center aligned">Hasil Pengujian</th>

            <th width="25%" class="center aligned"><i>U* <small>Ketidakpastian</small></i></th>

            <th width="25%" class="center aligned">Metode</th>

        </tr>

        </thead>

        <tbody>

        @foreach($parameters as $parameter)

            <tr>

                <th class="center aligned">{{ $parameter->label }} <input hidden name="{{'parameter'}}" value="{{$parameter->label}}"></th>

                <td>
                    <div class="ui fluid right labeled input">
                        <input placeholder="Hasil Pengujian" name="{{ 'hasil_pengujian_' . $parameter->label }}" value="{{ $f->{str_replace(' ', '_', 'hasil_pengujian_'.$parameter->label)} ?? '' }}" type="number" step="any" class="form-control">
                        <div class="ui label">
                            ppm
                        </div>
                    </div>
                </td>

                <td>
                    <div class="ui fluid labeled input">
                        <div class="ui label">
                            ±
                        </div>
                        <input placeholder="U*" type="text" class="form-control" name="{{ 'ketidakpastian_' . $parameter->label }}" value="{{ $f->{str_replace(' ', '_', 'ketidakpastian_'.$parameter->label)} ?? '' }}">
                    </div>
                </td>

                <td>
                    <div class="form-group">
                        <input placeholder="Metode" type="text" class="form-control" name="{{ 'metode_' . $parameter->label }}" value="{{ $f->{str_replace(' ', '_', 'metode_'.$parameter->label)} ?? '' }}">
                    </div>
                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

    <div class="ui field">
        <label>{{ 'Saran' }}</label>
        <textarea class="form-control" rows="3" placeholder="Tulis saran" name="{{'saran'}}">{{ $f->saran ?? '' }}</textarea>
    </div>

    <div class="ui field">
        <label>{{ 'Nama Pemeriksa' }}</label>
        <input placeholder="Tulis nama pemeriksa" type="text" class="form-control" name="nama_pemeriksa" value="{{ $f->nama_pemeriksa ?? '' }}">
    </div>

</form>
