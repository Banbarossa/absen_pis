<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="btn-group float-right">
                <ol class="breadcrumb hide-phone p-0 m-0">

                    @if (isset($breadcrumb))
                        {{$breadcrumb}}
                    @endif
                    {{-- <li class="breadcrumb-item"><a href="#">Annex</a></li>
                    <li class="breadcrumb-item"><a href="#">UI Kit</a></li>
                    <li class="breadcrumb-item active">Video</li> --}}
                </ol>
            </div>
            {{$slot}}
        </div>
    </div>
</div>