@php
    $parameterName = 'Anti HCV';

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
            <label for="tanggal_penerimaan_input">{{ 'Tanggal Penerimaan' }}</label>

            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input class="form-control pull-right" id="tanggal_penerimaan_input" name="tanggal_penerimaan" type="date" value="{{ $f->tanggal_penerimaan ?? '' }}">
            </div>
        </div>

        <div class="ui field">
            <label for="tanggal_pemeriksaan_input">{{ 'Tanggal Pemeriksaan' }}</label>

            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input class="form-control pull-right" id="tanggal_pemeriksaan_input" name="tanggal_pemeriksaan" type="date" value="{{ $f->tanggal_pemeriksaan ?? '' }}">
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
                <th width="5%" class="center aligned">{{ $i + 1 }}</th>

                <td width="10%" class="center aligned">
                    <div class="form-group has-feedback">
                        <input placeholder="Kode Panel" type="text" class="form-control" name="{{ 'kode_panel_' . $i }}" value="{{ $f->{ 'kode_panel_' . $i } ?? '' }}">
                    </div>
                </td>

                <td width="15%" class="center aligned">
                    <div class="form-group">
                        <select title="Kualitas Bahan" class="ui select dropdown search fluid" style="width: 100%;" tabindex="-1" aria-hidden="true" name="{{ 'kualitas_bahan_' . $i }}">
                            @php
                                $kualitas_bahan = isset($f->{ 'kualitas_bahan_' . $i }) ? $f->{ 'kualitas_bahan_' . $i } : '';
                            @endphp
                            <option selected value="">Kualitas Bahan</option>
                            <option value="baik" @if($kualitas_bahan == 'baik') selected @endif>Baik</option>
                            <option value="keruh" @if($kualitas_bahan == 'keruh') selected @endif>Keruh</option>
                            <option value="lain-lain" @if($kualitas_bahan == 'lain-lain') selected @endif>Lain-Lain</option>
                        </select>
                    </div>
                </td>

                <td width="60%" class="center aligned">
                    <div class="form-group has-feedback">
                        <input placeholder="Deskripsi Kualitas Bahan" type="text" class="form-control" name="{{ 'deskripsi_kualitas_bahan_' . $i }}" value="{{ $f->{ 'deskripsi_kualitas_bahan_' . $i } ?? '' }}">
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
            <td>
                <div class="form-group">
                    <select title="Metode Pemeriksaan" class="ui select search fluid dropdown" style="width: 100%;" tabindex="-1" aria-hidden="true" name="{{ 'metode_pemeriksaan' }}">
                        @php
                            $metode_pemeriksaan = isset($f->{ 'metode_pemeriksaan' }) ? $f->{ 'metode_pemeriksaan' } : '';
                        @endphp
                        <option selected value="">Metode Pemeriksaan</option>
                        <option value="rapid" @if($metode_pemeriksaan == 'rapid') selected @endif>Rapid</option>
                        <option value="eia-elfa" @if($metode_pemeriksaan == 'eia-elfa') selected @endif>EIA</option>
                    </select>
                </div>
            </td>
            <td>
                <div class="form-group has-feedback">
                    <input placeholder="Nama Reagen" type="text" class="form-control" name="{{ 'nama_reagen' }}" value="{{ $f->nama_reagen ?? '' }}">
                </div>
            </td>
            <td>
                <div class="form-group has-feedback">
                    <input placeholder="Nama Produsen" type="text" class="form-control" name="{{ 'nama_produsen' }}" value="{{ $f->nama_produsen ?? '' }}">
                </div>
            </td>
            <td>
                <div class="form-group has-feedback">
                    <input placeholder="Nama Lot / Batch" type="text" class="form-control" name="{{ 'nama_lot_atau_batch' }}" value="{{ $f->nama_lot_atau_batch ?? '' }}">
                </div>
            </td>
            <td>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input placeholder="Tanggal Kadaluarsa" name="tanggal_kadaluarsa" class="form-control pull-right" id="tanggal_kadaluarsa_input" type="text" value="{{ $f->tanggal_kadaluarsa ?? '' }}">
                </div>
            </td>
        </tr>
        </tbody>
    </table>

    <table class="ui table">
        <thead>
        <tr>
            <th width="5%" class="center aligned">{{ 'Panel' }}</th>
            <th width="23%" class="center aligned">{{ 'Abs atau OD (A) (Bila dengan EIA)' }}</th>
            <th width="23%" class="center aligned">{{ 'Cut off (B) (Bila dengan EIA)' }}</th>
            <th width="23%" class="center aligned">{{ 'S/CO (A:B) atau true value (TV) atau Indek (Bila dengan EIA)' }}</th>
            <th width="16%" class="center aligned">{{ 'Interpretasi Hasil' }}</th>
        </tr>
        </thead>
        <tbody>
        @for($i = 0; $i < 3; $i++)
            <tr>
                <th class="center aligned">{{ $i + 1 }}</th>
                <td>
                    <div class="form-group has-feedback">
                        <input placeholder="Abs atau OD (A) (Bila dengan EIA)" type="text" class="form-control" name="{{ 'abs_'. $i }}" value="{{ $f->{ 'abs_' . $i } ?? '' }}">
                    </div>
                </td>
                <td>
                    <div class="form-group has-feedback">
                        <input placeholder="Cut off (B) (Bila dengan EIA)" type="text" class="form-control" name="{{ 'cut_' . $i }}" value="{{ $f->{ 'cut_' . $i } ?? '' }}">
                    </div>
                </td>
                <td>
                    <div class="form-group has-feedback">
                        <input placeholder="S/CO (A:B) atau true value (TV) atau Indek (Bila dengan EIA)" type="text" class="form-control" name="{{ 'sco_' . $i }}" value="{{ $f->{ 'sco_' . $i } ?? '' }}">
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <select data-cke-caption-placeholder="Interpretasi Hasil" class="ui select search fluid dropdown" style="width: 100%;" tabindex="-1" aria-hidden="true" name="{{ 'hasil_' . $i }}">
                            @php
                                $hasil = isset($f->{ 'hasil_' . $i }) ? $f->{ 'hasil_' . $i } : ''
                            @endphp
                            <option selected value="">Interpretasi Hasil</option>
                            <option value="reaktif" @if($hasil == 'reaktif') selected @endif>Reaktif</option>
                            <option value="nonreaktif" @if($hasil == 'nonreaktif') selected @endif>Nonreaktif</option>
                        </select>
                    </div>
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
        <label for="nama_pemeriksa_input">{{ 'Nama Pemeriksa' }}</label>
        <input placeholder="Tulis nama pemeriksa" type="text" class="form-control" name="nama_pemeriksa" id="nama_pemeriksa_input" value="{{ $f->nama_pemeriksa ?? '' }}">
    </div>

    <div class="ui field">
        <label for="kualifikasi_pemeriksa">{{ 'Kualifikasi Pemeriksa' }}</label>
        <select id="kualifikasi_pemeriksa" name="kualifikasi_pemeriksa" class="ui select search fluid dropdown" style="width: 100%;" tabindex="-1" aria-hidden="true">
            @php
                $qualification_value = isset($f->kualifikasi_pemeriksa) ? $f->kualifikasi_pemeriksa : ''
            @endphp
            <option selected value="">Kualifikasi Pemeriksa</option>
            @foreach($qualifications as $qualification)
                <option value="{{ $qualification->id }}" @if($qualification_value == $qualification->id) selected @endif>{{ $qualification->text }}</option>
            @endforeach
        </select>
    </div>

</form>