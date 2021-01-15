@extends('layouts.semantic-ui.dashboard')

@section('style')

    @include('layouts.moment-js.css')

@endsection

@section('content')

    <div class="medium-form">

        <div class="medium-form-content">

            <div class="ui breadcrumb">
                <a href="{{ route('administrator.cycle.index') }}" class="section"><i class="recycle icon"></i>{{ __('Siklus') }}</a>
                <i class="right arrow icon divider"></i>
                <div class="active section">{{ __($cycle->getName()) }}</div>
            </div>

            <div class="ui raised segments">

                <form class="ui form" method="post">

                    <div class="ui clearing segment">

                        <a class="ui green ribbon label ribbon-sub-segment">{{ __('Penandatangan Hasil Evaluasi Siklus ') . $cycle->getName() }}</a>

                            @csrf

                            <div class="ui two fields">

                                <div class="ui field">
                                    <label>Lokasi Penandatanganan Hasil Evaluasi</label>
                                    <input name="evaluation_signed_on_place" value="{{ $cycle->evaluation_signed_on_place }}" placeholder="Isi lokasi penandatanganan hasil evaluasi"/>
                                </div>

                                <div class="ui field">
                                    <label>Tanggal Penandatanganan Hasil Evaluasi</label>
                                    <input name="evaluation_signed_on_date" value="{{ $cycle->evaluation_signed_on_date }}" placeholder="Isi teks tanggal penandatanganan hasil evaluasi"/>
                                </div>

                            </div>

                            <div class="ui two fields">

                                <div class="ui field">
                                    <label>Nama Penandatangan Hasil Evaluasi</label>
                                    <input name="evaluation_signed_by_name" value="{{ $cycle->evaluation_signed_by_name }}" placeholder="Isi nama penandatangan hasil evaluasi"/>
                                </div>

                                <div class="ui field">
                                    <label>NIP Penandatangan Hasil Evaluasi</label>
                                    <input name="evaluation_signed_by_identifier" value="{{ $cycle->evaluation_signed_by_identifier }}" placeholder="Isi NIP penandatangan hasil evaluasi"/>
                                </div>

                            </div>

                            <div class="ui two fields">

                                <div class="ui field">
                                    <label>Jabatan Penandatangan Hasil Evaluasi</label>
                                    <input name="evaluation_signed_by_position" value="{{ $cycle->evaluation_signed_by_position }}" placeholder="Isi jabatan penandatangan hasil evaluasi"/>
                                </div>

                            </div>

                            <br/>

                            <a class="ui green ribbon label ribbon-sub-segment">{{ __('Penandatangan Sertifikat Siklus ') . $cycle->getName() }}</a>

                            <div class="ui two fields">

                                <div class="ui field">
                                    <label>Lokasi Penandatanganan Sertifikat</label>
                                    <input name="certificate_signed_on_place" value="{{ $cycle->certificate_signed_on_place }}" placeholder="Isi lokasi penandatanganan sertifikat"/>
                                </div>

                                <div class="ui field">
                                    <label>Tanggal Penandatanganan Sertifikat</label>
                                    <input name="certificate_signed_on_date" value="{{ $cycle->certificate_signed_on_date }}" placeholder="Isi teks tanggal penandatanganan sertifikat"/>
                                </div>

                            </div>

                            <div class="ui two fields">

                                <div class="ui field">
                                    <label>Nama Penandatangan Sertifikat</label>
                                    <input name="certificate_signed_by_name" value="{{ $cycle->certificate_signed_by_name }}" placeholder="Isi nama penandatangan sertifikat"/>
                                </div>

                                <div class="ui field">
                                    <label>NIP Penandatangan Sertifikat</label>
                                    <input name="certificate_signed_by_identifier" value="{{ $cycle->certificate_signed_by_identifier }}" placeholder="Isi NIP penandatangan sertifikat"/>
                                </div>

                            </div>

                            <div class="ui two fields">

                                <div class="ui field">
                                    <label>Jabatan Penandatangan Sertifikat</label>
                                    <input name="certificate_signed_by_position" value="{{ $cycle->certificate_signed_by_position }}" placeholder="Isi jabatan penandatangan sertifikat"/>
                                </div>

                            </div>

                            <button type="submit" class="ui right floated primary button">
                                <i class="save icon"></i>
                                {{ __('Simpan Penandatangan Siklus ' . $cycle->getName()) }}
                            </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection

@section('script')
    @include('layouts.moment-js.js')
@endsection