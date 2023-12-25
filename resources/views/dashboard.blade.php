<x-app-layout>
    <x-slot name="header">
        <x-header>
        </x-header>

    </x-slot>




    <div class="row">
        <div class="col-lg-6">
            <div class="card m-b-30">
                <div class="card-body">

                    <h4 class="mt-0 header-title">Responsive embed video 16:9</h4>
                    <p class="text-muted m-b-30 font-14">Aspect ratios can be customized with modifier classes.</p>

                    <!-- 16:9 aspect ratio -->
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item"
                            src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0"></iframe>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->

        <div class="col-lg-6">
            <div class="card m-b-30">
                <div class="card-body">

                    <h4 class="mt-0 header-title">Responsive embed video 21:9</h4>
                    <p class="text-muted m-b-30 font-14">Aspect ratios can be customized with modifier classes.</p>

                    <!-- 21:9 aspect ratio -->
                    <div class="embed-responsive embed-responsive-21by9">
                        <iframe class="embed-responsive-item"
                            src="http://player.vimeo.com/video/220210162?color=67a8e4&amp;title=0&amp;byline=0&amp;portrait=0"></iframe>
                    </div>

                </div>
            </div>
        </div> <!-- end col -->

    </div>
</x-app-layout>
