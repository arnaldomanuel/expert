<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
       
    
            $user = Socialite::driver('google')->stateless()->user();
        
            $finduser = User::where('google_id', $user->id)->first();

            if (!$finduser) {
                $finduser = User::where('email', $user->email)->first();
            }
     
            if($finduser){
                Auth::login($finduser);
                Auth::logoutOtherDevices(auth()->user()->course_online);
                Auth::login($finduser);
                return redirect('/cursos');
            }else{
                $course_online = Str::random(10);
                
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'password' => $course_online,
                    'email_verified_at' => now(),
                ]);
               
                $newUser->course_online = $course_online; 
                $newUser->save();

                Auth::login($newUser);
                dd($newUser);
                return redirect('/cursos');
            }
    }

    public function social(){

        return view('auth.social');
    }
}
