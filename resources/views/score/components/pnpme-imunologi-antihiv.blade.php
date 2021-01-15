@php
    use Illuminate\Support\Facades\DB;

    $parameterName = 'Anti HIV';
    $f = new stdClass();
    $order_id = request()->query('order_id');
    $filled_form = \App\Submit::query()->where('order_id', '=', $order_id)->get()->first();
    if ($filled_form->value != null) {
        $f = json_decode($filled_form->value);
    }
@endphp

<h3 class="text-center"><b>PROGRAM NASIONAL PEMANTAPAN MUTU EKSTERNAL BIDANG IMUNOLOGI<br/>
        HASIL EVALUASI PARAMETER {{ strtoupper($parameterName) }}<br/>
        SIKLUS II - TAHUN 2018</b>
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
        <th class="text-center">Rata2</th>
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
                    <td class="text-center" rowspan="3"></td>
                @endif

                <td class="text-center">{{ 'Tes ' . ($test + 1) }}</td>

                <td class="text-center"></td>

                <td class="text-center"></td>

                <td class="text-center"></td>

                <td class="text-center"></td>

                <td class="text-center"></td>

                @if($test == 0)

                    <td rowspan="3" class="text-center">
                        -
                    </td>

                    <td rowspan="3" class="text-center">
                        -
                    </td>

                    <td rowspan="3" class="text-center">
                        -
                    </td>

                    <td rowspan="3" class="text-center">
                        -
                    </td>
                @endif
            </tr>
        @endfor
    @endfor
    </tbody>
    <tfoot>
    <tr>
        <th colspan="7" class="text-center">{{ 'Rata-Rata Nilai Ketepatan Hasil' }}</th>
        <th class="text-center"></th>
        <th class="text-center"></th>
        <th class="text-center"></th>
        <th class="text-center"></th>
    </tr>
    </tfoot>
</table>

<br/>
<br/>
<b>{{ 'Komentar / Saran' }}</b><br/>