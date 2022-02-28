<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Module;
use App\Services\Lesson\LessonService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            'lessons' => Lesson::all(),
        );
        return view('lesson.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $module_id = app('request')->input('module_id');
        $module = Module::find($module_id);
        if (!$module || $module->course->user_id != auth()->user()->id) {
            $v = Validator::make([], []);
            $v->errors()->add('module', 'Seleccione um módulo válido');
            return redirect()->back()
                ->withErrors($v)
                ->withInput();;
        }
        $data = array(
            'modules' => Module::join('courses', 'modules.course_id' ,'=', 'courses.id')->select('modules.*')
            ->where('courses.user_id', auth()->user()->id)->get(),
        );
        return view('lesson.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'required' => 'O campo :attribute  é obrigatório',
            'max' => 'Este campo excede :max caractéres',

            'file' => 'Falhou o upload do PDF',
            'audio' => 'O áudio deve ser um mp3 com menos de 1,5MB',
            'audio.max'=> 'O áudio deve ser um mp3 com menos de 3MBMB',
            'pdf.max' => 'O PDF não pode ter mais de 4MB',
            'pdf.mimetypes' => 'O documento deve ter a extensão pdf',
            'gte' => 'O campo :attribute deve ser maior ou igual a :value',
        ];
        $rules = [
            'pdf' => 'required|file|mimetypes:application/pdf|max:4000',
            'audio' => 'file|mimetypes:audio/mpeg|max:3000',
            'name' => 'required|max:255',
            'video_link' => 'required|url|max:255',
            'module_id' => 'required',
            'description' => 'required',
            'order' => 'required|gte:0',
        ];
        $attributes = [
            'name' => 'nome',
            'description' => 'descrição',
            'video_link' => 'Link do vídeo',
            'pdf' => 'documento',
            'order' => 'Número de Ordem'
        ];


        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if (!Str::contains($request->video_link, 'https://www.youtube.com/watch?v=')) {
            $validator->errors()->add('error.video_link', 'O link do vídeo precisa ser do Youtube');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $lesson = new Lesson();

        if ($request->hasfile('pdf')) {
            $file = $request->file('pdf');
            $filename = Str::random(4) . time() . '.' . $file->getClientOriginalExtension();
            $path = 'public/pdf/' . $filename;
            Storage::disk('local')->put($path, file_get_contents($file));
            $lesson->pdf_link = 'storage/pdf/' . $filename;
        }
        if ($request->hasfile('audio')) {
            $lesson->has_video=0;
            $file = $request->file('audio');
            $filename = Str::random(4) . time() . '.' . $file->getClientOriginalExtension();
            $path = 'public/audio/' . $filename;
            Storage::disk('local')->put($path, file_get_contents($file));
            $lesson->audio_path = 'storage/audio/' . $filename;
        }
        $lesson->name = $request->name;
        $lesson->order = $request->order;
        $lesson->audio_transcript = $request->audio_transcript;
        $lesson->module_id = $request->module_id;
        $lesson->video_link = Str::replaceFirst('https://www.youtube.com/watch?v=', 'https://www.youtube.com/embed/', $request->video_link);
        $lesson->description = $request->description;
        
        try {
            $lesson->save();
        } catch (\Illuminate\Database\QueryException $ex) {
            if (Str::contains($ex->getMessage(), 'lessons_module_id_order_unique')) {
                $validator->errors()->add('error.order_id', 'Já existe uma aula neste módulo com esse Número de Ordem');
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }
        $request->session()->flash('activity', 'Aula:  ' . $lesson->name . ' criada');
        return redirect('/admin/module/' . $lesson->module_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lesson = Lesson::findOrFail($id);
        if (auth()->user()->cannot('hasOwnership', $lesson)) {
            abort(403);
        }
        $data = array(
            'lesson' => $lesson,
        );
        return view('lesson.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lesson = Lesson::findOrFail($id);
        $module_id = $lesson->module_id;
        if (auth()->user()->cannot('hasOwnership', $lesson)) {
            abort(403);
        }
        $module = Module::find($module_id);
        if (!$module || $module->course->user_id != auth()->user()->id) {
            $v = Validator::make([], []);
            $v->errors()->add('module', 'Seleccione um módulo válido');
            return redirect()->back()
                ->withErrors($v)
                ->withInput();;
        }
        $data = array(
            'lesson' => $lesson,
            'modules' => Module::all(),
        );
        return view('lesson.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $lessonService = new LessonService();
        $validator = Validator::make(
            $request->all(),
            $lessonService->rules,
            $lessonService->messages,
            $lessonService->attributes
        );

        if ($validator->fails()) {

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $lessonService->updateLesson($request, $id);
        return redirect('/admin/lesson/' . $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lesson = Lesson::findOrFail($id);
        if (auth()->user()->cannot('hasOwnership', $lesson)) {
            abort(403);
        }
        Lesson::destroy($id);
        session()->flash('activity', 'Aula apagada');
        return redirect('/admin/lesson');
    }
}
