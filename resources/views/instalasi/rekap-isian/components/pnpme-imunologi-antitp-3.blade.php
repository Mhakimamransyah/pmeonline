@php
    use Illuminate\Support\Facades\DB;

    $package = \App\Package::query()->where('id', '=', request()->query('package_id'))->get()->first();
    $injects = $package->injects()->get();

    $table_kualifikasi_pemeriksa = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualifikasi Pemeriksa'; })->first()->option->table_name;
    $qualifications = DB::table($table_kualifikasi_pemeriksa)->get();

    $table_kualitas_bahan = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualitas Bahan'; })->first()->option->table_name;
    $daftar_pilihan_kualitas_bahan = DB::table($table_kualitas_bahan)->get();

    $table_daftar_pilihan_interpretasi_hasil = $injects->filter(function ($inject) { return $inject->name == 'Daftar Pilihan Interpretasi Hasil'; })->first()->option->table_name;
    $daftar_pilihan_interpretasi_hasil = DB::table($table_daftar_pilihan_interpretasi_hasil)->get();

    $table_daftar_pilihan_titer_tpha = $injects->filter(function ($inject) { return $inject->name == 'Daftar Pilihan Titer'; })->first()->option->table_name;
    $daftar_pilihan_titer_tpha = DB::table($table_daftar_pilihan_titer_tpha)->get();

    $index = 0
@endphp

<div class="ui raised green segment" style="overflow-y: scroll">
    <table class="ui table structured celled" style="width: 1900px">
        <thead>
        <tr>
            <th class="center aligned" rowspan="2">No.</th>
            <th class="center aligned" rowspan="2">Nama Instansi</th>
            <th class="center aligned" rowspan="2">Kode Peserta</th>
            <th class="center aligned" rowspan="2">{{ 'Panel' }}</th>
            <th class="center aligned" rowspan="2">{{ 'Metode Pemeriksaan' }}</th>
            <th class="center aligned" rowspan="2">{{ 'Nama Reagen' }}</th>
            <th class="center aligned" colspan="2">{{ 'Hasil Pemeriksaan' }}</th>
        </tr>
        <tr>
            <th class="center aligned">{{ 'Hasil' }}</th>
            <th class="center aligned">{{ 'Titer' }}</th>
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
                    <td class="center aligned">{{ $submitValue->{'kode_panel_'.$h} }}</td>
                    <td class="center aligned">
                        @if(isset($submitValue->{'metode_tpha'}))
                            {{ ucfirst($submitValue->{'metode_tpha'}) }}
                        @else
                            {{ '-' }}
                        @endif
                    </td>
                    <td class="center aligned">
                        @if(isset($submitValue->{'nama_reagen_tpha'}))
                            {{ $submitValue->{'nama_reagen_tpha'} }}
                        @else
                            {{ '-' }}
                        @endif
                    </td>
                    <td class="center aligned">
                        @if(isset($submitValue->{'hasil_'.$h}))
                            {{ ucfirst($submitValue->{'hasil_'.$h}) }}
                        @else
                            {{ '-' }}
                        @endif
                    </td>
                    <td class="center aligned">
                        @if(isset($submitValue->{'titer_tpha_'.$h}))
                            {{ $submitValue->{'titer_tpha_'.$h} }}
                        @else
                            {{ '-' }}
                        @endif
                    </td>
                </tr>
            @endfor

        @endforeach
        </tbody>
    </table>
</div>