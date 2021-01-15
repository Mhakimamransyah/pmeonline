<div class="field">
    <label>{{ $label }}</label>
    <input @if(isset($value)) value="{{ $value }}" @endif readonly>
</div>