<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Charmonman" rel="stylesheet">

    <style>
        html {
            position: relative;
            min-width: 297mm;
            min-height: 210mm;
            height: 100%;
        }
        @page {
            size: 297mm 210mm;
            margin: 0;
        }
        @media print {
            margin: 0;
            -webkit-print-color-adjust: exact;
        }
    </style>
</head>
<body>

@if(in_array($package_id, [1, 2, 3, 4, 13]))

@if(in_array($package_id, [1, 2, 3, 4]))
<div style="background-image: url('{{ asset('image/patologi.png') }}')!important; background-repeat: no-repeat; background-size: 297mm 210mm; size: 297mm 210mm; width: 297mm; height: 210mm">
@elseif(in_array($package_id, [13]))
<div style="background-image: url('{{ asset('image/kimia-air.png') }}')!important; background-repeat: no-repeat; background-size: 297mm 210mm; size: 297mm 210mm; width: 297mm; height: 210mm">
@endif
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <p style="text-align: center; font-family: 'Arial', sans-serif; font-size: 10pt">
        {{ 'Nomor : YM.01.03/XLII/' . sprintf('%04d', $order_package->id) . '/2018' }}
{{--        {{ 'Nomor : DEMO-2018/1234' }}--}}
    </p>
    <h2 style="text-align: center; font-family: 'Charmonman', cursive; font-size: 18pt">{{ $data->laboratory->name }}</h2>
    <p style="text-align: center; font-family: 'Arial', sans-serif; font-size: 12pt">
        SEBAGAI PESERTA<br/>
        PROGRAM PEMANTAPAN MUTU EKSTERNAL<br/>
        BIDANG {{ strtoupper($package_name) }}<br/>
        SIKLUS II TAHUN 2018
    </p>

    <p style="text-align: center; font-family: 'Arial', sans-serif; font-size: 12pt; margin-left: 60px; margin-right: 60px;">PARAMETER :
        <br/>
        @foreach($data->bottles[0]->parameters as $parameter)
            @if($parameter->hasil != null)
                {{ $parameter->name . ', ' }}
            @endif
        @endforeach
    </p>

    <p style="text-align: center; font-family: 'Arial', sans-serif; font-size: 12pt; margin-left: 60px; margin-right: 60px;">Yang diselenggarakan oleh<br/>
        BALAI BESAR LABORATORIUM KESEHATAN PALEMBANG
    </p>
    <p style="text-align: center; font-family: 'Arial', sans-serif; font-size: 12pt; margin-left: 60px; margin-right: 60px;">
        <br/>Palembang, 30 Oktober 2018<br/>
        Kepala,<br/>
        <br/>
        <br/>
        <br/>
        <strong>dr. Rochman Arif, M.Kes</strong><br/>
        NIP 196408291996021001<br/>
    </p>
</div>

@else

    @if(in_array($package_id, [5, 6, 7, 8]))
    <div style="background-image: url('{{ asset('image/imunologi.png') }}')!important; background-repeat: no-repeat; background-size: 297mm 210mm; size: 297mm 210mm; width: 297mm; height: 210mm">
    @elseif(in_array($package_id, [9, 10, 11, 12]))
    <div style="background-image: url('{{ asset('image/mikrobiologi.png') }}')!important; background-repeat: no-repeat; background-size: 297mm 210mm; size: 297mm 210mm; width: 297mm; height: 210mm">
    @endif
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <p style="text-align: center; font-family: 'Arial', sans-serif; font-size: 10pt">
            {{ 'Nomor : YM.01.03/XLII/' . sprintf('%04d', $order_package->id) . '/2018' }}
        </p>
        <h2 style="text-align: center; font-family: 'Charmonman', cursive; font-size: 18pt">{{ $laboratory->name }}</h2>
        <p style="text-align: center; font-family: 'Arial', sans-serif; font-size: 12pt">
            SEBAGAI PESERTA<br/>
            PROGRAM PEMANTAPAN MUTU EKSTERNAL<br/>
            BIDANG {{ strtoupper(explode('-', $package_name)[0]) }}<br/>
            SIKLUS II TAHUN 2018
        </p>

        <p style="text-align: center; font-family: 'Arial', sans-serif; font-size: 12pt; margin-left: 60px; margin-right: 60px;">PARAMETER :
            <br/>
            {{ explode('-', $package_name)[1] }}
        </p>

        <p style="text-align: center; font-family: 'Arial', sans-serif; font-size: 12pt; margin-left: 60px; margin-right: 60px;">Yang diselenggarakan oleh<br/>
            BALAI BESAR LABORATORIUM KESEHATAN PALEMBANG
        </p>
        <p style="text-align: center; font-family: 'Arial', sans-serif; font-size: 12pt; margin-left: 60px; margin-right: 60px;">
            <br/>Palembang, 30 Oktober 2018<br/>
            Kepala,<br/>
            <br/>
            <br/>
            <br/>
            <strong>dr. Rochman Arif, M.Kes</strong><br/>
            NIP 196408291996021001<br/>
        </p>
    </div>

@endif

</body>
</html>