<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MobileController extends Controller
{
    public function login(Request $request){
     
        
        $user = User::where('mobile_app_code', $request->password)
            ->where('email', $request->email)
            ->first();

        if($user){
            if($user->email==$request->email){
                return response()->json( $user );
            }
        } else {
            return response()->json(array('message'=>'Autenticação falhou'), 419);
        }
    }
}
