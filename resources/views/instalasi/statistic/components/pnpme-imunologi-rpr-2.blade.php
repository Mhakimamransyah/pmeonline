@php
    use Illuminate\Support\Facades\DB;

    $parameterName = 'Syphilis';

    $package = \App\Package::query()->where('id', '=', request()->query('package_id'))->get()->first();
    $injects = $package->injects()->get();

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

    $index = 0
@endphp

<div class="ui raised green segment" style="overflow-y: scroll">
    <table class="ui table structured celled" style="width: 1900px">
        <thead>
        <tr>
            <th class="center aligned" rowspan="3">No.</th>
            <th class="center aligned" rowspan="3">Kode Peserta</th>
        </tr>
        <tr>
            <th class="center aligned" rowspan="2">{{ 'Panel' }}</th>
            <th class="center aligned" rowspan="2">{{ 'Metode Pemeriksaan' }}</th>
            <th class="center aligned" rowspan="2">{{ 'Nama Reagen' }}</th>
            <th class="center aligned" colspan="2">{{ 'Hasil Pemeriksaan' }}</th>
            <th class="center aligned" colspan="2">{{ 'Hasil Rujukan' }}</th>
            <th class="center aligned" colspan="2">{{ 'Ketepatan Hasil' }}</th>
        </tr>
        <tr>
            <th class="center aligned">{{ 'Hasil' }}</th>
            <th class="center aligned">{{ 'Titer' }}</th>
            <th class="center aligned">{{ 'Hasil' }}</th>
            <th class="center aligned">{{ 'Titer' }}</th>
            <th class="center aligned">{{ 'Nilai' }}</th>
            <th class="center aligned">{{ 'Kategori' }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($submits as $filled_form)
            @php

                $index += 1;

                if ($filled_form->value != null) {
                    $submitValue = json_decode($filled_form->value);
                }

                $score = \App\v3\Score::query()->where('order_id', '=', $filled_form->order_id)->get()->first();
                if ($score != null && $score->value != null) {
                    $scoreValue = json_decode($score->value);
                }

            @endphp

            @for($h = 0; $h < 3; $h++)
                <tr>
                    @if($h == 0)
                        <td class="center aligned" rowspan="3">{{ $index }}</td>
                        <td class="center aligned" rowspan="3">{{ $filled_form->order->invoice->laboratory->participant_number ?? '-' }}</td>
                    @endif

                        <td class="center aligned">{{ $submitValue->{'kode_panel_'.$h} }}</td>
                        <td class="center aligned">
                            @if(isset($submitValue->{'metode'}))
                                {{ $submitValue->{'metode'} }}
                            @else
                                {{ '-' }}
                            @endif
                        </td>
                        <td class="center aligned">
                            @if(isset($submitValue->{'nama_reagen'}))
                                @php
                                    $selected = $submitValue->{'nama_reagen'} ?? '-';
                                @endphp
                                {{ $selected }}
                            @else
                                {{ '-' }}
                            @endif
                        </td>
                        <td class="center aligned">
                            @if(isset($submitValue->{'hasil_semi_kuantitatif_'.$h}))
                                @php
                                    $selected = $daftar_pilihan_interpretasi_hasil->where('value', '=', $submitValue->{'hasil_semi_kuantitatif_'.$h})->first();
                                @endphp
                                {{ $selected->text }}
                            @else
                                {{ '-' }}
                            @endif
                        </td>
                        <td class="center aligned">
                            @if(isset($submitValue->{'titer_'.$h}))
                                @php
                                    $selected = $daftar_pilihan_titer_rpr->where('value', '=', $submitValue->{'titer_'.$h})->first();
                                @endphp
                                {{ $selected->text }}
                            @else
                                {{ '-' }}
                            @endif
                        </td>
                        <td class="center aligned">
                            @if(isset($scoreValue->{'rujukan_hasil'}[$h]))
                                @php
                                    $selected = $daftar_pilihan_interpretasi_hasil->where('value', '=', $scoreValue->{'rujukan_hasil'}[$h])->first();
                                @endphp
                                {{ $selected->text }}
                            @else
                                <i>Belum dinilai</i>
                            @endif
                        </td>
                        <td class="center aligned">
                            @if(isset($scoreValue->{'rujukan_titer'}[$h]))
                                {{ $scoreValue->{'rujukan_titer'}[$h] }}
                            @else
                                <i>-</i>
                            @endif
                        </td>
                        <td class="center aligned">
                            @if(isset($scoreValue->{'score'}[$h]))
                                @php
                                    $selected = $scoreValue->{'score'}[$h];
                                @endphp
                                {{ $selected }}
                            @else
                                <i>Belum dinilai</i>
                            @endif
                        </td>
                        <td class="center aligned">
                            @if(isset($scoreValue->{'score'}[$h]))
                                @php
                                    $selected = $scoreValue->{'score'}[$h];
                                @endphp
                                @if($selected == 4)
                                    {{ 'Baik' }}
                                @else
                                    {{ 'Tidak Baik' }}
                                @endif
                            @else
                                <i>Belum dinilai</i>
                            @endif
                        </td>

                </tr>

            @endfor

        @endforeach
        </tbody>
    </table>
</div>