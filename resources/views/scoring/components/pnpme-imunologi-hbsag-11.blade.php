@php
    $parameterName = 'HBsAg';

    $f = new stdClass();
    $order_id = request()->query('order_id');
    $filled_form = \App\Submit::query()->where('order_id', '=', $order_id)->get()->first();
    if ($filled_form->value != null) {
        $f = json_decode($filled_form->value);
    }

    $packageInjectData = \App\Package::query()->where('name', 'pnpme-imunologi-hbsag-3')->get()->first();
    $injects = $packageInjectData->injects()->get();

    $table_kualifikasi_pemeriksa = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualifikasi Pemeriksa'; })->first()->option->table_name;
    $qualifications = DB::table($table_kualifikasi_pemeriksa)->get();

    $_score = \App\v3\Score::query()->where('order_id', '=', $order_id)->get()->first();
    if ($_score != null && $_score->value != null) {
        $score = json_decode($_score->value);
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
            <td class="center aligned">{{ $f->{ 'tanggal_penerimaan' } ?? '' }}</td>
            <td class="center aligned">{{ $f->{ 'tanggal_pemeriksaan' } ?? '' }}</td>
            @php
                $qualificationId = $f->{ 'kualifikasi_pemeriksa' };
                $qualification = $qualifications->filter(function ($item) use ($qualificationId) {
                    return $item->id == $qualificationId;
                })->first();
            @endphp
            @if($qualification != null)
                <td class="center aligned">{{ $qualificationId }} - {{ $qualification->text }}</td>
            @else
                <td class="center aligned"><i>Tidak diisi</i></td>
            @endif
        </tr>
        </tbody>
    </table>

    <table class="ui table celled">
        <thead>
        <tr>
            <th class="center aligned" style="width: 5%">{{ 'Panel' }}</th>
            <th class="center aligned" style="width: 20%">{{ 'Kode Bahan Kontrol' }}</th>
            <th class="center aligned" style="width: 15%">{{ 'Kualitas Bahan' }}</th>
            <th class="center aligned" style="width: 60%">{{ 'Deskripsi Kualitas Bahan' }}</th>
        </tr>
        @for($i = 0; $i < 3; $i++)
            <tr>
                <th class="center aligned">
                    {{ $i + 1 }}
                </th>
                <td class="center aligned">
                    {{ $f->{'kode_panel_'.$i} ?? '' }}
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
                        {{ '-' }}
                    @endif
                </td>
                <td class="center aligned">
                    {{ $f->{'deskripsi_kualitas_bahan_'.$i} ?? '' }}
                </td>
            </tr>
        @endfor
        </thead>
    </table>

    <table class="ui table celled">
        <thead>
        <tr>
            <th class="center aligned" style="width: 20%">{{ 'Metode Pemeriksaan' }}</th>
            <th class="center aligned" style="width: 20%">{{ 'Nama Reagen' }}</th>
            <th class="center aligned" style="width: 20%">{{ 'Nama Produsen' }}</th>
            <th class="center aligned" style="width: 20%">{{ 'Nama Lot / Batch' }}</th>
            <th class="center aligned" style="width: 20%">{{ 'Tanggal Kadaluarsa' }}</th>
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
                @elseif($metode_pemeriksaan == 'eia')
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

        <h4 class="ui divider horizontal header">Panel {{ $f->{'kode_panel_'.$h} ?? '' }}</h4>

        @php
            $score_h = isset($score->{'hasil'}[$h]) ? $score->{'hasil'}[$h] : '';
            $rujukan = isset($score->{'rujukan'}[$h]) ? $score->{'rujukan'}[$h] : '-';
        @endphp

        <table class="ui table celled">
            <thead>
            <tr>
                <th style="width: 20%" class="center aligned">{{ 'Abs atau OD (A) (Bila dengan EIA)' }}</th>
                <th style="width: 20%" class="center aligned">{{ 'Cut off (B) (Bila dengan EIA)' }}</th>
                <th style="width: 20%" class="center aligned">{{ 'S/CO (A:B) atau true value (TV) atau Indek (Bila dengan EIA)' }}</th>
                <th style="width: 20%" class="center aligned">{{ 'Interpretasi Hasil' }}</th>
                <th style="width: 20%" class="center aligned">{{ 'Hasil Rujukan' }}</th>
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
                        {{ 'Non Reaktif' }}
                    @else
                        <i>Tidak diisi</i>
                    @endif
                </td>
                <td class="error">
                    <select class="ui field dropdown search fluid" name="{{ 'rujukan[' . $h . ']' }}">
                        <option value="">{{ 'Hasil Rujukan Panel ' . $f->{'kode_panel_'.$h} }}</option>
                        <option value="reaktif" @if($rujukan == 'reaktif') selected @endif>Reaktif</option>
                        <option value="nonreaktif" @if($rujukan == 'nonreaktif') selected @endif>Non Reaktif</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="right aligned" colspan="4"><b>{{ 'Penilaian Hasil Panel' }} {!! $f->{'kode_panel_'.$h} ?? '<i>Tidak diisi</i>' !!} :</b></td>
                <td class="error">
                    <select class="ui field dropdown search fluid" name="{{ 'hasil[' . $h . ']' }}">
                        <option value="">{{ 'Penilaian Hasil Panel ' . $f->{'kode_panel_'.$h} }}</option>
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

    @component('layouts.semantic-ui.components.submit-footer', [
        'submit' => $submit,
    ])
    @endcomponent

    <div class="field">
        <label>{{ 'Saran' }}</label>
        <textarea class="form-control" rows="3" placeholder="Tulis saran" name="{{ 'saran' }}">{{ $score->saran ?? '' }}</textarea>
    </div>

    <h4 class="ui divider horizontal header">Hasil Penilaian</h4>

    <div class="hidden">
    @if(isset($score->hasil) && !in_array('-1', $score->hasil))
        @php
            $total_data = 0;
            $total_score = 0;
            foreach ($score->hasil as $value) {
                if($value >= 0) {
                    $total_score += $value;
                    $total_data++;
                }
            }
            $average = $total_score / $total_data;
            $good = $average == 4.0 ? true : false;
        @endphp
        <table class="ui table celled">
            <thead>
            <tr>
                <th class="center aligned" style="width: 50%;">Nilai Rata-Rata</th>
                <th class="center aligned" style="width: 50%">Kategori</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="center aligned">{{ $average }}</td>
                <td class="center aligned">{{ $good ? 'Baik' : 'Tidak Baik' }}</td>
            </tr>
            </tbody>
        </table>
    @else
        <i>Penilaian belum lengkap.</i>
    @endif
    </div>

</form>
