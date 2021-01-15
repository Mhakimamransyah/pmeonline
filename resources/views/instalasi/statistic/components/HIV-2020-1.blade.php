@php
    use Illuminate\Support\Facades\DB;

    $packageId = request('package_id');

    $parameterName = 'Anti HIV';

    $injects = \App\Package::findOrFail($packageId)->injects()->get();

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
                        <th class="center aligned" rowspan="2" style="width: 4%;">No.</th>
                        <th class="center aligned" rowspan="2" style="width: 8%;">Kode Sample</th>
                        <th class="center aligned" rowspan="2" style="width: 16%;">Peserta</th>
                        <th class="center aligned" rowspan="2" style="width: 20%;">Nama Reagen yang Digunakan</th>
                        <th class="center aligned" colspan="6" style="width: 24%;">Hasil Lab. Peserta</th>
                        <th class="center aligned" colspan="3" style="width: 12%;">Hasil Rujukan</th>
                        <th class="center aligned" rowspan="2" style="width: 16%;">Keterangan</th>
                    </tr>
                    <tr>
                        <th class="center aligned" style="width: 4%;">Panel 1</th>
                        <th class="center aligned" style="width: 4%;">Kesesuaian Strategi</th>
                        <th class="center aligned" style="width: 4%;">Panel 2</th>
                        <th class="center aligned" style="width: 4%;">Kesesuaian Strategi</th>
                        <th class="center aligned" style="width: 4%;">Panel 3</th>
                        <th class="center aligned" style="width: 4%;">Kesesuaian Strategi</th>
                        <th class="center aligned" style="width: 4%;">Panel 1</th>
                        <th class="center aligned" style="width: 4%;">Panel 2</th>
                        <th class="center aligned" style="width: 4%;">Panel 3</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $index = 1;
                    @endphp
                    @foreach($submits as $submit)
                        <tr>
                            <td rowspan="3" class="center aligned">{{ $index }}</td>
                            @php
                                $value = json_decode($submit->value);
                                $score = $submit->order->score;
                                if ($score != null && $score->value != null) {
                                    $scoreValue = json_decode($score->value);
                                } else {
                                    $scoreValue = null;
                                }
                            @endphp
                            <td rowspan="3" class="center aligned">
                                {{ $value->{'kode_panel_0'} }} / {{ $value->{'kode_panel_1'} }} / {{ $value->{'kode_panel_2'} }}
                            </td>
                            <td rowspan="3" class="center aligned @if($submit->verified) positive @else warning @endif">{{ $submit->order->invoice->laboratory->name }}</td>
                            <td class="center aligned">
                                @php
                                    $reagen_tes = $reagens->first(function ($pilihan) use ($value) { return $pilihan->value == $value->{'reagen_tes1'} ?? ''; });
                                @endphp
                                @if ($reagen_tes != null)
                                    @if ($reagen_tes->value == "--")
                                        <i>Reagen tidak terdaftar</i>
                                    @else
                                        {{ $reagen_tes->text }}
                                    @endif
                                @else
                                    <i>{{ __('Tidak dipilih') }}</i>
                                @endif
                            </td>
                            <td class="center aligned">
                                @php
                                    $selected_hasil = $daftar_pilihan_interpretasi_hasil->first(function ($pilihan) use ($value) { return $pilihan->value == $value->{'hasil_panel_0_tes_1'} ?? ''; });
                                @endphp
                                @if ($selected_hasil != null)
                                    {{ $selected_hasil->text }}
                                @else
                                    <i>{{ __('Tidak dipilih') }}</i>
                                @endif
                            </td>
                            @if($score == null)
                                <td rowspan="3" class="center aligned warning"><i>Belum dinilai</i></td>
                            @else
                                @php
                                    $subScore = $scoreValue->{'panel'}[0]->score;
                                @endphp
                                @if($subScore == 0)
                                    <td rowspan="3" class="center aligned error">
                                        Tidak Sesuai
                                    </td>
                                @elseif($subScore == 5)
                                    <td rowspan="3" class="center aligned positive">
                                        Sesuai
                                    </td>
                                @else
                                    <td rowspan="3" class="center aligned warning">
                                        <i>Belum dinilai</i>
                                    </td>
                                @endif
                            @endif
                            <td class="center aligned">
                                @php
                                    $selected_hasil = $daftar_pilihan_interpretasi_hasil->first(function ($pilihan) use ($value) { return $pilihan->value == $value->{'hasil_panel_1_tes_1'} ?? ''; });
                                @endphp
                                @if ($selected_hasil != null)
                                    {{ $selected_hasil->text }}
                                @else
                                    <i>{{ __('Tidak dipilih') }}</i>
                                @endif
                            </td>
                            @if($score == null)
                                <td rowspan="3" class="center aligned warning"><i>Belum dinilai</i></td>
                            @else
                                @php
                                    $subScore = $scoreValue->{'panel'}[1]->score;
                                @endphp
                                @if($subScore == 0)
                                    <td rowspan="3" class="center aligned error">
                                        Tidak Sesuai
                                    </td>
                                @elseif($subScore == 5)
                                    <td rowspan="3" class="center aligned positive">
                                        Sesuai
                                    </td>
                                @else
                                    <td rowspan="3" class="center aligned warning">
                                        <i>Belum dinilai</i>
                                    </td>
                                @endif
                            @endif
                            <td class="center aligned">
                                @php
                                    $selected_hasil = $daftar_pilihan_interpretasi_hasil->first(function ($pilihan) use ($value) { return $pilihan->value == $value->{'hasil_panel_2_tes_1'} ?? ''; });
                                @endphp
                                @if ($selected_hasil != null)
                                    {{ $selected_hasil->text }}
                                @else
                                    <i>{{ __('Tidak dipilih') }}</i>
                                @endif
                            </td>
                            @if($score == null)
                                <td rowspan="3" class="center aligned warning"><i>Belum dinilai</i></td>
                            @else
                                @php
                                    $subScore = $scoreValue->{'panel'}[2]->score;
                                @endphp
                                @if($subScore == 0)
                                    <td rowspan="3" class="center aligned error">
                                        Tidak Sesuai
                                    </td>
                                @elseif($subScore == 5)
                                    <td rowspan="3" class="center aligned positive">
                                        Sesuai
                                    </td>
                                @else
                                    <td rowspan="3" class="center aligned warning">
                                        <i>Belum dinilai</i>
                                    </td>
                                @endif
                            @endif
                            @if($score == null)
                                <td rowspan="1" class="center aligned warning"><i>Belum dinilai</i></td>
                            @else
                                @php
                                    $answer = $scoreValue->{'panel'}[0]->tes->answer[0];
                                    $selected_answer = $daftar_pilihan_interpretasi_hasil->first(function ($pilihan) use ($answer) { return $pilihan->value == $answer ?? ''; });
                                @endphp
                                @if($selected_answer != null)
                                    <td class="center aligned">
                                        {{ $selected_answer->text }}
                                    </td>
                                @else
                                    <td class="center aligned warning">
                                        <i>Belum dinilai</i>
                                    </td>
                                @endif
                            @endif
                            @if($score == null)
                                <td rowspan="1" class="center aligned warning"><i>Belum dinilai</i></td>
                            @else
                                @php
                                    $answer = $scoreValue->{'panel'}[1]->tes->answer[0];
                                    $selected_answer = $daftar_pilihan_interpretasi_hasil->first(function ($pilihan) use ($answer) { return $pilihan->value == $answer ?? ''; });
                                @endphp
                                @if($selected_answer != null)
                                    <td class="center aligned">
                                        {{ $selected_answer->text }}
                                    </td>
                                @else
                                    <td class="center aligned warning">
                                        <i>Belum dinilai</i>
                                    </td>
                                @endif
                            @endif
                            @if($score == null)
                                <td rowspan="1" class="center aligned warning"><i>Belum dinilai</i></td>
                            @else
                                @php
                                    $answer = $scoreValue->{'panel'}[2]->tes->answer[0];
                                    $selected_answer = $daftar_pilihan_interpretasi_hasil->first(function ($pilihan) use ($answer) { return $pilihan->value == $answer ?? ''; });
                                @endphp
                                @if($selected_answer != null)
                                    <td class="center aligned">
                                        {{ $selected_answer->text }}
                                    </td>
                                @else
                                    <td class="center aligned warning">
                                        <i>Belum dinilai</i>
                                    </td>
                                @endif
                            @endif
                            @if($scoreValue == null)
                                <td rowspan="3" class="center aligned warning"><i>Belum dinilai</i></td>
                            @else
                                @if (isset($scoreValue->advice))
                                <td rowspan="3" class="center aligned">
                                    {{ $scoreValue->advice }}
                                </td>
                                @else
                                    <td rowspan="3" class="center aligned warning">
                                        <i>Belum diisi</i>
                                    </td>
                                @endif
                            @endif
                        </tr>
                        <tr>
                            <td class="center aligned">
                                @php
                                    $reagen_tes = $reagens->first(function ($pilihan) use ($value) { return $pilihan->value == $value->{'reagen_tes2'} ?? ''; });
                                @endphp
                                @if ($reagen_tes != null)
                                    @if ($reagen_tes->value == "--")
                                        <i>Reagen tidak terdaftar</i>
                                    @else
                                        {{ $reagen_tes->text }}
                                    @endif
                                @else
                                    <i>{{ __('Tidak dipilih') }}</i>
                                @endif
                            </td>
                            <td class="center aligned">
                                @php
                                    $selected_hasil = $daftar_pilihan_interpretasi_hasil->first(function ($pilihan) use ($value) { return $pilihan->value == $value->{'hasil_panel_0_tes_2'} ?? ''; });
                                @endphp
                                @if ($selected_hasil != null)
                                    {{ $selected_hasil->text }}
                                @else
                                    <i>{{ __('Tidak dipilih') }}</i>
                                @endif
                            </td>
                            <td class="center aligned">
                                @php
                                    $selected_hasil = $daftar_pilihan_interpretasi_hasil->first(function ($pilihan) use ($value) { return $pilihan->value == $value->{'hasil_panel_1_tes_2'} ?? ''; });
                                @endphp
                                @if ($selected_hasil != null)
                                    {{ $selected_hasil->text }}
                                @else
                                    <i>{{ __('Tidak dipilih') }}</i>
                                @endif
                            </td>
                            <td class="center aligned">
                                @php
                                    $selected_hasil = $daftar_pilihan_interpretasi_hasil->first(function ($pilihan) use ($value) { return $pilihan->value == $value->{'hasil_panel_2_tes_2'} ?? ''; });
                                @endphp
                                @if ($selected_hasil != null)
                                    {{ $selected_hasil->text }}
                                @else
                                    <i>{{ __('Tidak dipilih') }}</i>
                                @endif
                            </td>
                            @if($score == null)
                                <td rowspan="1" class="center aligned warning"><i>Belum dinilai</i></td>
                            @else
                                @php
                                    $answer = $scoreValue->{'panel'}[0]->tes->answer[1];
                                    $selected_answer = $daftar_pilihan_interpretasi_hasil->first(function ($pilihan) use ($answer) { return $pilihan->value == $answer ?? ''; });
                                @endphp
                                @if($selected_answer != null)
                                    <td class="center aligned">
                                        {{ $selected_answer->text }}
                                    </td>
                                @else
                                    <td class="center aligned warning">
                                        <i>Belum dinilai</i>
                                    </td>
                                @endif
                            @endif
                            @if($score == null)
                                <td rowspan="1" class="center aligned warning"><i>Belum dinilai</i></td>
                            @else
                                @php
                                    $answer = $scoreValue->{'panel'}[1]->tes->answer[1];
                                    $selected_answer = $daftar_pilihan_interpretasi_hasil->first(function ($pilihan) use ($answer) { return $pilihan->value == $answer ?? ''; });
                                @endphp
                                @if($selected_answer != null)
                                    <td class="center aligned">
                                        {{ $selected_answer->text }}
                                    </td>
                                @else
                                    <td class="center aligned warning">
                                        <i>Belum dinilai</i>
                                    </td>
                                @endif
                            @endif
                            @if($score == null)
                                <td rowspan="1" class="center aligned warning"><i>Belum dinilai</i></td>
                            @else
                                @php
                                    $answer = $scoreValue->{'panel'}[2]->tes->answer[1];
                                    $selected_answer = $daftar_pilihan_interpretasi_hasil->first(function ($pilihan) use ($answer) { return $pilihan->value == $answer ?? ''; });
                                @endphp
                                @if($selected_answer != null)
                                    <td class="center aligned">
                                        {{ $selected_answer->text }}
                                    </td>
                                @else
                                    <td class="center aligned warning">
                                        <i>Belum dinilai</i>
                                    </td>
                                @endif
                            @endif
                        </tr>
                        <tr>
                            <td class="center aligned">
                                @php
                                    $reagen_tes = $reagens->first(function ($pilihan) use ($value) { return $pilihan->value == $value->{'reagen_tes3'} ?? ''; });
                                @endphp
                                @if ($reagen_tes != null)
                                    @if ($reagen_tes->value == "--")
                                        <i>Reagen tidak terdaftar</i>
                                    @else
                                        {{ $reagen_tes->text }}
                                    @endif
                                @else
                                    <i>{{ __('Tidak dipilih') }}</i>
                                @endif
                            </td>
                            <td class="center aligned">
                                @php
                                    $selected_hasil = $daftar_pilihan_interpretasi_hasil->first(function ($pilihan) use ($value) { return $pilihan->value == $value->{'hasil_panel_0_tes_3'} ?? ''; });
                                @endphp
                                @if ($selected_hasil != null)
                                    {{ $selected_hasil->text }}
                                @else
                                    <i>{{ __('Tidak dipilih') }}</i>
                                @endif
                            </td>
                            <td class="center aligned">
                                @php
                                    $selected_hasil = $daftar_pilihan_interpretasi_hasil->first(function ($pilihan) use ($value) { return $pilihan->value == $value->{'hasil_panel_1_tes_3'} ?? ''; });
                                @endphp
                                @if ($selected_hasil != null)
                                    {{ $selected_hasil->text }}
                                @else
                                    <i>{{ __('Tidak dipilih') }}</i>
                                @endif
                            </td>
                            <td class="center aligned">
                                @php
                                    $selected_hasil = $daftar_pilihan_interpretasi_hasil->first(function ($pilihan) use ($value) { return $pilihan->value == $value->{'hasil_panel_2_tes_3'} ?? ''; });
                                @endphp
                                @if ($selected_hasil != null)
                                    {{ $selected_hasil->text }}
                                @else
                                    <i>{{ __('Tidak dipilih') }}</i>
                                @endif
                            </td>
                            @if($score == null)
                                <td rowspan="1" class="center aligned warning"><i>Belum dinilai</i></td>
                            @else
                                @php
                                    $answer = $scoreValue->{'panel'}[0]->tes->answer[2];
                                    $selected_answer = $daftar_pilihan_interpretasi_hasil->first(function ($pilihan) use ($answer) { return $pilihan->value == $answer ?? ''; });
                                @endphp
                                @if($selected_answer != null)
                                    <td class="center aligned">
                                        {{ $selected_answer->text }}
                                    </td>
                                @else
                                    <td class="center aligned warning">
                                        <i>Belum dinilai</i>
                                    </td>
                                @endif
                            @endif
                            @if($score == null)
                                <td rowspan="1" class="center aligned warning"><i>Belum dinilai</i></td>
                            @else
                                @php
                                    $answer = $scoreValue->{'panel'}[1]->tes->answer[2];
                                    $selected_answer = $daftar_pilihan_interpretasi_hasil->first(function ($pilihan) use ($answer) { return $pilihan->value == $answer ?? ''; });
                                @endphp
                                @if($selected_answer != null)
                                    <td class="center aligned">
                                        {{ $selected_answer->text }}
                                    </td>
                                @else
                                    <td class="center aligned warning">
                                        <i>Belum dinilai</i>
                                    </td>
                                @endif
                            @endif
                            @if($score == null)
                                <td rowspan="1" class="center aligned warning"><i>Belum dinilai</i></td>
                            @else
                                @php
                                    $answer = $scoreValue->{'panel'}[2]->tes->answer[2];
                                    $selected_answer = $daftar_pilihan_interpretasi_hasil->first(function ($pilihan) use ($answer) { return $pilihan->value == $answer ?? ''; });
                                @endphp
                                @if($selected_answer != null)
                                    <td class="center aligned">
                                        {{ $selected_answer->text }}
                                    </td>
                                @else
                                    <td class="center aligned warning">
                                        <i>Belum dinilai</i>
                                    </td>
                                @endif
                            @endif
                        </tr>
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
