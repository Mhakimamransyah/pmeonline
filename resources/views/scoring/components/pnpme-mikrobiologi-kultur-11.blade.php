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

    $score_value = \App\v3\Score::query()->where('order_id', '=', $order_id)->get()->first();
    if ($score_value != null && $score_value->value != null) {
        $score = json_decode($score_value->value);
    }

@endphp

<form id="submit-form" class="ui form" method="post" action="{{ route('installation.scoring.store', ['order_id' => request()->get('order_id')]) }}">

    @csrf

    @if(\Illuminate\Support\Str::contains(request()->route()->getName(), 'print'))

        <h3 class="center aligned">Program Nasional Pemantapan Mutu Eksternal<br/>
            Bidang Mikrobiologi Parameter {{ $parameterName }}<br/>
            Siklus 2 Tahun 2019
        </h3>

    @else

        <h3 class="ui horizontal divider header">
            Formulir Bidang Mikrobiologi Parameter {{ $parameterName }}
        </h3>

    @endif

    @if(\Illuminate\Support\Str::contains(request()->route()->getName(), 'print'))

        @component('score.identity-header', [
            'submit' => $filled_form,
        ])
        @endcomponent

    @else

        @component('layouts.semantic-ui.components.submit-header', [
            'submit' => $filled_form,
        ])
        @endcomponent

    @endif

    <table class="ui table celled">
        <thead>
        <tr>
            <th class="center aligned">Tanggal Penerimaan</th>
            <th class="center aligned">Tanggal Pemeriksaan</th>
            <th class="center aligned">Kualitas Bahan</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="center aligned">{!! $f->{ 'tanggal_penerimaan' } ?? '<i>Tidak diisi</i>' !!}</td>
            <td class="center aligned">{!! $f->{ 'tanggal_pemeriksaan' } ?? '<i>Tidak diisi</i>' !!}</td>
            <td class="center aligned">
                @php
                    $quality = $f->{ 'kondisi_bahan' } ?? null;
                @endphp
                @if($quality == 'baik')
                    {{ 'Baik' }}
                @elseif($quality == 'kering')
                    {{ 'Kering' }}
                @elseif($quality == 'pecah')
                    {{ 'Pecah' }}
                @elseif($quality == 'kontaminasi')
                    {{ 'Kontamintasi' }}
                @else
                    <i>Tidak diisi</i>
                @endif
            </td>
        </tr>
        </tbody>
    </table>

    <table class="table ui celled">

        <thead>
        <tr>

            <th width="5%" class="center aligned">{{ '#' }}</th>

            <th width="20%" class="center aligned">{{ 'Kode Kultur' }}</th>

            <th width="25%" class="center aligned">{{ 'Hasil Identifikasi oleh Peserta' }}</th>

            <th width="25%" class="center aligned">{{ 'Hasil Identifikasi yang Seharusnya' }}</th>

            <th width="25%" class="center aligned">{{ 'Score' }}</th>

        </tr>
        </thead>

        <tbody>
        @for ($i = 1; $i < 4; $i++)

            <tr>

                <td class="center aligned">{{ $i }}</td>

                <td class="center aligned">
                    {!! $f->{'kode_kultur_' . $i} ?? '<i>Tidak diisi</i>' !!}
                </td>

                <td class="center aligned">
                    @php
                        $hasil = isset($f->{'hasil_identifikasi_'.$i}) ? $f->{'hasil_identifikasi_'.$i} : '<i>Tidak diisi</i>';
                    @endphp
                    {!! $hasil !!}
                </td>

                <td>
                    <textarea rows="3"
                              placeholder="Hasil identifikasi yang seharusnya panel {{ $f->{'kode_kultur_'.$i} }}" name="{{ 'rujukan[]' }}">{{ $score->{'rujukan'}[$i-1] ?? '' }}</textarea>
                </td>

                <td>
                    @php
                        $score_h = isset($score->{'score'}[$i - 1]) ? $score->{'score'}[$i - 1] : '';
                    @endphp
                    <select class="ui dropdown fluid" title="{{ 'Penilaian Hasil Panel ' . ($i) }}" name="{{ 'score[' . ($i - 1) . ']' }}">
                        <option value="">Belum dinilai</option>
                        <option value="0" @if($score_h == '0') selected @endif>{{ 'Hasil identifikasi salah (0)' }}</option>
                        <option value="1" @if($score_h == '1') selected @endif>{{ 'Hasil identifikasi benar hingga nama genus atau hasil identifikasi yang genusnya benar tapi spesiesnya salah (1)' }}</option>
                        <option value="2" @if($score_h == '2') selected @endif>{{ 'Hasil identifikasi benar mengidentifikasi hingga nama spesies atau jawaban hingga serotype untuk kuman patogen tertentu (2)' }}</option>
                    </select>
                </td>

            </tr>

        @endfor
        </tbody>

    </table>

    <table class="table ui celled">

        <thead>
        <tr>

            <th width="50%" class="center aligned">{{ 'Metode yang Digunakan' }}</th>
            <th width="50%" class="center aligned">{{ 'Disk Antibiotik yang Digunakan' }}</th>

        </tr>
        </thead>

        <tbody>
        <tr>

            <td class="center aligned">{!! $f->metode ?? '<i>Tidak diisi</i>' !!}</td>
            <td class="center aligned">{!! $f->disk ?? '<i>Tidak diisi</i>' !!}</td>

        </tr>
        </tbody>

    </table>

    <h4 class="ui divider header horizontal">Hasil Uji Kepekaan Kultur 1</h4>

    <table class="table ui celled">

        <thead>
        <tr>
            <th style="width: 30%" class="center aligned">Antibiotik</th>
            <th style="width: 35%" class="center aligned">Hasil Lab. Peserta</th>
            <th style="width: 35%" class="center aligned">Hasil Rujukan</th>
        </tr>
        </thead>

        <tbody>
        @foreach($kultur1_items as $item)

            <tr>

                <th class="center aligned">{{ $item }}</th>

                <td class="center aligned">{!! $f->{'hasil_kultur_1_obat_'.$item} ?? '<i>Tidak diisi</i>' !!}</td>

                <td>
                    @php

                        $selected_score = isset($score->{'hasil_kultur_1_obat_'.$item}) ? $score->{'hasil_kultur_1_obat_'.$item} : '';

                    @endphp
                    <select name="{{'hasil_kultur_1_obat_'.$item }}" class="ui select search fluid dropdown" style="width: 100%;" tabindex="-1" aria-hidden="true">
                        <option selected="selected" value="">-- Pilih --</option>
                        @foreach($scores as $score__)
                            <option @if($selected_score == $score__) selected @endif>{{ $score__ }}</option>
                        @endforeach
                    </select>
                </td>

            </tr>

        @endforeach
        </tbody>

    </table>

    <h4 class="ui divider header horizontal">Hasil Uji Kepekaan Kultur 2</h4>

    <table class="table ui celled">

        <thead>
        <tr>
            <th style="width: 30%" class="center aligned">Antibiotik</th>
            <th style="width: 35%" class="center aligned">Hasil Lab. Peserta</th>
            <th style="width: 35%" class="center aligned">Hasil Rujukan</th>
        </tr>
        </thead>

        <tbody>
        @foreach($kultur2_items as $item)

            <tr>

                <th class="center aligned">{{ $item }}</th>

                <td class="center aligned">{!! $f->{'hasil_kultur_2_obat_'.$item} ?? '<i>Tidak diisi</i>' !!}</td>

                <td>
                    @php

                        $selected_score = isset($score->{'hasil_kultur_2_obat_'.$item}) ? $score->{'hasil_kultur_2_obat_'.$item} : '';

                    @endphp
                    <select name="{{'hasil_kultur_2_obat_'.$item }}" class="ui select search fluid dropdown" style="width: 100%;" tabindex="-1" aria-hidden="true">
                        <option selected="selected" value="">-- Pilih --</option>
                        @foreach($scores as $score__)
                            <option @if($selected_score == $score__) selected @endif>{{ $score__ }}</option>
                        @endforeach
                    </select>
                </td>

            </tr>

        @endforeach
        </tbody>

    </table>

    <table class="ui table celled">
        <thead>
        <tr>
            <th class="center aligned">Deskripsi Kondisi Bahan</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="center aligned">{!! $f->deskripsi_keterangan_bahan ?? '<i>Tidak diisi</i>' !!}</td>
        </tr>
        </tbody>
    </table>

    <table class="ui table celled">
        <thead>
        <tr>
            <th class="center aligned">Saran</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="center aligned">{!! $f->saran ?? '<i>Tidak diisi</i>' !!}</td>
        </tr>
        </tbody>
    </table>

    <table class="ui table celled">
        <thead>
        <tr>
            <th class="center aligned" style="width: 50%">Nama Pemeriksa</th>
            <th class="center aligned" style="width: 50%">Kualifikasi Pemeriksa</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="center aligned">{!! $f->nama_pemeriksa ?? '<i>Tidak diisi</i>' !!}</td>
            <td class="center aligned">
                @php
                    $qualificationId = isset($f->{ 'kualifikasi_pemeriksa' }) ? $f->{ 'kualifikasi_pemeriksa' } : '';
                    $qualification = $qualifications->filter(function ($item) use ($qualificationId) {
                        return $item->id == $qualificationId;
                    })->first();
                @endphp
                @if($qualification == null)
                    <i>Tidak diisi</i>
                @else
                    {{ $qualificationId }} - {{ $qualification->text }}
                @endif
            </td>
        </tr>
        </tbody>
    </table>

    <div class="ui field">
        <label>{{ 'Saran' }}</label>
        <textarea class="form-control" rows="3" placeholder="Tulis saran" name="saran">{{ $score->saran ?? '' }}</textarea>
    </div>

    @component('layouts.semantic-ui.components.submit-footer', [
        'submit' => $filled_form,
    ])
    @endcomponent

    @if(\Illuminate\Support\Str::contains(request()->route()->getName(), 'print'))

        @component('preview.signature', [
            'submit' => $filled_form,
            'signer' => $f->nama_pemeriksa ?? '........................',
        ])
        @endcomponent

    @endif

</form>