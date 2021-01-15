@php
    use Illuminate\Support\Facades\DB;

    $parameterName = 'RPR';

    $f = new stdClass();
    $order_id = request()->query('order_id');
    $submit = \App\Submit::query()->where('order_id', '=', $order_id)->get()->first();
    if ($submit->value != null) {
        $f = json_decode($submit->value);
    }

    $injects = $submit->order->package->injects()->get();

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
        'submit' => $submit,
    ])
    @endcomponent

@else

    @component('layouts.semantic-ui.components.submit-header', [
        'submit' => $submit,
    ])
    @endcomponent

@endif

<table class="ui table celled">
    <thead>
    <tr>
        <th class="center aligned">{{ __('Tanggal Penerimaan') }}</th>
        <th class="center aligned">{{ __('Tanggal Pemeriksaan') }}</th>
        <th class="center aligned">{{ __('Kualifikasi Pemeriksa') }}</th>
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

        @php
            $selected_qualification = $qualifications->first(function ($pilihan) use ($f) { return $pilihan->value == $f->{'kualifikasi_pemeriksa'} ?? ''; });
        @endphp
        @if ($selected_qualification != null)
            <td style="width: 10%" class="center aligned">
                {{ $selected_qualification->text }}
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
        <th width="5%" class="center aligned">{{ 'Panel' }}</th>
        <th width="15%" class="center aligned">{{ 'Kualitas Bahan' }}</th>
        <th width="60%" class="center aligned">{{ 'Deskripsi Kualitas Bahan' }}</th>
    </tr>
    @for($i = 0; $i < 3; $i++)
        <tr>
            <th class="center aligned">
                {{ $f->{'kode_panel_'.$i} ?? '-' }}
            </th>
            <td class="center aligned">
                @php
                    $kualitas_bahan = isset($f->{'kualtias_bahan_'.$i}) ? $f->{'kualtias_bahan_'.$i} : '';
                @endphp
                @if($kualitas_bahan == 'baik')
                    {{ 'Baik' }}
                @elseif($kualitas_bahan == 'keruh')
                    {{ 'Keruh' }}
                @elseif($kualitas_bahan == 'lain-lain')
                    {{ 'Lain-Lain' }}
                @else
                    <i>Tidak diisi</i>
                @endif
            </td>
            <td>
                {!! $f->{'deskripsi_kualitas_bahan_'.$i} ?? '<i>Tidak diisi</i>' !!}
            </td>
        </tr>
    @endfor
    </thead>
</table>

<table class="ui table celled">
    <thead>
    <tr>
        <th width="20%" class="center aligned">{{ 'Metode Pemeriksaan' }}</th>
        <th width="20%" class="center aligned">{{ 'Nama Reagen' }}</th>
        <th width="20%" class="center aligned">{{ 'Nama Produsen' }}</th>
        <th width="20%" class="center aligned">{{ 'Nama Lot / Batch' }}</th>
        <th width="20%" class="center aligned">{{ 'Tanggal Kadaluarsa' }}</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="center aligned">
            @php
                $metode_pemeriksaan = isset($f->{'metode_rpr'}) ? $f->{'metode_rpr'} : null;
            @endphp
            {!! $metode_pemeriksaan ?? '<i>Tidak diisi</i>' !!}
        </td>
        <td class="center aligned">
            {{ $f->nama_reagen_rpr ?? '' }}
        </td>
        <td class="center aligned">
            {{ $f->nama_produsen_reagen_rpr ?? '' }}
        </td>
        <td class="center aligned">
            {{ $f->lot_reagen_rpr ?? '' }}
        </td>
        <td class="center aligned">
            {{ $f->tanggal_kadaluarsa_rpr ?? '' }}
        </td>
    </tr>
    </tbody>
</table>

@for($h = 0; $h < 3; $h++)

    <h4 class="ui horizontal divider header">
        <b>{{ 'Panel' }} {{ $f->{'kode_panel_'.$h} ?? '-' }}</b>
    </h4>

    <table class="ui table celled">
        <thead>
        <tr>
            <th width="23%" class="center aligned">{{ 'Interpretasi Hasil' }}</th>
            <th width="23%" class="center aligned">{{ 'Titer' }}</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="center aligned">
                @php
                    $selected_hasil = isset($f->{'hasil_semi_kuantitatif_'.$h}) ? $f->{'hasil_semi_kuantitatif_'.$h} : '';
                @endphp
                @if($selected_hasil == 'reaktif')
                    {{ 'Reaktif' }}
                @elseif($selected_hasil == 'nonreaktif')
                    {{ 'Nonreaktif' }}
                @else
                    {{ '-' }}
                @endif
            </td>
            <td class="center aligned">
                {{ $f->{'titer_'.$h} ?? '' }}
            </td>
        </tr>
        </tbody>
    </table>

@endfor

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

@component('layouts.semantic-ui.components.submit-footer', [
    'submit' => $submit,
])
@endcomponent

@if(\Illuminate\Support\Str::contains(request()->route()->getName(), 'print'))

    @component('preview.signature', [
        'submit' => $submit,
        'signer' => $f->nama_pemeriksa ?? '........................',
    ])
    @endcomponent

@endif
