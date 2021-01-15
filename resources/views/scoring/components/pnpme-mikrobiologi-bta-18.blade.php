@php
    use Illuminate\Support\Facades\DB;

    $parameterName = 'BTA';

    $f = new stdClass();
    $order_id = request()->query('order_id');
    $filled_form = \App\Submit::query()->where('order_id', '=', $order_id)->get()->first();
    if ($filled_form->value != null) {
        $f = json_decode($filled_form->value);
    }

    $injects = $filled_form->order->package->injects()->get();

    $table_kualifikasi_pemeriksa = $injects->filter(function ($inject) { return $inject->name == 'Daftar Kualifikasi Pemeriksa'; })->first()->option->table_name;
    $qualifications = DB::table($table_kualifikasi_pemeriksa)->get();

    $score = \App\v3\Score::query()->where('order_id', '=', $order_id)->get()->first();
    if ($score != null && $score->value != null) {
        $scoreValue = json_decode($score->value);
    }
@endphp

<h3 class="ui horizontal divider header">
    Formulir Hasil Bidang Mikrobiologi Parameter {{ $parameterName }}
</h3>

<form id="submit-form" class="ui form" method="post" action="{{ route('installation.scoring.store', ['order_id' => request()->get('order_id')]) }}">

    @csrf

    @component('layouts.semantic-ui.components.submit-header', [
        'submit' => $filled_form,
    ])
    @endcomponent

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
                    $quality = $f->{ 'kualitas_bahan' };
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

            <th style="width: 20%" class="center aligned">Kode Sediaan</th>

            <th style="width: 40%" class="center aligned">Hasil Pemeriksaan oleh Lab Peserta</th>

            <th style="width: 40%" class="center aligned">Hasil Pemeriksaan Rujukan</th>

        </tr>

        </thead>

        <tbody>

        @for ($i = 0; $i < 10; $i++)

            <tr>

                <td class="center aligned">
                    {{ $f->{'kode_sediaan_' . $i} ?? '-' }}
                </td>

                <td class="center aligned">
                    @php
                        $hasil = isset($f->{'hasil_'.$i}) ? $f->{'hasil_'.$i} : '';
                    @endphp
                    @if($hasil == 'negatif')
                        Negatif
                    @elseif($hasil == 'scanty')
                        Scanty
                    @elseif($hasil == '1+')
                        1+
                    @elseif($hasil == '2+')
                        2+
                    @elseif($hasil == '3+')
                        3+
                    @else
                        {!! $hasil ?? '<i>Tidak diisi</i>' !!}
                    @endif
                </td>

                <td>
                    @php
                        $rujukan = isset($scoreValue->{'rujukan'}[$i]) ? $scoreValue->{'rujukan'}[$i] : '';
                    @endphp
                    <select class="ui select search dropdown fluid" style="width: 100%;" tabindex="-1" aria-hidden="true" name="{{ 'rujukan['.$i.']' }}">
                        <option selected value="">Hasil Pemeriksaan oleh Rujukan</option>
                        <option value="negatif" @if($rujukan == 'negatif') selected @endif>Negatif</option>
                        <option value="scanty" @if($rujukan == 'scanty') selected @endif>{{ 'Scanty' }}</option>
                        <option value="1+" @if($rujukan == '1+') selected @endif>1+</option>
                        <option value="2+" @if($rujukan == '2+') selected @endif>2+</option>
                        <option value="3+" @if($rujukan == '3+') selected @endif>3+</option>
                    </select>
                </td>

            </tr>

        @endfor

        </tbody>

    </table>

    <div class="ui divider"></div>

    <div class="ui field">
        <label>{{ 'Saran' }}</label>
        <textarea class="form-control" rows="3" placeholder="Tulis saran" name="saran">{{ $scoreValue->saran ?? '' }}</textarea>
    </div>

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
            <th class="center aligned" style="width: 50%">Nama Pemeriksa</th>
            <th class="center aligned" style="width: 50%">Kualifikasi Pemeriksa</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="center aligned">{!! $f->nama_pemeriksa ?? '<i>Tidak diisi</i>' !!}</td>
            <td class="center aligned">
                @php
                    $qu = $qualifications->where('value', '=', $f->{'kualifikasi_pemeriksa'})->first();
                @endphp
                @if($qu != null)
                    {{ $qu->text }}
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
            <th class="center aligned" style="width: 100%">Saran</th>
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

</form>
