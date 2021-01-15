@php
    use Illuminate\Support\Facades\DB;

    $parameterName = 'Telur Cacing';

    $f = new stdClass();
    $order_id = request()->query('order_id');
    $submit = \App\Submit::query()->where('order_id', '=', $order_id)->get()->first();
    if ($submit->value != null) {
        $f = json_decode($submit->value);
    }

    $packageInjectData = \App\Package::query()->where('name', 'pnpme-mikrobiologi-telurcacing-3')->get()->first();
    $injects = $packageInjectData->injects()->get();

    $package = $submit->order->package;
    $parameters = $package->parameters;
    $cycle = $package->cycle;

    $table_kualifikasi_pemeriksa = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualifikasi Pemeriksa'; })->first()->option->table_name;
    $qualifications = DB::table($table_kualifikasi_pemeriksa)->get();

    // $cacings = [''];
    $cacings = [
        'Negatif',
        'Telur cacing Ascaris lumbricoides (+)',
        'Telur cacing Tambang (+)',
        'Telur cacing Trichuris trichiura (+)',
        'Telur cacing Oxyuris vermicularis (+)',
        'Telur cacing Taenia saginata (+)',
        'Telur cacing Taenia solium (+)',
    ];
@endphp

<div class="ui warning message">
    <h4>Peringatan!</h4>

    <ul>
        <li>Pengisian jenis telur cacing bisa diisi lebih dari satu jenis.</li>
        <li>Diharapkan untuk mengisi kode bahan kontrol dari nomor  bahan kontrol yang terkecil hingga terbesar.</li>
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
                <input class="form-control pull-right" id="tanggal_penerimaan" type="date" name="{{ 'tanggal_penerimaan' }}" value="{{ $f->tanggal_penerimaan ?? '' }}">
            </div>
        </div>

        <div class="ui field">
            <label for="tanggal_penerimaan">{{ 'Tanggal Pemeriksaan' }}</label>

            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input class="form-control pull-right" id="tanggal_penerimaan" type="date" name="{{ 'tanggal_pemeriksaan' }}" value="{{ $f->tanggal_pemeriksaan ?? '' }}">
            </div>
        </div>

    </div>

    <div class="ui two fields">
        <div class="ui field">
            @php
                $kondisi_bahan = isset($f->kondisi_bahan) ? $f->kondisi_bahan : '';
            @endphp
            <label for="'kondisi_bahan">{{ 'Kondisi Bahan' }}</label>
            <select id="'kondisi_bahan" name="kondisi_bahan" class="ui select search fluid dropdown" style="width: 100%;" tabindex="-1" aria-hidden="true">
                <option selected value="">Pilih Kondisi Bahan</option>
                <option value="baik" @if($kondisi_bahan == 'baik') selected @endif>Baik</option>
                <option value="kurang" @if($kondisi_bahan == 'kurang') selected @endif>Kurang Baik</option>
            </select>
        </div>

        <div class="ui field">
            <label for="deskripsi_keterangan_bahan">{{ 'Deskripsi Keterangan Bahan' }}</label>
            <input placeholder="Deskripsi Keterangan Bahan" type="text" class="form-control" id="deskripsi_keterangan_bahan" name="deskripsi_keterangan_bahan" value="{{ $f->deskripsi_keterangan_bahan ?? '' }}">
        </div>
    </div>

    <table class="ui table">

        <thead>

        <tr>

            <th width="5%" class="center aligned">No.</th>

            <th width="20%" class="center aligned">Kode Sediaan</th>

            <th class="center aligned">Hasil Pemeriksaan oleh Lab Peserta</th>

        </tr>

        </thead>

        <tbody>

        @for ($i = 0; $i < 3; $i++)

            <tr>

                <th class="center aligned">{{ $i + 1 }}</th>

                <td>
                    <input placeholder="Kode Sediaan" type="text" class="form-control" title="Kode Sediaan" name="{{ 'kode_sediaan_' . $i }}" value="{{ $f->{'kode_sediaan_'.$i} ?? '' }}">
                </td>

                <td>
                    @php
                        $hasil = isset($f->{'hasil_'.$i}) ? $f->{'hasil_'.$i} : array();
                        $moreHasil = array_diff($hasil, $cacings);
                    @endphp
                    <select title="Hasil Pemeriksaan oleh Lab Peserta" class="ui select search dropdown fluid" style="width: 100%;" tabindex="-1" aria-hidden="true" multiple name="{{ 'hasil_' . $i }}[]">
                        @foreach($cacings as $cacing)
                            <option @if(in_array($cacing, $hasil)) selected @endif>{{ $cacing }}</option>
                        @endforeach
                        @foreach($moreHasil as $item)
                            <option selected>{{ $item }}</option>
                        @endforeach
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
        <input placeholder="Tulis nama pemeriksa" id="nama_pemeriksa" name="nama_pemeriksa" type="text" class="form-control" value="{{ $f->nama_pemeriksa ?? '' }}">
    </div>

    <div class="ui field">
        @php
            $qualificationValue = isset($f->kualifikasi_pemeriksa) ? $f->kualifikasi_pemeriksa : '';
        @endphp
        <label for="kualifikasi_pemeriksa">{{ 'Kualifikasi Pemeriksa' }}</label>
        <select class="ui select search fluid dropdown" style="width: 100%;" tabindex="-1" aria-hidden="true" name="kualifikasi_pemeriksa" id="kualifikasi_pemeriksa">
            <option selected value="">Pilih Kualifikasi</option>
            @foreach($qualifications as $qualification)
                <option value="{{ $qualification->id }}" @if($qualification->id == $qualificationValue) selected @endif>{{ $qualification->text }}</option>
            @endforeach
        </select>
    </div>

</form>
