<?php

namespace App\Services;

use App\Models\CourseGrant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class CourseGrantService {

    public function getStudentsCoursesApproved($id){
        return CourseGrant::join('courses', 'course_grants.course_id', '=', 'courses.id')
                                ->select('courses.*', 'course_grants.authorize', 'course_grants.token')
                                ->where([
                                   
                                    ['course_grants.user_id', $id]
                                ])->get();
        
    }
}