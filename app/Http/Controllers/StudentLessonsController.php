<?php

namespace App\Http\Controllers;

use App\Models\CourseGrant;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class StudentLessonsController extends Controller
{
    public function viewLesson($id)
    {
        $lesson = Lesson::findOrFail($id);

        if (!Gate::allows('has-subscription', $lesson)) {

            abort(403, 'Não tem subscrição a este curso.');
        }


        if ($lesson->module->course->ondemand == 1) {
            $courseGrant = CourseGrant::where([
                ['user_id', auth()->user()->id],
                ['course_id', $lesson->module->course->id],
                ['authorize', CourseGrant::APPROVED],
            ])->first();

            $start_lesson = $courseGrant->schoolClass->start_lesson;
            $select = DB::selectOne('select timediff(now(), "'.$start_lesson.'") as hours');

            $numberOfDays=explode(':', $select->hours)[0]/24;
            if ($numberOfDays>0) {
                if ($lesson->order > $numberOfDays) {
                    abort(403);
                }
            } else {
                abort(403);
            }
           
        }
        $suggestions = Lesson::where([
            ['module_id', $lesson->module->id],
            ['id', '<>', $lesson->id]
        ])->orderBy('order', 'asc')->get();
        $data = array(
            'lesson' => $lesson,
            'suggestions' => $suggestions,
        );
        return view('students.lessons.show')->with($data);
    }
}
