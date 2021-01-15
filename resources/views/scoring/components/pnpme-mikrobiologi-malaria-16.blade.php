@php
    use Illuminate\Support\Facades\DB;

    $parameterName = 'Malaria';

    $f = new stdClass();
    $order_id = request()->query('order_id');
    $filled_form = \App\Submit::query()->where('order_id', '=', $order_id)->get()->first();
    if ($filled_form->value != null) {
        $f = json_decode($filled_form->value);
    }

    $injects = $filled_form->order->package->injects()->get();

    $table_kualifikasi_pemeriksa = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualifikasi Pemeriksa'; })->first()->option->table_name;
    $qualifications = DB::table($table_kualifikasi_pemeriksa)->get();

    $useSelect2 = true;
    $useIcheck = true;

    $package = $filled_form->order->package;
    $parameters = $package->parameters;
    $cycle = $package->cycle;
    $parameter = "Mikrobiologi - Malaria";
    $malarias = ['Plasmodium falciparum', 'Plasmodium vivax', 'Plasmodium malariae', 'Plasmodium ovale'];
    $opt_stadiums = ['Tropozoit', 'Schizont', 'Gametosit'];

    $definedOptions = array();
    array_push($definedOptions, 'Negatif');
    foreach($malarias as $malaria)
    {
        foreach($opt_stadiums as $stadium)
        {
            array_push($definedOptions, $malaria . ' stadium ' . $stadium);
        }
    }

    $score_value = \App\v3\Score::query()->where('order_id', '=', $order_id)->get()->first();
    if ($score_value != null && $score_value->value != null) {
        $score = json_decode($score_value->value);
    }
@endphp

<form id="submit-form" class="ui form" method="post" action="{{ route('installation.scoring.store', ['order_id' => request()->get('order_id')]) }}">

    @csrf

    @if(\Illuminate\Support\Str::contains(request()->route()->getName(), 'print'))

        <h3 class="center aligned">Program Nasional Pemantapan Mutu Eksternal<br/>
            Bidang Mikrobiologi Parameter {{ $parameterName }}<br/>
            {{ strtoupper($cycle->name) }}
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

    <table class="ui table celled">

        <thead>
        <tr>

            <th rowspan="2" width="5%" class="center aligned">{{ '#' }}</th>

            <th rowspan="2" width="15%" class="center aligned">{{ 'Kode Sediaan' }}</th>

            <th colspan="2" style="width: 40%" class="center aligned">{{ 'Jawaban Peserta' }}</th>

            <th colspan="2" style="width: 40%" class="center aligned">{{ 'Rujukan' }}</th>

        </tr>

        <tr>
            <th width="30%" class="center aligned">{{ 'Hasil Pemeriksaan' }}</th>

            <th width="10%" class="center aligned">{{ 'Kepadatan Parasit' }}</th>

            <th width="30%" class="center aligned">{{ 'Hasil Pemeriksaan' }}</th>

            <th width="10%" class="center aligned">{{ 'Kepadatan Parasit' }}</th>
        </tr>
        </thead>

        <tbody>

        @for ($i = 0; $i < 10; $i++)

            <tr>

                <td class="center aligned">{{ $i + 1 }}</td>

                <td class="center aligned">
                    {!! $f->{'kode_' . $i} ?? '<i>Tidak diisi</i>' !!}
                </td>

                <td class="center aligned">
                    @php
                        $hasil = isset($f->{'hasil_'.$i}) ? $f->{'hasil_'.$i} : array();
                        $jumlah_malaria = isset($f->{'jumlah_malaria_'.$i}) ? $f->{'jumlah_malaria_'.$i} : '<i>Tidak diisi</i>';
                    @endphp

                    @if(count($hasil) > 0)
                        @if($hasil == ["Negatif"])
                        {{ implode(', ', $hasil) }}
                        @else
                            @php
                            $plasmodiums = [];
                            $stadiums = [];
                            foreach ($hasil as $item) {
                                array_push($plasmodiums, explode(" ",$item)[1]);
                                array_push($stadiums, explode(" ",$item)[3]);
                            }
                            $plasmodiums = array_unique($plasmodiums);
                            $stadiums = array_unique($stadiums);
                            @endphp
                            {{ __('Positif') }}<br/>
                            <b>{{ __('Plasmodium : ')  }}</b>{{ implode(', ', $plasmodiums) }}<br/>
                            <b>{{ __('Stadium : ') }}</b>{{ implode(', ', $stadiums) }}
                        @endif
                    @else
                        <i>Tidak diisi</i>
                    @endif

                </td>


                <td class="center aligned">{!! $jumlah_malaria !!}</td>

                <td>

                    @php
                        $selectedOptions = (isset($score->{'hasil_'.$i})) ? $score->{ 'hasil_' . $i } : array();
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
                            foreach ($opt_stadiums as $stadium) {
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
                        @foreach($opt_stadiums as $stadium)
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

                <td>

                    <input type="number" class="ui field" placeholder="0" name="{{ 'jumlah_malaria_' . $i }}" value="{{ $score->{ 'jumlah_malaria_'.$i } ?? '' }}">

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
            <td class="center aligned">{!! $f->deskripsi_kondisi_bahan ?? '<i>Tidak diisi</i>' !!}</td>
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

    <div class="ui field">
        <label>{{ 'Saran' }}</label>
        <textarea class="form-control" rows="3" placeholder="Tulis saran" name="saran">{{ $score->saran ?? '' }}</textarea>
    </div>

    @if(\Illuminate\Support\Str::contains(request()->route()->getName(), 'print'))

        @component('preview.signature', [
            'submit' => $filled_form,
            'signer' => $f->nama_pemeriksa ?? '........................',
        ])
        @endcomponent

    @endif

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
