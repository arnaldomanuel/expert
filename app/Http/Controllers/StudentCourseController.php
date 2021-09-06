<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseGrant;
use App\Models\Objective;
use App\Services\CourseGrantService;
use App\Models\Module;
use App\Traits\APITrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class StudentCourseController extends Controller
{
    use APITrait;
    public function viewCourses(Request $request){
        $searchString  = $request->query('searchString');

        if ($searchString) {
            $courses=Course::where([
                ['name', 'like', '%'.  $searchString.'%'],
            ])->
            orWhere('description', 'like', '%'.  $searchString.'%')->get();
        } else {
            $courses=Course::orderBy('updated_at', 'desc')->get();
        }
        $data = array(
            'courses' => $courses,
        );


        if($this->isAPI($request)){
            return  response()->json($data);
        }

        return view('students.courses.courses')->with($data);
    }

    public function viewCourse(Request $request,$slug){


        $courses = Course::where('slug', $slug)->orWhere('id', $slug)->get();
        foreach($courses as $key){
            $course = $key;
        }
        if (!isset($course)) {
           abort(404);
        }


        $user = auth()->user();
        if ($user) {
            $coursGrant = CourseGrant::where([
                ['user_id', '=' ,$user->id],
                ['course_id','=' ,  $course->id]
            ])->orderBy('updated_at','desc')->first();
        } else {
            $coursGrant =null;
        }


        $data= array(
            'courseGrant' => $coursGrant,
            'course' => $course,
            'objectives'=>$course->objectives,
            'modules' => Module::where('course_id', $course->id)->orderBy('order')->get()
        );

        if($this->isAPI($request)){
            return  response()->json($data);
        }
        return view('students.courses.show')->with($data);
    }
    public function getCourse(Request $request, $slug){
        return response()->json(Course::where('slug', $slug)->orWhere('id', $slug)->first());
    }
    public function showStudentCourses(){
        $courseGrantService = new CourseGrantService();
        $data = array(
            'courses' => $courseGrantService->getStudentsCoursesApproved(auth()->user()->id),
        );

        return view('students.courses.mycourses')->with($data);
    }
    public function viewModule(Request $request,$id){
        $module = Module::findOrFail($id);
        $data = array(
            'module' => $module,
            'lessons' => $module->lessons,
            'course' => $module->course
        );
        if($this->isAPI($request)){
            return  response()->json($data);
        }
        return view('students.courses.module')->with($data);
    }
}
