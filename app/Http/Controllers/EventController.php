<?php

namespace App\Http\Controllers;

use App\Models\Event;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('calender');
    }

    public function eventList(Request $request)
    {
        // $start = Carbon::parse($request->start)->toDateString();
        // $end = Carbon::parse($request->end)->toDateString();
        $events = Event::all()
            ->map(fn($item) => [
                'id' => $item->id,
                'title' => $item->event_name,
                'start' => $item->event_start,
                'end' => $item->event_end,
            ]);
        return response()->json($events);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Event $event)
    {
        return view('event-form', [
            'data' => $event,
            'action' => route('coba.store'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataTerima = $request->all();
        return response()->json($dataTerima);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
