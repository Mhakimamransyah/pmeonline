@php
    use Illuminate\Support\Facades\DB;

    $parameterName = 'Anti TP';

    $f = new stdClass();
    $order_id = request()->query('order_id');
    $filled_form = \App\Submit::query()->where('order_id', '=', $order_id)->get()->first();
    if ($filled_form->value != null) {
        $f = json_decode($filled_form->value);
    }

    $injects = $filled_form->order->package->injects()->get();

    $table_kualifikasi_pemeriksa = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualifikasi Pemeriksa'; })->first()->option->table_name;
    $qualifications = DB::table($table_kualifikasi_pemeriksa)->get();

    $table_kualitas_bahan = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualitas Bahan'; })->first()->option->table_name;
    $daftar_pilihan_kualitas_bahan = DB::table($table_kualitas_bahan)->get();

    $table_daftar_pilihan_metode_tpha = $injects->filter(function ($inject) { return $inject->name == 'Daftar Pilihan Metode'; })->first()->option->table_name;
    $daftar_pilihan_metode_tpha = DB::table($table_daftar_pilihan_metode_tpha)->get();

    $table_daftar_pilihan_interpretasi_hasil = $injects->filter(function ($inject) { return $inject->name == 'Daftar Pilihan Interpretasi Hasil'; })->first()->option->table_name;
    $daftar_pilihan_interpretasi_hasil = DB::table($table_daftar_pilihan_interpretasi_hasil)->get();

    $table_daftar_pilihan_titer_tpha = $injects->filter(function ($inject) { return $inject->name == 'Daftar Pilihan Titer'; })->first()->option->table_name;
    $daftar_pilihan_titer_tpha = DB::table($table_daftar_pilihan_titer_tpha)->get();
@endphp

@if(\Illuminate\Support\Str::contains(request()->route()->getName(), 'print'))

    <h3 class="center aligned">Program Nasional Pemantapan Mutu Eksternal<br/>
        Bidang Imunologi Parameter {{ $parameterName }}<br/>
        Siklus 2 Tahun 2019
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
            <td style="width: 50%" class="center aligned">
                {{ $f->tanggal_penerimaan ?? '-' }}
            </td>
        @else
            <td style="width: 50%" class="warning center aligned">
                <i>{{ __('Tidak diisi') }}</i>
            </td>
        @endif

        @if (isset($f->tanggal_pemeriksaan) || $f->tanggal_pemeriksaan != null)
            <td style="width: 50%" class="center aligned">
                {{ $f->tanggal_pemeriksaan ?? '-' }}
            </td>
        @else
            <td style="width: 50%" class="warning center aligned">
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
                <td style="width: 15%" class="center aligned">
                    {{ $f->{'kode_panel_'.$i} ?? '-' }}
                </td>
            @else
                <td style="width: 15%" class="warning center aligned">
                    <i>{{ __('Tidak diisi') }}</i>
                </td>
            @endif

            @php
                $kualitas_bahan_terpilih = $daftar_pilihan_kualitas_bahan->first(function ($pilihan) use ($f, $i) { return $pilihan->value == $f->{'kualtias_bahan_'.$i} ?? ''; });
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
                <td class="center aligned">
                    {{ $f->{'deskripsi_kualitas_bahan_'.$i} ?? '-' }}
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

<table class="table ui celled">
    <thead>
    <tr>
        <th class="ui center aligned" width="20%">{{ 'Metode Pemeriksaan' }}</th>
        <th class="ui center aligned" width="20%">{{ 'Nama Reagen' }}</th>
        <th class="ui center aligned" width="20%">{{ 'Nama Produsen' }}</th>
        <th class="ui center aligned" width="20%">{{ 'Nama Lot / Batch' }}</th>
        <th class="ui center aligned" width="20%">{{ 'Tanggal Kadaluarsa' }}</th>
    </tr>
    </thead>
    <tbody>
    <tr>

        @php
            $metode = $daftar_pilihan_metode_tpha->first(function ($pilihan) use ($f) { return $pilihan->value == $f->{'metode_tpha'} ?? ''; });
        @endphp
        @if ($metode != null)
            <td class="center aligned">
                {{ $metode->text }}
            </td>
        @else
            <td class="warning center aligned">
                <i>{{ __('Tidak dipilih') }}</i>
            </td>
        @endif

        @if (isset($f->{'nama_reagen_tpha'}) || $f->{'nama_reagen_tpha'} != null)
            <td style="width: 10%" class="center aligned">
                {{ $f->{'nama_reagen_tpha'} ?? '-' }}
            </td>
        @else
            <td style="width: 10%" class="warning center aligned">
                <i>{{ __('Tidak diisi') }}</i>
            </td>
        @endif

        @if (isset($f->{'nama_produsen_reagen_tpha'}) || $f->{'nama_produsen_reagen_tpha'} != null)
            <td style="width: 10%" class="center aligned">
                {{ $f->{'nama_produsen_reagen_tpha'} ?? '-' }}
            </td>
        @else
            <td style="width: 10%" class="warning center aligned">
                <i>{{ __('Tidak diisi') }}</i>
            </td>
        @endif

        @if (isset($f->{'lot_reagen_tpha'}) || $f->{'lot_reagen_tpha'} != null)
            <td style="width: 10%" class="center aligned">
                {{ $f->{'lot_reagen_tpha'} ?? '-' }}
            </td>
        @else
            <td style="width: 10%" class="warning center aligned">
                <i>{{ __('Tidak diisi') }}</i>
            </td>
        @endif

        @if (isset($f->{'tanggal_kadaluarsa_tpha'}) || $f->{'tanggal_kadaluarsa_tpha'} != null)
            <td style="width: 10%" class="center aligned">
                {{ $f->{'tanggal_kadaluarsa_tpha'} ?? '-' }}
            </td>
        @else
            <td style="width: 10%" class="warning center aligned">
                <i>{{ __('Tidak diisi') }}</i>
            </td>
        @endif
    </tr>
    </tbody>
</table>

<table class="table ui celled">
    <thead>
    <tr>
        <th width="5%" class="ui center aligned">Panel</th>
        <th width="19%" class="ui center aligned">{{ 'Abs atau OD (A) (Bila dengan EIA)' }}</th>
        <th width="19%" class="ui center aligned">{{ 'Cut off (B) (Bila dengan EIA)' }}</th>
        <th width="19%" class="ui center aligned">{{ 'S/CO (A:B) atau true value (TV) atau Indek (Bila dengan EIA)' }}</th>
        <th width="19%" class="ui center aligned">{{ 'Interpretasi Hasil' }}</th>
        <th width="19%" class="ui center aligned">{{ __('Titer') }}</th>
    </tr>
    </thead>
    <tbody>
    @for($i = 0; $i < 3; $i++)
        <tr>
            <th class="ui center aligned">{{ $i + 1 }}</th>

            @if (isset($f->{'kualitatif_abs_'.$i}) || $f->{'kualitatif_abs_'.$i} != null)
                <td style="width: 10%" class="center aligned">
                    {{ $f->{'kualitatif_abs_'.$i} ?? '-' }}
                </td>
            @else
                <td style="width: 10%" class="warning center aligned">
                    <i>{{ __('Tidak diisi') }}</i>
                </td>
            @endif

            @if (isset($f->{'kualitatif_cut_'.$i}) || $f->{'kualitatif_cut_'.$i} != null)
                <td style="width: 10%" class="center aligned">
                    {{ $f->{'kualitatif_cut_'.$i} ?? '-' }}
                </td>
            @else
                <td style="width: 10%" class="warning center aligned">
                    <i>{{ __('Tidak diisi') }}</i>
                </td>
            @endif

            @if (isset($f->{'kualitatif_sco_'.$i}) || $f->{'kualitatif_sco_'.$i} != null)
                <td style="width: 10%" class="center aligned">
                    {{ $f->{'kualitatif_sco_'.$i} ?? '-' }}
                </td>
            @else
                <td style="width: 10%" class="warning center aligned">
                    <i>{{ __('Tidak diisi') }}</i>
                </td>
            @endif

            @php
                $hasil = $daftar_pilihan_interpretasi_hasil->first(function ($pilihan) use ($f, $i) { return $pilihan->value == $f->{'hasil_'. $i} ?? ''; });
            @endphp
            @if ($hasil != null)
                <td class="center aligned">
                    {{ $hasil->text }}
                </td>
            @else
                <td class="warning center aligned">
                    <i>{{ __('Tidak dipilih') }}</i>
                </td>
            @endif

            @php
                $titer = $daftar_pilihan_titer_tpha->first(function ($pilihan) use ($f, $i) { return $pilihan->value == $f->{'titer_tpha_'. $i} ?? ''; });
            @endphp
            @if ($titer != null)
                <td class="center aligned">
                    {{ $titer->text }}
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

<table class="ui table celled">
    <thead>
    <tr>
        <th style="width: 100%" class="center aligned">{{ __('Saran') }}</th>
    </tr>
    </thead>
    <tbody>
    <tr>
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
