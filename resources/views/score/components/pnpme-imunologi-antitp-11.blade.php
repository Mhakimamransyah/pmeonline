@php
    use Illuminate\Support\Facades\DB;

    $parameterName = 'TPHA';

    $f = new stdClass();
    $order_id = request()->query('order_id');
    $filled_form = \App\Submit::query()->where('order_id', '=', $order_id)->get()->first();
    if ($filled_form->value != null) {
        $f = json_decode($filled_form->value);
    }

    $packageInjectData = \App\Package::query()->where('name', 'pnpme-imunologi-antitp-3')->get()->first();
    $injects = $packageInjectData->injects()->get();

    $package = $filled_form->order->package;
    $parameters = $package->parameters;
    $cycle = $package->cycle;

    $table_kualifikasi_pemeriksa = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualifikasi Pemeriksa'; })->first()->option->table_name;
    $qualifications = DB::table($table_kualifikasi_pemeriksa)->get();

    $table_kualitas_bahan = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualitas Bahan'; })->first()->option->table_name;
    $daftar_pilihan_kualitas_bahan = DB::table($table_kualitas_bahan)->get();

    $table_daftar_pilihan_metode_tpha = $injects->filter(function ($inject) { return $inject->name == 'Daftar Pilihan Metode'; })->first()->option->table_name;
    $daftar_pilihan_metode_tpha = DB::table($table_daftar_pilihan_metode_tpha)->get();

    $table_daftar_pilihan_interpretasi_hasil = $injects->filter(function ($inject) { return $inject->name == 'Daftar Pilihan Interpretasi Hasil'; })->first()->option->table_name;
    $daftar_pilihan_interpretasi_hasil = DB::table($table_daftar_pilihan_interpretasi_hasil)->get();

    $table_daftar_pilihan_titer_tpha = $injects->filter(function ($inject) { return $inject->name == 'Daftar Pilihan Titer'; })->first()->option->table_name;
    $daftar_pilihan_titer_tpha = DB::table($table_daftar_pilihan_titer_tpha)->get();

    $score = \App\v3\Score::query()->where('order_id', '=', $order_id)->get()->first();
    if ($score != null && $score->value != null) {
        $scoreValue = json_decode($score->value);
    }

    $tphaScores = [];

    foreach ($scoreValue->tpha->score as $score) {
        if ($score != null) {
            array_push($tphaScores, $score);
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

@if (count($tphaScores) > 0)

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
                    @if(isset($submitValue->{'metode_tpha'}))
                        @php
                            $selected = $daftar_pilihan_metode_tpha->where('value', '=', $submitValue->{'metode_tpha'})->first();
                        @endphp
                        {{ $selected->text }}
                    @else
                        {{ '-' }}
                    @endif
                </td>
                <td class="text-center">
                    @if(isset($submitValue->{'nama_reagen_tpha'}))
                        @php
                            $selected = $submitValue->{'nama_reagen_tpha'} ?? '-';
                        @endphp
                        {{ $selected }}
                    @else
                        {{ '-' }}
                    @endif
                </td>
                <td class="text-center">
                    @if(isset($submitValue->{'hasil_'.$h}))
                        @php
                            $selected = $daftar_pilihan_interpretasi_hasil->where('value', '=', $submitValue->{'hasil_'.$h})->first();
                        @endphp
                        {{ $selected->text }}
                    @else
                        {{ '-' }}
                    @endif
                </td>
                <td class="text-center">
                    @if(isset($submitValue->{'titer_tpha_'.$h}))
                        @php
                            $selected = $daftar_pilihan_titer_tpha->where('value', '=', $submitValue->{'titer_tpha_'.$h})->first();
                        @endphp
                        {{ $selected->text }}
                    @else
                        {{ '-' }}
                    @endif
                </td>
                <td class="text-center">
                    @if(isset($scoreValue->{'tpha'}->{'interpretasi_hasil'}[$h]))
                        @php
                            $selected = $daftar_pilihan_interpretasi_hasil->where('value', '=', $scoreValue->{'tpha'}->{'interpretasi_hasil'}[$h])->first();
                        @endphp
                        {{ $selected->text }}
                    @else
                        {{ '-' }}
                    @endif
                </td>
                <td class="text-center">
                    @if(isset($scoreValue->{'tpha'}->{'titer'}[$h]))
                        @php
                            $selected = $daftar_pilihan_titer_tpha->where('value', '=', $scoreValue->{'tpha'}->{'titer'}[$h])->first();
                            $lowerTiter = $daftar_pilihan_titer_tpha->where('id', '=', $selected->id - 2)->first();
                            $upperTiter = $daftar_pilihan_titer_tpha->where('id', '=', $selected->id + 2)->first();
                        @endphp
                        {{ $lowerTiter->text }} - {{ $upperTiter->text }}
                    @else
                        {{ '-' }}
                    @endif
                </td>
                <td class="text-center">
                    @if(isset($scoreValue->{'tpha'}->{'score'}[$h]))
                        @php
                            $selected = $scoreValue->{'tpha'}->{'score'}[$h];
                        @endphp
                        {{ $selected }}
                    @else
                        {{ '-' }}
                    @endif
                </td>
                <td class="text-center">
                    @if(isset($scoreValue->{'tpha'}->{'score'}[$h]))
                        @php
                            $selected = $scoreValue->{'tpha'}->{'score'}[$h];
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
                    $avgTpha = array_sum($tphaScores) / count($tphaScores);
                    $kebaikan_text_tpha = ($avgTpha == 4) ? 'Baik' : 'Tidak Baik';
                @endphp
                {{ number_format($avgTpha, 0) }}

            </th>
            <th class="text-center">
                {{ $kebaikan_text_tpha }}
            </th>
        </tr>
        </tfoot>
    </table>

    <br/>
    <br/>
    <b>{{ 'Komentar / Saran' }}</b><br/>
    <p>{!! 'Kategori ketepatan hasil parameter TPHA, <b>' . strtolower($kebaikan_text_tpha) . '</b>.' !!}</p>
    @if(isset($scoreValue->tpha->advice))
        <p>{{ $scoreValue->tpha->advice }}</p>
    @endif

@endif

<br/>
<br/>

@component('score.signature', [
    'submit' => $submit
])
@endcomponent