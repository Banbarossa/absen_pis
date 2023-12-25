<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class CalendarController extends Controller
{

    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = Event::whereDate('start', '>=', $request->start)
                ->whereDate('end', '<=', $request->end)
                ->get(['id', 'title', 'start', 'end']);

            return response()->json($data);
        }

        return view('admin.kelola-calender');
    }
    // public function index(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $data = Event::whereDate('event_start', '>=', $request->start)
    //             ->whereDate('event_end', '<=', $request->end)
    //             ->get(['id', 'event_name', 'event_start', 'event_end']);
    //         return response()->json($data);
    //     }

    //     $now = Carbon::now();
    //     // $events = Event::all();
    //     $events = Event::where('event_start', '>=', $now->startOfYear()->toDateString())
    //         ->where('event_start', '<=', $now->endOfYear()->toDateString())
    //         ->get();

    //     return view('admin.kelola-calender', ['events' => $events]);
    //     // return view('calender', ['events' => $events]);
    // }

    // public function calendarEvents(Request $request)
    // {

    //     // dd($request->event_start);

    //     switch ($request->type) {
    //         case 'create':
    //             $event = Event::create([
    //                 'event_name' => $request->event_name,
    //                 'event_start' => $request->event_start,
    //                 'event_end' => $request->event_end,
    //             ]);

    //             return response()->json($event);
    //             break;

    //         case 'edit':
    //             $event = Event::find($request->id)->update([
    //                 'event_name' => $request->event_name,
    //                 'event_start' => $request->event_start,
    //                 'event_end' => $request->event_end,
    //             ]);

    //             return response()->json($event);
    //             break;

    //         case 'delete':
    //             $event = Event::find($request->id)->delete();

    //             return response()->json($event);
    //             break;

    //         default:
    //             # ...
    //             break;
    //     }
    // }
    public function calendarEvents(Request $request)
    {

        switch ($request->type) {
            case 'add':
                $event = Event::create([
                    'event_name' => $request->title,
                    'event_start' => $request->start,
                    'event_end' => $request->end,
                ]);

                return response()->json($event);
                break;

            case 'update':
                $event = Event::find($request->id)->update([
                    'event_name' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                ]);

                return response()->json($event);
                break;

            case 'delete':
                $event = Event::find($request->id)->delete();

                return response()->json($event);
                break;

            default:
                # code...
                break;
        }
    }
}
