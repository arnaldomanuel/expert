<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class StudentLessonsController extends Controller
{
    public function viewLesson($id)
    {
        $lesson = Lesson::findOrFail($id);

        /*if (!Gate::allows('has-subscription', $lesson)) {
          
            abort(403, 'Não tem subscrição a este curso.');
        }

        if ($lesson->module->course->ondemand == 1) {
            $days = DB::selectOne("SELECT DATEDIFF(now(), updated_at) +1 AS 'days' FROM course_grants
         WHERE course_id=" . $lesson->module->course_id . " and user_id = " . auth()->user()->id);

            $ids = DB::select("SELECT lessons.id from lessons JOIN modules 
        on module_id = modules.id LEFT JOIN courses on modules.course_id = courses.id 
        WHERE course_id = " . $lesson->module->course_id . "  ORDER BY lessons.order 
        ASC LIMIT " . $days->days);

            $found = false;
            foreach ($ids as $idArray) {
                if ($idArray->id == $id) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                abort(403, 'Termine as aulas anteriores');
            }
        }*/
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
