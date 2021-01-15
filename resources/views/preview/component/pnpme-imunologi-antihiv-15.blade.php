@php
    use Illuminate\Support\Facades\DB;

    $parameterName = 'Anti HIV';

    $f = new stdClass();
    $order_id = request()->query('order_id');
    $filled_form = \App\Submit::query()->where('order_id', '=', $order_id)->get()->first();
    if ($filled_form->value != null) {
        $f = json_decode($filled_form->value);
    }

    $injects = $filled_form->order->package->injects()->get();

    $package = $filled_form->order->package;
    $parameters = $package->parameters;
    $cycle = $package->cycle;

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

@if(\Illuminate\Support\Str::contains(request()->route()->getName(), 'print'))

    <h3 class="center aligned">Program Nasional Pemantapan Mutu Eksternal<br/>
        Bidang Imunologi Parameter {{ $parameterName }}<br/>
        {{ $cycle->name }}
    </h3>

@else

    <h3 class="ui horizontal divider header">
        Formulir Bidang Imunologi Parameter {{ $parameterName }}
    </h3>

@endif

@if(\Illuminate\Support\Str::contains(request()->route()->getName(), 'print'))

    @component('score.identity-header', [
        'submit' => $filled_form,
    ])
    @endcomponent

@else

    @component('layouts.semantic-ui.components.submit-header', [
        'submit' => $filled_form,
    ])
    @endcomponent

@endif

<table class="ui table celled">
    <thead>
    <tr>
        <th class="center aligned">{{ __('Tanggal Penerimaan') }}</th>
        <th class="center aligned">{{ __('Tanggal Pemeriksaan') }}</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        @if (isset($f->tanggal_penerimaan) || $f->tanggal_penerimaan != null)
            <td style="width: 10%" class="center aligned">
                {{ $f->tanggal_penerimaan ?? '-' }}
            </td>
        @else
            <td style="width: 10%" class="warning center aligned">
                <i>{{ __('Tidak diisi') }}</i>
            </td>
        @endif

        @if (isset($f->tanggal_pemeriksaan) || $f->tanggal_pemeriksaan != null)
            <td style="width: 10%" class="center aligned">
                {{ $f->tanggal_pemeriksaan ?? '-' }}
            </td>
        @else
            <td style="width: 10%" class="warning center aligned">
                <i>{{ __('Tidak diisi') }}</i>
            </td>
        @endif
    </tr>
    </tbody>
</table>

<table class="ui table celled">
    <thead>
    <tr>
        <th class="center aligned">{{ '#' }}</th>
        <th class="center aligned">{{ 'Kode Panel' }}</th>
        <th class="center aligned">{{ 'Kualitas Bahan' }}</th>
        <th class="center aligned">{{ 'Deskripsi Kualitas Bahan' }}</th>
    </tr>
    </thead>
    <tbody>
    @for($i = 0; $i < 3; $i++)
        <tr>
            <th class="center aligned" width="5%">{{ $i + 1 }}</th>

            @if (isset($f->{'kode_panel_'.$i}) || $f->{'kode_panel_'.$i} != null)
                <td style="width: 10%" class="center aligned">
                    {{ $f->{'kode_panel_'.$i} ?? '-' }}
                </td>
            @else
                <td style="width: 10%" class="warning center aligned">
                    <i>{{ __('Tidak diisi') }}</i>
                </td>
            @endif

            @php
                $kualitas_bahan_terpilih = $daftar_pilihan_kualitas_bahan->first(function ($pilihan) use ($f, $i) { return $pilihan->value == $f->{'kualitas_bahan_'.$i} ?? ''; });
            @endphp
            @if ($kualitas_bahan_terpilih != null)
                <td style="width: 15%" class="center aligned">
                    {{ $kualitas_bahan_terpilih->text }}
                </td>
            @else
                <td style="width: 15%" class="warning center aligned">
                    <i>{{ __('Tidak dipilih') }}</i>
                </td>
            @endif

            @if (isset($f->{'deskripsi_kualitas_bahan_'.$i}) || $f->{'deskripsi_kualitas_bahan_'.$i} != null)
                <td style="width: 60%" class="center aligned">
                    {{ $f->{'deskripsi_kualitas_bahan_'.$i} ?? '-' }}
                </td>
            @else
                <td style="width: 60%" class="warning center aligned">
                    <i>{{ __('Tidak diisi') }}</i>
                </td>
            @endif
        </tr>
    @endfor
    </tbody>
</table>

<table class="ui table celled">
    <thead>
    <tr>
        <th class="center aligned" width="12%">{{ 'Tes' }}</th>
        <th class="center aligned" width="22%">{{ 'Metode Pemeriksaan' }}</th>
        <th class="center aligned" width="22%">{{ 'Nama Reagen' }}</th>
        <th class="center aligned" width="22%">{{ 'Nomor Lot / Batch' }}</th>
        <th class="center aligned" width="22%">{{ 'Tanggal Kadaluarsa' }}</th>
    </tr>
    </thead>
    <tbody>
    @for($tes = 1; $tes <= 3; $tes++)
        <tr>
            <td class="center aligned">
                <strong>Reagen @for($j = 0; $j < $tes; $j++){{ 'I' }}@endfor
                </strong>
            </td>
            @php
                $metode_pemeriksaan_tes = $daftar_pilihan_metode_pemeriksaan->first(function ($pilihan) use ($f, $tes) { return $pilihan->value == $f->{'metode_pemeriksaan_tes'.$tes} ?? ''; });
            @endphp
            @if ($metode_pemeriksaan_tes != null)
                <td class="center aligned">
                    {{ $metode_pemeriksaan_tes->text }}
                </td>
            @else
                <td class="warning center aligned">
                    <i>{{ __('Tidak dipilih') }}</i>
                </td>
            @endif
            @php
                $reagen_tes = $reagens->first(function ($pilihan) use ($f, $tes) { return $pilihan->value == $f->{'reagen_tes'.$tes} ?? ''; });
            @endphp
            @if ($reagen_tes != null)
                <td class="center aligned">
                    {{ $reagen_tes->value . ' - ' . $reagen_tes->text }}
                </td>
            @else
                <td class="warning center aligned">
                    <i>{{ __('Tidak dipilih') }}</i>
                </td>
            @endif

            @if (isset($f->{'batch_tes'.$tes}) || $f->{'batch_tes'.$tes} != null)
                <td class="center aligned">
                    {{$f->{'batch_tes'.$tes} ?? '-'}}
                </td>
            @else
                <td class="warning center aligned">
                    <i>{{ __('Tidak diisi') }}</i>
                </td>
            @endif

            @if (isset($f->{'tanggal_kadaluarsa_tes'.$tes}) || $f->{'tanggal_kadaluarsa_tes'.$tes} != null)
                <td class="center aligned">
                    {{$f->{'tanggal_kadaluarsa_tes'.$tes} ?? '-'}}
                </td>
            @else
                <td class="warning center aligned">
                    <i>{{ __('Tidak diisi') }}</i>
                </td>
            @endif
        </tr>
    @endfor
    </tbody>
</table>

@for($h = 0; $h < 3; $h++)

    <h4 class="ui horizontal divider header">
        {{ 'Panel ' }} {{ $f->{'kode_panel_'.$h} ?? '-' }}
    </h4>

    <table class="table ui celled">
        <thead>
        <tr>
            <th width="15%" class="center aligned">{{ 'Tes' }}</th>
            <th width="23%" class="center aligned">{{ 'Abs atau OD (A) (Bila dengan EIA)' }}</th>
            <th width="23%" class="center aligned">{{ 'Cut off (B) (Bila dengan EIA)' }}</th>
            <th width="23%"
                class="center aligned">{{ 'S/CO (A:B) atau true value (TV) atau Indek (Bila dengan EIA)' }}</th>
            <th width="16%" class="center aligned">{{ 'Interpretasi Hasil' }}</th>
        </tr>
        </thead>
        <tbody>
        @for($i = 0; $i < 3; $i++)
            <tr>
                <td class="center aligned">
                    <strong>Hasil Reagen @for($j = 0; $j < $i + 1; $j++){{ 'I' }}@endfor
                    </strong>
                </td>

                {{--Tes = j, Panel = h--}}

                @if (isset($f->{'abs_panel_'.$h.'_tes_'.$j}) || $f->{'abs_panel_'.$h.'_tes_'.$j} != null)
                    <td class="center aligned">
                        {{$f->{'abs_panel_'.$h.'_tes_'.$j} ?? '-'}}
                    </td>
                @else
                    <td class="warning center aligned">
                        <i>{{ __('Tidak diisi') }}</i>
                    </td>
                @endif

                @if (isset($f->{'cut_panel_'.$h.'_tes_'.$j}) || $f->{'cut_panel_'.$h.'_tes_'.$j} != null)
                    <td class="center aligned">
                        {{$f->{'cut_panel_'.$h.'_tes_'.$j} ?? '-'}}
                    </td>
                @else
                    <td class="warning center aligned">
                        <i>{{ __('Tidak diisi') }}</i>
                    </td>
                @endif

                @if (isset($f->{'sco_panel_'.$h.'_tes_'.$j}) || $f->{'sco_panel_'.$h.'_tes_'.$j} != null)
                    <td class="center aligned">
                        {{$f->{'sco_panel_'.$h.'_tes_'.$j} ?? '-'}}
                    </td>
                @else
                    <td class="warning center aligned">
                        <i>{{ __('Tidak diisi') }}</i>
                    </td>
                @endif

                @php
                    $selected_hasil = $daftar_pilihan_interpretasi_hasil->first(function ($pilihan) use ($f, $h, $j) { return $pilihan->value == $f->{'hasil_panel_'.$h.'_tes_'.$j} ?? ''; });
                @endphp
                @if ($selected_hasil != null)
                    <td class="center aligned">
                        {{ $selected_hasil->text }}
                    </td>
                @else
                    <td class="warning center aligned">
                        <i>{{ __('Tidak dipilih') }}</i>
                    </td>
                @endif

            </tr>
        @endfor
        </tbody>
    </table>

@endfor

@if(\Illuminate\Support\Str::contains(request()->route()->getName(), 'print'))
    <br/>
@else
    <div class="ui divider"></div>
@endif

<table class="ui table celled">
    <thead>
    <tr>
        <th style="width: 50%" class="center aligned">{{ __('Keterangan') }}</th>
        <th style="width: 50%" class="center aligned">{{ __('Saran') }}</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        @if (isset($f->keterangan) || $f->keterangan != null)
            <td class="center aligned">{{$f->keterangan ?? '-'}}</td>
        @else
            <td class="warning center aligned"><i>{{ __('Tidak diisi') }}</i></td>
        @endif

        @if (isset($f->saran) || $f->saran != null)
            <td class="center aligned">{{$f->saran ?? '-'}}</td>
        @else
            <td class="warning center aligned"><i>{{ __('Tidak diisi') }}</i></td>
        @endif
    </tr>
    </tbody>
</table>

<table class="ui table celled">
    <thead>
    <tr>
        <th style="width: 50%" class="center aligned">{{ __('Nama Pemeriksa') }}</th>
        <th style="width: 50%" class="center aligned">{{ __('Kualifikasi Pemeriksa') }}</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        @if (isset($f->nama_pemeriksa) || $f->nama_pemeriksa != null)
            <td class="center aligned">{{$f->nama_pemeriksa ?? '-'}}</td>
        @else
            <td class="warning center aligned"><i>{{ __('Tidak diisi') }}</i></td>
        @endif

        @php
            $selected_qualification = $qualifications->first(function ($pilihan) use ($f) { return $pilihan->value == $f->{'kualifikasi_pemeriksa'} ?? ''; });
        @endphp
        @if ($selected_qualification != null)
            <td class="center aligned">
                {{ $selected_qualification->text }}
            </td>
        @else
            <td class="warning center aligned">
                <i>{{ __('Tidak dipilih') }}</i>
            </td>
        @endif
    </tr>
    </tbody>
</table>

@component('layouts.semantic-ui.components.submit-footer', [
    'submit' => $filled_form,
])
@endcomponent

@if(\Illuminate\Support\Str::contains(request()->route()->getName(), 'print'))

    @component('preview.signature', [
        'submit' => $filled_form,
        'signer' => $f->nama_pemeriksa ?? '........................',
    ])
    @endcomponent

@endif