@extends('layouts.semantic-ui.dashboard')

@section('content')

    <div class="medium-form">

        <div class="medium-form-content">

            @if($orders->isEmpty())

                @include('participant.submit.no-item')

            @else

                <div class="ui segment">

                    <a class="ui green ribbon label">{{ __('Jadwal Pengisian Ujian PME') }}</a>

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

                                        <a class="ui green label">
                                            <i class="calendar half icon"></i>&nbsp;
                                            {{ __('Pengisian dibuka pada ') . $order->getPackage()->getCycle()->getStartSubmitDate()->formatLocalized('%e %B %Y') }}
                                        </a>

                                    </div>
                                    <div class="description">
                                    </div>

                                    <div class="extra">
                                        @foreach($order->getPackage()->getParameters() as $parameter)
                                            <span class="ui label" style="margin: 2px 0 2px;">{{ $parameter->label }}</span>
                                        @endforeach

                                        <br/>

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