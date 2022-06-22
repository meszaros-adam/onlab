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
            'eventId' => 'required',
        ]);

        return Comment::create([
            'comment' => $request->comment,
            'user_id' => Auth::user()->id,
            'event_id'  => $request->eventId,
            'parent_comment_id' =>$request->parent_comment_id,
            ]);
    }
}
