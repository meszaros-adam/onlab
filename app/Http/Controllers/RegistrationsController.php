<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\Registration;
use Auth;

class RegistrationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('registrations.index', ['registrations' => Registration::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Event $event)
    {
        return view('registrations.create', compact('event'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Event $event) 
    {

        $user = Auth::user();
        
        request()->validate([
            'adult_headcount' => 'required|integer|between:0,10',
            'child_headcount' => 'required|integer|between:0,10',
        ]);
 
         if(request('adult_headcount')+request('child_headcount')==0){
             return 'Nulla fővel nem lehet regisztrálni';
         }
 
         if(request('adult_headcount')+request('child_headcount')>$event->free_places()){
             return 'Sajnos nincs ennyi szabad hely, kérem próbáljon meg kevesebb fővel regisztrálni!';
         }
         if($event->check_registration($user)==true){
             return 'Csak egyszer regisztrálhat egy eseményre';
         }
        
        $registration = new Registration();
        $registration->user_id=$user->id;
        $registration->event_id=$event->id;
        $registration->adult_headcount=request('adult_headcount');
        $registration->child_headcount=request('child_headcount');

        $registration->save();

        $response= 'Sikeresen mentve!';
        return view('response', compact('response'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Registration $registration)
    {
        return view('registrations.show', compact('registration'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Registration $registration)
    {
        return view('registrations.edit', compact('registration'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Registration $registration)
    {
        request()->validate([
            'adult_headcount' => 'required|integer|between:0,10',
            'child_headcount' => 'required|integer|between:0,10',
        ]);
 
         if(request('adult_headcount')+request('child_headcount')==0){
             return 'Nulla fővel nem lehet regisztrálni';
         }
 
         if(request('adult_headcount')+request('child_headcount')>$registration->event->free_places()){
             return 'Sajnos nincs ennyi szabad hely, kérem próbáljon meg kevesebb fővel regisztrálni!';
         }

        $registration->adult_headcount=request('adult_headcount');
        $registration->child_headcount=request('child_headcount');
        
        $registration->save();

        $response= 'Sikeresen módosítva!';
        return view('response', compact('response'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Registration $registration)
    {
        $registration->delete();
        
        $response= 'Sikeresen törölve!';
        return view('response', compact('response'));
    }
}
