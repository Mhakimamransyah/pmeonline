@php
    use Illuminate\Support\Facades\DB;

    $parameterName = 'HBs Ag';

    $f = new stdClass();
    $order_id = request()->query('order_id');
    $filled_form = \App\Submit::query()->where('order_id', '=', $order_id)->get()->first();
    if ($filled_form->value != null) {
        $f = json_decode($filled_form->value);
    }

    $packageInjectData = \App\Package::query()->where('name', 'pnpme-imunologi-hbsag-3')->get()->first();
    $injects = $packageInjectData->injects()->get();

    $package = $filled_form->order->package;
    $parameters = $package->parameters;
    $cycle = $package->cycle;

    $table_kualifikasi_pemeriksa = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualifikasi Pemeriksa'; })->first()->option->table_name;
    $qualifications = DB::table($table_kualifikasi_pemeriksa)->get();

    $jumlahPanel = 3;

    $score = \App\v3\Score::query()->where('order_id', '=', $order_id)->get()->first();
    if ($score != null && $score->value != null) {
        $scoreValue = json_decode($score->value);
    }

    $scorePerPanel = [];

@endphp

<h3 class="text-center"><b>PROGRAM NASIONAL PEMANTAPAN MUTU EKSTERNAL BIDANG IMUNOLOGI<br/>
        HASIL EVALUASI PARAMETER {{ $parameterName }}<br/>
        {{ strtoupper($cycle->name) }}</b>
</h3>

<br/>

@component('score.identity-header', [
    'submit' => $submit,
])
@endcomponent

<br/>

<table class="table table-bordered">

    <thead>
    <tr>
        <th rowspan="2" class="text-center">{{ 'Panel' }}</th>
        <th rowspan="2" class="text-center">{{ 'Metode Pemeriksaan' }}</th>
        <th rowspan="2" class="text-center">{{ 'Reagen' }}</th>
        <th rowspan="2" class="text-center">{{ 'Hasil Pemeriksaan' }}</th>
        <th rowspan="2" class="text-center">{{ 'Hasil Rujukan' }}</th>
        <th colspan="2" class="text-center">{{ 'Ketepatan Hasil' }}</th>
    </tr>
    <tr>
        <th class="text-center">{{ 'Nilai' }}</th>
        <th class="text-center">{{ 'Kategori' }}</th>
    </tr>
    </thead>

    <tbody>
    @for($h = 0; $h < 3; $h++)
        <tr>
            <td class="text-center">{{ $f->{'kode_panel_'.$h} }}</td>
            <td class="text-center">
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
            <td class="text-center">{{ $f->{'nama_reagen'} }}</td>
            <td class="text-center">
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
            <td class="text-center">
                @php
                    $selected_hasil = isset($scoreValue->{'rujukan'}[$h]) ? $scoreValue->{'rujukan'}[$h] : '';
                @endphp
                @if($selected_hasil == 'reaktif')
                    {{ 'Reaktif' }}
                @elseif($selected_hasil == 'nonreaktif')
                    {{ 'Non Reaktif' }}
                @else
                    <i>Tidak diisi</i>
                @endif
            </td>
            <td class="text-center">
                @php
                    $score = isset($scoreValue->{'hasil'}[$h]) ? $scoreValue->{'hasil'}[$h] : '';
                    array_push($scorePerPanel, $score)
                @endphp
                {{ $score }}
            </td>
            <td class="text-center">
                @if($score == 4)
                    Baik
                @else
                    Tidak Baik
                @endif
            </td>
        </tr>
    @endfor
    </tbody>
    <tfoot>
    <tr>
        <th class="text-center" colspan="5">{{ 'Rata-Rata Nilai Ketepatan Hasil' }}</th>
        <th class="text-center">
            @php
                $avg = array_sum($scorePerPanel) / $jumlahPanel;
                if ($avg == 4) {
                    $kebaikan_text = "Baik";
                } else {
                    $kebaikan_text = "Tidak Baik";
                }
            @endphp
            {{ number_format($avg, 0) }}
        </th>
        <th class="text-center">
            {{ $kebaikan_text }}
        </th>
    </tr>
    </tfoot>

</table>

<br/>
<br/>
<b>{{ 'Komentar / Saran' }}</b><br/>
<p>{!! 'Kategori ketepatan hasil parameter HBs Ag saudara, <b>' . strtolower($kebaikan_text) . '</b>.' !!}</p>
{{ $scoreValue->saran ?? '-' }}

<br/>
<br/>

@component('score.signature', [
    'submit' => $submit
])
@endcomponent