@include('layouts.dashboard.legacy-error')

<div class="ui segment hide-on-loading">

    <table class="ui striped table" id="cycle-laboratory-list-table">
        <thead>
        <tr>
            <th>{{ __('No') }}</th>
            <th>{{ __('Provinsi') }}</th>
            <th>{{ __('Kab.') }}</th>
            <th>{{ __('Kec.') }}</th>
            <th>{{ __('Kel. / Desa') }}</th>
            <th>{{ __('Instansi') }}</th>
            <th>{{ __('Pemerintah') }}</th>
            <th>{{ __('Swasta') }}</th>
            <th>{{ __('RS') }}</th>
            <th>{{ __('PKM') }}</th>
            <th>{{ __('BLK') }}</th>
            <th>{{ __('LK') }}</th>
            <th>{{ __('PMI') }}</th>
            <th>{{ __('Alamat') }}</th>
            <th>{{ __('Kode Peserta') }}</th>
            <th>{{ __('Kontak Person') }}</th>
            <th>{{ __('Nomor Telepon') }}</th>
            <th>{{ __('Email') }}</th>
            @foreach($cycle->getPackages() as $package)
                <th>{{ $package->getLabel() }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

</div>