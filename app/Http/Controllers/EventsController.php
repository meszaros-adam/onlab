<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events=Event::all();

        $active_events=array();

        $earlier_events=array();

        foreach($events as $event){
            if($event->isActive()==true){
                array_push($active_events, $event);
            }
            else{
                array_push($earlier_events, $event);
            }
        }      

        return view('events.index', compact('active_events', 'earlier_events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'date' => 'required',
            'description' => 'required',
            'headcount' => 'required|integer|min:1',
            'location' => 'required',
        ]);

        $event = new Event();

        $event->name = request('name');
        $event->date = request('date');
        $event->description = request('description');
        $event->headcount = request('headcount');
        $event->location = request('location');
        $event->google_maps = request('google_maps');

        $event->save();

        $response = 'Sikeresen mentve!';
        return view('response', compact('response'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event){
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        request()->validate([
            'name' => 'required',
            'date' => 'required',
            'description' => 'required',
            'headcount' => 'required|integer|min:1',
            'location' => 'required',
        ]);

        if(request('headcount')<$event->reserved_total()){
            return('A létszám nem lehet kisebb mint a már lefoglalt helyek száma!');
        }
        
        $event->name=request('name');
        $event->date=request('date');
        $event->description=request('description');
        $event->headcount=request('headcount');
        $event->location=request('location');
        $event->google_maps=request('google_maps');
        $event->save();

        $response= 'Sikeresen frissítve!';
        return view('response', compact('response'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $registrations=$event->registrations;

        foreach ($registrations as $registration)
        {
        $registration->delete();
        }       
        
        $event->delete();
        
        $response= 'Sikeresen törölve!';
        return view('response', compact('response'));
    }
}
