@php
    $parameterName = "Urinalisa";

    $package = \App\v3\Package::query()->where('name', '=', 'pnpme-ur')->get()->first();
    $parameters = $package->parameters;

    $submit = \App\Submit::query()->where('order_id', '=', request('order_id'))->get()->first();
    $injects = $submit->order->package->injects()->get();

    $table_kualifikasi_pemeriksa = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualifikasi Pemeriksa'; })->first()->option->table_name;
    $qualifications = DB::table($table_kualifikasi_pemeriksa)->get();

    $table_metode_pemeriksaan = $injects->filter(function ($inject) { return $inject->name == 'Daftar Metode Pemeriksaan'; })->first()->option->table_name;
    $methods = DB::table($table_metode_pemeriksaan)->get();

    $table_daftar_reagen = $injects->filter(function ($inject) { return $inject->name == 'Daftar Reagen'; })->first()->option->table_name;
    $reagents = DB::table($table_daftar_reagen)->get();

    $table_daftar_alat = $injects->filter(function ($inject) { return $inject->name == 'Daftar Alat'; })->first()->option->table_name;
    $equipments = DB::table($table_daftar_alat)->get();

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
                <label for="tanggal_penerimaan">{{ 'Tanggal Penerimaan' }}</label>

                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input name="{{'tanggal_penerimaan_' .$bottle}}" value="{{ $f->{ 'tanggal_penerimaan_' .$bottle } ?? '' }}" class="form-control pull-right" id="tanggal_penerimaan" type="date">
                </div>
            </div>

            <div class="ui field">
                <label for="tanggal_pemeriksaan">{{ 'Tanggal Pemeriksaan' }}</label>

                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input name="{{'tanggal_pemeriksaan_'.$bottle}}" value="{{ $f->{'tanggal_pemeriksaan_'.$bottle} ?? '' }}" class="form-control pull-right" id="tanggal_pemeriksaan" type="date">
                </div>
            </div>

            <div class="ui field">
                @php
                    $kualitas_bahan = isset($f->{'kualitas_bahan_'.$bottle}) ? $f->{'kualitas_bahan_'.$bottle} : '';
                @endphp
                <label>{{ 'Kualitas Bahan' }}</label>
                <select name="{{ 'kualitas_bahan_' . $bottle }}" class="ui select dropdown fluid" style="width: 100%;" tabindex="-1" aria-hidden="true">
                    <option selected="selected" value="">Pilih Kualitas Bahan</option>
                    <option value="baik" @if($kualitas_bahan == 'baik') selected @endif>Baik</option>
                    <option value="kurang_baik" @if($kualitas_bahan == 'kurang_baik') selected @endif>Kurang Baik</option>
                </select>
            </div>

        </div>

        <table class="ui table">

            <thead>

            <tr>

                <th width="10%">Parameter</th>

                <th width="18%">Metode Pemeriksaan</th>

                <th width="18%">Alat</th>

                <th width="18%">Reagen</th>

                <th width="25%">Kualifikasi Pemeriksa</th>

                <th width="11%">Hasil Pemeriksaan</th>

            </tr>

            </thead>

            <tbody>

            @foreach($parameters as $key => $parameter)

                <tr>

                    <td>
                        <strong>{{ $parameter->label }}</strong>
                        <input hidden name="{{'parameter_' . $key }}" value="{{ $parameter->label }}">
                    </td>

                    <td>
                        <div class="form-group">

                            @php

                                $selected_method = isset( $f->{'method_'.$key.'_bottle_'.$bottle} ) ? $f->{'method_'.$key.'_bottle_'.$bottle} : '';

                            @endphp
                            <select name="{{'method_'.$key.'_bottle_'.$bottle}}" class="ui select search dropdown fluid" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option selected="selected" value="">Pilih Metode</option>
                                @foreach($methods as $method)
                                    <option value="{{ $method->value }}" @if($method->value == $selected_method) selected @endif>{{ $method->value }} - {{ $method->text }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>

                    <td>
                        <div class="form-group">
                            @php

                                $selected_equipment = isset($f->{'equipment_'.$key.'_bottle_'.$bottle}) ? $f->{'equipment_'.$key.'_bottle_'.$bottle} : '';

                            @endphp
                            <select name="{{ 'equipment_' . $key .'_bottle_'.$bottle}}" class="ui select search dropdown fluid" style="width: 100%;" tabindex="-1" aria-hidden="true">
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

                                $selected_reagen = isset($f->{'reagen_'.$key.'_bottle_'.$bottle}) ? $f->{'reagen_'.$key.'_bottle_'.$bottle} : '';

                            @endphp

                            <select name="{{'reagen_'.$key.'_bottle_'.$bottle}}" class="ui select search dropdown fluid" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option selected="selected" value="">Pilih Reagen</option>
                                @foreach($reagents as $reagen)
                                    <option value="{{ $reagen->value }}" @if($reagen->value == $selected_reagen) selected @endif>{{ $reagen->value }} - {{ $reagen->text }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>

                    <td>
                        <div class="form-group">
                            @php

                                $selected_qualification = isset($f->{'kualifikasi_pemeriksa_'.$key.'_bottle_'.$bottle}) ? $f->{'kualifikasi_pemeriksa_'.$key.'_bottle_'.$bottle} : '';

                            @endphp

                            <select name="{{'kualifikasi_pemeriksa_'.$key.'_bottle_'.$bottle}}" class="ui select search dropdown fluid" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option selected="selected" value="">Pilih Kualifikasi</option>
                                @foreach($qualifications as $qualification)
                                    <option value="{{ $qualification->id }}" @if($qualification->id == $selected_qualification) selected @endif>{{ $qualification->text }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>

                    <td>
                        <div class="form-group">
                            @php
                                $hasil = isset($f->{'hasil_pemeriksaan_'.$key.'_bottle_'.$bottle}) ? $f->{'hasil_pemeriksaan_'.$key.'_bottle_'.$bottle} : '';
                            @endphp
                            <select name="{{'hasil_pemeriksaan_'.$key.'_bottle_'.$bottle}}" class="ui select search dropdown fluid" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option selected="selected" value="">Hasil</option>
                                @if ($parameter->label == 'Berat Jenis')
                                    <option value="1.005" @if($hasil == '1.005') selected @endif>{{ __('1.005') }}</option>
                                    <option value="1.010" @if($hasil == '1.010') selected @endif>{{ __('1.010') }}</option>
                                    <option value="1.015" @if($hasil == '1.015') selected @endif>{{ __('1.015') }}</option>
                                    <option value="1.020" @if($hasil == '1.020') selected @endif>{{ __('1.020') }}</option>
                                    <option value="1.025" @if($hasil == '1.025') selected @endif>{{ __('1.025') }}</option>
                                    <option value="1.030" @if($hasil == '1.030') selected @endif>{{ __('1.030') }}</option>
                                @elseif ($parameter->label == 'PH')
                                    <option value="5.0" @if($hasil == '5.0') selected @endif>{{ __('5.0') }}</option>
                                    <option value="5.5" @if($hasil == '5.5') selected @endif>{{ __('5.5') }}</option>
                                    <option value="6.0" @if($hasil == '6.0') selected @endif>{{ __('6.0') }}</option>
                                    <option value="6.5" @if($hasil == '6.5') selected @endif>{{ __('6.5') }}</option>
                                    <option value="7.0" @if($hasil == '7.0') selected @endif>{{ __('7.0') }}</option>
                                    <option value="7.5" @if($hasil == '7.5') selected @endif>{{ __('7.5') }}</option>
                                    <option value="8.0" @if($hasil == '8.0') selected @endif>{{ __('8.0') }}</option>
                                    <option value="8.5" @if($hasil == '8.5') selected @endif>{{ __('8.5') }}</option>
                                @elseif ($parameter->label == 'Nitrit')
                                    <option value="negatif" @if($hasil == 'negatif') selected @endif>{{ __('Negatif') }}</option>
                                    <option value="positif" @if($hasil == 'positif') selected @endif>{{ __('Positif') }}</option>
                                @elseif ($parameter->label == 'Tes Kehamilan')
                                    <option value="negatif" @if($hasil == 'negatif') selected @endif>{{ __('Negatif') }}</option>
                                    <option value="positif" @if($hasil == 'positif') selected @endif>{{ __('Positif') }}</option>
                                @else
                                    <option value="negatif" @if($hasil == 'negatif') selected @endif>{{ __('Negatif') }}</option>
                                    <option value="+1" @if($hasil == '+1') selected @endif>{{ __('+1') }}</option>
                                    <option value="+2" @if($hasil == '+2') selected @endif>{{ __('+2') }}</option>
                                    <option value="+3" @if($hasil == '+3') selected @endif>{{ __('+3') }}</option>
                                    <option value="+4" @if($hasil == '+4') selected @endif>{{ __('+4') }}</option>
                                @endif
                            </select>
                        </div>
                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    @endfor

    <div class="ui field">
        <label>{{ 'Keterangan' }}</label>
        <textarea class="form-control" rows="3" placeholder="Tulis keterangan" name="{{'keterangan'}}">{{ $f->keterangan ?? '' }}</textarea>
    </div>

    <div class="ui field">
        <label>{{ 'Saran' }}</label>
        <textarea class="form-control" rows="3" placeholder="Tulis saran" name="{{'saran'}}">{{ $f->saran ?? '' }}</textarea>
    </div>

    <div class="ui field">
        <label>{{ 'Nama Pemeriksa' }}</label>
        <input placeholder="Tulis nama pemeriksa" type="text" class="form-control" name="{{'nama_pemeriksa'}}" value="{{ $f->nama_pemeriksa ?? '' }}">
    </div>

</form>