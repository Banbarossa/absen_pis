<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" class="form-control" value="{{ $value ?? old($name) }}">
    @error($name)
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>