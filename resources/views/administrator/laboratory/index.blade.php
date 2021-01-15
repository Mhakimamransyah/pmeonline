@extends('layouts.semantic-ui.dashboard')

@section('style')

    @include('layouts.datatables.css')

@endsection

@section('content')

    @include('layouts.semantic-ui.components.progress-html')

    <div class="medium-form loaded-content">

        <div class="medium-form-content">

            <div class="ui segment">

                <a class="ui green ribbon label ribbon-sub-segment">{{ __('Laboratorium') }}</a>

                <table class="ui striped table data-tables">
                    <thead>
                    <tr>
                        <th width="5%">
                            {{ __('#') }}
                        </th>
                        <th>
                            {{ __('Nama') }}
                        </th>
                        <th>
                            {{ __('Email') }}
                        </th>
                        <th>
                            {{ __('Nomor Telepon') }}
                        </th>
                        <th>
                            {{ __('Personil Penghubung') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($laboratories as $laboratory)
                        <tr>
                            <td class="ui center aligned">{{ __($laboratory->getId()) }}</td>
                            <td><a href="{{ route('administrator.laboratory.show', ['id' => $laboratory->getId()]) }}">{{ __($laboratory->getName()) }}</a></td>
                            <td>{{ __($laboratory->getEmail()) }}</td>
                            <td>{{ __($laboratory->getPhoneNumber()) }}</td>
                            @if($laboratory->getUser() == null)
                                <td class="ui center aligned">{{ __('-') }}</td>
                            @else
                                <td><a href="{{ route('administrator.contact-person.show', ['user_id' => $laboratory->getUser()->getId()]) }}">{{ $laboratory->getUser()->getName() }}</a></td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>

        </div>

    </div>

@endsection

@section('script')

    @include('layouts.datatables.js')

@endsection