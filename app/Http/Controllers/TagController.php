<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    public function get(Request $request){

        //if $request has itemPerPage property, it return with paginate, else it return without paginate
        return $request->itemPerPage ? Tag::orderBy($request->orderBy, $request->ordering)->paginate($request->itemPerPage) : Tag::orderBy('id','desc')->get();

    }
    public function add(Request $request){
        $this->validate($request,[
            'name' => 'required',
        ]);

        return Tag::create([
            'name' => $request->name,
        ]);
    }
    public function delete(Request $request){
        $this->validate($request,[
            'id' => 'required',
        ]);

        return Tag::where('id', $request->id)->delete();
    }
    public function edit(Request $request){
        $this->validate($request,[
            'name' => 'required',
        ]);

        return Tag::where(['id' => $request->id,])->update([
            'name' => $request->name,
        ]);
    }
}
