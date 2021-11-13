<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseGrant;
use App\Models\Objective;
use App\Models\User;
use App\Services\CourseGrantService;
use App\Models\Module;
use App\Traits\APITrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;


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


        $random= Str::random(6);
        if(auth()->user()){
            $user = auth()->user();
            if($user->mobile_app_code == null){
                $user->mobile_app_code = $random;
                $user->save();
            }
        }
        $data = array(
            'courses' => $courses,
            'mobile_app_code'=>$random,
        );
        if($this->isAPI($request)){
            return  response()->json($data);
        }

        return view('students.courses.courses')->with($data);
    }
    public function getLastViewedCourse(){


        $data = array(
            'lastViewedCourse' => Course::find(auth()->user()->last_viewed_course),
        );

        return  response()->json($data);

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

        $statusCourseGrant=array(
          'APPROVED'=>CourseGrant::APPROVED,
           'REPROVED'=>CourseGrant::REPROVED,
           'UNPROCESSED'=>CourseGrant::UNPROCESSED,

        );

        $data= array(
            'courseGrant' => $coursGrant,
            'course' => $course,
            'courseGrantStatus'=>$statusCourseGrant,
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
    public function showStudentCourses(Request $request){
        $courseGrantService = new CourseGrantService();
        $data = array(
            'courses' => $courseGrantService->getStudentsCoursesApproved( auth()->user()->id),
        );

        if($this->isAPI($request)){
            return  response()->json($data);
        }
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
