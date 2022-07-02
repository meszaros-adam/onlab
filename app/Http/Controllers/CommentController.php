<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Symfony\Component\String\b;

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
    public function getAll(Request $request){
        return Comment::orderBy($request->orderBy, 'desc')->with('user', 'event')->paginate($request->itemPerPage);
    }
    public function getByUser(Request $request) {
        return Comment::where('user_id', Auth::user()->id)->orderBy($request->orderBy, 'desc')->with('user', 'event')->paginate($request->itemPerPage);
    }
    public function edit(Request $request){
        $this->validate($request,[
            "id" => "required",
            "comment" =>"required",
        ]);

       if( $this->checkPermission($request->id)){
    
        return Comment::where('id',$request->id)->update([
            'comment' => $request->comment
        ]);
       }else{
        return response('Nem jogosult a művelethez', 101);
       }

    }
    //checking edit and delete permission
    public function checkPermission($commentId){
        $commentUserId = Comment::where('id',$commentId)->first()->user_id;

        return Auth::user()->isAdmin || Auth::user()->id == $commentUserId ? true : false;
    }
    public function delete(Request $request){
        $this->validate($request,[
            "id" => "required",
        ]);

        if($this->checkPermission($request->id)){
            return  Comment::where('id',$request->id)->delete();
        }else{
            return response('Nem jogosult a művelethez', 101);
        }

    }
}
