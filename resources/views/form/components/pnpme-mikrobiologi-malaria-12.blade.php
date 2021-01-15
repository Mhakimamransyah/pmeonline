@php
    use Illuminate\Support\Facades\DB;

    $parameterName = 'Malaria';

    $f = new stdClass();
    $order_id = request()->query('order_id');
    $filled_form = \App\Submit::query()->where('order_id', '=', $order_id)->get()->first();
    if ($filled_form->value != null) {
        $f = json_decode($filled_form->value);
    }

    $packageInjectData = \App\Package::query()->where('name', 'pnpme-mikrobiologi-malaria-3')->get()->first();
    $injects = $packageInjectData->injects()->get();

    $package = $filled_form->order->package;
    $parameters = $package->parameters;
    $cycle = $package->cycle;

    $table_kualifikasi_pemeriksa = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualifikasi Pemeriksa'; })->first()->option->table_name;
    $qualifications = DB::table($table_kualifikasi_pemeriksa)->get();

    $malarias = ['Plasmodium falciparum', 'Plasmodium vivax', 'Plasmodium malariae', 'Plasmodium ovale', 'Plasmodium knowlesi'];
    $stadiums = ['Tropozoit', 'Gametosit', 'Skizon'];

    $definedOptions = array();
    array_push($definedOptions, 'Negatif');
    foreach($malarias as $malaria)
    {
        foreach($stadiums as $stadium)
        {
            array_push($definedOptions, $malaria . ' stadium ' . $stadium);
        }
    }
@endphp

<div class="ui warning message">
    <h4>Peringatan!</h4>

    <ul>
        <li>Pengisian jenis stadium bisa diisi lebih dari satu jenis.</li>
        <li>Kolom kepadatan parasit hanya diisi pada slide yang positif malaria.</li>
        <li>Diharapkan untuk mengisi kode bahan kontrol dari nomor  bahan kontrol yang terkecil hingga terbesar.</li>
    </ul>
</div>

<h3 class="ui horizontal divider header">
    Formulir Hasil Bidang Mikrobiologi Parameter {{ $parameterName }}
</h3>

<form id="submit-form" class="ui form" method="post" action="{{ $route }}">

    @csrf

    <div class="ui two fields">

        <div class="ui field">
            <label>{{ 'Tanggal Penerimaan' }}</label>

            @php
                $tanggal_penerimaan = isset($f->tanggal_penerimaan) ? $f->tanggal_penerimaan : '';
            @endphp

            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input class="form-control pull-right" id="tanggal_penerimaan" type="date" name="tanggal_penerimaan" value="{{ $tanggal_penerimaan }}">
            </div>
        </div>

        <div class="ui field">
            <label>{{ 'Tanggal Pemeriksaan' }}</label>

            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                @php
                    $tanggal_pemeriksaan = isset($f->tanggal_pemeriksaan) ? $f->tanggal_pemeriksaan : '';
                @endphp
                <input class="form-control pull-right" id="tanggal_pemeriksaan" type="date" name="tanggal_pemeriksaan" value="{{ $tanggal_pemeriksaan }}">
            </div>
        </div>

    </div>

    <div class="ui two fields">

        @php
            $kondisi_bahan = isset($f->kondisi_bahan) ? $f->kondisi_bahan : '';
        @endphp

        <div class="ui field">
            <label>{{ 'Kondisi Bahan' }}</label>
            <select class="ui select search fluid dropdown" style="width: 100%;" tabindex="-1" aria-hidden="true" name="kondisi_bahan">
                <option selected="selected" value="">Pilih Kondisi Bahan</option>
                <option value="baik" @if($kondisi_bahan == 'baik') selected @endif>Baik</option>
                <option value="kurang_baik" @if($kondisi_bahan == 'kurang_baik') selected @endif>Kurang Baik</option>
            </select>
        </div>

        <div class="ui field">
            <label>{{ 'Deskripsi Kondisi Bahan' }}</label>
            <input placeholder="Deskripsi Kondisi Bahan" type="text" class="form-control" name="deskripsi_kondisi_bahan" value="@if(isset($f->deskripsi_kondisi_bahan)) {{ $f->deskripsi_kondisi_bahan }} @endif">
        </div>

    </div>

    <table class="ui table">

        <thead>

        <tr>

            <th width="5%" class="center aligned">No.</th>

            <th width="25%" class="center aligned">Kode Sediaan</th>

            <th class="center aligned">Hasil Pemeriksaan oleh Lab Peserta</th>

            <th width="25%" class="center aligned">Kepadatan Parasit</th>

        </tr>

        </thead>

        <tbody>

        @for ($i = 0; $i < 10; $i++)

            <tr>

                <th class="center aligned">{{ $i + 1 }}</th>

                <td>
                    <input placeholder="Kode Sediaan" type="text" class="ui field" name="{{ 'kode_' . $i }}" value="@if(isset($f->{'kode_'.$i})) {{ $f->{ 'kode_' . $i } }} @endif">
                </td>

                <td>
                    @php
                        $selectedOptions = (isset($f->{'hasil_'.$i})) ? $f->{ 'hasil_' . $i } : array();
                    @endphp
                    <div class="ui field" style="margin-top: 14px">
                        <div class="ui radio checkbox">
                            <input type="radio" @if(in_array('Negatif', $selectedOptions)) checked @endif name="{{ __('_isi_benar_exists_') . $i }}" value="Negatif">
                            <label>Negatif</label>
                        </div>
                    </div>
                    <div class="ui field">
                        <div class="ui radio checkbox">
                            <input type="radio" @if(!in_array('Negatif', $selectedOptions) && count($selectedOptions) > 0) checked @endif name="{{ __('_isi_benar_exists_') . $i }}" value="Positif">
                            <label>Positif</label>
                        </div>
                    </div>
                    @foreach($malarias as $malaria)
                        @php
                            $malaria_selected = false;
                            foreach ($stadiums as $stadium) {
                                if (in_array($malaria.' stadium '.$stadium, $selectedOptions)) {
                                    $malaria_selected = true;
                                    break;
                                }
                            }
                        @endphp
                        <div @if(count($selectedOptions) == 0 || in_array('Negatif', $selectedOptions)) hidden @endif class="{{ 'class_label_malaria_'.$i }} ui field" style="margin-left: 32px">
                            <div class="ui checkbox">
                                <input class="{{ __('class_input_benar_').$i }} {{ __('class_input_benar_malaria_title_').$i }}" @if(in_array('Negatif', $selectedOptions) || count($selectedOptions) == 0) disabled @endif id="{{ __('checkbox_genus_').$i }}" @if($malaria_selected) checked @endif type="checkbox" data-malaria-title="{{ $malaria }}">
                                <label><i>{{ $malaria }}</i></label>
                            </div>
                        </div>
                        @foreach($stadiums as $stadium)
                            <div @if(!$malaria_selected) hidden @endif class="{{ 'class_label_stadium_'.$i }} class_label_positif ui field" data-malaria-title="{{ $malaria }}" style="margin-left: 64px">
                                <div class="ui checkbox">
                                    <input class="{{ __('class_input_benar_').$i }} {{ __('class_input_benar_has_value_').$i }}" @if(in_array('Negatif', $selectedOptions) || !$malaria_selected) disabled @endif type="checkbox" @if(in_array($malaria.' stadium '.$stadium, $selectedOptions)) checked @endif name="{{ __('hasil_').$i.'[]' }}" value="{{ $malaria . ' stadium ' . $stadium }}" data-malaria-title="{{ $malaria }}">
                                    <label>{{ $stadium }}</label>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                    <div hidden>
                        <input class="{{ __('class_input_negatif_').$i }}" @if(in_array('Negatif', $selectedOptions)) checked @endif type="checkbox" name="{{ __('hasil_').$i.'[]' }}" value="{{ __('Negatif') }}">&nbsp;&nbsp;&nbsp;{{ __('Negatif') }}<br>
                    </div>
                </td>

                <td><input type="number" class="ui field" placeholder="Isi kepadatan parasit" name="{{ 'jumlah_malaria_' . $i }}" value="{{ $f->{ 'jumlah_malaria_'.$i } ?? '' }}"></td>

            </tr>

        @endfor

        </tbody>

    </table>

    <div class="ui divider"></div>

    <div class="ui field">
        <label>{{ 'Saran' }}</label>
        <textarea class="form-control" rows="3" placeholder="Tulis saran" name="saran">@if(isset($f->saran)) {{ $f->saran }} @endif</textarea>
    </div>

    <div class="ui field">
        <label>{{ 'Nama Pemeriksa' }}</label>
        <input placeholder="Nama Pemeriksa" type="text" class="form-control" name="nama_pemeriksa" value="@if(isset($f->nama_pemeriksa)) {{ $f->nama_pemeriksa }} @endif">
    </div>

    <div class="ui field">
        <label>{{ 'Kualifikasi Pemeriksa' }}</label>
        <select class="ui select search field dropdown" style="width: 100%;" tabindex="-1" aria-hidden="true" name="kualifikasi_pemeriksa">
            <option selected="selected" value="">Kualifikasi Pemeriksa</option>
            @foreach($qualifications as $qualification)
                <option value="{{ $qualification->id }}" @if((isset($f->kualifikasi_pemeriksa)) && $f->kualifikasi_pemeriksa == $qualification->id) selected @endif>{{ $qualification->text }}</option>
            @endforeach
        </select>
    </div>

</form>

@section('script')
    @for ($i = 0; $i < 10; $i++)
        <script>
            $('#<?php echo e('input_jumlah_malaria'.$i); ?>').on('input', function () {
                let x = $(this).val();
                let min = x - (25/100*x);
                let max = x - 0 + (25/100*x);
                $('#<?php echo e('range_jumlah_malaria_'.$i); ?>').html(Math.ceil(min) + ' - ' + Math.ceil(max));
            });
            $('<?php echo 'input:radio[name="_isi_benar_exists_'.$i.'"]'; ?>').change(function () {
                let i = <?php echo $i;?>;
                let classNamePositif = '.class_input_benar_' + i;
                let classNamePositifMalariaTitle = '.class_input_benar_malaria_title_' + i;
                let classNameNegatif = '.class_input_negatif_' + i;
                let classLabelMalaria = '.class_label_malaria_' + i;
                let classLabelStadium = '.class_label_stadium_' + i;
                if ($(this).val().toString() === 'Negatif') {
                    $(classNamePositif).each(function () {
                        $(this).prop('checked', false);
                        $(this).prop('disabled', true);
                    });
                    $(classNameNegatif).each(function () {
                        $(this).prop('disabled', false);
                        $(this).prop('checked', true);
                    });
                    $(classLabelMalaria).each(function () {
                        $(this).prop('hidden', true);
                    });
                    $(classLabelStadium).each(function () {
                        $(this).prop('hidden', true);
                    });
                } else {
                    $(classNamePositifMalariaTitle).each(function () {
                        $(this).prop('disabled', false);
                    });
                    $(classNameNegatif).each(function () {
                        $(this).prop('disabled', false);
                        $(this).prop('checked', false);
                    });
                    $(classLabelMalaria).each(function () {
                        $(this).prop('hidden', false);
                    });
                }
            });
            $('.<?php echo 'class_input_benar_malaria_title_'.$i; ?>').change(function () {
                let i = <?php echo $i;?>;
                let malariaTitle = $(this).data('malaria-title');
                let titleChecked = $(this).prop('checked');
                let classLabelStadium = '.class_label_stadium_' + i;
                let classNamePositif = '.class_input_benar_has_value_' + i;
                $(classLabelStadium).each(function () {
                    if ($(this).data('malaria-title') === malariaTitle) {
                        if (titleChecked) {
                            $(this).prop('hidden', false);
                        } else {
                            $(this).prop('hidden', true);
                        }
                    }
                });
                $(classNamePositif).each(function () {
                    if ($(this).data('malaria-title') === malariaTitle) {
                        if (titleChecked) {
                            $(this).prop('disabled', false);
                        } else {
                            $(this).prop('checked', false);
                            $(this).prop('disabled', true);
                        }
                    }
                });
            });
        </script>
    @endfor
    <script>
        $('.ui.checkbox').checkbox();
    </script>
@endsection
