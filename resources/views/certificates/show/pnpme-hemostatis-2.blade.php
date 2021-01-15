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
<div style="background-image: url('{{ asset('image/imunologi.png') }}')!important; background-repeat: no-repeat; background-size: 297mm 210mm; size: 297mm 210mm; width: 297mm; height: 210mm">
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
        {{ 'Nomor : YM.01.03/XLII/' . sprintf('%04d', $order->id) . '/' . __('2019') }}
    </p>
    <h2 style="text-align: center; font-family: 'Charmonman', cursive; font-size: 18pt">{{ $order->invoice->laboratory->name }}</h2>
    <p style="text-align: center; font-family: 'Arial', sans-serif; font-size: 12pt">
        SEBAGAI PESERTA<br/>
        PROGRAM PEMANTAPAN MUTU EKSTERNAL<br/>
        BIDANG {{ strtoupper('Hemostasis') }}<br/>
        SIKLUS I TAHUN 2019
    </p>

    <p style="text-align: center; font-family: 'Arial', sans-serif; font-size: 12pt; margin-left: 60px; margin-right: 60px;">PARAMETER :
        <br/>
        {{ implode(', ', $parameters) }}
    </p>

    <p style="text-align: center; font-family: 'Arial', sans-serif; font-size: 12pt; margin-left: 60px; margin-right: 60px;">Yang diselenggarakan oleh<br/>
        BALAI BESAR LABORATORIUM KESEHATAN PALEMBANG
    </p>
    <p style="text-align: center; font-family: 'Arial', sans-serif; font-size: 12pt; margin-left: 60px; margin-right: 60px;">
        <br/>Palembang, {{ __('03 Juli 2019') }}<br/>
        {{ __('Kepala,') }}<br/>
        <br/>
        <br/>
        <br/>
        <strong>{{ __('dr. Rochman Arif, M.Kes') }}</strong><br/>
        NIP {{ __('196408291996021001') }}<br/>
    </p>
</div>

</body>
</html>