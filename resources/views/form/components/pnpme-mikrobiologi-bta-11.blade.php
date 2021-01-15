@php
    use Illuminate\Support\Facades\DB;

    $parameterName = 'BTA';

    $f = new stdClass();
    $order_id = request()->query('order_id');
    $filled_form = \App\Submit::query()->where('order_id', '=', $order_id)->get()->first();
    if ($filled_form->value != null) {
        $f = json_decode($filled_form->value);
    }

    $packageInjectData = \App\Package::query()->where('name', 'pnpme-mikrobiologi-bta-3')->get()->first();
    $injects = $packageInjectData->injects()->get();

    $package = $filled_form->order->package;
    $parameters = $package->parameters;
    $cycle = $package->cycle;

    $table_kualifikasi_pemeriksa = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualifikasi Pemeriksa'; })->first()->option->table_name;
    $qualifications = DB::table($table_kualifikasi_pemeriksa)->get();
@endphp

<div class="ui warning message">
    <h4>Peringatan!</h4>

    <ul>
        <li>Diharapkan untuk mengisi kode sediaan dari yang terkecil hingga yang terbesar.</li>
    </ul>
</div>

<h3 class="ui horizontal divider header">
    Formulir Hasil Bidang Mikrobiologi Parameter {{ $parameterName }}
</h3>

<form id="submit-form" class="ui form" method="post" action="{{ $route }}">

    @csrf

    <div class="ui two fields">
        <div class="ui field">
            <label for="tanggal_penerimaan">{{ 'Tanggal Penerimaan' }}</label>

            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input class="form-control pull-right" id="tanggal_penerimaan" type="date" name="tanggal_penerimaan" value="{{ $f->tanggal_penerimaan ?? '' }}">
            </div>
        </div>

        <div class="ui field">
            <label for="tanggal_pemeriksaan">{{ 'Tanggal Pemeriksaan' }}</label>

            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input class="form-control pull-right" id="tanggal_pemeriksaan" type="date" name="tanggal_pemeriksaan" value="{{ $f->tanggal_pemeriksaan ?? '' }}">
            </div>
        </div>
    </div>

    <div class="ui two fields">
        <div class="ui field">
            @php
                $kualitas_bahan = isset($f->{'kualitas_bahan'}) ? $f->{'kualitas_bahan'} : '';
            @endphp
            <label for="kualitas_bahan">{{ 'Kualitas Bahan' }}</label>
            <select id="kualitas_bahan" name="kualitas_bahan" class="ui select search dropdown fluid" style="width: 100%;" tabindex="-1" aria-hidden="true">
                <option selected value="">Pilih Kualitas Bahan</option>
                <option value="baik" @if($kualitas_bahan == 'baik') selected @endif>Baik</option>
                <option value="kurang_baik" @if($kualitas_bahan == 'kurang_baik') selected @endif>Kurang Baik</option>
            </select>
        </div>

        <div class="ui field">
            <label for="deskripsi_keterangan_bahan">{{ 'Deskripsi Kondisi Bahan' }}</label>
            <input placeholder="Deskripsi Kondisi Bahan" type="text" class="form-control" id="deskripsi_keterangan_bahan" name="deskripsi_keterangan_bahan" value="{{ $f->{'deskripsi_keterangan_bahan'} ?? '' }}">
        </div>
    </div>

    <table class="ui table">

        <thead>

        <tr>

            <th width="50%" class="center aligned">Kode Sediaan</th>

            <th width="50%" class="center aligned">Hasil Pemeriksaan oleh Lab Peserta</th>

        </tr>

        </thead>

        <tbody>

        @for ($i = 0; $i < 10; $i++)

            <tr>

                <td>
                    <input placeholder="Kode Sediaan" type="text" class="form-control" id="kode_sediaan" name="{{'kode_sediaan_'.$i}}" value="{{ $f->{'kode_sediaan_' . $i} ?? '' }}">
                </td>

                <td>
                    @php
                        $hasil = isset($f->{'hasil_'.$i}) ? $f->{'hasil_'.$i} : '';
                    @endphp
                    <select class="ui select search dropdown fluid" style="width: 100%;" tabindex="-1" aria-hidden="true" name="{{ 'hasil_'.$i }}" title="Hasil Pemeriksaan oleh Lab Peserta">
                        <option selected value="">Hasil Pemeriksaan oleh Lab Peserta</option>
                        <option value="negatif" @if($hasil == 'negatif') selected @endif>Negatif</option>
                        <option value="scanty" @if($hasil == 'scanty') selected @endif>{{ 'Scanty' }}</option>
                        <option value="1+" @if($hasil == '1+') selected @endif>1+</option>
                        <option value="2+" @if($hasil == '2+') selected @endif>2+</option>
                        <option value="3+" @if($hasil == '3+') selected @endif>3+</option>
                    </select>
                </td>

            </tr>

        @endfor

        </tbody>

    </table>

    <div class="ui divider"></div>

    <div class="ui field">
        <label>{{ 'Saran' }}</label>
        <textarea class="form-control" rows="3" placeholder="Tulis saran" name="saran">{{ $f->saran ?? '' }}</textarea>
    </div>

    <div class="ui field">
        <label for="nama_pemeriksa">{{ 'Nama Pemeriksa' }}</label>
        <input type="text" class="form-control" id="nama_pemeriksa" name="nama_pemeriksa" value="{{ $f->nama_pemeriksa ?? '' }}">
    </div>

    <div class="ui field">
        @php
            $kualifikasi_pemeriksa = isset($f->kualifikasi_pemeriksa) ? $f->kualifikasi_pemeriksa : '';
        @endphp
        <label>{{ 'Kualifikasi Pemeriksa' }}</label>
        <select class="ui select search field dropdown" style="width: 100%;" tabindex="-1" aria-hidden="true" name="kualifikasi_pemeriksa">
            <option selected="selected" value="">-- Pilih --</option>
            @foreach($qualifications as $qualification)
                <option value="{{ $qualification->id }}" @if($kualifikasi_pemeriksa == $qualification->id) selected @endif>{{ $qualification->text }}</option>
            @endforeach
        </select>
    </div>

</form>
