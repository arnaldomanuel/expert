<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseGrant;
use App\Models\Objective;
use App\Services\Course\CourseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\Cast\Object_;

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
            'objectives' => Objective::where('course_id', $id)->get(),
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
        $course->schoolClasses()->delete();
        $course->objectives()->delete();
        $course->destroy($id);
        session()->flash('activity', 'Curso: ' . $course->name . ' apagado com sucesso');
        
        return redirect('/admin/course');
    }

    public function members($id){
        
        $course = Course::findOrFail($id);
        if (auth()->user()->cannot('update', $course)) {
            abort(403);
        }
        
        $data = array(
            'courseGrants' => CourseGrant::join('courses', 'course_grants.course_id', '=', 'courses.id')
                                ->join('users', 'users.id', '=', 'course_grants.user_id')
                                ->select('courses.name as curso', 'course_grants.*', 'users.name as nome')
                                ->where([
                                    ['courses.user_id', auth()->user()->id],
                                    ['course_grants.authorize', 1],
                                    ['courses.id', $id],
                                ])->paginate(40),
        );
       
        return view('course-grant.members')->with($data);
    }
    public function updateObjective(Request $request){
        $objective = Objective::find($request->objective_id);
        $objective->description = $request->objective;
        $objective->save();
        session()->flash('activity', 'Objectivo ' . ' actualizado com sucesso');
        return redirect()->back();
    }
    public function deleteObjective(Request $request){
        Objective::destroy($request->objective_id);
        session()->flash('activity', 'Objectivo ' .  ' apagado com sucesso');
        return redirect()->back();
    }
    public function createObjective(Request $request){
        $objective =new Objective();
        $objective->course_id=$request->course_id;
        $objective->description = $request->objective;
        $objective->save();
        session()->flash('activity', 'Objectivo ' . ' criado com sucesso');
        return redirect()->back();
    }
}
