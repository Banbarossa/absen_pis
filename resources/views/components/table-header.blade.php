@props(['name'=>'search','pagination'=>'perPage'])

<div class="d-flex align-items-center mb-2 justify-content-between">
    {{-- <div class="col-12 col-md-6 col-lg-9"> --}}
    <div class="">
        <span>Show</span>
        <select wire:model.live='{{$pagination}}' class="custom-select" style="width:80px">
            <option value="15">15</option>
            <option value="25">25</option>
            <option value="50">50</option>
        </select>
        <span>entries</span>
    </div>
    {{-- <div class="col-12 col-md-6 col-lg-3" style="width: %"> --}}
    <div class="" style="width: 40%">
        <div class="input-group mt-2">
            <span class="input-group-prepend">
                <button type="button" class="btn btn-primary"><i class="fa fa-search"></i></button>
            </span>
            <input type="text" id="search" wire:model.live="{{$name}}" class="form-control" placeholder="Search">
        </div>
    </div>
    
    
</div>