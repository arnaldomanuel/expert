<?php

namespace App\Services\Course;

use App\Models\Course;
use App\Models\Objective;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class CourseService {
  public  $messages = [
        'required' => 'O campo :attribute  é obrigatório',
        'max' => 'Este campo excede :max caractéres',       
        'pdf.pdf' => 'O PDF deve ter a extensão pdf',
        'thumbnail.max' => 'A imagem não pode ter mais de 350 Kilobytes',
        'thumbnail.image' => 'A imagem deve ter a extensão jpeg, jpg, png',
    ];
 public   $rules = [
        'name' => 'required|max:240',
        'price' => 'required',
        'thumbnail' => 'required|file|image|max:350',
        'description' => 'required',
    ];
   public $attributes = [
        'name' => 'nome',
        'description' => 'descrição',
    ];


    public function saveCourse(Request $request){
      
        $validator = Validator::make($request->all(), $this->rules, $this->messages, $this->attributes);
       
        if ($validator->fails()) {
          
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $course = new Course();
        if($request->hasfile('thumbnail')){
            $course->thumbnail = $this->saveCourseThumbnail($request->file('thumbnail'));
        }
        $course->name = $request->name;
         $course->price = $request->price;
         $course->start_lesson= $request->start_lesson;
        $course->description = $request->description;
        $course->ondemand = $request->ondemand;
        $course->slug = Str::slug($request->name);
        $course->user_id = auth()->user()->id;


        $getInLoop = true;
        $aux = 0;
        
      
        while($getInLoop && $aux < 3){
         
            $aux++;
            try {
                $course->save();
                $getInLoop = false;
            } catch (\Illuminate\Database\QueryException $ex) {
               
                if (Str::contains($ex->getMessage(), 'courses_slug_unique')) {
                    $course->slug .= '-'. Str::random(3);
                } else {
                    $validator->errors()->add('error.logic', 'Um erro ocorreu ao gravar o curso. Contacte a equipe técnicca');
           
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
            
                    }
            }
        }
       if ($aux>=3) {

        dd('a ', $course->slug, $aux);
        $validator->errors()->add('error.logic', 'Um erro ocorreu ao gravar o curso, Existe um curso com nome parecido. Tente um novo nome');
            if ($aux>=3) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
       }
        $a =1;
        while ($request->input('objective'.$a)) {
            # code...
            $objective = new Objective();
            $objective->description = $request->input('objective'.$a);
            $objective->course_id = $course->id;
            $objective->save();
            $a++;
        }

        return "OK";
    }

    public function updateCourse(Request $request, $id){
        $rules = [
            'name' => 'required|max:240',
            'price' => 'required',
            'thumbnail' => 'nullable|image|max:350',
            'description' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules, $this->messages, $this->attributes);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $course =  Course::findOrFail($id);

        if (auth()->user()->cannot('update', $course)) {
            abort(403);
        }

        if($request->hasfile('thumbnail')){
            $deletePath = Str::replaceFirst('storage', 'public', $course->thumbnail);
            Storage::disk('local')->delete($deletePath);
            $course->thumbnail = $this->saveCourseThumbnail($request->file('thumbnail'));
        }
        $course->name = $request->name;
        $course->price = $request->price;
        $course->ondemand = $request->ondemand;
        $course->description = $request->description;
        $course->save(); 
        return "OK";
    }

    public function saveCourseThumbnail($file){
        $filename = Str::random(4) . time() . '.' . $file->getClientOriginalExtension();
        $path = 'public/thumbnail/' . $filename;
        Storage::disk('local')->put($path, file_get_contents($file));
        return 'storage/thumbnail/' . $filename;   
    }
}