@php
    $submit = \App\Submit::query()->where('order_id', '=', request('order_id'))->get()->first();

    $packageInjectData = \App\Package::query()->where('name', 'pnpme-ka-3')->get()->first();
    $injects = $packageInjectData->injects()->get();

    $package = $submit->order->package;
    $parameters = $package->parameters;
    $parameterName = $package->label;
    $cycle = $package->cycle;

    $table_kualifikasi_pemeriksa = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualifikasi Pemeriksa'; })->first()->option->table_name;
    $qualifications = DB::table($table_kualifikasi_pemeriksa)->get();

    $f = new stdClass();
    if ($submit->value != null) {
        $f = json_decode($submit->value);
    }
@endphp

@if(\Illuminate\Support\Str::contains(request()->route()->getName(), 'print'))

    <h3 class="center aligned">Program Nasional Pemantapan Mutu Eksternal<br/>
        Bidang {{ $parameterName }}<br/>
        {{ $cycle->name }}
    </h3>

@else

    <h3 class="ui horizontal divider header">
        Formulir Bidang {{ $parameterName }}
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
        <th class="center aligned">{{ __('Kode Kemasan') }}</th>
        <th class="center aligned">{{ __('Tanggal Penerimaan') }}</th>
        <th class="center aligned">{{ __('Tanggal Pemeriksaan') }}</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        @if (isset($f->{ 'kode_bahan_kontrol' }) || $f->{ 'kode_bahan_kontrol' } != null)
            <td style="width: 10%" class="center aligned">
                {{ $f->{ 'kode_bahan_kontrol' } ?? '-' }}
            </td>
        @else
            <td style="width: 10%" class="warning center aligned">
                <i>{{ __('Tidak diisi') }}</i>
            </td>
        @endif

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
        <th class="center aligned" style="width: 50%">{{ __('Kondisi Kemasan Luar') }}</th>
        <th class="center aligned" style="width: 50%">{{ __('Kondisi Bahan Uji') }}</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        @if (isset($f->kondisi_kemasan_luar) || $f->kondisi_kemasan_luar != null)
            <td style="width: 10%" class="center aligned">
                {{ $f->kondisi_kemasan_luar ?? '-' }}
            </td>
        @else
            <td style="width: 10%" class="warning center aligned">
                <i>{{ __('Tidak diisi') }}</i>
            </td>
        @endif

        @if (isset($f->kondisi_bahan_uji) || $f->kondisi_bahan_uji != null)
            <td style="width: 10%" class="center aligned">
                {{ $f->kondisi_bahan_uji ?? '-' }}
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
        <th width="20%" class="center aligned">{{ 'Parameter' }}</th>
        <th width="20%" class="center aligned">{{ 'Hasil Pengujian	(ppm)' }}</th>
        <th width="20%" class="center aligned">{{ 'U* / Ketidakpastian (±)' }}</th>
        <th width="20%" class="center aligned">{{ 'Metode' }}</th>
    </tr>
    </thead>

    <tbody>
    @foreach($parameters as $parameter)
        <tr>
            <th class="center aligned">{{ $parameter->label }}</th>
            <td class="center aligned">{!! $f->{str_replace(' ', '_', 'hasil_pengujian_'.$parameter->label)} ?? '<i>Tidak diisi</i>' !!}</td>
            <td class="center aligned">{!! $f->{str_replace(' ', '_', 'ketidakpastian_'.$parameter->label)} ?? '<i>Tidak diisi</i>' !!}</td>
            <td class="center aligned">{!! $f->{str_replace(' ', '_', 'metode_'.$parameter->label)} ?? '<i>Tidak diisi</i>' !!}</td>
        </tr>
    @endforeach
    </tbody>

</table>

<table class="ui table celled">
    <thead>
    <tr>
        <th class="center aligned">
            Saran
        </th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="center aligned">{!! $f->saran ?? '<i>Tidak diisi</i>' !!}</td>
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