@php
    use Illuminate\Support\Facades\DB;

    $parameterName = 'Telur Cacing';

    $f = new stdClass();
    $order_id = request()->query('order_id');
    $filled_form = \App\Submit::query()->where('order_id', '=', $order_id)->get()->first();
    if ($filled_form->value != null) {
        $f = json_decode($filled_form->value);
    }

    $packageInjectData = \App\Package::query()->where('name', 'pnpme-mikrobiologi-telurcacing-3')->get()->first();
    $injects = $packageInjectData->injects()->get();

    $package = $filled_form->order->package;
    $parameters = $package->parameters;
    $cycle = $package->cycle;

    $table_kualifikasi_pemeriksa = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualifikasi Pemeriksa'; })->first()->option->table_name;
    $qualifications = DB::table($table_kualifikasi_pemeriksa)->get();

    // $cacings = [''];
    $cacings = ['negatif', 'Telur cacing Ascaris lumbricoides (+)', 'Telur cacing Trichuris trichiura (+)', 'Telur cacing Tambang (+)'];
@endphp

@if(\Illuminate\Support\Str::contains(request()->route()->getName(), 'print'))

    <h3 class="center aligned">Program Nasional Pemantapan Mutu Eksternal<br/>
        Bidang Mikrobiologi Parameter {{ $parameterName }}<br/>
        {{ $cycle->name }}
    </h3>

@else

    <h3 class="ui horizontal divider header">
        Formulir Bidang Mikrobiologi Parameter {{ $parameterName }}
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
        <th class="center aligned">Tanggal Penerimaan</th>
        <th class="center aligned">Tanggal Pemeriksaan</th>
        <th class="center aligned">Kualitas Bahan</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="center aligned">{!! $f->{ 'tanggal_penerimaan' } ?? '<i>Tidak diisi</i>' !!}</td>
        <td class="center aligned">{!! $f->{ 'tanggal_pemeriksaan' } ?? '<i>Tidak diisi</i>' !!}</td>
        <td class="center aligned">
            @php
                $quality = $f->{ 'kondisi_bahan' } ?? null;
            @endphp
            @if($quality == 'baik')
                {{ 'Baik' }}
            @elseif($quality == 'kurang_baik')
                {{ 'Kurang Baik' }}
            @else
                <i>Tidak diisi</i>
            @endif
        </td>
    </tr>
    </tbody>
</table>

<table class="table ui celled">

    <thead>
    <tr>

        <th width="5%" class="center aligned">{{ '#' }}</th>

        <th width="20%" class="center aligned">{{ 'Kode Sediaan' }}</th>

        <th width="75%" class="center aligned">{{ 'Hasil Pemeriksaan oleh Lab Peserta' }}</th>

    </tr>
    </thead>

    <tbody>
    @for ($i = 0; $i < 3; $i++)

        <tr>

            <td class="center aligned">{{ $i + 1 }}</td>

            <td class="center aligned">
                {!! $f->{'kode_sediaan_' . $i} ?? '<i>Tidak diisi</i>' !!}
            </td>

            <td class="center aligned">
                @php
                    $hasil = isset($f->{'hasil_'.$i}) ? $f->{'hasil_'.$i} : [];
                @endphp
                @if (count($hasil) > 0)
                    {{ implode(', ', $hasil) }}
                @else
                    <i>Tidak diisi</i>
                @endif
            </td>

        </tr>

    @endfor
    </tbody>


</table>


<table class="ui table celled">
    <thead>
    <tr>
        <th class="center aligned">Deskripsi Kondisi Bahan</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="center aligned">{!! $f->deskripsi_keterangan_bahan ?? '<i>Tidak diisi</i>' !!}</td>
    </tr>
    </tbody>
</table>

<table class="ui table celled">
    <thead>
    <tr>
        <th class="center aligned">Saran</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="center aligned">{!! $f->saran ?? '<i>Tidak diisi</i>' !!}</td>
    </tr>
    </tbody>
</table>

<table class="ui table celled">
    <thead>
    <tr>
        <th class="center aligned" style="width: 50%">Nama Pemeriksa</th>
        <th class="center aligned" style="width: 50%">Kualifikasi Pemeriksa</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="center aligned">{!! $f->nama_pemeriksa ?? '<i>Tidak diisi</i>' !!}</td>
        <td class="center aligned">
            @php
                $qualificationId = isset($f->{ 'kualifikasi_pemeriksa' }) ? $f->{ 'kualifikasi_pemeriksa' } : '';
                $qualification = $qualifications->filter(function ($item) use ($qualificationId) {
                    return $item->id == $qualificationId;
                })->first();
            @endphp
            @if($qualification == null)
                <i>Tidak diisi</i>
            @else
                {{ $qualificationId }} - {{ $qualification->text }}
            @endif
        </td>
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
