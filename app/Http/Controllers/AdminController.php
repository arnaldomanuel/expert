<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function options(){
        $data=array(
            'user' => auth()->user(),
        );
        return view('admin.options')->with($data);
    }
    
    public function saveOptions(Request $request){
       

        
        $user = auth()->user();
        $user->mpesa_name= $request->mpesa_name;
        $user->whatsapp_number = $request->whatsapp_number;
        $user->mpesa_number = $request->mpesa_number;
        $user->save();
       return redirect('/admin/options');
    }
}
