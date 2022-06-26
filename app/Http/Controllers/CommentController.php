<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function add(Request $request){
        $this->validate($request,[
            'comment' => 'required',
            'event_id' => 'required',
        ]);

        return Comment::create([
            'comment' => $request->comment,
            'user_id' => Auth::user()->id,
            'event_id'  => $request->event_id,
            'parent_comment_id' =>$request->parent_comment_id,
            ]);
    }
    public function getByEvent(Request $request){
        return Comment::where('event_id', $request->event_id)->with('user', 'children')->get();
    }
}
