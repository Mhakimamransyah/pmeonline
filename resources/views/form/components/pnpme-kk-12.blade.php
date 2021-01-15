@php
    $submit = \App\Submit::query()->where('order_id', '=', request('order_id'))->get()->first();

    $packageInjectData = \App\Package::query()->where('name', 'pnpme-kk-3')->get()->first();
    $injects = $packageInjectData->injects()->get();

    $package = $submit->order->package;
    $parameters = $package->parameters;
    $parameterName = $package->label;
    $cycle = $package->cycle;

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

<h3 class="ui horizontal divider header">
    Formulir Hasil Bidang {{ $parameterName }}
</h3>

<form id="submit-form" class="ui form" method="post" action="{{ $route }}">

    @csrf

    @for($bottle = 1; $bottle <= 2; $bottle++)

        <h4 class="ui horizontal divider header">
            <i class="pills icon"></i>{{ 'Botol ' . $bottle }}
        </h4>

        <div class="ui three fields">

            <div class="ui field">
                <label>{{ 'Tanggal Penerimaan' }}</label>

                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input class="form-control pull-right" id="tanggal_penerimaan" type="date" name="{{ 'tanggal_penerimaan_' . $bottle }}" value="{{ $f->{ 'tanggal_penerimaan_' . $bottle } ?? '' }}">
                </div>
            </div>

            <div class="ui field">
                <label>{{ 'Tanggal Pemeriksaan' }}</label>

                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input class="form-control pull-right" id="tanggal_pemeriksaan" type="date" name="{{ 'tanggal_pemeriksaan_' . $bottle }}" value="{{ $f->{ 'tanggal_pemeriksaan_' . $bottle } ?? '' }}">
                </div>
            </div>

            <div class="ui field">
                <label>{{ 'Kualitas Bahan' }}</label>
                <select class="ui selection dropdown search fluid" style="width: 100%;" tabindex="-1" aria-hidden="true" name="{{ 'kualitas_bahan_' . $bottle }}">
                    @php
                        $kualitas_bahan = isset($f->{ 'kualitas_bahan_' . $bottle }) ? $f->{ 'kualitas_bahan_' . $bottle } : '';
                    @endphp
                    <option selected="selected" value="">Pilih Kualitas Bahan</option>
                    @foreach($daftar_pilihan_kualitas_bahan as $pilihan)
                        <option value="{{ $pilihan->value }}" @if($kualitas_bahan == $pilihan->value) selected @endif>{{ $pilihan->text }}</option>
                    @endforeach
                </select>
            </div>

        </div>

        <table class="ui table">

            <thead>

            <tr>

                <th width="15%">{{ 'Parameter' }}</th>

                <th width="17%">{{ 'Metode' }}</th>

                <th width="17%">{{ 'Alat' }}</th>

                <th width="17%">{{ 'Reagen' }}</th>

                <th width="17%">{{ 'Kualifikasi Pemeriksa' }}</th>

                <th width="17%">{{ 'Hasil Pengujian' }}</th>

            </tr>

            </thead>

            <tbody>

            @foreach($parameters as $key => $parameter)

                <tr>

                    <td>
                        <strong>{{ $parameter->label }}</strong><br/>
                        <i>{{ $parameter->unit }}</i>

                        <input type="hidden" name="{{ 'parameter_name_' . $key }}" value="{{ $parameter->label }}">
                    </td>

                    @php
                        $parameterMethods = $methods->filter(function ($item) use ($parameter) {
                            return $item->opt_1 == $parameter->label;
                        })
                    @endphp

                    <td>
                        <select class="ui selection dropdown search fluid" style="width: 100%;" tabindex="-1" aria-hidden="true" name="{{ 'metode_pemeriksaan_' . $key . '_' . $bottle }}">
                            @php
                                $selectedMethod = isset($f->{ 'metode_pemeriksaan_' . $key . '_' . $bottle }) ? $f->{ 'metode_pemeriksaan_' . $key . '_' . $bottle } : '';
                            @endphp
                            <option value="" selected>Pilih Metode</option>
                            @foreach($parameterMethods as $method)
                                <option value="{{ $method->value }}" @if($selectedMethod == $method->value) selected @endif>{{ $method->value }} - {{ $method->text }}</option>
                            @endforeach
                            <option value="099" @if($selectedMethod == "099") selected @endif>099 - Metode Lainnya (Tulis di Kolom Keterangan)</option>
                        </select>

                    </td>

                    <td>

                        <select class="ui selection dropdown search fluid" style="width: 100%;" tabindex="-1" aria-hidden="true" name="{{ 'alat_' . $key . '_' . $bottle }}">
                            @php
                                $selectedEquipment = isset($f->{ 'alat_' . $key . '_' . $bottle }) ? $f->{ 'alat_' . $key . '_' . $bottle } : '';
                            @endphp
                            <option value="" selected>Pilih Alat</option>
                            @foreach($equipments as $equipment)
                                <option value="{{ $equipment->value }}" @if($selectedEquipment == $equipment->value) selected @endif>{{ $equipment->value }} - {{ $equipment->text }}</option>
                            @endforeach
                        </select>

                    </td>

                    <td>

                        <select class="ui selection dropdown search fluid" style="width: 100%;" tabindex="-1" aria-hidden="true" name="{{ 'reagen_' . $key . '_' . $bottle }}">
                            @php
                                $selectedReagen = isset($f->{ 'reagen_' . $key . '_' . $bottle }) ? $f->{ 'reagen_' . $key . '_' . $bottle } : '';
                            @endphp
                            <option value="" selected>Pilih Reagen</option>
                            @foreach($reagents as $reagent)
                                <option value="{{ $reagent->value }}" @if($selectedReagen == $reagent->value) selected @endif>{{ $reagent->value }} - {{ $reagent->text }}</option>
                            @endforeach
                        </select>

                    </td>

                    <td>

                        <select class="ui selection dropdown search fluid" style="width: 100%;" tabindex="-1" aria-hidden="true" name="{{ 'qualification_' . $key . '_' . $bottle }}">
                            @php
                                $selectedQualification = isset($f->{ 'qualification_' . $key . '_' . $bottle }) ? $f->{ 'qualification_' . $key . '_' . $bottle } : '';
                            @endphp
                            <option value="" selected>Pilih Kualifikasi</option>
                            @foreach($qualifications as $qualification)
                                <option value="{{ $qualification->value }}" @if($selectedQualification == $qualification->value) selected @endif>{{ $qualification->text }}</option>
                            @endforeach
                        </select>

                    </td>

                    <td>

                        <input placeholder="Hasil" type="number" step="any" class="form-control" name="{{ 'hasil_' . $key . '_' . $bottle }}" value="{{ $f->{ 'hasil_' . $key . '_' . $bottle } ?? '' }}">

                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    @endfor

    <div class="ui field">
        <label>{{ 'Keterangan' }}</label>
        <textarea class="form-control" rows="3" placeholder="Tulis keterangan" name="{{ 'keterangan' }}">{{ $f->keterangan ?? '' }}</textarea>
    </div>

    <div class="ui field">
        <label>{{ 'Saran' }}</label>
        <textarea class="form-control" rows="3" placeholder="Tulis saran" name="{{ 'saran' }}">{{ $f->saran ?? '' }}</textarea>
    </div>

    <div class="ui field">
        <label>{{ 'Nama Pemeriksa' }}</label>
        <input type="text" class="form-control" name="{{ 'nama_pemeriksa' }}" placeholder="Tulis nama pemeriksa" value="{{ $f->nama_pemeriksa ?? '' }}">
    </div>

</form>
