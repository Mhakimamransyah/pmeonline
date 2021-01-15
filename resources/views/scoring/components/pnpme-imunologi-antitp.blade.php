@php
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

    $score_value = \App\v3\Score::query()->where('order_id', '=', $order_id)->get()->first();
    if ($score_value != null && $score_value->value != null) {
        $score = json_decode($score_value->value);
    }
@endphp

<h3 class="ui horizontal divider header">
    Formulir Evaluasi Bidang Imunologi Parameter {{ $parameterName }}
</h3>

<form id="submit-form" class="ui form" method="post" action="{{ route('installation.scoring.store', ['order_id' => request()->get('order_id')]) }}">

    @csrf

    @component('layouts.semantic-ui.components.submit-header', [
        'submit' => $submit,
    ])
    @endcomponent

    <table class="ui table celled">
        <thead>
        <tr>
            <th class="center aligned">Tanggal Penerimaan</th>
            <th class="center aligned">Tanggal Pemeriksaan</th>
            <th class="center aligned">Kualifikasi Pemeriksa</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="center aligned">{!! $f->{ 'tanggal_penerimaan' } ?? '<i>Tidak diisi</i>' !!}</td>
            <td class="center aligned">{!! $f->{ 'tanggal_pemeriksaan' } ?? '<i>Tidak diisi</i>' !!}</td>
            @php
                $qualificationId = $f->{ 'kualifikasi_pemeriksa' };
                $qualification = $qualifications->filter(function ($item) use ($qualificationId) {
                    return $item->id == $qualificationId;
                })->first();
            @endphp
            <td class="center aligned">{{ $qualificationId }} - {{ $qualification->text }}</td>
        </tr>
        </tbody>
    </table>

    <table class="ui table celled">
        <thead>
        <tr>
            <th width="5%" class="center aligned">{{ 'Panel' }}</th>
            <th width="20%" class="center aligned">{{ 'Kode Bahan Kontrol' }}</th>
            <th width="15%" class="center aligned">{{ 'Kualitas Bahan' }}</th>
            <th width="60%" class="center aligned">{{ 'Deskripsi Kualitas Bahan' }}</th>
        </tr>
        @for($i = 0; $i < 3; $i++)
            <tr>
                <th class="center aligned">
                    {{ $i + 1 }}
                </th>
                <td class="center aligned">
                    {!! $f->{'kode_bahan_kontrol_'.$i} ?? '<i>Tidak diisi</i>' !!}
                </td>
                <td class="center aligned">
                    @php
                        $kualitas_bahan = isset($f->{'kualtias_bahan_'.$i}) ? $f->{'kualtias_bahan_'.$i} : '';
                    @endphp
                    @if($kualitas_bahan == 'baik')
                        {{ 'Baik' }}
                    @elseif($kualitas_bahan == 'keruh')
                        {{ 'Keruh' }}
                    @elseif($kualitas_bahan == 'lain-lain')
                        {{ 'Lain-Lain' }}
                    @else
                        <i>Tidak diisi</i>
                    @endif
                </td>
                <td class="center aligned">
                    {!! $f->{'deskripsi_kualitas_bahan_'.$i} ?? '<i>Tidak diisi</i>' !!}
                </td>
            </tr>
        @endfor
        </thead>
    </table>

    <table class="ui table celled">
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
                @php
                    $metode_pemeriksaan = isset($f->{'metode'}) ? $f->{'metode'} : '';
                @endphp
                @if($metode_pemeriksaan == 'rapid')
                    {{ 'Rapid' }}
                @elseif($metode_pemeriksaan == 'eia_elfa')
                    {{ 'EIA / ELFA' }}
                @elseif($metode_pemeriksaan == 'algutinasi')
                    {{ 'Aglutinasi' }}
                @else
                    <i>Tidak diisi</i>
                @endif
            </td>
            <td class="center aligned">
                {!! $f->nama_reagen ?? '<i>Tidak diisi</i>' !!}
            </td>
            <td class="center aligned">
                {!! $f->nama_produsen_reagen ?? '<i>Tidak diisi</i>' !!}
            </td>
            <td class="center aligned">
                {!! $f->lot_reagen ?? '<i>Tidak diisi</i>' !!}
            </td>
            <td class="center aligned">
                {!! $f->tanggal_kadaluarsa ?? '<i>Tidak diisi</i>' !!}
            </td>
        </tr>
        </tbody>
    </table>

    <h3 class="ui divider horizontal header"><b>{{ 'Kualitatif' }}</b></h3>

    @for($h = 0; $h < 3; $h++)

        <h4 class="ui divider horizontal header"><b>{{ 'Panel ' }}{!! $f->{'kode_bahan_kontrol_'.$h} ?? '<i>Tidak diisi</i>' !!}</b></h4>

        <table class="ui table celled">
            <thead>
            <tr>
                <th width="23%" class="center aligned">{{ 'Abs atau OD (A) (Bila dengan EIA)' }}</th>
                <th width="23%" class="center aligned">{{ 'Cut off (B) (Bila dengan EIA)' }}</th>
                <th width="23%" class="center aligned">{{ 'S/CO (A:B) atau true value (TV) atau Indek (Bila dengan EIA)' }}</th>
                <th width="16%" class="center aligned">{{ 'Interpretasi Hasil' }}</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="center aligned">
                    {!! $f->{'kualitatif_abs_'.$h} ?? '<i>Tidak diisi</i>' !!}
                </td>
                <td class="center aligned">
                    {!! $f->{'kualitatif_cut_'.$h} ?? '<i>Tidak diisi</i>' !!}
                </td>
                <td class="center aligned">
                    {!! $f->{'kualitatif_sco_'.$h} ?? '<i>Tidak diisi</i>' !!}
                </td>
                <td class="center aligned">
                    @php
                        $selected_hasil = isset($f->{'hasil_'.$h}) ? $f->{'hasil_'.$h} : '';
                    @endphp
                    @if($selected_hasil == 'reaktif')
                        {{ 'Reaktif' }}
                    @elseif($selected_hasil == 'nonreaktif')
                        {{ 'Nonreaktif' }}
                    @else
                        <i>Tidak diisi</i>
                    @endif
                </td>
            </tr>
            </tbody>
        </table>

    @endfor

    <h3 class="ui divider horizontal header"><b>{{ 'Semi Kuantitatif' }}</b></h3>

    @for($h = 0; $h < 3; $h++)

        <h4 class="ui divider horizontal header"><b>{{ 'Panel ' }}{!! $f->{'kode_bahan_kontrol_'.$h} ?? '<i>Tidak diisi</i>' !!}</b></h4>

        <table class="ui table celled">
            <thead>
            <tr>
                <th width="23%" class="center aligned">{{ 'Interpretasi Hasil' }}</th>
                <th width="23%" class="center aligned">{{ 'Titer' }}</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="center aligned">
                    @php
                        $selected_hasil = isset($f->{'hasil_semi_kuantitatif_'.$h}) ? $f->{'hasil_semi_kuantitatif_'.$h} : '';
                    @endphp
                    @if($selected_hasil == 'reaktif')
                        {{ 'Reaktif' }}
                    @elseif($selected_hasil == 'nonreaktif')
                        {{ 'Nonreaktif' }}
                    @else
                        <i>Tidak diisi</i>
                    @endif
                </td>
                <td class="center aligned">
                    {!! $f->{'semi_kuantitatif_tier_'.$h} ?? '<i>Tidak diisi</i>' !!}
                </td>
            </tr>
            </tbody>
        </table>

    @endfor

    <table class="ui table celled">
        <thead>
        <tr>
            <th rowspan="2" class="center aligned" style="vertical-align: middle; width: 16%">{{ 'Panel' }}</th>
            <th colspan="2" class="center aligned" style="vertical-align: middle">{{ 'Hasil Rujukan' }}</th>
            <th rowspan="2" class="center aligned" style="vertical-align: middle; width: 28%">{{ 'Skor Peserta' }}</th>
        </tr>
        <tr>
            <th class="center aligned" style="vertical-align: middle; width: 28%">{{ 'Hasil' }}</th>
            <th class="center aligned" style="vertical-align: middle; width: 28%">{{ 'Titer' }}</th>
        </tr>
        </thead>
        <tbody>
        @for($h = 0; $h < 3; $h++)
            <tr>
                <td class="center aligned">{!! $f->{'kode_bahan_kontrol_'.$h} ?? '<i>Tidak diisi</i>' !!}</td>
                <td class="center aligned error">
                    @php
                        $hasil = isset($score->{'rujukan_hasil'}[$h]) ? $score->{'rujukan_hasil'}[$h] : '';
                    @endphp

                    <select name="{{'rujukan_hasil['.$h.']'}}" class="ui select search dropdown fluid" style="width: 100%;" tabindex="-1" aria-hidden="true">
                        <option selected="selected" value="">-- Pilih --</option>
                        <option value="reaktif" @if($hasil == 'reaktif') selected @endif>Reaktif</option>
                        <option value="nonreaktif" @if($hasil == 'nonreaktif') selected @endif>Nonreaktif</option>
                    </select>
                </td>
                <td class="center aligned error">
                    <input type="text" placeholder="Titer hasil rujukan" name="{{ 'rujukan_titer['.$h.']' }}" value="{{ $score->{'rujukan_titer'}[$h] ?? '' }}" class="form-control"/>
                </td>
                <td class="center aligned error">
                    @php
                        $score_h = isset($score->{'score'}[$h]) ? $score->{'score'}[$h] : '';
                    @endphp
                    <select class="ui select search dropdown fluid" title="{{ 'Penilaian Hasil Panel ' . ($h + 1) }}" name="{{ 'score[' . $h . ']' }}">
                        <option value="" selected>{{ 'Belum Dinilai' }}</option>
                        <option value="-2" @if($score_h == '-2') selected @endif>{{ '-- Tidak Dinilai --' }}</option>
                        <option value="0" @if($score_h == '0') selected @endif>{{ '0 - Tidak Baik' }}</option>
                        <option value="4" @if($score_h == '4') selected @endif>{{ '4 - Baik' }}</option>
                    </select>
                </td>
            </tr>
        @endfor
        </tbody>
    </table>

    <table class="ui table">
        <thead>
        <tr>
            <th class="center aligned" style="width: 50%">Saran</th>
            <th class="center aligned" style="width: 50%">Nama Pemeriksa</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="center aligned">{!! $f->saran ?? '<i>Tidak diisi</i>' !!}</td>
            <td class="center aligned">{!! $f->nama_pemeriksa ?? '<i>Tidak diisi</i>' !!}</td>
        </tr>
        </tbody>
    </table>

    <div class="ui field">
        <label>{{ 'Saran untuk Peserta' }}</label>
        <textarea title="Saran untuk Peserta" name="saran" class="form-control" rows="5">{{ $score->saran ?? '' }}</textarea>
    </div>

</form>
