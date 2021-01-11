<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Services\Course\CourseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array(
            'courses' => Course::where('user_id', auth()->user()->id)->paginate(20),
        );

        return view('courses.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $courseService = new CourseService();

        $result =  $courseService->saveCourse($request);
        if ($result!="OK") {
           return $result;
        }
        $request->session()->flash('activity', 'Curso ' . $request->name . ' criado');
        return redirect('/admin/course');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::findOrFail($id);
        $data = array(
            'course' => $course,
        );
        if (auth()->user()->cannot('view', $course)) {
            abort(403);
        }
        return view('courses.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $data = array(
            'course' => $course,
        );
        if (auth()->user()->cannot('update', $course)) {
            abort(403);
        }
        return view('courses.edit')->with($data);
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
        $courseService = new CourseService();
        $result = $courseService->updateCourse($request, $id);

    
        if ($result!="OK") {
           return $result;
        }
        $request->session()->flash('activity', 'Curso ' . $request->name . ' actualizado');
        return redirect('/admin/course');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $course = Course::findOrFail($id);
        if (auth()->user()->cannot('forceDelete', $course)) {
            abort(403);
        }
        $deletePath = Str::replaceFirst('storage', 'public', $course->thumbnail);
        Storage::disk('local')->delete($deletePath);
        $course->modules()->delete();
        $course->destroy($id);
        session()->flash('activity', 'Curso: ' . $course->name . ' apagado com sucesso');
        
        return redirect('/admin/course');
    }
}
