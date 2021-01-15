@php
    $packageId = request('package_id');
    $packageInjectData = \App\Package::query()->where('name', 'pnpme-imunologi-hbsag-3')->get()->first();
    $injects = $packageInjectData->injects()->get();
@endphp

<div class="medium-form" style="margin-top: 24px">

    <div class="medium-form-content">

        <div class="ui raised green segment">

            <a class="ui green ribbon label">{{ 'Rekap Data Anti HBsAg' }}</a>

            <br/>
            <br/>

            <div style="overflow-x: scroll;">

                <table class="ui table structured celled" style="width: 1366px">
                    <thead>
                    <tr>
                        <th class="center aligned" rowspan="2">No.</th>
                        <th rowspan="2" class="center aligned">Nama Instansi</th>
                        <th class="center aligned" rowspan="2">Kode Peserta</th>
                        <th class="center aligned" rowspan="2">{{ 'Panel' }}</th>
                        <th class="center aligned" rowspan="2">{{ 'Metode Pemeriksaan' }}</th>
                        <th class="center aligned" rowspan="2">{{ 'Nama Reagen' }}</th>
                        <th class="center aligned" rowspan="2">{{ 'Hasil Pemeriksaan' }}</th>
                        <th class="center aligned" rowspan="2">{{ 'Hasil Rujukan' }}</th>
                        <th class="center aligned" colspan="2">{{ 'Ketepatan Hasil' }}</th>
                        <th class="center aligned" rowspan="2">{{ 'Keterangan / Saran' }}</th>
                    </tr>
                    <tr>
                        <th class="center aligned">{{ 'Nilai' }}</th>
                        <th class="center aligned">{{ 'Kategori' }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $index = 1;
                    @endphp
                    @foreach($submits as $submit)
                        @php
                            $value = json_decode($submit->value);
                            $score = $submit->order->score;
                            if ($score != null) {
                                $scoreValue = json_decode($score->value);
                            } else {
                                $scoreValue = null;
                            }
                        @endphp
                        @for($h = 0; $h < 3; $h++)
                            <tr>
                                @if($h == 0)
                                    <td class="center aligned" rowspan="3">{{ $index }}</td>
                                    <td class="center aligned" rowspan="3">{{ $submit->order->invoice->laboratory->name ?? '-' }}</td>
                                    <td class="center aligned" rowspan="3">{{ $submit->order->invoice->laboratory->participant_number ?? '-' }}</td>
                                @endif
                                <td class="center aligned">{{ $value->{'kode_panel_'.$h} }}</td>
                                <td class="center aligned">{!! $value->{'metode_pemeriksaan'} ?? '<i>Tidak diisi</i>' !!}</td>
                                <td class="center aligned">{!! $value->{'nama_reagen'} ?? '<i>Tidak diisi</i>' !!}</td>
                                <td class="center aligned">{!! $value->{'hasil_'.$h} ?? '<i>Tidak diisi</i>' !!}</td>
                                <td class="center aligned">
                                    @if ($scoreValue != null)
                                        {!! $scoreValue->{'rujukan'}[$h] ?? '<i>Tidak diisi</i>' !!}
                                    @else
                                        <i>Belum dinilai</i>
                                    @endif
                                </td>
                                <td class="center aligned">
                                    @if ($scoreValue != null)
                                        {!! $scoreValue->{'hasil'}[$h] ?? '<i>Tidak diisi</i>' !!}
                                    @else
                                        <i>Belum dinilai</i>
                                    @endif
                                </td>
                                <td class="center aligned">
                                    @if ($scoreValue != null)
                                        @if($scoreValue->{'hasil'}[$h] == 4)
                                            Baik
                                        @else
                                            Tidak Baik
                                        @endif
                                    @else
                                        <i>Belum dinilai</i>
                                    @endif
                                </td>
                                <td class="center aligned">
                                    @if ($scoreValue != null)
                                        {{ $scoreValue->saran }}
                                    @else
                                        <i>Belum dinilai</i>
                                    @endif
                                </td>
                            </tr>
                        @endfor
                        @php
                            $index += 1;
                        @endphp
                    @endforeach
                    </tbody>
                </table>

            </div>

        </div>

    </div>

</div>
