<div class="form-group has-feedback @if($errors->has($name)) has-error @endif">
    <label>{{ $label }}</label>
    <select class="form-control select2" style="width: 100%;" name="{{ $name }}" id="{{ 'select-' . $name }}" @if(isset($disabled)) disabled="" @endif @if(isset($required)) required @endif>
        @if(isset($placeholder))
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach($items as $item)
            <option value="{{ $item->id }}" @if(old($name) == $item->id) selected="" @endif @if(isset($selected) && ($selected == $item->id)) selected="" @endif>{{ $item->name }}</option>
        @endforeach
    </select>
    <span class="help-block"><small>{{ $errors->first($name) }}</small></span>
</div>
