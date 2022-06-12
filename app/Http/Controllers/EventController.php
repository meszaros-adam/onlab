<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventTag;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{

    public function add(Request $request){
        
        $this->validate($request,[
            'date' => 'required',
            'name' => 'required',
            'description' => 'required',
            'headcount' => 'required|integer|min:1',
            'location' => 'required',
        ]);

        DB::beginTransaction();

        try{

            $event = Event::create([
                'user_id' => Auth::user()->id,
                'date' =>  $request->date,
                'name' => $request->name,
                'description' => $request->description,
                'headcount' => $request->headcount,
                'location' => $request->location,
                'google_maps_iframe' => $request->googleMaps,
            ]);

            $event_tags = [];

            foreach($request->tags as $t){
                array_push($event_tags,[
                    'event_id' => $event->id,
                    'tag_id' => $t['id'],
                ]);
            }
            EventTag::insert($event_tags);

            DB::commit();
            return response ($event, 201);

        }catch(\Throwable $th){
            DB::rollback();
            return response ($th, 500);
        }

        
    }
    public function getAll(Request $request){
        return Event::orderBy($request->orderBy, 'desc')->with('tags')->paginate($request->itemPerPage);
    }
    public function getActual(Request $request){

        if($request->tagFilter){
            $tag = $request->tagFilter;
            return Event::where('date' ,'>', Carbon::now())->whereHas('tags', function($q) use($tag){
                $q->where('name', $tag);
            })->orderBy($request->orderBy, 'desc')->with('tags')->paginate($request->itemPerPage);
        }

        return Event::where('date' ,'>', Carbon::now())->orderBy($request->orderBy, 'desc')->with('tags')->paginate($request->itemPerPage);
    }
    public function getEarlier(Request $request){

        if($request->tagFilter){
            $tag = $request->tagFilter;
            return Event::where('date' ,'<', Carbon::now())->whereHas('tags', function($q) use($tag){
                $q->where('name', $tag);
            })->orderBy($request->orderBy, 'desc')->with('tags')->paginate($request->itemPerPage);
        }

        return Event::where('date' ,'<', Carbon::now())->orderBy($request->orderBy, 'desc')->with('tags')->paginate($request->itemPerPage);
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

        try{
            DB::beginTransaction();

           Event::where('id',$request->id)->update([
                'user_id' =>  Auth::user()->id,
                'date' => $request->date,
                'name' => $request->name,
                'description' => $request->description,
                'headcount' => $request->headcount,
                'location' => $request->location,
                'google_maps_iframe' => $request->google_maps_iframe,
            ]);

            //delete previous tags
            EventTag::where('event_id', $request->id)->delete();

            $event_tags = [];

            foreach($request->tags as $t){
                array_push($event_tags, [
                    'event_id' => $request->id,
                    'tag_id' => $t['id'],
                    ]);
            }

            EventTag::insert($event_tags);

            DB::commit();

            return response('Esemény sikeresen szerkesztve!', 200);

        }catch(\Throwable $th){
            DB::rollBack();
            return response($th, 500);
        } 
       
    }
}
