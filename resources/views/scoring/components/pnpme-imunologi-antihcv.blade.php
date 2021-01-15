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
            <td class="center aligned">
                {{ $qualificationId }} - {{ $qualification->text }}
            </td>
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
                        $kualitas_bahan = isset($f->{'kualitas_bahan_'.$i}) ? $f->{'kualitas_bahan_'.$i} : '';
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
                    $metode_pemeriksaan = isset($f->{'metode_pemeriksaan'}) ? $f->{'metode_pemeriksaan'} : '';
                @endphp
                @if($metode_pemeriksaan == 'rapid')
                    {{ 'Rapid' }}
                @elseif($metode_pemeriksaan == 'eia-elfa')
                    {{ 'EIA / ELFA' }}
                @else
                    <i>Tidak diisi</i>
                @endif
            </td>
            <td class="center aligned">
                {!! $f->nama_reagen ?? '<i>Tidak diisi</i>' !!}
            </td>
            <td class="center aligned">
                {!! $f->nama_produsen ?? '<i>Tidak diisi</i>' !!}
            </td>
            <td class="center aligned">
                {!! $f->nama_lot_atau_batch ?? '<i>Tidak diisi</i>' !!}
            </td>
            <td class="center aligned">
                {!! $f->tanggal_kadaluarsa ?? '<i>Tidak diisi</i>' !!}
            </td>
        </tr>
        </tbody>
    </table>

    @for($h = 0; $h < 3; $h++)

        <h4 class="ui divider horizontal header">Panel {!! $f->{'kode_bahan_kontrol_'.$h} ?? '<i>Tidak diisi</i>' !!}</h4>

        @php
            $score_h = isset($score->{'hasil'}[$h]) ? $score->{'hasil'}[$h] : '';
            $rujukan = isset($score->{'rujukan'}[$h]) ? $score->{'rujukan'}[$h] : '-';
        @endphp
        <table class="ui table celled">
            <thead>
            <tr>
                <th width="20%" class="center aligned">{{ 'Abs atau OD (A) (Bila dengan EIA)' }}</th>
                <th width="20%" class="center aligned">{{ 'Cut off (B) (Bila dengan EIA)' }}</th>
                <th width="20%" class="center aligned">{{ 'S/CO (A:B) atau true value (TV) atau Indek (Bila dengan EIA)' }}</th>
                <th width="20%" class="center aligned">{{ 'Interpretasi Hasil' }}</th>
                <th width="20%" class="center aligned">{{ 'Hasil Rujukan' }}</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="center aligned">
                    {!! $f->{'abs_'.$h} ?? '<i>Tidak diisi</i>' !!}
                </td>
                <td class="center aligned">
                    {!! $f->{'cut_'.$h} ?? '<i>Tidak diisi</i>' !!}
                </td>
                <td class="center aligned">
                    {!! $f->{'sco_'.$h} ?? '<i>Tidak diisi</i>' !!}
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
                <td class="error">
                    <select class="ui select search fluid dropdown" title="{{ 'Penilaian Hasil Panel ' . ($h + 1) }}" name="{{ 'rujukan[' . $h . ']' }}">
                        <option selected value="">Hasil Rujukan</option>
                        <option value="reaktif" @if($rujukan == 'reaktif') selected @endif>Reaktif</option>
                        <option value="nonreaktif" @if($rujukan == 'nonreaktif') selected @endif>Non Reaktif</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th colspan="4" class="right aligned">{{ 'Penilaian Hasil Panel ' }} {!! $f->{'kode_bahan_kontrol_'.$i} ?? '<i>Tidak diisi</i>' !!} :&nbsp;&nbsp;</th>
                <td class="error">
                    <select class="ui select search fluid dropdown" title="{{ 'Penilaian Hasil Panel ' . ($h + 1) }}" name="{{ 'hasil[' . $h . ']' }}">
                        <option selected value="">Belum Dinilai</option>
                        <option value="-2" @if($score_h == '-2') selected @endif>{{ '-- Tidak Dinilai --' }}</option>
                        <option value="0" @if($score_h == '0') selected @endif>{{ '0 - Tidak Baik' }}</option>
                        <option value="4" @if($score_h == '4') selected @endif>{{ '4 - Baik' }}</option>
                    </select>
                </td>
            </tr>
            </tbody>
        </table>

    @endfor

    <table class="ui table celled">
        <thead>
        <tr>
            <th class="center aligned">Nama Pemeriksa</th>
            <th class="center aligned">Saran dari Peserta</th>
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
