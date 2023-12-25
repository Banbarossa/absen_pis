<div>
    <x-content-area>

        <x-header>
            <h4 class="page-title">Informasi</h4>
        </x-header>
        @if ($informasi_id)
            <form action="" wire:submit.prevent='update'>
        @else
            <form action="" wire:submit.prevent='store'>
        @endif
            <div class="row">
                {{-- musyria Area --}}
                <div class="col-lg-12">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                {{-- <h4 class="mt-0 header-title">Informasi</h4> --}}
                            </div>
                            <div class="form-group">
                                <label for="title">Judul</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" wire:model.live='title' placeholder="Judul">
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>

                            @error('content')
                                <small class="text-danger">Content Wajib Diisi</small>
                            @enderror
                            <div wire:ignore>
                                <textarea id="elm1" name="content" wire:model.live='content'></textarea>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
    </x-content-area>
    @push('script')
    <script src="{{asset('assets/plugins/tinymce/tinymce.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            if($("#elm1").length > 0){
                tinymce.init({
                    selector: "textarea#elm1",
                    theme: "modern",
                    height:300,
                    plugins: [
                        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                        "save table contextmenu directionality emoticons template paste textcolor"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
                    style_formats: [
                        {title: 'Bold text', inline: 'b'},
                        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                        {title: 'Example 1', inline: 'span', classes: 'example1'},
                        {title: 'Example 2', inline: 'span', classes: 'example2'},
                        {title: 'Table styles'},
                        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                    ],
                    setup:  function(editor){
                        editor.on('init change',function(e){
                            editor.save();
                        })
                        editor.on('change',function(e){
                            @this.set('content',editor.getContent())
                        })
                    }
                });
            }
        });
    </script>
    @endpush
</div>
