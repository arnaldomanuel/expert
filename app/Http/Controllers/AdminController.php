<?php

namespace App\Http\Controllers;

use App\Services\Course\CourseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;


class AdminController extends Controller
{
    public  $messages = [
        'required' => 'O campo :attribute  é obrigatório',
       
    ];
 public   $rules = [
        'profilepic' => 'nullable|file|image|max:450|dimensions:ratio=1',
    ];
   public $attributes = [
       
        'profilepic' => 'Foto de perfil',
    ];

    public function options(){
        $data=array(
            'user' => auth()->user(),
        );
        return view('admin.options')->with($data);
    }
    
    public function saveOptions(Request $request){

        $validator = Validator::make($request->all(), $this->rules, $this->messages, $this->attributes);
       
        if ($validator->fails()) {
          
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = auth()->user();
        $service = new CourseService();
        if ($request->hasFile('profilepic')) {
           if ($user->profilepic) {
                $deletePath = Str::replaceFirst('storage', 'public', $user->profilepic);
                Storage::disk('local')->delete($deletePath);
            
           }
           $user->profilepic = $service->saveCourseThumbnail($request->file('profilepic'));
        }
        $user->mpesa_name= $request->mpesa_name;
        $user->whatsapp_number = $request->whatsapp_number;
        $user->mpesa_number = $request->mpesa_number;
        $user->biography=$request->biography;
        $user->save();
        $request->session()->flash('activity', 'Sucesso! Actualizou a informação com sucesso');
        return redirect('/admin/options');
    }
}
