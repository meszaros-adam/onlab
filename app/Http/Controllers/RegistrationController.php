<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\Registration;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResponseMail;

class RegistrationController extends Controller
{
    public function add(Request $request){

        $event = Event::where('id', $request->eventId)->first();

        $this->validate($request, [
            'userId' => 'required',
            'eventId' => 'required',
            'headcount' => "required|numeric|min:1|max:$event->free_seats|max:5",
        ]);

        return Registration::create([
            'user_id' => $request->userId,	
            'event_id' => $request->eventId,	
            'headcount' => $request->headcount,	
        ]);
    }
}
