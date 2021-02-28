<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Event;


class EventController extends Controller
{
    public function listing(){
        $events=Event::all();
        return $events;
    }
}
