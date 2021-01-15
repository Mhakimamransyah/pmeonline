@php

$cycles = \App\v3\Cycle::all();
$packages = \App\v3\Package::query()->where('cycle_id', '=', request()->get('cycle_id'))->get();
$divisionId = auth()->user()->role->division->id;
$packages = $packages->filter(function (\App\v3\Package $package) use ($divisionId) {
    return $package->divisions()->where('divisions.id', '=', $divisionId)->count() > 0;
})

@endphp

<div class="ui form" style="margin-top: 16px;">

    <div class="two fields">

        <div class="field five wide">
            <label for="input-cycle">Siklus</label>
            <select id="input-cycle" class="ui search fluid dropdown">
                <option value="">Pilih Siklus</option>
                @foreach($cycles as $cycle)
                    <option @if(request()->get('cycle_id') == $cycle->id) selected @endif value="{{ $cycle->id }}">{{ $cycle->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="field eleven wide">
            <label for="input-package">Paket</label>
            <select v-model="package_id" id="input-package" class="ui search fluid dropdown">
                <option value="">Pilih Paket</option>
                @foreach($packages as $package)
                    <option @if(request()->get('package_id') == $package->id) selected @endif value="{{ $package->id }}">{{ $package->label }}</option>
                @endforeach
            </select>
        </div>
    </div>

</div>
