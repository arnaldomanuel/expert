<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                'email_verified_at' => now(),
            ]);
           
            $newUser->course_online = 'Password'; 
            $newUser->save();

            return response()->json( $newUser );
        }
    }
}
