<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function registration(Request $request){
        $this->validate($request,[
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $password = bcrypt($request->password);

        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password,
        ]);
    }
    public function login(Request $request){
        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)){
            return response('Sikeres bejelentkezés!', 200);
        }else{
            return response('Bejelentkezés sikertelen!', 422);
        }
    }
    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
    public function get(Request $request){
        return User::orderBy('id', 'desc')->paginate($request->itemPerPage);
    }
    public function edit(Request $request){
        $this->validate($request,[
            'id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'is_admin' => 'required|boolean',
        ]);

        return User::where('id' , $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'admin' => $request->is_admin,
        ]);      
    }
    public function delete(Request $request){
        $this->validate($request,[
            'id' => 'required',
        ]);

        return User::where('id', $request->id)->delete();
    }
}
