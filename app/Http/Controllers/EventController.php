<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{

    public function add(Request $request){
        
        $this->validate($request,[
            'dateTime' => 'required',
            'name' => 'required',
            'description' => 'required',
            'headcount' => 'required|integer|min:1',
            'location' => 'required',
        ]);

        return Event::create([
            'user_id' => Auth::user()->id,
            'date' =>  $request->dateTime,
            'name' => $request->name,
            'description' => $request->description,
            'headcount' => $request->headcount,
            'location' => $request->location,
            'google_maps_iframe' => $request->googleMaps,
        ]);
    }
    public function getAll(Request $request){
        return Event::orderBy($request->orderBy, 'desc')->paginate($request->itemPerPage);
    }
    public function getActual(Request $request){
        return Event::where('date' ,'>', Carbon::now() )->orderBy($request->orderBy, 'desc')->paginate($request->itemPerPage);
    }
    public function getEarlier(Request $request){
        return Event::where('date' ,'<', Carbon::now() )->orderBy($request->orderBy, 'desc')->paginate($request->itemPerPage);
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
            'date' => 'required',
            'name' => 'required',
            'description' => 'required',
            'headcount' => 'required|integer|min:1',
            'location' => 'required',
        ]);

        return Event::where('id',$request->id)->update([
            'user_id' =>  Auth::user()->id,
            'date' => $request->date,
            'name' => $request->name,
            'description' => $request->description,
            'headcount' => $request->headcount,
            'location' => $request->location,
            'google_maps_iframe' => $request->google_maps_iframe,
        ]);
    }
}
