@php
use Illuminate\Support\Facades\DB;

$parameterName = 'Anti HIV';
$f = new stdClass();
$order_id = request()->query('order_id');
$filled_form = \App\Submit::query()->where('order_id', '=', $order_id)->get()->first();
if ($filled_form->value != null) {
$f = json_decode($filled_form->value);
}

$injects = $filled_form->order->package->injects()->get();

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

$scorePerTest = [];
$scorePerPanel = [];
@endphp

<h3 class="text-center"><b>PROGRAM NASIONAL PEMANTAPAN MUTU EKSTERNAL BIDANG IMUNOLOGI<br/>
    HASIL EVALUASI PARAMETER {{ strtoupper($parameterName) }}<br/>
SIKLUS IMUNOLOGI - TAHUN 2019</b>
</h3>

<br/>

@component('score.identity-header', [
'submit' => $submit,
])
@endcomponent

<br/>

<div class="row">

    <div class="col-xs-12">

        <table class="table table-bordered">

            <thead>
                <tr>
                    <th rowspan="2" style="vertical-align: middle" class="text-center">Panel</th>
                    <th rowspan="2" style="vertical-align: middle" class="text-center">Tes</th>
                    <th rowspan="2" style="vertical-align: middle" class="text-center">Metode Pemeriksaan</th>
                    <th rowspan="2" style="vertical-align: middle" class="text-center">Nama Reagen</th>
                    <th rowspan="2" style="vertical-align: middle" class="text-center">Hasil Pemeriksaan</th>
                    <th rowspan="2" style="vertical-align: middle" class="text-center">Hasil Rujukan</th>
                    <th rowspan="1" colspan="3" style="vertical-align: middle" class="text-center">Ketepatan Hasil</th>
                    <th rowspan="1" colspan="2" style="vertical-align: middle" class="text-center">Kesesuaian Strategi</th>
                </tr>
                <tr>
                    <th class="text-center">Nilai</th>
                    <th class="text-center">Rata-<br/>Rata</th>
                    <th class="text-center">Kategori</th>
                    <th class="text-center">Nilai</th>
                    <th class="text-center">Kategori</th>
                </tr>
            </thead>
            <tbody>
                @for($panel = 0; $panel < 3; $panel++)
                @for($test = 0; $test < 3; $test++)
                <tr>
                    @if($test == 0)
                    @php
                    $selected = $submitValue->{'kode_panel_'.$panel};
                    @endphp
                    @if ($selected != null)
                    <td class="text-center" rowspan="3">
                        {{ $selected }}
                    </td>
                    @else
                    <td class="text-center" rowspan="3">
                        <i>{{ '' }}</i>
                    </td>
                    @endif
                    @endif

                    <td class="text-center">{{ 'Tes ' . ($test + 1) }}</td>

                    @php
                    $selected = $daftar_pilihan_metode_pemeriksaan->where('value', '=', $submitValue->{'metode_pemeriksaan_tes'.($test+1)})->first();
                    @endphp
                    @if($selected != null)
                    <td class="text-center">
                        {{ $selected->text }}
                    </td>
                    @else
                    <td class="text-center">
                        <i>{{ '' }}</i>
                    </td>
                    @endif

                    @php
                    $selected = $reagens->where('value', '=', $submitValue->{'reagen_tes'.($test+1)})->first();
                    @endphp
                    @if($selected != null)
                    @if($selected->value == '--')
                    <td class="text-center">
                        {{ 'Reagen tidak terdaftar' }}
                    </td>
                    @else
                    <td class="text-center">
                        {{ $selected->text }}
                    </td>
                    @endif
                    @else
                    <td class="text-center">
                        <i>{{ '' }}</i>
                    </td>
                    @endif

                    @php
                    $selected = $daftar_pilihan_interpretasi_hasil->where('value', '=', $submitValue->{'hasil_panel_'.$panel.'_tes_'.($test+1)})->first();
                    @endphp
                    @if ($selected != null)
                    <td class="text-center">
                        {{ $selected->text }}
                    </td>
                    @else
                    <td class="text-center">
                        <i>{{ '' }}</i>
                    </td>
                    @endif

                    @php
                    $selected = $daftar_pilihan_interpretasi_hasil->where('value', '=', $scoreValue->{'panel'}[$panel]->{'tes'}->{'answer'}[$test])->first();
                    @endphp
                    @if ($selected != null)
                    <td class="text-center">
                        {{ $selected->text }}
                    </td>
                    @else
                    <td class="text-center">
                        <i>{{ '' }}</i>
                    </td>
                    @endif

                    @php
                    $selected = $scoreValue->{'panel'}[$panel]->{'tes'}->{'score'}[$test];
                    @endphp
                    @if ($selected != null)
                    <td class="text-center">
                        {{ $selected }}
                    </td>
                    @else
                    <td class="text-center">
                        <i>{{ '' }}</i>
                    </td>
                    @endif

                    @if($test == 0)

                    @php
                    $sum = array_sum($scoreValue->{'panel'}[$panel]->{'tes'}->{'score'});
                    $count = count(array_filter($scoreValue->{'panel'}[$panel]->{'tes'}->{'score'},
                    function ($item) { return $item != null; }));
                    @endphp
                    @if($count > 0)
                    @php
                    array_push($scorePerTest, $sum / $count)
                    @endphp
                    <td rowspan="3" class="text-center">
                        {{ floor($sum / $count) }}
                    </td>
                    @else
                    <td rowspan="3" class="text-center">
                        -
                    </td>
                    @endif

                    @if($count > 0)
                    @if($sum / $count == 4)
                    <td rowspan="3" class="text-center">
                        {{ 'Baik' }}
                    </td>
                    @else
                    <td rowspan="3" class="text-center">
                        {{ 'Tidak Baik' }}
                    </td>
                    @endif
                    @else
                    <td rowspan="3" class="text-center">
                        -
                    </td>
                    @endif

                    @php
                    $score = $scoreValue->{'panel'}[$panel]->{'score'};
                    array_push($scorePerPanel, $score)
                    @endphp
                    <td rowspan="3" class="text-center">
                        {{ $score }}
                    </td>

                    @if($score == 5)
                    <td rowspan="3" class="text-center">
                        {{ 'Sesuai' }}
                    </td>
                    @else
                    <td rowspan="3" class="text-center">
                        {{ 'Tidak Sesuai' }}
                    </td>
                    @endif
                    @endif
                </tr>
                @endfor
                @endfor
            </tbody>
            <tfoot>
                <tr>
                    @php
                    $avgScorePerTest = array_sum($scorePerTest) / count($scorePerTest);
                    $avgScorePerPanel = array_sum($scorePerPanel) / count($scorePerPanel);

                    if($avgScorePerTest == 4)
                    $kebaikan_text = 'Baik';
                    else
                    $kebaikan_text = 'Tidak Baik';

                    if($avgScorePerPanel == 5)
                    $kesesuaian_text = 'Sesuai';
                    else
                    $kesesuaian_text = 'Tidak Sesuai';
                    @endphp
                    <th colspan="7" class="text-center">{{ 'Rata-Rata Nilai Ketepatan Hasil' }}</th>
                    <th class="text-center">
                        {{ number_format($avgScorePerTest, 0, ',', '.') }}
                    </th>
                    <th class="text-center">
                        @if ($avgScorePerTest == 4)
                        Baik
                        @else
                        Tidak Baik
                        @endif
                    </th>
                    <th class="text-center">
                        {{ number_format($avgScorePerPanel, 0, ',', '.') }}
                    </th>
                    <th class="text-center">
                        @if ($avgScorePerPanel == 5)
                        Sesuai
                        @else
                        Tidak Sesuai
                        @endif
                    </th>
                </tr>
            </tfoot>
        </table>

    </div>

</div>

<br/>
<br/>
<b>{{ 'Komentar / Saran' }}</b><br/>
<p>{!! 'Kategori ketepatan hasil parameter HIV, <b>' . strtolower($kebaikan_text) . '</b>. Kategori kesesuaian strategi,
    <b>' . strtolower($kesesuaian_text) . '</b>.' !!}</p>
    @if(isset($scoreValue->advice))
    <p>{{ $scoreValue->advice }}</p>
    @endif

    <br/>
    <br/>

    @component('score.signature', [
    'submit' => $submit
    ])
    @endcomponent