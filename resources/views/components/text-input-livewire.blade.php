@props(['disabled'=>false ,'label','name','type'=>'text'])

<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <input type="{{ $type }}" wire:model="{{ $name }}" class="form-control @error($name) is-invalid @enderror" {{$disabled ? 'disabled' :''}}>
    @error($name)
    <div class="invalid-feedback">
        {{$message}}
    </div>
    @enderror
</div>