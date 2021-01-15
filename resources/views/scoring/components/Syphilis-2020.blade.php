@php
    use Illuminate\Support\Facades\DB;

    $parameterName = 'Syphilis';

    $f = new stdClass();
    $order_id = request()->query('order_id');
    $filled_form = \App\Submit::query()->where('order_id', '=', $order_id)->get()->first();
    if ($filled_form->value != null) {
        $f = json_decode($filled_form->value);
    }

    $injects = $filled_form->order->package->injects()->get();

    $table_kualifikasi_pemeriksa = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualifikasi Pemeriksa'; })->first()->option->table_name;
    $qualifications = DB::table($table_kualifikasi_pemeriksa)->get();

    $table_kualitas_bahan = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualitas Bahan'; })->first()->option->table_name;
    $daftar_pilihan_kualitas_bahan = DB::table($table_kualitas_bahan)->get();

    $table_daftar_pilihan_metode_tpha = $injects->filter(function ($inject) { return $inject->name == 'Daftar Pilihan Metode TPHA'; })->first()->option->table_name;
    $daftar_pilihan_metode_tpha = DB::table($table_daftar_pilihan_metode_tpha)->get();

    $table_daftar_pilihan_metode_rpr = $injects->filter(function ($inject) { return $inject->name == 'Daftar Pilihan Metode RPR'; })->first()->option->table_name;
    $daftar_pilihan_metode_rpr = DB::table($table_daftar_pilihan_metode_rpr)->get();

    $table_daftar_pilihan_interpretasi_hasil = $injects->filter(function ($inject) { return $inject->name == 'Daftar Pilihan Interpretasi Hasil'; })->first()->option->table_name;
    $daftar_pilihan_interpretasi_hasil = DB::table($table_daftar_pilihan_interpretasi_hasil)->get();

    $table_daftar_pilihan_titer_rpr = $injects->filter(function ($inject) { return $inject->name == 'Daftar Pilihan Titer RPR'; })->first()->option->table_name;
    $daftar_pilihan_titer_rpr = DB::table($table_daftar_pilihan_titer_rpr)->get();

    $table_daftar_pilihan_titer_tpha = $injects->filter(function ($inject) { return $inject->name == 'Daftar Pilihan Titer TPHA'; })->first()->option->table_name;
    $daftar_pilihan_titer_tpha = DB::table($table_daftar_pilihan_titer_tpha)->get();

    $table_daftar_pilihan_nilai_tpha = $injects->filter(function ($inject) { return $inject->name == 'Daftar Pilihan Nilai TPHA'; })->first()->option->table_name;
    $daftar_pilihan_nilai_tpha = DB::table($table_daftar_pilihan_nilai_tpha)->get();

    $table_daftar_pilihan_nilai_rpr = $injects->filter(function ($inject) { return $inject->name == 'Daftar Pilihan Nilai RPR'; })->first()->option->table_name;
    $daftar_pilihan_nilai_rpr = DB::table($table_daftar_pilihan_nilai_rpr)->get();

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
            <th class="center aligned" style="width: 50%">Tanggal Penerimaan</th>
            <th class="center aligned" style="width: 50%">Tanggal Pemeriksaan</th>
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

    <table class="table ui celled">
        <thead>
        <tr>
            <th class="ui center aligned" style="width: 5%">{{ '#' }}</th>
            <th class="ui center aligned" style="width: 15%">{{ 'Kode Panel' }}</th>
            <th class="ui center aligned" style="width: 15%">{{ 'Kualitas Bahan' }}</th>
            <th class="ui center aligned">{{ 'Deskripsi Kualitas Bahan' }}</th>
        </tr>
        </thead>
        <tbody>
        @for($i = 0; $i < 3; $i++)
            <tr>
                <th class="ui center aligned">
                    {{ $i + 1 }}
                </th>

                @php
                    $selected = $f->{'kode_panel_'.$i}
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
                    $selected = $daftar_pilihan_kualitas_bahan->where('value', '=', $f->{'kualtias_bahan_'.$i})->first();
                @endphp
                @if($selected != null)
                    <td class="center aligned">
                        {{ $selected->text }}
                    </td>
                @else
                    <td class="warning center aligned">
                        <i>{{ 'Tidak dipilih' }}</i>
                    </td>
                @endif

                @php
                    $selected = $f->{'deskripsi_kualitas_bahan_'.$i}
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

    <h4 class="ui horizontal divider header">
        TPHA
    </h4>

    <table class="table ui celled">
        <thead>
        <tr>
            <th class="ui center aligned" style="width: 20%">{{ 'Metode Pemeriksaan' }}</th>
            <th class="ui center aligned" style="width: 20%">{{ 'Nama Reagen' }}</th>
            <th class="ui center aligned" style="width: 20%">{{ 'Nama Produsen' }}</th>
            <th class="ui center aligned" style="width: 20%">{{ 'Nama Lot / Batch' }}</th>
            <th class="ui center aligned" style="width: 20%">{{ 'Tanggal Kadaluarsa' }}</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            @php
                $selected = $daftar_pilihan_metode_tpha->where('value', '=', $f->{'metode_tpha'})->first();
            @endphp
            @if($selected != null)
                <td class="center aligned">
                    {{ $selected->text }}
                </td>
            @else
                <td class="warning center aligned">
                    <i>{{ 'Tidak dipilih' }}</i>
                </td>
            @endif

            @php
                $selected = $f->{'nama_reagen_tpha'}
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
                $selected = $f->{'nama_produsen_reagen_tpha'}
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
                $selected = $f->{'lot_reagen_tpha'}
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
                $selected = $f->{'tanggal_kadaluarsa_tpha'}
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

    <table class="table ui celled">
        <thead>
        <tr>
            <th style="width: 5%" class="ui center aligned">#</th>
            <th class="ui center aligned" style="width: 20%">{{ 'Kode Panel' }}</th>
            <th style="width: 25%" class="ui center aligned">{{ 'Abs atau OD (A) (Bila dengan EIA)' }}</th>
            <th style="width: 25%" class="ui center aligned">{{ 'Cut off (B) (Bila dengan EIA)' }}</th>
            <th style="width: 25%" class="ui center aligned">{{ 'S/CO (A:B) atau true value (TV) atau Indek (Bila dengan EIA)' }}</th>
        </tr>
        </thead>
        <tbody>
        @for($i = 0; $i < 3; $i++)
            <tr>
                <th class="ui center aligned">{{ $i + 1 }}</th>

                @php
                    $selected = $f->{'kode_panel_'.$i}
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
                    $selected = $f->{'kualitatif_abs_'. $i}
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
                    $selected = $f->{'kualitatif_cut_'. $i}
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
                    $selected = $f->{'kualitatif_sco_'. $i}
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
            <th rowspan="2" style="width: 5%" class="ui center aligned">#</th>
            <th rowspan="2" class="ui center aligned" style="width: 20%">{{ 'Kode Panel' }}</th>
            <th colspan="2" style="width: 30%" class="ui center aligned">{{ __('Hasil Pemeriksaan Peserta') }}</th>
            <th colspan="2" style="width: 30%" class="ui center aligned">{{ __('Hasil Rujukan') }}</th>
            <th rowspan="2" style="width: 15%" class="ui center aligned">{{ __('Skor Peserta') }}</th>
        </tr>
        <tr>
            <th style="width: 15%" class="ui center aligned">{{ 'Interpretasi Hasil' }}</th>
            <th style="width: 15%" class="ui center aligned">{{ 'Titer' }}</th>
            <th style="width: 15%" class="ui center aligned">{{ 'Interpretasi Hasil' }}</th>
            <th style="width: 15%" class="ui center aligned">{{ 'Titer' }}</th>
        </tr>
        </thead>
        <tbody>
        @for($i = 0; $i < 3; $i++)
            <tr>
                <th class="ui center aligned">{{ $i + 1 }}</th>

                @php
                    $selected = $f->{'kode_panel_'.$i}
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
                    $selected = $daftar_pilihan_interpretasi_hasil->where('value', '=', $f->{'hasil_'.$i})->first();
                @endphp
                @if($selected != null)
                    <td class="center aligned">
                        {{ $selected->text }}
                    </td>
                @else
                    <td class="warning center aligned">
                        <i>{{ 'Tidak dipilih' }}</i>
                    </td>
                @endif

                @php
                    $selected = $daftar_pilihan_titer_tpha->where('value', '=', $f->{'titer_tpha_'.$i})->first();
                @endphp
                @if($selected != null)
                    <td class="center aligned">
                        {{ $selected->text }}
                    </td>
                @else
                    <td class="warning center aligned">
                        <i>{{ 'Tidak dipilih' }}</i>
                    </td>
                @endif

                <td>
                    <div class="form-group">
                        @php
                            $hasil = isset($scoreValue->{'tpha'}->{'interpretasi_hasil'}[$i]) ? $scoreValue->{'tpha'}->{'interpretasi_hasil'}[$i] : '';
                        @endphp
                        <select name="{{'tpha[interpretasi_hasil][]'}}" class="ui search dropdown fluid" style="width: 100%;" tabindex="-1" aria-hidden="true">
                            <option selected="selected" value="">-- Pilih --</option>
                            @foreach($daftar_pilihan_interpretasi_hasil as $pilihan_interpretasi_hasil)
                                <option value="{{ $pilihan_interpretasi_hasil->value }}" @if($hasil == $pilihan_interpretasi_hasil->value) selected @endif>{{ $pilihan_interpretasi_hasil->text }}</option>
                            @endforeach
                        </select>
                    </div>
                </td>

                <td>
                    <div class="form-group">
                        @php
                            $titer = isset($scoreValue->{'tpha'}->{'titer'}[$i]) ? $scoreValue->{'tpha'}->{'titer'}[$i] : '';
                        @endphp
                        <select name="{{'tpha[titer][]'}}" class="ui search dropdown fluid" style="width: 100%;" tabindex="-1" aria-hidden="true">
                            <option selected="selected" value="">-- Pilih --</option>
                            @foreach($daftar_pilihan_titer_tpha as $pilihan_titer)
                                <option value="{{ $pilihan_titer->value }}" @if($titer == $pilihan_titer->value) selected @endif>{{ $pilihan_titer->text }}</option>
                            @endforeach
                        </select>
                    </div>
                </td>

                <td>
                    <div class="form-group">
                        @php
                            $selected = isset($scoreValue->{'tpha'}->{'score'}[$i]) ? $scoreValue->{'tpha'}->{'score'}[$i] : '';
                        @endphp
                        <select name="{{'tpha[score][]'}}" class="ui search dropdown fluid" style="width: 100%;" tabindex="-1" aria-hidden="true">
                            <option selected="selected" value="">-- Pilih --</option>
                            @foreach($daftar_pilihan_nilai_tpha as $pilihan)
                                <option value="{{ $pilihan->value }}" @if($selected == $pilihan->value) selected @endif>{{ $pilihan->text }}</option>
                            @endforeach
                        </select>
                    </div>
                </td>
            </tr>
        @endfor
        </tbody>
    </table>

    <div class="field">
        <label>{{ 'Saran (TPHA)' }}</label>
        <textarea class="form-control" rows="3" placeholder="Tulis saran" name="{{ 'tpha[advice]' }}">{{ $scoreValue->{'tpha'}->{'advice'} ?? '' }}</textarea>
    </div>

    <h4 class="ui horizontal divider header">
        RPR
    </h4>

    <table class="table ui celled">
        <thead>
        <tr>
            <th class="ui center aligned" style="width: 20%">{{ 'Metode Pemeriksaan' }}</th>
            <th class="ui center aligned" style="width: 20%">{{ 'Nama Reagen' }}</th>
            <th class="ui center aligned" style="width: 20%">{{ 'Nama Produsen' }}</th>
            <th class="ui center aligned" style="width: 20%">{{ 'Nama Lot / Batch' }}</th>
            <th class="ui center aligned" style="width: 20%">{{ 'Tanggal Kadaluarsa' }}</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            @php
                $selected = $daftar_pilihan_metode_rpr->where('value', '=', $f->{'metode_rpr'})->first();
            @endphp
            @if($selected != null)
                <td class="center aligned">
                    {{ $selected->text }}
                </td>
            @else
                <td class="warning center aligned">
                    <i>{{ 'Tidak dipilih' }}</i>
                </td>
            @endif

            @php
                $selected = $f->{'nama_reagen_rpr'}
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
                $selected = $f->{'nama_produsen_reagen_rpr'}
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
                $selected = $f->{'lot_reagen_rpr'}
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
                $selected = $f->{'tanggal_kadaluarsa_rpr'}
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

    <table class="table ui celled">
        <thead>
        <tr>
            <th rowspan="2" style="width: 5%" class="ui center aligned">#</th>
            <th rowspan="2" class="ui center aligned" style="width: 20%">{{ 'Kode Panel' }}</th>
            <th colspan="2" style="width: 30%" class="ui center aligned">{{ __('Hasil Pemeriksaan Peserta') }}</th>
            <th colspan="2" style="width: 30%" class="ui center aligned">{{ __('Hasil Rujukan') }}</th>
            <th rowspan="2" style="width: 15%" class="ui center aligned">{{ __('Skor Peserta') }}</th>
        </tr>
        <tr>
            <th style="width: 15%" class="ui center aligned">{{ 'Interpretasi Hasil' }}</th>
            <th style="width: 15%" class="ui center aligned">{{ 'Titer' }}</th>
            <th style="width: 15%" class="ui center aligned">{{ 'Interpretasi Hasil' }}</th>
            <th style="width: 15%" class="ui center aligned">{{ 'Titer' }}</th>
        </tr>
        </thead>
        <tbody>
        @for($i = 0; $i < 3; $i++)
            <tr>
                <th class="ui center aligned">{{ $i + 1 }}</th>

                @php
                    $selected = $f->{'kode_panel_'.$i}
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
                    $selected = $daftar_pilihan_interpretasi_hasil->where('value', '=', $f->{'hasil_semi_kuantitatif_'.$i})->first();
                @endphp
                @if($selected != null)
                    <td class="center aligned">
                        {{ $selected->text }}
                    </td>
                @else
                    <td class="warning center aligned">
                        <i>{{ 'Tidak dipilih' }}</i>
                    </td>
                @endif

                @php
                    $selected = $daftar_pilihan_titer_rpr->where('value', '=', $f->{'titer_'.$i})->first();
                @endphp
                @if($selected != null)
                    <td class="center aligned">
                        {{ $selected->text }}
                    </td>
                @else
                    <td class="warning center aligned">
                        <i>{{ 'Tidak dipilih' }}</i>
                    </td>
                @endif

                <td>
                    <div class="form-group">
                        @php
                            $hasil = isset($scoreValue->{'rpr'}->{'interpretasi_hasil'}[$i]) ? $scoreValue->{'rpr'}->{'interpretasi_hasil'}[$i] : '';
                        @endphp
                        <select name="{{'rpr[interpretasi_hasil][]'}}" class="ui search dropdown fluid" style="width: 100%;" tabindex="-1" aria-hidden="true">
                            <option selected="selected" value="">-- Pilih --</option>
                            @foreach($daftar_pilihan_interpretasi_hasil as $pilihan_interpretasi_hasil)
                                <option value="{{ $pilihan_interpretasi_hasil->value }}" @if($hasil == $pilihan_interpretasi_hasil->value) selected @endif>{{ $pilihan_interpretasi_hasil->text }}</option>
                            @endforeach
                        </select>
                    </div>
                </td>

                <td>
                    <div class="form-group">
                        @php
                            $titer = isset($scoreValue->{'rpr'}->{'titer'}[$i]) ? $scoreValue->{'rpr'}->{'titer'}[$i] : '';
                        @endphp
                        <select name="{{'rpr[titer][]'}}" class="ui search dropdown fluid" style="width: 100%;" tabindex="-1" aria-hidden="true">
                            <option selected="selected" value="">-- Pilih --</option>
                            @foreach($daftar_pilihan_titer_rpr as $pilihan_titer)
                                <option value="{{ $pilihan_titer->value }}" @if($titer == $pilihan_titer->value) selected @endif>{{ $pilihan_titer->text }}</option>
                            @endforeach
                        </select>
                    </div>
                </td>

                <td>
                    <div class="form-group">
                        @php
                            $selected = isset($scoreValue->{'rpr'}->{'score'}[$i]) ? $scoreValue->{'rpr'}->{'score'}[$i] : '';
                        @endphp
                        <select name="{{'rpr[score][]'}}" class="ui search dropdown fluid" style="width: 100%;" tabindex="-1" aria-hidden="true">
                            <option selected="selected" value="">-- Pilih --</option>
                            @foreach($daftar_pilihan_nilai_rpr as $pilihan)
                                <option value="{{ $pilihan->value }}" @if($selected == $pilihan->value) selected @endif>{{ $pilihan->text }}</option>
                            @endforeach
                        </select>
                    </div>
                </td>
            </tr>
        @endfor
        </tbody>
    </table>

    <div class="field">
        <label>{{ 'Saran (RPR)' }}</label>
        <textarea class="form-control" rows="3" placeholder="Tulis saran" name="{{ 'rpr[advice]' }}">{{ $scoreValue->{'rpr'}->{'advice'} ?? '' }}</textarea>
    </div>

    <div class="ui divider"></div>

    <table class="ui table celled">
        <thead>
        <tr>
            <th style="width: 100%" class="center aligned">{{ 'Saran' }}</th>
        </tr>
        </thead>
        <tbody>
        <tr>
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