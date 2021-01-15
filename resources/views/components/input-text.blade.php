<div class="form-group has-feedback @if($errors->has($name)) has-error @endif">
    <label>{{ $label }}</label>
    <input class="form-control" placeholder="{{ $placeholder }}" type="text" name="{{ $name }}"
            @if(isset($value))
            value="{{ $value }}"
            @else
            value="{{ old($name) }}"
            @endif

            @if(isset($required))
            required
            @endif
    >
    <span class="help-block"><small>{{ $errors->first($name) }}</small></span>
</div>