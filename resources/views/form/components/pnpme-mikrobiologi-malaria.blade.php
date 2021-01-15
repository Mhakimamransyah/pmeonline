@php
    use Illuminate\Support\Facades\DB;

    $parameterName = 'Malaria';

    $f = new stdClass();
    $order_id = request()->query('order_id');
    $filled_form = \App\Submit::query()->where('order_id', '=', $order_id)->get()->first();
    if ($filled_form->value != null) {
        $f = json_decode($filled_form->value);
    }

    $injects = $filled_form->order->package->injects()->get();

    $table_kualifikasi_pemeriksa = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualifikasi Pemeriksa'; })->first()->option->table_name;
    $qualifications = DB::table($table_kualifikasi_pemeriksa)->get();

    $useSelect2 = true;
    $useIcheck = true;
    $cycle = \App\Cycle::first();
    $parameter = "Mikrobiologi - Malaria";
    $malarias = ['Plasmodium falciparum', 'Plasmodium vivax', 'Plasmodium malariae', 'Plasmodium ovale'];
    $stadiums = ['Tropozoit', 'Schizont', 'Gametosit'];

    $definedOptions = array();
    array_push($definedOptions, 'Negatif');
    foreach($malarias as $malaria)
    {
        foreach($stadiums as $stadium)
        {
            array_push($definedOptions, $malaria . ' stadium ' . $stadium);
        }
    }
@endphp

<div class="ui warning message">
    <h4>Peringatan!</h4>

    <ul>
        <li>Pengisian jenis stadium bisa diisi lebih dari satu jenis.</li>
        <li>Kolom kepadatan parasit hanya diisi pada slide yang positif malaria.</li>
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
            <label>{{ 'Tanggal Penerimaan' }}</label>

            @php
                $tanggal_penerimaan = isset($f->tanggal_penerimaan) ? $f->tanggal_penerimaan : '';
            @endphp

            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input class="form-control pull-right" id="tanggal_penerimaan" type="date" name="tanggal_penerimaan" value="{{ $tanggal_penerimaan }}">
            </div>
        </div>

        <div class="ui field">
            <label>{{ 'Tanggal Pemeriksaan' }}</label>

            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                @php
                    $tanggal_pemeriksaan = isset($f->tanggal_pemeriksaan) ? $f->tanggal_pemeriksaan : '';
                @endphp
                <input class="form-control pull-right" id="tanggal_pemeriksaan" type="date" name="tanggal_pemeriksaan" value="{{ $tanggal_pemeriksaan }}">
            </div>
        </div>

    </div>

    <div class="ui two fields">

        @php
            $kondisi_bahan = isset($f->kondisi_bahan) ? $f->kondisi_bahan : '';
        @endphp

        <div class="ui field">
            <label>{{ 'Kondisi Bahan' }}</label>
            <select class="ui select search fluid dropdown" style="width: 100%;" tabindex="-1" aria-hidden="true" name="kondisi_bahan">
                <option selected="selected" value="">Pilih Kondisi Bahan</option>
                <option value="baik" @if($kondisi_bahan == 'baik') selected @endif>Baik</option>
                <option value="kurang_baik" @if($kondisi_bahan == 'kurang_baik') selected @endif>Kurang Baik</option>
            </select>
        </div>

        <div class="ui field">
            <label>{{ 'Deskripsi Kondisi Bahan' }}</label>
            <input placeholder="Deskripsi Kondisi Bahan" type="text" class="form-control" name="deskripsi_kondisi_bahan" value="@if(isset($f->deskripsi_kondisi_bahan)) {{ $f->deskripsi_kondisi_bahan }} @endif">
        </div>

    </div>

    <table class="ui table">

        <thead>

        <tr>

            <th width="5%" class="center aligned">No.</th>

            <th width="20%" class="center aligned">Kode Sediaan</th>

            <th class="center aligned">Hasil Pemeriksaan oleh Lab Peserta</th>

            <th width="10%" class="center aligned">Kepadatan Parasit</th>

        </tr>

        </thead>

        <tbody>

        @for ($i = 0; $i < 10; $i++)

            <tr>

                <th class="center aligned">{{ $i + 1 }}</th>

                <td>
                    <input placeholder="Kode Sediaan" type="text" class="ui field" name="{{ 'kode_' . $i }}" value="@if(isset($f->{'kode_'.$i})) {{ $f->{ 'kode_' . $i } }} @endif">
                </td>

                <td>
                    @php
                        $selectedOptions = (isset($f->{'hasil_'.$i})) ? $f->{ 'hasil_' . $i } : array();
                    @endphp
                    <select class="ui select search fluid dropdown" style="width: 100%;" tabindex="-1" aria-hidden="true" multiple name="{{ 'hasil_' . $i }}[]">
                        @foreach($definedOptions as $option)
                            <option @if(in_array($option, $selectedOptions)) selected @endif>{{ $option }}</option>
                        @endforeach
                        @foreach($selectedOptions as $selectedOption)
                            @if($selectedOption != '' && !in_array($selectedOption, $definedOptions))
                                <option selected>{{ $selectedOption }}</option>
                            @endif
                        @endforeach
                    </select>
                </td>

                <td><input type="number" class="ui field" name="{{ 'jumlah_malaria_' . $i }}" value="@if(isset($f->{'jumlah_malaria_'.$i})) {{ $f->{ 'jumlah_malaria_' . $i } }} @endif"></td>

            </tr>

        @endfor

        </tbody>

    </table>

    <div class="ui divider"></div>

    <div class="ui field">
        <label>{{ 'Saran' }}</label>
        <textarea class="form-control" rows="3" placeholder="Tulis saran" name="saran">@if(isset($f->saran)) {{ $f->saran }} @endif</textarea>
    </div>

    <div class="ui field">
        <label>{{ 'Nama Pemeriksa' }}</label>
        <input placeholder="Nama Pemeriksa" type="text" class="form-control" name="nama_pemeriksa" value="@if(isset($f->nama_pemeriksa)) {{ $f->nama_pemeriksa }} @endif">
    </div>

    <div class="ui field">
        <label>{{ 'Kualifikasi Pemeriksa' }}</label>
        <select class="ui select search field dropdown" style="width: 100%;" tabindex="-1" aria-hidden="true" name="kualifikasi_pemeriksa">
            <option selected="selected" value="">Kualifikasi Pemeriksa</option>
            @foreach($qualifications as $qualification)
                <option value="{{ $qualification->id }}" @if((isset($f->kualifikasi_pemeriksa)) && $f->kualifikasi_pemeriksa == $qualification->id) selected @endif>{{ $qualification->text }}</option>
            @endforeach
        </select>
    </div>

</form>