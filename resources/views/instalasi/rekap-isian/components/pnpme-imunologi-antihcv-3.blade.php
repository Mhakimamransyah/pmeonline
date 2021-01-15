@php
    $packageId = request('package_id');
    $injects = \App\Package::findOrFail($packageId)->injects()->get();
@endphp

<div class="medium-form" style="margin-top: 24px">

    <div class="medium-form-content">

        <div class="ui raised green segment">

            <a class="ui green ribbon label">{{ 'Rekap Data Anti HCV' }}</a>

            <br/>
            <br/>

            <div style="overflow-x: scroll;">

                <table class="ui table structured celled" style="width: 1366px">
                    <thead>
                    <tr>
                        <th class="center aligned" rowspan="2">No.</th>
                        <th class="center aligned" rowspan="2">Nama Instansi</th>
                        <th class="center aligned" rowspan="2">Kode Peserta</th>
                        <th class="center aligned" rowspan="2">{{ 'Panel' }}</th>
                        <th class="center aligned" rowspan="2">{{ 'Metode Pemeriksaan' }}</th>
                        <th class="center aligned" rowspan="2">{{ 'Nama Reagen' }}</th>
                        <th class="center aligned" rowspan="2">{{ 'Hasil Pemeriksaan' }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $index = 1;
                    @endphp
                    @foreach($submits as $submit)
                        @php
                            $value = json_decode($submit->value);
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
