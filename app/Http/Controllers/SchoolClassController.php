<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $courses = Course::where('user_id', auth()->user()->id)->get();
        $schoolClasses = SchoolClass::join('courses', 'courses.id', '=', 'course_id')
                ->select('school_classes.*')
                ->where('courses.user_id', auth()->user()->id)
                ->get();
        if ($request->query('course')) {
            $schoolClasses = SchoolClass::where('course_id', $request->query('course'))->get();
        }
        return view('classes.index', compact('courses', 'schoolClasses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        SchoolClass::create($request->all());
    
        $request->session()->flash('activity', 'Turma criada com sucesso');
        return redirect('/admin/school-class');
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
        //
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
        $schoolClass= SchoolClass::findOrFail($id);
        $schoolClass->class_name = $request->class_name;
        $schoolClass->course_id = $request->course_id;
       if ($request->start_lesson) {
            $schoolClass->start_lesson = $request->start_lesson;
       }
        $schoolClass->active = $request->active ? 1 :0;
        $schoolClass->save();
      
        $request->session()->flash('activity', 'Turma actualizada com sucesso');
        return redirect('/admin/school-class');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
