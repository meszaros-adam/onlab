<?php

namespace App\Http\Controllers;
    use Illuminate\Http\Request;    
    use App\Models\User;
    use Validator;
    use Socialite;
    use Auth;


class SocialController extends Controller
 {

  public function redirect($provider)
  {
      return Socialite::driver($provider)->redirect(); 
  }

  public function callback($provider){
    $userSocial =   Socialite::driver($provider)->stateless()->user();
    $users       =   User::where(['email' => $userSocial->getEmail()])->first();
    if($users){
        Auth::login($users);
        return redirect('/');
    }else{
        $user = User::create([
            'name'          => $userSocial->getName(),
            'email'         => $userSocial->getEmail(),
            'provider_id'   => $userSocial->getId(),
            'provider'      => $provider,
            'password'      => bcrypt('1234567'),
        ]);
     return redirect()->route('/');
    }
}
}