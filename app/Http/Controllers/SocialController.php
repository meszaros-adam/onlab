<?php

namespace App\Http\Controllers;
    use Illuminate\Http\Request;    
    use App\Models\User;
    use Validator;
    use Laravel\Socialite\Facades\Socialite;
    use Illuminate\Support\Facades\Auth;


class SocialController extends Controller
 {

  public function redirect($provider)
  {
      return Socialite::driver($provider)->redirect(); 
  }

  public function callback($provider){
    $userSocial =   Socialite::driver($provider)->user();
    $find_user       =   User::where(['email' => $userSocial->getEmail()])->first();
    if($find_user){
        Auth::login($find_user);
        return redirect('/');
    }else{
        $user = User::create([
            'name'          => $userSocial->getName(),
            'email'         => $userSocial->getEmail(),
            'provider_id'   => $userSocial->getId(),
            'provider'      => $provider,
            'password'      => bcrypt('1234567'),
        ]);
        Auth::login($user);
     return redirect('/');
    }
}
}