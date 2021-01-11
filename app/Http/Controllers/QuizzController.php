<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Quizz;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuizzController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        return view('quizzes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Quizz::create($request->all());
        $request->session()->flash('activity', 'Pergunta Adicionada');
        return redirect('/admin/module/'. $request->module_id);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quizz = Quizz::findOrFail($id);
        if (auth()->user()->cannot('hasOwnership', $quizz)) {
            abort(403);
        }
        $data = array(
            'quizz' => $quizz,
        );
        return view('quizzes.edit')->with($data);
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
        $quizz = Quizz::findOrFail($id);
        if (auth()->user()->cannot('hasOwnership', $quizz)) {
            abort(403);
        }
        $quizz->update($request->all());
        $request->session()->flash('activity', 'Pergunta Actualizada');
        return redirect('/admin/module/'. $quizz->module_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quizz = Quizz::findOrFail($id);
        if (auth()->user()->cannot('hasOwnership', $quizz)) {
            abort(403);
        }
        Quizz::destroy($id);

        session()->flash('activity', 'Pergunta Apagada');
        return redirect('/admin/module/'. $quizz->module_id);
     }
}
