@php
    use Illuminate\Support\Facades\DB;

    $parameterName = 'Syphilis';

    $package = \App\Package::query()->where('id', '=', request()->query('package_id'))->get()->first();
    $injects = $package->injects()->get();

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

    $index = 0
@endphp

<div class="ui raised green segment" style="overflow-y: scroll">
    <table class="ui table structured celled" style="width: 1900px">
        <thead>
        <tr>
            <th class="center aligned" rowspan="3">No.</th>
            <th class="center aligned" rowspan="3">Nama Instansi</th>
            <th class="center aligned" rowspan="3">Kode Peserta</th>
            <th class="center aligned" colspan="5">Parameter TPHA</th>
            <th class="center aligned" colspan="5">Parameter RPR</th>
            <th class="center aligned" rowspan="3" width="20%">Saran</th>
            <th class="center aligned" rowspan="3" width="20%">Keterangan</th>
        </tr>
        <tr>
            <th class="center aligned" rowspan="2">{{ 'Panel' }}</th>
            <th class="center aligned" rowspan="2">{{ 'Metode Pemeriksaan' }}</th>
            <th class="center aligned" rowspan="2">{{ 'Nama Reagen' }}</th>
            <th class="center aligned" colspan="2">{{ 'Hasil Pemeriksaan' }}</th>
            <th class="center aligned" rowspan="2">{{ 'Panel' }}</th>
            <th class="center aligned" rowspan="2">{{ 'Metode Pemeriksaan' }}</th>
            <th class="center aligned" rowspan="2">{{ 'Nama Reagen' }}</th>
            <th class="center aligned" colspan="2">{{ 'Hasil Pemeriksaan' }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($submits as $filled_form)
            @php

                $index += 1;

                if ($filled_form->value != null) {
                    $submitValue = json_decode($filled_form->value);
                } else {
                    $submitValue = null;
                }

            @endphp

            @for($h = 0; $h < 3; $h++)
                <tr>
                    @if($h == 0)
                        <td class="center aligned" rowspan="3">{{ $index }}</td>
                        <td class="center aligned" rowspan="3">{{ $filled_form->order->invoice->laboratory->name ?? '-' }}</td>
                        <td class="center aligned" rowspan="3">{{ $filled_form->order->invoice->laboratory->participant_number ?? '-' }}</td>
                    @endif
                    @if(isset($submitValue->{'hasil_'.$h}))
                        <td class="center aligned">{{ $submitValue->{'kode_panel_'.$h} }}</td>
                        <td class="center aligned">
                            @if(isset($submitValue->{'metode_tpha'}))
                                @php
                                    $selected = $daftar_pilihan_metode_tpha->where('value', '=', $submitValue->{'metode_tpha'})->first();
                                @endphp
                                {{ $selected->text }}
                            @else
                                {{ '-' }}
                            @endif
                        </td>
                        <td class="center aligned">
                            @if(isset($submitValue->{'nama_reagen_tpha'}))
                                @php
                                    $selected = $submitValue->{'nama_reagen_tpha'} ?? '-';
                                @endphp
                                {{ $selected }}
                            @else
                                {{ '-' }}
                            @endif
                        </td>
                        <td class="center aligned">
                            @if(isset($submitValue->{'hasil_'.$h}))
                                @php
                                    $selected = $daftar_pilihan_interpretasi_hasil->where('value', '=', $submitValue->{'hasil_'.$h})->first();
                                @endphp
                                {{ $selected->text }}
                            @else
                                {{ '-' }}
                            @endif
                        </td>
                        <td class="center aligned">
                            @if(isset($submitValue->{'titer_tpha_'.$h}))
                                @php
                                    $selected = $daftar_pilihan_titer_tpha->where('value', '=', $submitValue->{'titer_tpha_'.$h})->first();
                                @endphp
                                {{ $selected->text }}
                            @else
                                {{ '-' }}
                            @endif
                        </td>

                    @else

                        @if ($h == 0)

                            <td rowspan="3" colspan="5" class="center aligned">{{ 'Tidak mengisi parameter TPHA' }}</td>

                        @endif

                    @endif

                    @if ($submitValue->{'metode_rpr'} != null)

                        <td class="center aligned">{{ $submitValue->{'kode_panel_'.$h} }}</td>
                        <td class="center aligned">
                            @if(isset($submitValue->{'metode_rpr'}))
                                @php
                                    $selected = $daftar_pilihan_metode_rpr->where('value', '=', $submitValue->{'metode_rpr'})->first();
                                @endphp
                                {{ $selected->text }}
                            @else
                                {{ '-' }}
                            @endif
                        </td>
                        <td class="center aligned">
                            @if(isset($submitValue->{'nama_reagen_rpr'}))
                                @php
                                    $selected = $submitValue->{'nama_reagen_rpr'} ?? '-';
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

                        @if ($h == 0)
                            <td rowspan="3" class="center aligned">{{ $submitValue->saran ?? '-' }}</td>
                            <td rowspan="3" class="center aligned">{{ $submitValue->keterangan ?? '-' }}</td>
                        @endif

                </tr>

                @else

                    @if ($h == 0)

                        <td rowspan="3" colspan="5" class="center aligned">{{ 'Tidak mengisi parameter RPR' }}</td>

                    @endif

                    @if ($h == 0)
                        <td rowspan="3" class="center aligned">{{ $submitValue->saran ?? '-' }}</td>
                        <td rowspan="3" class="center aligned">{{ $submitValue->keterangan ?? '-' }}</td>
                    @endif

                @endif
            @endfor

        @endforeach
        </tbody>
    </table>
</div>