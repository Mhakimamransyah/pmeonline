@php
    $cycle = \App\Cycle::first();
    $parameterName = "Hematologi";
    $package = \App\v3\Package::query()->where('name', '=', 'pnpme-hematologi')->get()->first();
    $parameters = $package->parameters;

    $submit = \App\Submit::query()->where('order_id', '=', request('order_id'))->get()->first();
    $injects = $submit->order->package->injects()->get();

    $table_kualifikasi_pemeriksa = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualifikasi Pemeriksa'; })->first()->option->table_name;
    $qualifications = DB::table($table_kualifikasi_pemeriksa)->get();

    $table_metode_pemeriksaan = $injects->filter(function ($inject) { return $inject->name == 'Daftar Metode Pemeriksaan'; })->first()->option->table_name;
    $methods = DB::table($table_metode_pemeriksaan)->get();

    $table_daftar_alat = $injects->filter(function ($inject) { return $inject->name == 'Daftar Alat'; })->first()->option->table_name;
    $equipments = DB::table($table_daftar_alat)->get();

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

        <div class="ui two fields">

            <div class="ui field">
                <label for="tanggal_penerimaan">{{ 'Tanggal Penerimaan' }}</label>

                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input class="form-control pull-right" id="tanggal_penerimaan" type="date" name="{{ 'tanggal_penerimaan_' .$bottle }}" value="{{ $f->{ 'tanggal_penerimaan_' . $bottle } ?? '' }}">
                </div>
            </div>

            <div class="ui field">
                <label for="tanggal_pemeriksaan">{{ 'Tanggal Pemeriksaan' }}</label>

                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input class="form-control pull-right" id="tanggal_pemeriksaan" type="date" name="{{ 'tanggal_pemeriksaan_' . $bottle }}" value="{{ $f->{ 'tanggal_pemeriksaan_' . $bottle } ?? '' }}">
                </div>
            </div>

        </div>

        <div class="ui two fields">

            <div class="ui field">

                @php
                    $kualitas_bahan = isset($f->{ 'kualitas_bahan_' . $bottle }) ? $f->{ 'kualitas_bahan_' . $bottle } : '';
                @endphp

                <label>{{ 'Kualitas Bahan' }}</label>
                <select class="ui select search dropdown fluid" style="width: 100%;" tabindex="-1" aria-hidden="true" name="{{ 'kualitas_bahan_' . $bottle }}">
                    <option selected="selected" value="">Pilih Kualitas Bahan</option>
                    <option value="baik" @if($kualitas_bahan == 'baik') selected @endif>Baik</option>
                    <option value="kurang_baik" @if($kualitas_bahan == 'kurang_baik') selected @endif>Kurang Baik</option>
                </select>
            </div>

            <div class="ui field">

                @php
                    $kondisi_bahan = isset($f->{ 'kondisi_bahan_' . $bottle }) ? $f->{ 'kondisi_bahan_' . $bottle } : '';
                @endphp

                <label for="kondisi_bahan">{{ 'Kondisi Bahan' }}</label>
                <select id="kondisi_bahan" name="{{ 'kondisi_bahan_' . $bottle }}" class="ui select search dropdown fluid" style="width: 100%;" tabindex="-1" aria-hidden="true">
                    <option selected="selected" value="">Pilih Kondisi Bahan</option>
                    <option value="pecah" @if($kondisi_bahan == 'pecah') selected @endif>Pecah</option>
                    <option value="lisis" @if($kondisi_bahan == 'lisis') selected @endif>Lisis</option>
                    <option value="baik" @if($kondisi_bahan == 'baik') selected @endif>Baik</option>
                </select>
            </div>

        </div>

        <table class="ui table">

            <thead>

            <tr>

                <th width="10%">Parameter</th>

                <th width="18%">Metode Pemeriksaan</th>

                <th width="18%">Alat</th>

                <th width="25%">Kualifikasi Pemeriksa</th>

                <th width="11%">Hasil Pemeriksaan</th>

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

                    <td>

                        @php

                            $selected_method = isset($f->{ 'method_' . $key . '_bottle_' . $bottle }) ? $f->{ 'method_' . $key . '_bottle_' . $bottle } : '';

                            $parameterMethods = $methods->filter(function ($item) use ($parameter) {
                                return $item->opt_1 == $parameter->label;
                            });

                        @endphp

                        <div class="form-group">
                            <select title="Metode Pemeriksaan" class="ui select search dropdown fluid" style="width: 100%;" tabindex="-1" aria-hidden="true" name="{{ 'method_' . $key . '_bottle_' . $bottle  }}">
                                <option selected="selected" value="">Pilih Metode</option>
                                @foreach($parameterMethods as $method)
                                    <option value="{{ $method->value }}" @if($method->value == $selected_method) selected @endif>{{ $method->value }} - {{ $method->text }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>

                    <td>
                        <div class="form-group">

                            @php

                                $selected_equipment = isset($f->{ 'equipment_' . $key . '_bottle_' . $bottle  }) ? $f->{ 'equipment_' . $key . '_bottle_' . $bottle } : '';

                            @endphp

                            <select name="{{ 'equipment_' . $key . '_bottle_' . $bottle  }}" title="Alat" class="ui select search dropdown fluid" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option selected="selected" value="">Pilih Alat</option>
                                @foreach($equipments as $equipment)
                                    <option value="{{ $equipment->value }}" @if($equipment->value == $selected_equipment) selected @endif>{{ $equipment->value }} - {{ $equipment->text }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>

                    <td>
                        <div class="form-group">

                            @php

                                $selected_qualification = isset($f->{'kualifikasi_pemeriksa_'.$key. '_bottle_' . $bottle }) ? $f->{'kualifikasi_pemeriksa_'.$key. '_bottle_' . $bottle } : '';

                            @endphp

                            <select title="Kualifikasi Pemeriksa" class="ui select search dropdown fluid" style="width: 100%;" tabindex="-1" aria-hidden="true" name="{{ 'kualifikasi_pemeriksa_' . $key . '_bottle_' . $bottle }}">
                                <option selected="selected" value="">Pilih Kualifikasi</option>
                                @foreach($qualifications as $qualification)
                                    <option value="{{ $qualification->id }}" @if($selected_qualification == $qualification->id) selected @endif>{{ $qualification->text }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>

                    <td>
                        <div class="form-group">
                            <input placeholder="Hasil" type="number" step="any" class="form-control" value="{{ $f->{'hasil_' . $key . '_bottle_' . $bottle } ?? '' }}" name="{{ 'hasil_' . $key . '_bottle_' . $bottle  }}">
                        </div>
                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    @endfor

    <div class="ui field">
        <label>{{ 'Keterangan' }}</label>
        <textarea class="form-control" rows="3" placeholder="Tulis Keterangan" name="{{ 'keterangan' }}">{{ $f->keterangan ?? '' }}</textarea>
    </div>

    <div class="ui field">
        <label>{{ 'Saran' }}</label>
        <textarea class="form-control" rows="3" placeholder="Tulis saran" name="saran">{{ $f->saran ?? '' }}</textarea>
    </div>

    <div class="ui field">
        <label>{{ 'Nama Pemeriksa' }}</label>
        <input type="text" class="form-control" name="nama_pemeriksa" placeholder="Tulis nama pemeriksa" value="{{ $f->nama_pemeriksa ?? '' }}">
    </div>

</form>
