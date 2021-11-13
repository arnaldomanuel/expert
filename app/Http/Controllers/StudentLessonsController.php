<?php

namespace App\Http\Controllers;

use App\Models\CourseGrant;
use App\Models\Lesson;
use App\Models\User;
use App\Traits\APITrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class StudentLessonsController extends Controller
{
    use APITrait;
    public function viewLesson(Request $request, $id)
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

            $numberOfDays=explode(':', $select->hours)[0]/24 + 1;


            if (!Str::contains(explode(':', $select->hours)[0], '-')) {
                if ($lesson->order > $numberOfDays) {
                    abort(403, 'Aula ainda não está disponível.');
                }
            } else {
                abort(403, 'Aula ainda não está disponível. Aula disponível em: '.(explode(':', $select->hours)[0] *-1) .
                'horas e '.(explode(':', $select->hours)[1]) . ' minutos');
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


        $user = auth()->user();
        $user->last_viewed_course=$lesson->module->course_id;
        $user->save();

        if($this->isAPI($request)){
            return response()->json($data);
        }
        return view('students.lessons.show')->with($data);
    }
}
