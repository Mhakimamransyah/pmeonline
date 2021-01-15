<div class="field @if(isset($hasError) && $hasError) error @endif">
    <label>{{ $label }}</label>
    <input placeholder="{{ $placeholder ?? '' }}" type="{{ isset($type) ? $type : 'text' }}" name="{{ $name }}"
            @if(isset($value))
            value="{{ $value }}"
            @else
            value="{{ old($old) }}"
            @endif

            @if(isset($required))
            required
            @endif

            @if(isset($type) && $type == 'date')
           data-date-format="LL" class="date-input"
            @endif
    >
</div>