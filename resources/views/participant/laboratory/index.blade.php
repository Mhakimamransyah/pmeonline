@extends('layouts.semantic-ui.dashboard')

@section('content')

    <div class="medium-form">

        <div class="medium-form-content ui segments">
            @foreach($laboratories as $laboratory)
                <tr>
                    <td>
                        <div class="ui clearing segment">
                            <a class="ui green ribbon label">{{ $laboratory->getName() }}</a>
                            <h4 class="header">{{ $laboratory->getName() }}</h4>
                            <span>{{ $laboratory->getAddress() }}</span><br/>
                            <span>{{ $laboratory->getVillage() . ', ' . $laboratory->getDistrict() . ', ' . $laboratory->getCity() }}</span><br/>
                            <span>{{ $laboratory->getProvince()->getName() . ' ' . $laboratory->getPostalCode() }}</span>
                            <a href="{{ route('participant.laboratory.show', ['id' => $laboratory->id]) }}" class="ui button right floated">
                                {{ __('Detail') }}
                                <i class="chevron right icon"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </div>

    </div>

@endsection
