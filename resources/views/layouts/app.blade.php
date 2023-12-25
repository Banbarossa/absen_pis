<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>{{config('app.name')}}</title>

        @include('layouts.css')
        @stack('style')

    </head>


    <body class="fixed-left">

        <!-- Loader -->
        <div id="preloader"><div id="status"><div class="spinner"></div></div></div>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">
                <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
                    <i class="ion-close"></i>
                </button>

                <!-- LOGO -->
                <div class="topbar-left border border-bottom mb-3">
                    <div class="text-center">
                        <a href="index.html" class="logo" >
                            <img src="{{asset('assets/images/logo.png')}}" height="70" alt="logo">
                        </a>
                        <!-- <a href="index.html" class="logo"><img src="assets/images/logo.png" height="24" alt="logo"></a> -->
                    </div>
                </div>

                <div class="sidebar-inner slimscrollleft">

                    @include('layouts.sidebar')
                    <div class="clearfix"></div>
                </div> <!-- end sidebarinner -->
            </div>
            <!-- Left Sidebar End -->

            <!-- Start right Content here -->

            <div class="content-page">
                <!-- Start content -->
                <div class="content">

                    <!-- Top Bar Start -->
                   @include('layouts.topbar')
                    <!-- Top Bar End -->

                    <div class="page-content-wrapper ">

                        <div class="container-fluid">

                            @if (isset($header))
                            {{$header}}
                            @endif

                            <!-- end page title end breadcrumb -->
                            {{$slot}}

                        </div><!-- container -->

                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->

                @include('layouts.footer')

            </div>
            <!-- End Right content here -->

        </div>
        <!-- END wrapper -->

        <script>
         window.addEventListener('close-modal',event=>{
             $('#crudModal').modal('hide');
         })

        </script>




        @include('layouts.js')

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
        <x-livewire-alert::scripts />
        @stack('script')

        <script>
            $(document).ready(function() {
            
                
                $.ajax({
                    url: '/unread-messages',
                    type: 'GET',
                    success: function(response) {
                        
                        var unreadMessages = response.unreadMessages;
                        var unreadCount = unreadMessages.length;

                        console.log(unreadCount)
            
                        if (unreadCount > 0) {
                            $('#jumlah_pesan').text(unreadCount).show();
                            
                            // console.log(unreadMessages);

                            var chatLink = '/chat';
                            var chatDropdown = $('#looping_pesan');

                            
                            unreadMessages.forEach(function(message) {
                                var chatItem = '<a href="' + chatLink + '/' + message.user.id + '" target="blank" class="dropdown-item notify-item">' +
                                    '<div class="notify-icon"><img src="/storage/users-avatar/avatar.png" alt="user-img" class="img-fluid rounded-circle" /></div>' +
                                    '<p class="notify-details"><b>' + message.user.name + '</b><small class="text-muted">' + message.body + '</small></p>' +
                                    '</a>';

                                chatDropdown.append(chatItem);
                            });

                            
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        
        </script>

       

    </body>
</html>