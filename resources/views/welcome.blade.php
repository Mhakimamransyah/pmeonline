@extends('layouts.app')

@section('content-header')
    <h1>
        &nbsp;
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('homepage') }}">Home</a></li>
        <li><a href="{{ route('homepage') }}">Panduan</a></li>
    </ol>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header">
            <h3 class="box-title">Jadwal Penyelenggaraan PME Tahun 2018 Siklus 2</h3>
        </div>
        <div class="box-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th width="3%">No.</th>
                    <th>Bidang</th>
                    <th width="5%">Target Jumlah Peserta</th>
                    <th width="8%">Jumlah Sample</th>
                    <th width="8%">Parameter</th>
                    <th width="10%">Biaya</th>
                    <th width="8%">Mengirimkan Surat Pemberitahuan</th>
                    <th width="8%">Batas Akhir Pendaftaran</th>
                    <th width="8%">Pendistribusian</th>
                    <th width="8%" class="bg-warning">Pemeriksaan</th>
                    <th width="8%">Akhir Batas Penerimaan Jawaban</th>
                    <th width="8%">Feedback</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>Kimia Klinik</td>
                    <td>150</td>
                    <td>2 bahan</td>
                    <td>19 parameter</td>
                    <td>Rp 650.000</td>
                    <td>26 Jan. 2018</td>
                    <td>2 Juli 2018</td>
                    <td>3 Sept. 2018</td>
                    <td class="bg-warning">18 Sept. 2018</td>
                    <td>5 Okt. 2018</td>
                    <td>10 Des. 2018</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Hematologi</td>
                    <td>150</td>
                    <td>2 bahan</td>
                    <td>8 parameter</td>
                    <td>Rp 1.110.000</td>
                    <td>26 Jan. 2018</td>
                    <td>2 Juli 2018</td>
                    <td>3 Sept. 2018</td>
                    <td class="bg-warning">18 Sept. 2018</td>
                    <td>5 Okt. 2018</td>
                    <td>10 Des. 2018</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Urinalisa</td>
                    <td>150</td>
                    <td>2 bahan</td>
                    <td>11 parameter</td>
                    <td>Rp 740.000</td>
                    <td>26 Jan. 2018</td>
                    <td>2 Juli 2018</td>
                    <td>3 Sept. 2018</td>
                    <td class="bg-warning">18 Sept. 2018</td>
                    <td>5 Okt. 2018</td>
                    <td>10 Des. 2018</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Hemostatis</td>
                    <td>50</td>
                    <td>2 bahan</td>
                    <td>4 parameter</td>
                    <td>Rp 510.000</td>
                    <td>26 Jan. 2018</td>
                    <td>2 Juli 2018</td>
                    <td>3 Sept. 2018</td>
                    <td class="bg-warning">18 Sept. 2018</td>
                    <td>5 Okt. 2018</td>
                    <td>10 Des. 2018</td>
                </tr>
                <tr>
                    <td rowspan="4">5</td>
                    <td rowspan="4">Imunologi</td>
                    <td>50</td>
                    <td>3 bahan</td>
                    <td>HIV</td>
                    <td>Rp 575.000</td>
                    <td>26 Jan. 2018</td>
                    <td>2 Juli 2018</td>
                    <td>3 Sept. 2018</td>
                    <td class="bg-warning">18 Sept. 2018</td>
                    <td>5 Okt. 2018</td>
                    <td>10 Des. 2018</td>
                </tr>
                <tr>
                    <td>50</td>
                    <td>3 bahan</td>
                    <td>HBs Ag</td>
                    <td>Rp 470.000</td>
                    <td>26 Jan. 2018</td>
                    <td>2 Juli 2018</td>
                    <td>3 Sept. 2018</td>
                    <td class="bg-warning">18 Sept. 2018</td>
                    <td>5 Okt. 2018</td>
                    <td>10 Des. 2018</td>
                </tr>
                <tr>
                    <td>50</td>
                    <td>3 bahan</td>
                    <td>HCV</td>
                    <td>Rp 550.000</td>
                    <td>26 Jan. 2018</td>
                    <td>2 Juli 2018</td>
                    <td>3 Sept. 2018</td>
                    <td class="bg-warning">18 Sept. 2018</td>
                    <td>5 Okt. 2018</td>
                    <td>10 Des. 2018</td>
                </tr>
                <tr>
                    <td>50</td>
                    <td>3 bahan</td>
                    <td>TPHA</td>
                    <td>Rp 550.000</td>
                    <td>26 Jan. 2018</td>
                    <td>2 Juli 2018</td>
                    <td>3 Sept. 2018</td>
                    <td class="bg-warning">18 Sept. 2018</td>
                    <td>5 Okt. 2018</td>
                    <td>10 Des. 2018</td>
                </tr>
                <tr>
                    <td rowspan="4">6</td>
                    <td rowspan="4">Mikrobiologi</td>
                    <td>50</td>
                    <td>10 slide</td>
                    <td>BTA</td>
                    <td>Rp 375.000</td>
                    <td>26 Jan. 2018</td>
                    <td>2 Juli 2018</td>
                    <td>3 Sept. 2018</td>
                    <td class="text-center bg-warning">langsung diperiksa</td>
                    <td>5 Okt. 2018</td>
                    <td>10 Des. 2018</td>
                </tr>
                <tr>
                    <td>50</td>
                    <td>10 slide</td>
                    <td>Malaria</td>
                    <td>Rp 375.000</td>
                    <td>26 Jan. 2018</td>
                    <td>2 Juli 2018</td>
                    <td>3 Sept. 2018</td>
                    <td class="text-center bg-warning">langsung diperiksa</td>
                    <td>5 Okt. 2018</td>
                    <td>10 Des. 2018</td>
                </tr>
                <tr>
                    <td>50</td>
                    <td>2 tube</td>
                    <td>Parasit Saluran Pencernaan (Telur Cacing)</td>
                    <td>Rp 317.000</td>
                    <td>26 Jan. 2018</td>
                    <td>2 Juli 2018</td>
                    <td>3 Sept. 2018</td>
                    <td class="text-center bg-warning">langsung diperiksa</td>
                    <td>5 Okt. 2018</td>
                    <td>10 Des. 2018</td>
                </tr>
                <tr>
                    <td>10</td>
                    <td>3 tube</td>
                    <td>Kultur dan Resistensi MO</td>
                    <td>Rp 525.000</td>
                    <td>26 Jan. 2018</td>
                    <td>2 Juli 2018</td>
                    <td>3 Sept. 2018</td>
                    <td class="text-center bg-warning">langsung diperiksa</td>
                    <td>5 Okt. 2018</td>
                    <td>10 Des. 2018</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Kimia Kesehatan</td>
                    <td>10</td>
                    <td>1 bahan</td>
                    <td>Mangan, Besi, Alumunium, dan Zink</td>
                    <td>Rp 900.000</td>
                    <td>26 Jan. 2018</td>
                    <td>2 Juli 2018</td>
                    <td>3 Sept. 2018</td>
                    <td  class="bg-warning">18 Sept. 2018</td>
                    <td>5 Okt. 2018</td>
                    <td>10 Des. 2018</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
