<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function get(Request $request){
       return Tag::orderBy($request->orderBy,'desc')->paginate($request->itemPerPage);
    }
    public function add(Request $request){
        $this->validate($request,[
            'name' => 'required',
        ]);

        return Tag::create([
            'name' => $request->name,
        ]);
    }
}
