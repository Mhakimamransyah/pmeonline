@php
    use Illuminate\Support\Facades\DB;

    $parameterName = 'Kultur dan Uji Kepekaan Mikro Organisme';

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

    $table_kualifikasi_pemeriksa = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualifikasi Pemeriksa'; })->first()->option->table_name;
    $qualifications = DB::table($table_kualifikasi_pemeriksa)->get();

    $hint_methods = ['Kirby Bauer'];
    $hint_discs = ['Difco', 'Oxoid', 'Merck', 'Biomerioux'];
    $scores = ['Sensitif', 'Resisten', 'Intermediet'];

    //$kultur1_items = ['Ampicillin', 'Co-trimoxazole', 'Cefepime', 'Meropenem', 'Gentamicin'];
    // $kultur1_items = ['Meropenem', 'Amikacin', 'Gentamycin', 'Co-trimoxazole', 'Ciprofloxacine'];
    $kultur1_items = ['Ampicilline', 'Gentamicin', 'Amikacin', 'Ciprifloxacine', 'Levofloxacine'];

    // $kultur2_items = ['Cefepime', 'Co-trimoxazole', 'Meropenem', 'Gentamicin', 'Ciproflixacine'];
    // $kultur2_items = $kultur1_items;
    $kultur2_items = ['Ciprofloxaxine', 'Gentacimin', 'Levofloxacine', 'Penicilline', 'Erytrimicin'];

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
            @elseif($quality == 'kering')
                {{ 'Kering' }}
            @elseif($quality == 'pecah')
                {{ 'Pecah' }}
            @elseif($quality == 'kontaminasi')
                {{ 'Kontamintasi' }}
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

        <th width="20%" class="center aligned">{{ 'Kode Kultur' }}</th>

        <th width="75%" class="center aligned">{{ 'Hasil Identifikasi' }}</th>

    </tr>
    </thead>

    <tbody>
    @for ($i = 1; $i < 4; $i++)

        <tr>

            <td class="center aligned">{{ $i }}</td>

            <td class="center aligned">
                {!! $f->{'kode_kultur_' . $i} ?? '<i>Tidak diisi</i>' !!}
            </td>

            <td class="center aligned">
                @php
                    $hasil = isset($f->{'hasil_identifikasi_'.$i}) ? $f->{'hasil_identifikasi_'.$i} : '<i>Tidak diisi</i>';
                @endphp
                {!! $hasil !!}
            </td>

        </tr>

    @endfor
    </tbody>

</table>

<table class="table ui celled">

    <thead>
    <tr>

        <th width="50%" class="center aligned">{{ 'Metode yang Digunakan' }}</th>
        <th width="50%" class="center aligned">{{ 'Disk Antibiotik yang Digunakan' }}</th>

    </tr>
    </thead>

    <tbody>
    <tr>

        <td class="center aligned">{!! $f->metode ?? '<i>Tidak diisi</i>' !!}</td>
        <td class="center aligned">{!! $f->disk ?? '<i>Tidak diisi</i>' !!}</td>

    </tr>
    </tbody>

</table>

<h4 class="ui divider header horizontal">Hasil Uji Kepekaan Kultur 1</h4>

<table class="table ui celled">

    <tbody>
    @foreach($kultur1_items as $item)

        <tr>

            <th width="50%" class="center aligned">{{ $item }}</th>

            <td width="50%" class="center aligned">{!! $f->{'hasil_kultur_1_obat_'.$item} ?? '<i>Tidak diisi</i>' !!}</td>

        </tr>

    @endforeach
    </tbody>

</table>

<h4 class="ui divider header horizontal">Hasil Uji Kepekaan Kultur 2</h4>

<table class="table ui celled">

    <tbody>
    @foreach($kultur2_items as $item)

        <tr>

            <th width="50%" class="center aligned">{{ $item }}</th>

            <td width="50%" class="center aligned">{!! $f->{'hasil_kultur_2_obat_'.$item} ?? '<i>Tidak diisi</i>' !!}</td>

        </tr>

    @endforeach
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
