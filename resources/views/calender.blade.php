<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
    <meta name="csrf-token" content="{{csrf_token()}}">
  </head>
  <body>
    
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="mt-5" id='calendar'></div>
            </div>
        </div>
        

    </div>
    {{-- Modal --}}
    <div id="calendar-modal" class="modal" tabindex="-1">
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@6.1.9/index.global.min.js'></script>
    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script>


        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name=csrf-token]').attr('content'),
            }
        });

        var calendarEl =document.getElementById('calendar');
        var events =[];
        var calendar = new FullCalendar.Calendar(calendarEl,{
            themeSystem :'bootstrap5',
            headerToolbar:{
                left:'prev,next today',
                center:'title',
                right:'dayGridMonth,timeGridWeek,timeGridDay',
            },
            initialView:'dayGridMonth',
            events:'{{route("event.list")}}',
            timeZone:'UTC',
            editable:true,
            selectable:true,

            select:function(info){
                console.log(info);
            }

            

        })
        
        calendar.render();

        // const modal =$('#calendar-modal')


        // document.addEventListener('DOMContentLoaded', function() {

        //     // $.ajaxSetup({
        //     //     headers: {
        //     //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     //     }
        //     // });


        //     var calendarEl = document.getElementById('calendar');
        //     var calendar = new FullCalendar.Calendar(calendarEl, {
        //         themeSystem: 'bootstrap5',
        //         headerToolbar: {
        //             left: 'prev,next today',
        //             center: 'title',
        //             right: 'dayGridMonth,timeGridWeek,timeGridDay'
        //         },
        //         selectable:true,
        //         editable:true,
                
        //         events:'{{ route("event.list")}}',

        //         dateClick:function(info){

        //             console.log(info.dateStr)
        //             $.ajax({
        //                 url:`{{route('coba.create')}}`,
        //                 data:{
        //                     'event_start': info.dateStr,
        //                     'event_end': info.dateStr,
        //                 },
        //                 success:function(res){
        //                     modal.html(res).modal('show')

        //                     $('#calendar-modal').on('submit',function(e){
        //                         e.preventDefault()
        //                         const form = this
        //                         const formData = new formData(form)

        //                         $.ajax({
        //                             url:form.action,
        //                             method:form.method,
        //                             data:formData,
        //                             processData:false,
        //                             contentType:false,
        //                             success :function(res){
        //                                 console.log(res)
        //                             },
        //                         })
        //                     })
        //                 }
        //             })
        //             // $('#calendar-modal').modal('show')
        //             // $('#event_start').val(info.dateStr)
        //             // $('#event_end').val(info.dateStr)
        //         },

        //         // select: function(info) {
        //         //     alert('selected ' + info.startStr + ' to ' + info.endStr);
        //         // },

        //         initialView: 'dayGridMonth'
        //     });
        //     calendar.render();
        // });

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>