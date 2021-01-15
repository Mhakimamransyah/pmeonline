@include('layouts.dashboard.legacy-error')

<div class="ui segments">

    <div class="ui segment">
        <a class="ui right floated blue button" href="{{ route('administrator.cycle.participant.export', ['cycleId' => $cycle->getId()]) }}">Export Data ke Excel</a>
        <br/>
        <br/>
    </div>

    <div class="ui segment">

        <a class="ui green ribbon label ribbon-sub-segment">{{ __('Siklus') }}</a>

        <table class="ui striped table" id="cycle-laboratory-list-table">
            <thead>
            <tr>
                <th>
                    {{ __('Laboratorium') }}
                </th>
                <th style="width: 150px">
                    {{ __('Tagihan') }}
                </th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

    </div>

</div>