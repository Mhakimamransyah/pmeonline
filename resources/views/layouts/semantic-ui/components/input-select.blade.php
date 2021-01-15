<div class="field @if(isset($hasError) && $hasError) error @endif">
    <label>{{ $label }}</label>
    <select class="ui search fluid dropdown" name="{{ $name }}" @if(isset($required)) required @endif>
        <option value="">{{ $label }}</option>
        @foreach($items as $item)
            <option value="{{ $item->id }}" @if(old($old) == $item->id) selected="" @endif @if(isset($selected) && ($selected == $item->id)) selected="" @endif>{{ $item->name }}</option>
        @endforeach
    </select>
</div>