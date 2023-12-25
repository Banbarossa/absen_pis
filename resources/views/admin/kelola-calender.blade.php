<x-app-layout>
    <x-content-area>
        <x-header>
            <x-slot name="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Annex</a></li>
                <li class="breadcrumb-item"><a href="#">UI Kit</a></li>
                <li class="breadcrumb-item active">Video</li>
            </x-slot name="breadcrumb">
            <h4 class="page-title">Kalender Akademik</h4>
        </x-header>

        <div class="card m-b-30">
            <div class="card-body">
                <div class="row">
                    {{-- <div class="col-12 col-lg-6">
                        <h4 class="mt-0 header-title">Kalender KBM</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Agenda</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($events as $item)
                                <tr>
                                    <td>{{\Carbon\Carbon::parse($item->event_start)->format('d/m/Y')}} - {{\Carbon\Carbon::parse($item->event_end)->format('d/m/Y')}}</td>
                                    <td>{{$item->event_name}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> --}}
                    <div class="col-12">
                        <div class="">
                            <h4 class="mt-0 header-title">Kalender KBM</h4>
                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>




            </div>
        </div>

        {{-- css --}}
        @push('style')
        {{-- <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{asset('assets/plugins/fullcalendar/css/fullcalendar.min.css')}}" rel="stylesheet" />
        <link rel="stylesheet" href="{{asset('assets/css/home.css')}}"> --}}
            
        @endpush

        {{-- js --}}
        @push('script')
        {{-- Scripts --}}
        {{-- <script src="{{asset('assets/plugins/moment/moment.js')}}"></script>
        <script src='{{asset('assets/plugins/fullcalendar/js/fullcalendar.min.js')}}'></script> --}}
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
    
        {{-- <script src="{{asset('assets/pages/calendar-init.js')}}"></script> --}}
        {{-- <script>
            $(document).ready(function () {
               
            var SITEURL = "{{ url('/') }}";
              
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
              
            var calendar = $('#calendar').fullCalendar({
                editable: true,
                events: SITEURL + "/calendar-event",
                displayEventTime: false,
                editable: true,
                eventRender: function (event, element, view) {
                    if (event.allDay === 'true') {
                            event.allDay = true;
                    } else {
                            event.allDay = false;
                    }
                },
                selectable: true,
                selectHelper: true,
                select: function (start, end, allDay) {
                    var title = prompt('Event Title:');
                    if (title) {
                        var start = $.moment(start).format("Y-MM-DD");
                        var end = $.moment(end).format("Y-MM-DD");
                        // var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
                        $.ajax({
                            url: SITEURL + "/calendar-crud-ajax",
                            data: {
                                title: title,
                                start: start,
                                end: end,
                                type: 'add'
                            },
                            type: "POST",
                            success: function (data) {
                                displayMessage("Event Created Successfully");

                                calendar.fullCalendar('renderEvent',
                                    {
                                        id: data.id,
                                        title: title,
                                        start: start,
                                        end: end,
                                        allDay: allDay
                                    },true);

                                calendar.fullCalendar('unselect');
                            }
                        });
                    }
                },
                eventDrop: function (event, delta) {
                    var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                    var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");

                    $.ajax({
                        url: SITEURL + '/fullcalenderAjax',
                        data: {
                            title: event.title,
                            start: start,
                            end: end,
                            id: event.id,
                            type: 'update'
                        },
                        type: "POST",
                        success: function (response) {
                            displayMessage("Event Updated Successfully");
                        }
                    });
                },
                eventClick: function (event) {
                    var deleteMsg = confirm("Do you really want to delete?");
                    if (deleteMsg) {
                        $.ajax({
                            type: "POST",
                            url: SITEURL + '/fullcalenderAjax',
                            data: {
                                    id: event.id,
                                    type: 'delete'
                            },
                            success: function (response) {
                                calendar.fullCalendar('removeEvents', event.id);
                                displayMessage("Event Deleted Successfully");
                            }
                        });
                    }
                }

            });
             
            });
             
            function displayMessage(message) {
                toastr.success(message, 'Event');
            } 
              
        </script> --}}

        <script>
            document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = $('#calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth'
            });

            calendar.render();
        });
        </script>
      
            
        @endpush

    </x-content-area>
</x-app-layout>
