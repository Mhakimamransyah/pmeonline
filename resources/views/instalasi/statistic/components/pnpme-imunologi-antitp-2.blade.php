@php
    use Illuminate\Support\Facades\DB;

    $package = \App\Package::query()->where('id', '=', request()->query('package_id'))->get()->first();
    $injects = $package->injects()->get();

    $table_kualifikasi_pemeriksa = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualifikasi Pemeriksa'; })->first()->option->table_name;
    $qualifications = DB::table($table_kualifikasi_pemeriksa)->get();

    $index = 0
@endphp

<div class="ui raised green segment" style="overflow-y: scroll">
    <table class="ui table structured celled" style="width: 1900px">
        <thead>
        <tr>
            <th class="center aligned" rowspan="3">No.</th>
            <th class="center aligned" rowspan="3">Kode Peserta</th>
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
                            {{ $submitValue->{'nama_reagen'} }}
                        @else
                            {{ '-' }}
                        @endif
                    </td>
                    <td class="center aligned">
                        @if(isset($submitValue->{'hasil_'.$h}))
                            {{ $submitValue->{'hasil_'.$h} }}
                        @else
                            {{ '-' }}
                        @endif
                    </td>
                    <td class="center aligned">
                        @if(isset($submitValue->{'titer_'.$h}))
                            {{ $submitValue->{'titer_'.$h} }}
                        @else
                            {{ '-' }}
                        @endif
                    </td>
                    <td class="center aligned">
                        @if(isset($scoreValue->{'rujukan_hasil'}[$h]))
                            {{ $scoreValue->{'rujukan_hasil'}[$h] }}
                        @else
                            {{ '-' }}
                        @endif
                    </td>
                    <td class="center aligned">
                        @if(isset($scoreValue->{'rujukan_titer'}[$h]))
                            {{ $scoreValue->{'rujukan_titer'}[$h] }}
                        @else
                            {{ '-' }}
                        @endif
                    </td>
                    <td class="center aligned">
                        @if(isset($scoreValue->{'score'}[$h]))
                            @php
                                $selected = $scoreValue->{'score'}[$h];
                            @endphp
                            {{ $selected }}
                        @else
                            {{ '-' }}
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
                            {{ '-' }}
                        @endif
                    </td>
                </tr>
            @endfor

        @endforeach
        </tbody>
    </table>
</div>