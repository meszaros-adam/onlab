<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EventController extends Controller
{

    public function add(Request $request){
        
        $this->validate($request,[
            'userId' => 'required',
            'dateTime' => 'required',
            'name' => 'required',
            'description' => 'required',
            'headcount' => 'required|integer',
            'location' => 'required',
        ]);

        return Event::create([
            'user_id' => $request->userId,
            'date' =>  $request->dateTime,
            'name' => $request->name,
            'description' => $request->description,
            'headcount' => $request->headcount,
            'location' => $request->location,
            'google_maps_iframe' => $request->googleMaps,
        ]);
    }
    public function get(Request $request){
        return Event::orderBy('id', 'desc')->paginate($request->itemPerPage);
    }
}
