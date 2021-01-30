<?php

namespace App\Services\Lesson;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class LessonService {
public  $messages = [
        'required' => 'O campo :attribute  é obrigatório',
        'max' => 'Este campo excede :max caractéres',
        'file' => 'Falhou o upload do PDF',
        'pdf.max' => 'O PDF não pode ter mais de 4MB',
        'pdf.mimetypes' => 'O documento deve ter a extensão pdf',
        'thumbnail.max' => 'A imagem não pode ter mais de 350 Kilobytes',
        'thumbnail.image' => 'A imagem deve ter a extensão jpeg, jpg, png',
        'gte' => 'O campo :attribute deve ser maior ou igual a :value',
    ];
 public    $rules = [
    'pdf' => 'nullable|file|mimetypes:application/pdf|max:4000',
    'name' => 'required|max:255',
    'video_link' => 'required|url|max:255',
    'module_id' => 'required',
    'description' => 'required',
    'order' => 'required|gte:0'
];
   public $attributes = [
        'name' => 'nome',
        'description' => 'descrição',
    'order' => 'Número de ordem'
    ];

    public function updateLesson(Request $request, $id){
        
        
       
        $lesson = Lesson::findOrFail($id);
        if (auth()->user()->cannot('hasOwnership', $lesson)) {
            abort(403);
        }
        
        if($request->hasfile('pdf')){
            $file = $request->file('pdf');
            $deletePath = Str::replaceFirst('storage', 'public', $lesson->pdf_link);
            Storage::disk('local')->delete($deletePath);
            $lesson->pdf_link = $this->saveLessonPDF($file);
            
        }
        $lesson->name = $request->name;
        $lesson->module_id = $request->module_id;
        $lesson->video_link = $request->video_link;
        $lesson->order = $request->order;
        $lesson->description = $request->description;
        $lesson->save();
        $request->session()->flash('activity', 'Aula:  ' . $lesson->name . ' actualizada');

        return "ok";
        
    }

    public function saveLessonPDF($file){
        $filename = Str::random(4) . time() . '.' . $file->getClientOriginalExtension();
        $path = 'public/pdf/' . $filename;
        Storage::disk('local')->put($path, file_get_contents($file));
        return 'storage/pdf/' . $filename;   
    }
    

}