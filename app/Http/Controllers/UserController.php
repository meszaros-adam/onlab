<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function registration(Request $request){
        $this->validate($request,[
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        

        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
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
        return User::orderBy($request->orderBy, 'desc')->paginate($request->itemPerPage);
    }
    public function editByAdmin(Request $request){
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
    public function editByUser(Request $request){
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(!Hash::check( $request->password, Auth::user()->password)){
            return response('A jelszó nem egyezik!', 401);
        }

        return User::where('id' , Auth::user()->id)->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);      
    }
    public function delete(Request $request){
        $this->validate($request,[
            'id' => 'required',
        ]);

        return User::where('id', $request->id)->delete();
    }
    public function changePassword(Request $request){
        $this->validate($request,[
            'newPassword' => 'required|confirmed|min:6',
            'currentPassword'=> 'required',
        ]);

        if(!Hash::check($request->currentPassword, Auth::user()->password)){
            return response('A jelszó nem egyezik!', 401);
        }

        return User::where('id' , Auth::user()->id)->update([
            'password' =>  bcrypt($request->newPassword),
        ]);      
    }
    public function deleteByUser(Request $request){
        $this->validate($request,[
            'id' => 'required',
            'password'=> 'required',
        ]);

        if(!Hash::check($request->password, Auth::user()->password)){
            return response('A jelszó nem egyezik!', 401);
        }

        return User::where('id', $request->id)->delete();
    }
}
