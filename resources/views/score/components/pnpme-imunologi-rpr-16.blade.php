@php
    use Illuminate\Support\Facades\DB;

    $parameterName = 'RPR';

    $f = new stdClass();
    $order_id = request()->query('order_id');
    $filled_form = \App\Submit::query()->where('order_id', '=', $order_id)->get()->first();
    if ($filled_form->value != null) {
        $f = json_decode($filled_form->value);
    }

    $injects = $filled_form->order->package->injects()->get();

    $package = $filled_form->order->package;
    $parameters = $package->parameters;
    $cycle = $package->cycle;

    $table_kualifikasi_pemeriksa = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualifikasi Pemeriksa'; })->first()->option->table_name;
    $qualifications = DB::table($table_kualifikasi_pemeriksa)->get();

    $table_kualitas_bahan = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualitas Bahan'; })->first()->option->table_name;
    $daftar_pilihan_kualitas_bahan = DB::table($table_kualitas_bahan)->get();

    $table_daftar_pilihan_metode_rpr = $injects->filter(function ($inject) { return $inject->name == 'Daftar Pilihan Metode RPR'; })->first()->option->table_name;
    $daftar_pilihan_metode_rpr = DB::table($table_daftar_pilihan_metode_rpr)->get();

    $table_daftar_pilihan_interpretasi_hasil = $injects->filter(function ($inject) { return $inject->name == 'Daftar Pilihan Interpretasi Hasil'; })->first()->option->table_name;
    $daftar_pilihan_interpretasi_hasil = DB::table($table_daftar_pilihan_interpretasi_hasil)->get();

    $table_daftar_pilihan_titer_rpr = $injects->filter(function ($inject) { return $inject->name == 'Daftar Pilihan Titer RPR'; })->first()->option->table_name;
    $daftar_pilihan_titer_rpr = DB::table($table_daftar_pilihan_titer_rpr)->get();

    $table_daftar_pilihan_nilai_rpr = $injects->filter(function ($inject) { return $inject->name == 'Daftar Pilihan Nilai RPR'; })->first()->option->table_name;
    $daftar_pilihan_nilai_rpr = DB::table($table_daftar_pilihan_nilai_rpr)->get();

    $score = \App\v3\Score::query()->where('order_id', '=', $order_id)->get()->first();
    if ($score != null && $score->value != null) {
        $scoreValue = json_decode($score->value);
    }

    $rprScores = [];

    foreach ($scoreValue->rpr->score as $score) {
        if ($score != null) {
            array_push($rprScores, $score);
        }
    }
@endphp

<h3 class="text-center"><b>PROGRAM NASIONAL PEMANTAPAN MUTU EKSTERNAL BIDANG IMUNOLOGI<br/>
        HASIL EVALUASI PARAMETER {{ strtoupper($parameterName) }}<br/>
        {{ strtoupper($cycle->name) }}</b>
</h3>

<br/>

@component('score.identity-header', [
    'submit' => $submit,
])
@endcomponent

<br/>

@if (count($rprScores) > 0)

    <table class="table table-bordered">
        <thead>
        <tr>
            <th class="text-center" rowspan="2">{{ 'Panel' }}</th>
            <th class="text-center" rowspan="2">{{ 'Metode Pemeriksaan' }}</th>
            <th class="text-center" rowspan="2">{{ 'Nama Reagen' }}</th>
            <th class="text-center" colspan="2">{{ 'Hasil Pemeriksaan' }}</th>
            <th class="text-center" colspan="2">{{ 'Hasil Rujukan' }}</th>
            <th class="text-center" colspan="2">{{ 'Nilai Keterangan Hasil' }}</th>
        </tr>
        <tr>
            <th class="text-center">{{ 'Hasil' }}</th>
            <th class="text-center">{{ 'Titer' }}</th>
            <th class="text-center">{{ 'Hasil' }}</th>
            <th class="text-center">{{ 'Titer' }}</th>
            <th class="text-center">{{ 'Nilai' }}</th>
            <th class="text-center">{{ 'Kategori' }}</th>
        </tr>
        </thead>
        <tbody>
        @for($h = 0; $h < 3; $h++)
            <tr>
                <td class="text-center">{{ $submitValue->{'kode_panel_'.$h} }}</td>
                <td class="text-center">
                    @if(isset($submitValue->{'metode_rpr'}))
                        @php
                            $selected = $daftar_pilihan_metode_rpr->where('value', '=', $submitValue->{'metode_rpr'})->first();
                        @endphp
                        {{ $selected->text }}
                    @else
                        {{ '-' }}
                    @endif
                </td>
                <td class="text-center">
                    @if(isset($submitValue->{'nama_reagen_rpr'}))
                        @php
                            $selected = $submitValue->{'nama_reagen_rpr'} ?? '-';
                        @endphp
                        {{ $selected }}
                    @else
                        {{ '-' }}
                    @endif
                </td>
                <td class="text-center">
                    @if(isset($submitValue->{'hasil_semi_kuantitatif_'.$h}))
                        @php
                            $selected = $daftar_pilihan_interpretasi_hasil->where('value', '=', $submitValue->{'hasil_semi_kuantitatif_'.$h})->first();
                        @endphp
                        {{ $selected->text }}
                    @else
                        {{ '-' }}
                    @endif
                </td>
                <td class="text-center">
                    @if(isset($submitValue->{'titer_'.$h}))
                        @php
                            $selected = $daftar_pilihan_titer_rpr->where('value', '=', $submitValue->{'titer_'.$h})->first();
                        @endphp
                        {{ $selected->text }}
                    @else
                        {{ '-' }}
                    @endif
                </td>
                <td class="text-center">
                    @if(isset($scoreValue->{'rpr'}->{'interpretasi_hasil'}[$h]))
                        @php
                            $selected = $daftar_pilihan_interpretasi_hasil->where('value', '=', $scoreValue->{'rpr'}->{'interpretasi_hasil'}[$h])->first();
                        @endphp
                        {{ $selected->text }}
                    @else
                        {{ '-' }}
                    @endif
                </td>
                <td class="text-center">
                    @if(isset($scoreValue->{'rpr'}->{'titer'}[$h]))
                        @php
                            $selected = $daftar_pilihan_titer_rpr->where('value', '=', $scoreValue->{'rpr'}->{'titer'}[$h])->first();
                            $range = ($selected->id > 2) ? 2 : 1;
                            $lowerTiter = $daftar_pilihan_titer_rpr->where('id', '=', $selected->id - $range)->first();
                            $upperTiter = $daftar_pilihan_titer_rpr->where('id', '=', $selected->id + $range)->first();
                        @endphp
                        {{ $lowerTiter->text }} - {{ $upperTiter->text }}
                    @else
                        {{ '-' }}
                    @endif
                </td>
                <td class="text-center">
                    @if(isset($scoreValue->{'rpr'}->{'score'}[$h]))
                        @php
                            $selected = $scoreValue->{'rpr'}->{'score'}[$h];
                        @endphp
                        {{ $selected }}
                    @else
                        {{ '-' }}
                    @endif
                </td>
                <td class="text-center">
                    @if(isset($scoreValue->{'rpr'}->{'score'}[$h]))
                        @php
                            $selected = $scoreValue->{'rpr'}->{'score'}[$h];
                        @endphp
                        @if($selected == 4)
                            {{ 'Baik' }}
                        @else
                            {{ 'Tidak Baik' }}
                        @endif
                    @else
                        {{ '-' }}
                    @endif
                </td>
            </tr>
        @endfor
        </tbody>
        <tfoot>
        <tr>
            <th colspan="7" class="text-center">{{ 'Rata-Rata Nilai Ketepatan Hasil' }}</th>
            <th class="text-center">
                @php
                    $avgRpr = array_sum($rprScores) / count($rprScores);
                    $kebaikan_text_rpr = ($avgRpr == 4) ? 'Baik' : 'Tidak Baik';
                @endphp
                {{ number_format($avgRpr, 0) }}
            </th>
            <th class="text-center">
                {{ $kebaikan_text_rpr }}
            </th>
        </tr>
        </tfoot>
    </table>

    <br/>
    <br/>
    <b>{{ 'Komentar / Saran' }}</b><br/>
    <p>{!! 'Kategori ketepatan hasil parameter RPR, <b>' . strtolower($kebaikan_text_rpr) . '</b>.' !!}</p>
    @if(isset($scoreValue->rpr->advice))
        <p>{{ $scoreValue->rpr->advice }}</p>
    @endif

@endif

<br/>
<br/>

@component('score.signature', [
    'submit' => $submit
])
@endcomponent
