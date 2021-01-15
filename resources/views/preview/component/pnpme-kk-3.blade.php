@php
    $parameterName = "Kimia Klinik";
    $package = \App\v3\Package::query()->where('name', '=', 'pnpme-kk-3')->get()->first();
    $parameters = $package->parameters;

    $submit = \App\Submit::query()->where('order_id', '=', request('order_id'))->get()->first();
    $injects = $submit->order->package->injects()->get();

    $table_kualifikasi_pemeriksa = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualifikasi Pemeriksa'; })->first()->option->table_name;
    $qualifications = DB::table($table_kualifikasi_pemeriksa)->get();

    $table_metode_pemeriksaan = $injects->filter(function ($inject) { return $inject->name == 'Daftar Metode Pemeriksaan'; })->first()->option->table_name;
    $methods = DB::table($table_metode_pemeriksaan)->get();

    $table_daftar_alat = $injects->filter(function ($inject) { return $inject->name == 'Daftar Alat'; })->first()->option->table_name;
    $equipments = DB::table($table_daftar_alat)->get();

    $table_daftar_reagen = $injects->filter(function ($inject) { return $inject->name == 'Daftar Reagen'; })->first()->option->table_name;
    $reagents = DB::table($table_daftar_reagen)->get();

    $table_kualitas_bahan = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualitas Bahan'; })->first()->option->table_name;
    $daftar_pilihan_kualitas_bahan = DB::table($table_kualitas_bahan)->get();

    $f = new stdClass();
    if ($submit->value != null) {
        $f = json_decode($submit->value);
    }
@endphp

@if(\Illuminate\Support\Str::contains(request()->route()->getName(), 'print'))

    <h3 class="center aligned">Program Nasional Pemantapan Mutu Eksternal<br/>
        Bidang {{ $parameterName }}<br/>
        Siklus 2 Tahun 2019
    </h3>

@else

    <h3 class="ui horizontal divider header">
        Formulir Hasil Bidang {{ $parameterName }}
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

@for($bottle = 1; $bottle <= 2; $bottle++)

    <h4 class="ui horizontal divider header">
        <i class="pills icon"></i>{{ 'Botol ' . $bottle }}
    </h4>

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
            <td class="center aligned">{!! $f->{ 'tanggal_penerimaan_' . $bottle } ?? '<i>Tidak diisi</i>' !!}</td>
            <td class="center aligned">{!! $f->{ 'tanggal_pemeriksaan_' . $bottle } ?? '<i>Tidak diisi</i>' !!}</td>
            <td class="center aligned">
                @php
                    $quality = $f->{ 'kualitas_bahan_' . $bottle };
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

    <table class="ui table celled">

        <thead>
        <tr>

            <th width="15%" class="center aligned">{{ 'Parameter' }}</th>

            <th width="17%" class="center aligned">{{ 'Metode' }}</th>

            <th width="17%" class="center aligned">{{ 'Alat' }}</th>

            <th width="17%" class="center aligned">{{ 'Reagen' }}</th>

            <th width="17%" class="center aligned">{{ 'Kualifikasi Pemeriksa' }}</th>

            <th width="17%" class="center aligned">{{ 'Hasil Pengujian' }}</th>

        </tr>
        </thead>

        <tbody>
        @foreach($parameters as $key => $parameter)
            <tr>
                <td>
                    <strong>{{ $parameter->label }}</strong><br/>
                    <i>{{ $parameter->unit }}</i>
                </td>
                <td class="center aligned">
                    @php
                        $methodId = $f->{ 'metode_pemeriksaan_' . $key . '_' . $bottle };
                        $method = $methods->filter(function ($item) use ($parameter, $methodId) {
                            return $item->opt_1 == $parameter->label && $item->value == $methodId;
                        })->first();
                    @endphp
                    @if($method == null)
                        @if($methodId == "099")
                            99 - Metode Lainnya
                        @else
                            <i>Tidak diisi</i>
                        @endif
                    @else
                        {{ $methodId }} - {{ $method->text }}
                    @endif
                </td>
                <td class="center aligned">
                    @php
                        $equipmentId = $f->{ 'alat_' . $key . '_' . $bottle };
                        $equipment = $equipments->filter(function ($item) use ($equipmentId) {
                            return $item->value == $equipmentId;
                        })->first();
                    @endphp
                    @if($equipment == null)
                        <i>Tidak diisi</i>
                    @else
                        {{ $equipment->text }}
                    @endif
                </td>
                <td class="center aligned">
                    @php
                        $reagentId = $f->{ 'reagen_' . $key . '_' . $bottle };
                        $reagent = $reagents->filter(function ($item) use ($reagentId) {
                            return $item->value == $reagentId;
                        })->first();
                    @endphp
                    @if($reagent == null)
                        <i>Tidak diisi</i>
                    @else
                        {{ $reagentId }} - {{ $reagent->text }}
                    @endif
                </td>
                <td class="center aligned">
                    @php
                        $qualificationId = $f->{ 'qualification_' . $key . '_' . $bottle };
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
                <td class="center aligned">
                    {!! $f->{ 'hasil_' . $key . '_' . $bottle } ?? '<i>Tidak diisi</i>' !!}
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>

@endfor

<table class="ui table celled">
    <thead>
    <tr>
        <th class="center aligned" style="width: 50%">Keterangan</th>
        <th class="center aligned" style="width: 50%">Saran</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="center aligned">{!! $f->keterangan ?? '<i>Tidak diisi</i>' !!}</td>
        <td class="center aligned">{!! $f->saran ?? '<i>Tidak diisi</i>' !!}</td>
    </tr>
    </tbody>
</table>

<table class="ui table celled">
    <thead>
    <tr>
        <th class="center aligned" style="width: 100%">Nama Pemeriksa</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="center aligned">{!! $f->nama_pemeriksa ?? '<i>Tidak diisi</i>' !!}</td>
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
