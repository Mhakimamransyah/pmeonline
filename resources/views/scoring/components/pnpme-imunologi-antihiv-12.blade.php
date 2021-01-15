@php
    use Illuminate\Support\Facades\DB;

    $parameterName = 'Anti HIV';

    $f = new stdClass();
    $order_id = request()->query('order_id');
    $filled_form = \App\Submit::query()->where('order_id', '=', $order_id)->get()->first();
    if ($filled_form->value != null) {
        $f = json_decode($filled_form->value);
    }

    $packageInjectData = \App\Package::query()->where('name', 'pnpme-imunologi-antihiv-3')->get()->first();
    $injects = $packageInjectData->injects()->get();

    $table_reagens = $injects->filter(function ($inject) { return $inject->name == 'Daftar Reagen'; })->first()->option->table_name;
    $reagens = DB::table($table_reagens)->get();

    $table_kualifikasi_pemeriksa = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualifikasi Pemeriksa'; })->first()->option->table_name;
    $qualifications = DB::table($table_kualifikasi_pemeriksa)->get();

    $table_kualitas_bahan = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualitas Bahan'; })->first()->option->table_name;
    $daftar_pilihan_kualitas_bahan = DB::table($table_kualitas_bahan)->get();

    $table_metode_pemeriksaan = $injects->filter(function ($inject) { return $inject->name == 'Daftar Metode Pemeriksaan'; })->first()->option->table_name;
    $daftar_pilihan_metode_pemeriksaan = DB::table($table_metode_pemeriksaan)->get();

    $table_interpretasi_hasil = $injects->filter(function ($inject) { return $inject->name == 'Daftar Interpretasi Hasil'; })->first()->option->table_name;
    $daftar_pilihan_interpretasi_hasil = DB::table($table_interpretasi_hasil)->get();

    $table_daftar_pilihan_nilai_hasil_reagen = $injects->filter(function ($inject) { return $inject->name == 'Daftar Pilihan Nilai Hasil Reagen'; })->first()->option->table_name;
    $daftar_pilihan_nilai_hasil_reagen = DB::table($table_daftar_pilihan_nilai_hasil_reagen)->get();

    $table_daftar_pilihan_nilai_kesesuaian_pemeriksaan = $injects->filter(function ($inject) { return $inject->name == 'Daftar Pilihan Nilai Kesesuaian Pemeriksaan Panel'; })->first()->option->table_name;
    $daftar_pilihan_nilai_kesesuaian_pemeriksaan = DB::table($table_daftar_pilihan_nilai_kesesuaian_pemeriksaan)->get();

    $jumlahPanel = 3;
    $jumlahTes = 3;

    $score = \App\v3\Score::query()->where('order_id', '=', $order_id)->get()->first();
    if ($score != null && $score->value != null) {
        $scoreValue = json_decode($score->value);
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
            <th class="center aligned" style="width: 30%">Tanggal Penerimaan</th>
            <th class="center aligned" style="width: 30%">Tanggal Pemeriksaan</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            @php
                $selected = $submitValue->{'tanggal_penerimaan'};
            @endphp
            @if($selected != null)
                <td class="center aligned">
                    {{ $selected }}
                </td>
            @else
                <td class="warning center aligned">
                    <i>{{ 'Tidak diisi' }}</i>
                </td>
            @endif

            @php
                $selected = $submitValue->{'tanggal_pemeriksaan'};
            @endphp
            @if($selected != null)
                <td class="center aligned">
                    {{ $selected }}
                </td>
            @else
                <td class="warning center aligned">
                    <i>{{ 'Tidak diisi' }}</i>
                </td>
            @endif
        </tr>
        </tbody>
    </table>

    <div class="ui divider"></div>

    <table class="ui table celled">
        <thead>
        <tr>
            <th class="center aligned">{{ '#' }}</th>
            <th class="center aligned">{{ 'Kode Panel' }}</th>
            <th class="center aligned">{{ 'Kualitas Bahan' }}</th>
            <th class="center aligned">{{ 'Deskripsi Kualitas Bahan' }}</th>
        </tr>
        </thead>
        <tbody>
        @for($i = 0; $i < $jumlahPanel; $i++)
        <tr>
            <th class="center aligned" style="width: 5%">{{ $i+1 }}</th>

            <td style="width: 10%" class="center aligned">
                {{ $submitValue->{'kode_panel_'.$i} }}
            </td>

            @php
                $selected = $daftar_pilihan_kualitas_bahan->where('value', '=', $submitValue->{'kualitas_bahan_'.$i})->first();
            @endphp
            @if($selected != null)
                <td class="center aligned">
                    {{ $selected->text }}
                </td>
            @else
                <td class="warning center aligned">
                    <i>{{ 'Tidak diisi' }}</i>
                </td>
            @endif

            @php
                $selected = $submitValue->{'deskripsi_kualitas_bahan_'.$i};
            @endphp
            @if($selected != null)
                <td class="center aligned">
                    {{ $selected }}
                </td>
            @else
                <td class="warning center aligned">
                    <i>{{ 'Tidak diisi' }}</i>
                </td>
            @endif

        </tr>
        @endfor
        </tbody>
    </table>

    <table class="ui table celled">
        <thead>
        <tr>
            <th class="center aligned" style="width: 12%">{{ 'Keterangan' }}</th>
            <th class="center aligned" style="width: 22%">{{ 'Metode Pemeriksaan' }}</th>
            <th class="center aligned" style="width: 22%">{{ 'Nama Reagen' }}</th>
            <th class="center aligned" style="width: 22%">{{ 'Nomor Lot / Batch' }}</th>
            <th class="center aligned" style="width: 22%">{{ 'Tanggal Kadaluarsa' }}</th>
        </tr>
        </thead>
        <tbody>
        @for($t = 0; $t < $jumlahTes; $t++)
        <tr>
            <th class="center aligned" style="vertical-align: middle">
                {{ $t+1 }}
            </th>

            @php
                $selected = $daftar_pilihan_metode_pemeriksaan->where('value', '=', $submitValue->{'metode_pemeriksaan_tes'.($t+1)})->first();
            @endphp
            @if($selected != null)
                <td class="center aligned">
                    {{ $selected->text }}
                </td>
            @else
                <td class="warning center aligned">
                    <i>{{ 'Tidak diisi' }}</i>
                </td>
            @endif

            @php
                $selected = $reagens->where('value', '=', $submitValue->{'reagen_tes'.($t+1)})->first();
            @endphp
            @if($selected != null)
                <td class="center aligned">
                    {{ $selected->value . ' - ' . $selected->text }}
                </td>
            @else
                <td class="warning center aligned">
                    <i>{{ 'Tidak diisi' }}</i>
                </td>
            @endif

            @php
                $selected = $submitValue->{'batch_tes'.($t+1)};
            @endphp
            @if($selected != null)
                <td class="center aligned">
                    {{ $selected }}
                </td>
            @else
                <td class="warning center aligned">
                    <i>{{ 'Tidak diisi' }}</i>
                </td>
            @endif

            @php
                $selected = $submitValue->{'tanggal_kadaluarsa_tes'.($t+1)};
            @endphp
            @if($selected != null)
                <td class="center aligned">
                    {{ $selected }}
                </td>
            @else
                <td class="warning center aligned">
                    <i>{{ 'Tidak diisi' }}</i>
                </td>
            @endif

        </tr>
        @endfor
        </tbody>
    </table>

    @for($p = 0; $p < $jumlahPanel; $p++)

        <h4 class="ui horizontal divider header">
            {{ 'Panel ' . $submitValue->{'kode_panel_'.$p} }}
        </h4>

        <table class="table ui celled">
            <thead>
            <tr>
                <th style="width: 15%" class="center aligned">{{ 'Reagen' }}</th>
                <th style="width: 15%" class="center aligned">{{ 'Abs atau OD (A) (Bila dengan EIA)' }}</th>
                <th style="width: 15%" class="center aligned">{{ 'Cut off (B) (Bila dengan EIA)' }}</th>
                <th style="width: 15%" class="center aligned">{{ 'S/CO (A:B) atau true value (TV) atau Indek (Bila dengan EIA)' }}</th>
                <th style="width: 15%" class="center aligned">{{ 'Interpretasi Hasil' }}</th>
                <th style="width: 25%" class="center aligned">{{ 'Penilaian' }}</th>
            </tr>
            </thead>
            <tbody>
            @for($t = 0; $t < $jumlahTes; $t++)
                <tr>

                    <td class="center aligned">
                        <strong>Reagen
                            @for($i = 0; $i < $t+1; $i++)<span>I</span>@endfor
                        </strong>
                    </td>

                    @php
                        $selected = $submitValue->{'abs_panel_'.$p.'_tes_'.($t+1)};
                    @endphp
                    @if ($selected != null)
                        <td class="center aligned">
                            {{ $selected }}
                        </td>
                    @else
                        <td class="warning center aligned">
                            <i>{{ 'Tidak diisi' }}</i>
                        </td>
                    @endif

                    @php
                        $selected = $submitValue->{'cut_panel_'.$p.'_tes_'.($t+1)};
                    @endphp
                    @if ($selected != null)
                        <td class="center aligned">
                            {{ $selected }}
                        </td>
                    @else
                        <td class="warning center aligned">
                            <i>{{ 'Tidak diisi' }}</i>
                        </td>
                    @endif

                    @php
                        $selected = $submitValue->{'sco_panel_'.$p.'_tes_'.($t+1)};
                    @endphp
                    @if ($selected != null)
                        <td class="center aligned">
                            {{ $selected }}
                        </td>
                    @else
                        <td class="warning center aligned">
                            <i>{{ 'Tidak diisi' }}</i>
                        </td>
                    @endif

                    @php
                        $selected = $daftar_pilihan_interpretasi_hasil->where('value', '=', $submitValue->{'hasil_panel_'.$p.'_tes_'.($t+1)})->first();
                    @endphp
                    @if ($selected != null)
                        <td class="center aligned">
                            {{ $selected->text }}
                        </td>
                    @else
                        <td class="warning center aligned">
                            <i>{{ 'Tidak diisi' }}</i>
                        </td>
                    @endif

                    <td>
                        @php
                            $selected = isset($scoreValue->{'panel'}[$p]->{'tes'}->{'answer'}[$t]) ? $scoreValue->{'panel'}[$p]->{'tes'}->{'answer'}[$t] : '';
                        @endphp
                        <div class="ui field">
                            <select aria-label="Rujukan Hasil" name="{{ 'panel['.$p.'][tes][answer][]' }}" class="ui search fluid dropdown">
                                <option value="">Rujukan Hasil</option>
                                @foreach($daftar_pilihan_interpretasi_hasil as $item)
                                    <option @if($selected == $item->value) selected @endif value="{{ $item->value }}">{{ $item->text }}</option>
                                @endforeach
                            </select>
                        </div>

                        @php
                            $selected = isset($scoreValue->{'panel'}[$p]->{'tes'}->{'score'}[$t]) ? $scoreValue->{'panel'}[$p]->{'tes'}->{'score'}[$t] : '';
                        @endphp
                        <div class="ui field">
                            <select aria-label="Penilaian" name="{{ 'panel['.$p.'][tes][score][]' }}" class="ui search fluid dropdown">
                                <option value="">Penilaian</option>
                                @foreach($daftar_pilihan_nilai_hasil_reagen as $pilihan)
                                    <option @if($selected == $pilihan->value) selected @endif value="{{ $pilihan->value }}">{{ $pilihan->text }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>

                </tr>

            @endfor

            <tr>
                <td colspan="5" class="right aligned"><b>Nilai Kesesuaian Pemeriksaan Panel {{ $p + 1 }}</b></td>
                <td>
                    @php
                        $selected = isset($scoreValue->{'panel'}[$p]->{'score'}) ? $scoreValue->{'panel'}[$p]->{'score'} : '';
                    @endphp
                    <div class="ui field">
                        <select aria-label="Kesesuaian" name="{{ 'panel['.$p.'][score]' }}" class="ui search fluid dropdown">
                            <option value="">Kesesuaian</option>
                            @foreach($daftar_pilihan_nilai_kesesuaian_pemeriksaan as $pilihan)
                                <option value="{{ $pilihan->value }}" @if($selected == $pilihan->value) selected @endif>{{ $pilihan->text }}</option>
                            @endforeach
                        </select>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>

    @endfor

    <div class="ui divider"></div>

    <table class="ui table celled">
        <thead>
        <tr>
            <th style="width: 50%" class="center aligned">{{ 'Keterangan' }}</th>
            <th style="width: 50%" class="center aligned">{{ 'Saran' }}</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            @php
                $selected = $submitValue->{'keterangan'};
            @endphp
            @if($selected != null)
                <td class="center aligned">
                    {{ $selected }}
                </td>
            @else
                <td class="warning center aligned">
                    <i>{{ 'Tidak diisi' }}</i>
                </td>
            @endif

            @php
                $selected = $submitValue->{'saran'};
            @endphp
            @if($selected != null)
                <td class="center aligned">
                    {{ $selected }}
                </td>
            @else
                <td class="warning center aligned">
                    <i>{{ 'Tidak diisi' }}</i>
                </td>
            @endif
        </tr>
        </tbody>
    </table>

    <div class="field">
        <label>{{ 'Saran' }}</label>
        <textarea class="form-control" rows="3" placeholder="Tulis saran" name="{{ 'advice' }}">{{ $scoreValue->{'advice'} ?? '' }}</textarea>
    </div>

    <table class="ui table celled">
        <thead>
        <tr>
            <th style="width: 50%" class="center aligned">{{ 'Nama Pemeriksa' }}</th>
            <th style="width: 50%" class="center aligned">{{ 'Kualifikasi Pemeriksa' }}</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            @php
                $selected = $submitValue->{'nama_pemeriksa'};
            @endphp
            @if($selected != null)
                <td class="center aligned">
                    {{ $selected }}
                </td>
            @else
                <td class="warning center aligned">
                    <i>{{ 'Tidak diisi' }}</i>
                </td>
            @endif

            @php
                $selected = $qualifications->where('value', '=', $submitValue->{'kualifikasi_pemeriksa'})->first();
            @endphp
            @if($selected != null)
                <td class="center aligned">
                    {{ $selected->text }}
                </td>
            @else
                <td class="warning center aligned">
                    <i>{{ 'Tidak diisi' }}</i>
                </td>
            @endif
        </tr>
        </tbody>
    </table>

    @component('layouts.semantic-ui.components.submit-footer', [
        'submit' => $submit,
    ])
    @endcomponent

</form>