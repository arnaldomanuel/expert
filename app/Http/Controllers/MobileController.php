<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MobileController extends Controller
{
    public function login(Request $request){
        $user = User::where('email', $request->email)->first();
        Auth::login($user);
        return response()->json(auth()->user());
        $user = User::where('mobile_app_code', $request->code)->first();

        if($user){
            if($user->email==$request->email){
                Auth::login($user);
                return response()->json('OK');
            }
        } else {
            return response('')->json(array('message'=>'Autenticação falhou'), 419);
        }
    }
}
