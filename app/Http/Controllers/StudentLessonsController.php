<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class StudentLessonsController extends Controller
{
    public function viewLesson($id){
        $lesson = Lesson::findOrFail($id);

    

        if (! Gate::allows('has-subscription', $lesson)) {
            abort(403);
        }
        $suggestions = Lesson::where([
            ['module_id', $lesson->module->id],
            ['id', '<>', $lesson->id]
        ])->orderBy('created_at', 'desc')->get();
        $data = array(
            'lesson' => $lesson,
            'suggestions' => $suggestions,
        );
        return view('students.lessons.show')->with($data);
    }
}
