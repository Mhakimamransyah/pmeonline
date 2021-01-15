@php
    use Illuminate\Support\Facades\DB;

    $packageId = request('package_id');

    $parameterName = 'Anti HIV';

    $packageInjectData = \App\Package::query()->where('name', 'pnpme-imunologi-antihiv-3')->get()->first();
    $injects = $packageInjectData->injects()->get();

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
@endphp

<div class="medium-form" style="margin-top: 24px">

    <div class="medium-form-content">

        <div class="ui raised green segment">

            <a class="ui green ribbon label">{{ 'Rekap Data ' . $parameterName }}</a>

            <br/>
            <br/>

            <div style="overflow-x: scroll;">

                <table class="ui table celled structured" style="min-width: 1366px;">
                    <thead>
                    <tr>
                        <th rowspan="2" class="center aligned">No.</th>
                        <th rowspan="2" class="center aligned">Nama Instansi</th>
                        <th rowspan="2" class="center aligned">No. Peserta</th>
                        <th rowspan="2" class="center aligned">Kode Panel</th>
                        <th rowspan="2" class="center aligned">Tes</th>
                        <th rowspan="2" class="center aligned">Metode</th>
                        <th rowspan="2" class="center aligned">Reagen</th>
                        <th rowspan="2" class="center aligned">Hasil Pemeriksaan</th>
                        <th rowspan="2" class="center aligned">Hasil Rujukan</th>
                        <th rowspan="2" class="center aligned">Skor</th>
                        <th colspan="3" class="center aligned">Ketepatan Hasil</th>
                        <th colspan="3" class="center aligned">Kesesuaian Strategi</th>
                        <th rowspan="2" class="center aligned">Saran</th>
                    </tr>
                    <tr>
                        <th class="center aligned">Nilai</th>
                        <th class="center aligned">Rata-Rata</th>
                        <th class="center aligned">Kategori</th>
                        <th class="center aligned">Nilai</th>
                        <th class="center aligned">Rata-Rata</th>
                        <th class="center aligned">Kategori</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $index = 1;
                    @endphp
                    @foreach($submits as $submit)

                        @php
                            $submitValue = json_decode($submit->value);
                            $score = $submit->order->score;
                            if ($score != null && $score->value != null) {
                                $scoreValue = json_decode($score->value);
                            } else {
                                $scoreValue = null;
                            }

                            $scorePerTest = [];
                            $scorePerPanel = [];
                        @endphp

                        <td rowspan="10" class="center aligned">{{ $index }}</td>
                        <td rowspan="10" class="center aligned" style="max-width: 300px;">{{ $submit->order->invoice->laboratory->name }}</td>
                        <td rowspan="10" class="center aligned">{{ $submit->order->invoice->laboratory->participant_number }}</td>

                        @for($panel = 0; $panel < 3; $panel++)
                            @for($test = 0; $test < 3; $test++)
                                <tr>
                                    @if($test == 0)
                                        @php
                                            $selected = $submitValue->{'kode_panel_'.$panel};
                                        @endphp
                                        @if ($selected != null)
                                            <td class="center aligned" rowspan="3">
                                                {{ $selected }}
                                            </td>
                                        @else
                                            <td class="center aligned" rowspan="3">
                                                <i>{{ '' }}</i>
                                            </td>
                                        @endif
                                    @endif

                                    <td class="center aligned">{{ 'Tes ' . ($test + 1) }}</td>

                                    @php
                                        $selected = $daftar_pilihan_metode_pemeriksaan->where('value', '=', $submitValue->{'metode_pemeriksaan_tes'.($test+1)})->first();
                                    @endphp
                                    @if($selected != null)
                                        <td class="center aligned">
                                            {{ $selected->text }}
                                        </td>
                                    @else
                                        <td class="center aligned">
                                            <i>{{ '' }}</i>
                                        </td>
                                    @endif

                                    @php
                                        $selected = $reagens->where('value', '=', $submitValue->{'reagen_tes'.($test+1)})->first();
                                    @endphp
                                    @if($selected != null)
                                        @if($selected->value == '--')
                                            <td class="center aligned">
                                                {{ 'Reagen tidak terdaftar' }}
                                            </td>
                                        @else
                                            <td class="center aligned">
                                                {{ $selected->text }}
                                            </td>
                                        @endif
                                    @else
                                        <td class="center aligned">
                                            <i>{{ '' }}</i>
                                        </td>
                                    @endif

                                    @php
                                        $selected = $daftar_pilihan_interpretasi_hasil->where('value', '=', $submitValue->{'hasil_panel_'.$panel.'_tes_'.($test+1)})->first();
                                    @endphp
                                    @if ($selected != null)
                                        <td class="center aligned">
                                            {{ $selected->text }}
                                        </td>
                                    @else
                                        <td class="center aligned">
                                            <i>{{ '' }}</i>
                                        </td>
                                    @endif

                                    @if($scoreValue != null && isset($scoreValue->{'panel'}))
                                        @php
                                            $selected = $daftar_pilihan_interpretasi_hasil->where('value', '=', $scoreValue->{'panel'}[$panel]->{'tes'}->{'answer'}[$test])->first();
                                        @endphp
                                        @if ($selected != null)
                                            <td class="center aligned">
                                                {{ $selected->text }}
                                            </td>
                                        @else
                                            <td class="center aligned">
                                                <i>{{ '' }}</i>
                                            </td>
                                        @endif

                                        @php
                                            $selected = $scoreValue->{'panel'}[$panel]->{'tes'}->{'score'}[$test];
                                        @endphp
                                        @if ($selected != null)
                                            <td class="center aligned">
                                                {{ $selected }}
                                            </td>
                                        @else
                                            <td class="center aligned">
                                                <i>{{ '' }}</i>
                                            </td>
                                        @endif

                                        @if($test == 0)

                                            @php
                                                $sum = array_sum($scoreValue->{'panel'}[$panel]->{'tes'}->{'score'});
                                                $count = count(array_filter($scoreValue->{'panel'}[$panel]->{'tes'}->{'score'}, function ($item) { return $item != null; }));
                                            @endphp

                                            @if($count > 0)
                                                @php
                                                    array_push($scorePerTest, $sum / $count)
                                                @endphp
                                                <td rowspan="3" class="center aligned">
                                                    {{ $sum }}
                                                </td>
                                            @else
                                                <td rowspan="3" class="center aligned">
                                                    -
                                                </td>
                                            @endif

                                            @if($count > 0)
                                                <td rowspan="3" class="center aligned">
                                                    {{ number_format($sum / $count, 0) }}
                                                </td>
                                            @else
                                                <td rowspan="3" class="center aligned">
                                                    -
                                                </td>
                                            @endif

                                            @if($count > 0)
                                                @if($sum / $count == 4)
                                                    <td rowspan="3" class="center aligned positive">
                                                        {{ 'Baik' }}
                                                    </td>
                                                @else
                                                    <td rowspan="3" class="center aligned negative">
                                                        {{ 'Tidak Baik' }}
                                                    </td>
                                                @endif
                                            @else
                                                <td rowspan="3" class="center aligned">
                                                    -
                                                </td>
                                            @endif

                                            @php
                                                $score = $scoreValue->{'panel'}[$panel]->{'score'};
                                                array_push($scorePerPanel, $score)
                                            @endphp
                                            <td rowspan="3" class="center aligned">
                                                {{ $score }}
                                            </td>

                                            <td rowspan="3" class="center aligned">
                                                {{ $score }}
                                            </td>

                                            @if($score == 5)
                                                <td rowspan="3" class="center aligned positive">
                                                    {{ 'Sesuai' }}
                                                </td>
                                            @else
                                                <td rowspan="3" class="center aligned negative">
                                                    {{ 'Tidak Sesuai' }}
                                                </td>
                                            @endif

                                        @endif

                                    @else

                                        <td class="center aligned warning">
                                            <i>{{ 'Belum dinilai' }}</i>
                                        </td>

                                        <td class="center aligned warning">
                                            <i>{{ 'Belum dinilai' }}</i>
                                        </td>

                                        @if($test == 0)

                                            <td rowspan="3" class="center aligned warning">
                                                <i>{{ 'Belum dinilai' }}</i>
                                            </td>

                                            <td rowspan="3" class="center aligned warning">
                                                <i>{{ 'Belum dinilai' }}</i>
                                            </td>

                                            <td rowspan="3" class="center aligned warning">
                                                <i>{{ 'Belum dinilai' }}</i>
                                            </td>

                                            <td rowspan="3" class="center aligned warning">
                                                <i>{{ 'Belum dinilai' }}</i>
                                            </td>

                                            <td rowspan="3" class="center aligned warning">
                                                <i>{{ 'Belum dinilai' }}</i>
                                            </td>

                                            <td rowspan="3" class="center aligned warning">
                                                <i>{{ 'Belum dinilai' }}</i>
                                            </td>

                                        @endif

                                    @endif
                                    @if($panel == 0 && $test == 0)
                                        @if ($scoreValue != null)
                                            <td rowspan="9" class="center aligned">{{ $scoreValue->advice }}</td>
                                        @else
                                            <td rowspan="9" class="center aligned warning"><i>{{ 'Belum dinilai' }}</i></td>
                                        @endif
                                    @endif
                                </tr>
                            @endfor
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
