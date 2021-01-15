@extends('v1.layouts.dashboard')

@section('content')

    <div class="row">

        <div class="col-md-3">

            <div class="box box-success">

                <div class="box-header">
                    <div class="box-title">
                        <h4>{{ __('Pencarian Formulir Ujian Peserta') }}</h4>
                    </div>
                </div>


                <div class="box-body">

                    <div class="row">

                        <form action="{{ route('v1.administrator.form-input') }}" method="GET">

                            <div class="col-md-12">

                                <div class="form-group has-feedback">
                                    <label for="order_package_id">{{ 'ID Pemesanan Paket :' }}</label>
                                    <input id="order_package_id" type="number" class="form-control" name="{{'order_package_id'}}" value="{{ old('order_package_id') }}">
                                    <p>{!! __('Angka yang ada setelah <b>/participant/post-result/</b>') !!}</p>
                                </div>

                                <button type="submit" class="btn btn-info pull-right" style="margin-left: 8px;">Cari</button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-9">

            <div class="box box-success">

                <div class="box-header">
                    <div class="box-title">
                        <h4>{{ __('Detail Formulir Ujian Peserta') }}</h4>
                    </div>
                </div>


                <div class="box-body">

                    @if (isset($orderPackage) && $orderPackage != null)

                        <div class="row">

                            <div class="col-md-12 table-responsive">

                                <table class="table table-striped">
                                    <tr>
                                        <th width="25%">{{ __('ID Pemesanan Paket') }}</th>
                                        <th>#{{ $orderPackage->id }}</th>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Nama Laboratorium') }}</th>
                                        <td>{{ $orderPackage->order->laboratory->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Alamat Laboratorium') }}</th>
                                        <td>
                                            {{ $orderPackage->order->laboratory->address }}<br/>
                                            {!! $orderPackage->order->laboratory->village ?: '<i>Kelurahan tidak diisi</i>' !!}, {!! $orderPackage->order->laboratory->district ?: '<i>Kecamatan tidak diisi</i>' !!}, {!! $orderPackage->order->laboratory->city ?: '<i>Kota tidak diisi</i>' !!}<br/>
                                            {{ $orderPackage->order->laboratory->province->name }} {{ $orderPackage->order->laboratory->postal_code }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Siklus') }}</th>
                                        <td>{{ $orderPackage->order->cycle->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Paket') }}</th>
                                        <td>{{ $orderPackage->package->subject->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Parameter') }}</th>
                                        <td>{{ $orderPackage->package->displayParameters() }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('Status Isian') }}</th>
                                        <td>
                                            @if ($orderPackage->input == null)
                                                {{ __('Belum terisi') }}
                                            @elseif ($orderPackage->input->sent)
                                                {{ __('Terisi, sudah terkirim') }}
                                            @else
                                                {{ __('Terisi, baru tersiman') }}
                                            @endif
                                        </td>
                                    </tr>
                                </table>

                                <form method="POST" action="{{ route('v1.administrator.form-input.send') }}">
                                    @csrf
                                    <input id="order_package_id" type="hidden" class="form-control" name="{{'order_package_id'}}" value="{{ $orderPackage->id }}">
                                    @if ($orderPackage->input == null)
                                    @elseif ($orderPackage->input->sent)
                                        <input id="order_package_id" type="hidden" class="form-control" name="{{'send'}}" value="0">
                                        <button class="btn btn-warning pull-right">{{ __('Kembalikan') }}</button>
                                    @else
                                        <input id="order_package_id" type="hidden" class="form-control" name="{{'send'}}" value="1">
                                        <button class="btn btn-warning pull-right">{{ __('Kirim') }}</button>
                                    @endif
                                </form>

                            </div>

                        </div>

                    @elseif (request()->get('order_package_id') != null)

                        <div class="callout callout-warning">
                            <h4>Peringatan!</h4>
                            <ul>
                                <li>{{ __('ID pemesanan paket ditemukan.') }}</li>
                            </ul>
                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>



@endsection