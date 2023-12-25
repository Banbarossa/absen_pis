<x-modal-calendar action={{$action}} method='post'>
    @if ($data->id)
        @method('put')
    @endif
    <div class="row">
        <div class="col-6">
            <input type="text" class="form-control" id="event_start" value="{{$data->event_start ?? request()->event_start}}" name="event_start">
        </div>
        <div class="col-6">
            <input type="text" class="form-control" id="event_end" value="{{$data->event_end ?? request()->event_end}}" name="event_end">
        </div>
        <div class="row">
            <div class="col-12">
                <textarea name="event_name" id="" cols="30" rows="10">{{$data->event_name}}</textarea>
            </div>
        </div>
    </div>
</x-modal-calendar>


