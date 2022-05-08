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
            'headcount' => 'required|integer|min:1',
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
    public function getByDate(Request $request){
        return Event::orderBy('date', 'desc')->paginate($request->itemPerPage);
    }
    public function delete(Request $request){

        $this->validate($request,[
            'id' => 'required',
        ]);

        return Event::where('id', $request->id)->delete();
    }
    public function edit(Request $request){
        
        $this->validate($request, [
            'id' => 'required',
            'userId' => 'required',
            'date' => 'required',
            'name' => 'required',
            'description' => 'required',
            'headcount' => 'required|integer|min:1',
            'location' => 'required',
        ]);

        return Event::where('id',$request->id)->update([
            'user_id' => $request->userId,
            'date' => $request->date,
            'name' => $request->name,
            'description' => $request->description,
            'headcount' => $request->headcount,
            'location' => $request->location,
            'google_maps_iframe' => $request->google_maps_iframe,
        ]);
    }
}
