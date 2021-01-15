@extends('layouts.semantic-ui.dashboard')

@section('content')

    <div class="medium-form">

        <div class="medium-form-content">

            @if($orders->isEmpty())

                @include('participant.submit.no-item')

            @else

                <div class="ui segment">

                    <a class="ui green ribbon label">{{ __('Isian Uji PME') }}</a>

                    <div class="ui divided items">

                        @foreach($orders as $order)

                            <div class="ui item">
                                <div class="content">
                                    <h3 class="header">{{ $order->getPackage()->getLabel() }}</h3>
                                    <div class="meta">

                                        <a class="ui teal label">
                                            <i class="recycle icon"></i>&nbsp;
                                            {{ 'Siklus ' . $order->getPackage()->getCycle()->getName() }}
                                        </a>

                                        @if($order->getSubmit() == null)
                                            <a class="ui red label">
                                                <i class="edit outline icon"></i>&nbsp;
                                                {{ 'Belum Diisi' }}
                                            </a>
                                        @elseif ($order->getSubmit()->isSent())
                                            <a class="ui green label">
                                                <i class="edit outline icon"></i>&nbsp;
                                                {{ 'Terkirim ' . $order->getSubmit()->getUpdatedAt() }}
                                            </a>
                                        @else
                                            <a class="ui orange label">
                                                <i class="edit outline icon"></i>&nbsp;
                                                {{ 'Tersimpan ' . $order->getSubmit()->getUpdatedAt() }}
                                            </a>
                                        @endif

                                        @if($order->getSubmit() != null && !$order->getSubmit()->isSent())

                                            @if($order->getPackage()->getCycle()->getEndSubmitDate()->isPast())
                                                <a class="ui red label">
                                                    <i class="hourglass half icon"></i>&nbsp;
                                                    {{ 'Batas akhir pengisian sudah lewat ' . $order->getPackage()->getCycle()->getEndSubmitDateDisplay() }}
                                                </a>
                                            @else
                                                <a class="ui orange label">
                                                    <i class="hourglass half icon"></i>&nbsp;
                                                    {{ 'Batas akhir pengisian ' . $order->getPackage()->getCycle()->getEndSubmitDateDisplay() }}
                                                </a>
                                            @endif

                                        @endif

                                    </div>
                                    <div class="description">
                                    </div>

                                    <div class="extra">
                                        @foreach($order->getPackage()->getParameters() as $parameter)
                                            <span class="ui label" style="margin: 2px 0 2px;">{{ $parameter->label }}</span>
                                        @endforeach

                                        <br/>

                                        @if($order->getSubmit() == null)
                                            <a href="{{ route('participant.submit.show', ['order_id' => $order->getId() ]) }}" target="_blank" class="ui right floated button">
                                                {{ __('Isi') }}
                                                <i class="right chevron icon"></i>
                                            </a>
                                        @elseif ($order->getSubmit()->isSent() || $order->getPackage()->getCycle()->getEndSubmitDate()->isPast())
                                            <a href="{{ route('participant.submit.show', ['order_id' => $order->getId() ]) }}" class="ui right floated button">
                                                {{ __('Lihat Isian') }}
                                                <i class="right chevron icon"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('participant.submit.show', ['order_id' => $order->getId() ]) }}" target="_blank" class="ui right floated blue button">
                                                {{ __('Ubah Isi') }}
                                                <i class="right chevron icon"></i>
                                            </a>
                                        @endif

                                    </div>
                                </div>
                            </div>

                        @endforeach

                    </div>

                </div>

            @endif

        </div>

    </div>

@endsection