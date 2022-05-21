<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResponseMail;

class RegistrationController extends Controller
{
    public function add(Request $request){

        $event = Event::where('id', $request->eventId)->first();

        $this->validate($request, [
            'eventId' => 'required',
            'headcount' => "required|numeric|min:1|max:$event->free_seats|max:5",
        ]);

        return Registration::create([
            'user_id' =>  Auth::user()->id,
            'event_id' => $request->eventId,	
            'headcount' => $request->headcount,	
        ]);
    }
}
