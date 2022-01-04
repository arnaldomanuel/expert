<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class MobileController extends Controller
{
    public function login(Request $request){
     
        
        $user = User::where('email', $request->email)
            ->first();

        if($user){
           
            return response()->json( $user );
            
        } else {
            $newUser = User::create([
                'name' => $request->email,
                'email' => $request->email,
                'google_id'=> 100,
                'password' => 'password',
                'api_token' => Str::random(60),
                'email_verified_at' => now(),
            ]);
           
            $newUser->course_online = 'Password'; 
            $newUser->save();

            return response()->json( $newUser );
        }
    }
}
