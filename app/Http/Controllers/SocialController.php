<?php

namespace App\Http\Controllers;
    use Illuminate\Http\Request;    
    use App\Models\User;
    use Validator;
    use Socialite;
    use Auth;


class SocialController extends Controller
 {

  public function facebookRedirect()
  {
      return Socialite::driver('facebook')->redirect(); 
  }

  public function loginWithFacebook(){
    $user = Socialite::driver('facebook')->stateless()->user();
    $finduser = User::where('facebook_id', $user->id)->first();

            if($finduser){
                Auth::login($finduser);
                return redirect('/');
            }
            else{
                $finduser_by_email = User::where('email', $user->email)->first();
                if($finduser_by_email){
                    $finduser_by_email->facebook_id = $user->id;
                    Auth::login($finduser_by_email);
                    return redirect('/');
                }else{
                    $newUser = new User();
                    $newUser->name = $user->name;
                    $newUser->email = $user->email;
                    $newUser->facebook_id = $user->id;
                    $newUser->password = bcrypt('12345678');
                    $newUser->save();
                    Auth::login($newUser);
                    return redirect('/');
                }
            }
    }
} 