<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use App\Models\Quizz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            'modules' =>Module::join('courses', 'modules.course_id', '=', 'courses.id')
            ->select('modules.*')
            ->where([
                ['courses.user_id', auth()->user()->id],
            ])->paginate(40),
        );
        return view('modules.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array(
            'courses' => Course::where('user_id', auth()->user()->id)->get(),
        );
        return view('modules.create')->with($data);
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
            'unique' => 'Já existe uma categoria com este nome',
            'file' => 'Falhou o upload da imagem',
            'photo_path.max' => 'A imagem não pode ter mais de 350 Kilobytes',
            'photo_path.image' => 'A imagem deve ter a extensão jpeg, jpg, png',
        ];
        $rules = [
            'photo_path' => 'required|file|image|max:700',
            'name' => 'required|unique:modules|max:255',
            'description' => 'required',
        ];
        $attributes = [
            'name' => 'nome',
            'description' => 'descrição',
            'photo_path' => 'imagem',
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $module = new Module();

        if ($request->hasfile('photo_path')) {
            $file = $request->file('photo_path');
            $filename = Str::random(4) . time() . '.' . $file->getClientOriginalExtension();
            $path = 'public/img/' . $filename;
            Storage::disk('local')->put($path, file_get_contents($file));
            $module->photo_path = 'storage/img/' . $filename;
        }
        $module->course_id = $request->course_id;
        $module->name = $request->name;
        $module->description = $request->description;
        $module->save();
        $request->session()->flash('activity', 'Módulo:  ' . $module->name . ' criado');
        return redirect('/admin/module');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $module=Module::findOrFail($id);
        if (auth()->user()->cannot('hasOwnership', $module)) {
            abort(403);
        }
        $data = array(
            'quizzes' => Quizz::where('module_id', $id)->get(),
            'module' => $module,
        );

        return view('modules.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $module=Module::findOrFail($id);
        if (auth()->user()->cannot('hasOwnership', $module)) {
            abort(403);
        }
        $data = array(
            'module' =>$module,
        );

        return view('modules.edit')->with($data);
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
        $messages = [
            'required' => 'O campo :attribute  é obrigatório',
            'max' => 'Este campo excede :max caractéres',    
            'file' => 'Falhou o upload da thumbnail',
            'photo_path.max' => 'O thumbnail não pode ter mais de 350 Kilobytes',
            'photo_path.image' => 'O thumbnail deve ter a extensão jpeg, jpg, png',
        ];
        $rules = [
            'photo_path' => 'nullable|file|image|max:700',
            'name' => 'required|max:255',
            'description' => 'required',
        ];
        $attributes = [
            'name' => 'nome',
            'description' => 'descrição',
            'photo_path' => 'thumbnail',
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $module = Module::findOrFail($id);
      
        if (auth()->user()->cannot('hasOwnership', $module)) {
            abort(403);
        }

        if ($request->hasfile('photo_path')) {
            $deletePath = Str::replaceFirst('storage', 'public', $module->photo_path);
            Storage::disk('local')->delete($deletePath);

            $file = $request->file('photo_path');
            $filename = Str::random(4) . time() . '.' . $file->getClientOriginalExtension();
            $path = 'public/img/' . $filename;
            Storage::disk('local')->put($path, file_get_contents($file));
            $module->photo_path = 'storage/img/' . $filename;
        }
      
        $module->name = $request->name;
        $module->description = $request->description;
        $module->save();
        $request->session()->flash('activity', 'Módulo:  ' . $module->name . ' actualizado');
        return redirect('/admin/module');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $module = Module::findOrFail($id);
    
        if (auth()->user()->cannot('hasOwnership', $module)) {
            abort(403);
        }
        $deletePath = Str::replaceFirst('storage', 'public', $module->photo_path);
        Storage::disk('local')->delete($deletePath);
        foreach ($module->lessons as $lesson => $value) {
            
            $deletePath = Str::replaceFirst('storage', 'public', $value->pdf_link);
            Storage::disk('local')->delete($deletePath);
        }
        $module->lessons()->delete();
        $module->delete();
        session()->flash('activity', 'Módulo apagada com sucesso');
        return redirect('/admin/module');
    }
}
