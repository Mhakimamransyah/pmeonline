@php
    use Illuminate\Support\Facades\DB;

    $parameterName = 'Telur Cacing';

    $f = new stdClass();
    $order_id = request()->query('order_id');
    $filled_form = \App\Submit::query()->where('order_id', '=', $order_id)->get()->first();
    if ($filled_form->value != null) {
        $f = json_decode($filled_form->value);
    }

    $injects = $filled_form->order->package->injects()->get();

    $table_kualifikasi_pemeriksa = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualifikasi Pemeriksa'; })->first()->option->table_name;
    $qualifications = DB::table($table_kualifikasi_pemeriksa)->get();

    // $cacings = [''];
    $cacings = [
        'Negatif',
        'Telur cacing Ascaris lumbricoides (+)',
        'Telur cacing Tambang (+)',
        'Telur cacing Trichuris trichiura (+)',
        'Telur cacing Oxyuris vermicularis (+)',
        'Telur cacing Taenia saginata (+)',
        'Telur cacing Taenia solium (+)',
    ];

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
            Siklus 2 Tahun 2019
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

            <th width="15%" class="center aligned">{{ 'Kode Sediaan' }}</th>

            <th width="40%" class="center aligned">{{ 'Hasil Pemeriksaan oleh Lab Peserta' }}</th>

            <th width="40%" class="center aligned">{{ 'Hasil Pemeriksaan oleh Rujukan' }}</th>

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

                <td>
                    @php
                        $hasil = isset($score->{'hasil_'.$i}) ? $score->{'hasil_'.$i} : array();
                        $moreHasil = array_diff($hasil, $cacings);
                    @endphp
                    <select title="Hasil Pemeriksaan oleh Lab Peserta" class="ui select search dropdown fluid" style="width: 100%;" tabindex="-1" aria-hidden="true" multiple name="{{ 'hasil_' . $i }}[]">
                        @foreach($cacings as $cacing)
                            <option @if(in_array($cacing, $hasil)) selected @endif>{{ $cacing }}</option>
                        @endforeach
                        @foreach($moreHasil as $item)
                            <option selected>{{ $item }}</option>
                        @endforeach
                    </select>
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