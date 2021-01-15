@php
    $orderPackage = \App\OrderPackage::findOrFail($order_package_id);
@endphp

@extends('layouts.preview')

@section('style-override')

    @component('score.style-override')
    @endcomponent

    <style>
        @page {
            margin: 50mm 16mm 35mm 16mm;
        }
    </style>

@endsection

@section('content')

    @component('score.header2', [
        'orderPackage' => $orderPackage,
        'bidang' => 'KIMIA AIR',
    ])
    @endcomponent

    <div class="row">

        <div class="col-xs-12">

            <table class="table table-bordered">

                <thead>
                <tr>
                    <th class="text-center">{{ 'No' }}</th>
                    <th class="text-center">{{ 'Parameter' }}</th>
                    <th class="text-center">{{ 'Hasil Lab Saudara' }}</th>
                    <th class="text-center">{{ 'U*' }}</th>
                    <th class="text-center">{{ 'Nilai Evaluasi' }}</th>
                    <th class="text-center">{{ 'SDPA' }}</th>
                    <th class="text-center">{{ 'Z Score' }}</th>
                    <th class="text-center">{{ 'Kategori' }}</th>
                    <th class="text-center">{{ 'Kesimpulan' }}</th>
                </tr>
                </thead>

                <tbody>
                @php
                $counter = 1;
                @endphp
                @foreach($score->daftarParameter() as $parameter)
                    <tr>
                        <td class="text-center">{{ $counter }}</td>
                        <td class="text-center">{{ $parameter->nama() }}</td>
                        <td class="text-center">{{ $parameter->hasilPeserta() }}</td>
                        <td class="text-center">{{ $parameter->ketidakpastian() }}</td>
                        <td class="text-center">{{ $parameter->nilaiEvaluasi() }}</td>
                        <td class="text-center">{{ $parameter->sdpa() }}</td>
                        <td class="text-center">{{ $parameter->zscore() }}</td>
                        <td class="text-center">{{ $parameter->kategori() }}</td>
                        <td class="text-center">{{ $parameter->kesimpulan() }}</td>
                    </tr>

                    @php
                    $counter = $counter + 1;
                    @endphp
                @endforeach
                </tbody>

            </table>

        </div>

    </div>

    <div class="row">

        <div class="col-xs-12 form-group">
            <label>{{ 'Komentar / Saran' }}</label><br/>
            <p id="result_text">{{ $score->saran() }}</p>
        </div>

    </div>

    @component('score.signature')
    @endcomponent

@endsection
