<?php

namespace App\Http\Controllers;
use App\Models\User;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Socialite;
use App\Services\SocialFacebookAccountService;


class SocialAuthFacebookController extends Controller
{
    /**
   * Create a redirect method to facebook api.
   *
   * @return void
   */
  public function redirect()
  {
      return Socialite::driver('facebook')->redirect();
  }
  /**
   * Return a callback method from facebook api.
   *
   * @return callback URL from facebook
   */
  public function callback()
  {
    $user = Socialite::driver('facebook')->stateless()->user();
        
    $finduser = User::where('facebook_id', $user->id)->first();
    if (!$finduser) {
        $finduser = User::where('email', $user->getEmail())->first();
    }

    if($finduser){
        Auth::login($finduser);
        Auth::logoutOtherDevices(auth()->user()->course_online);
        Auth::login($finduser);
        return redirect('/dashboard');

    }else{
        $course_online = Str::random(10);
        $newUser = User::create([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'facebook_id'=> $user->id,
            'password' => $course_online,
            'email_verified_at' => now(),
        ]);
        $newUser->course_online = $course_online; 
        $newUser->save(); 

        Auth::login($newUser);
       
        return redirect('/dashboard');
    }

    
     
  }
}
