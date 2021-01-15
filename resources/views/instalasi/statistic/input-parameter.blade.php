<div class="ui form" style="margin-top: 16px;">

    <div class="ui field">
        <label for="input-parameter">Parameter</label>
        <select id="input-parameter" class="ui search fluid dropdown">
            <option value="">Pilih Parameter</option>
            @foreach($package->parameters as $parameter)
                <option value="{{ $parameter->id }}" data-parameter-label="{{ $parameter->label }}">{{ $parameter->label }}</option>
            @endforeach
        </select>
    </div>

</div>