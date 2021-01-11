<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Quizz;
use App\Models\QuizzResults;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class StudentQuizzController extends Controller
{
    public function viewQuizz($id){
        $module = Module::findOrFail($id);
        $quizzes = Quizz::where('module_id', $id)->get();

        $data = array(
            'module' => $module,
            'quizzes' => $quizzes,
            'quizzesJSON' => json_encode($quizzes),
        );

        return view('students.quizzes.show')->with($data);;

    }

    public function postResult(Request $request){


        $quizzResults = QuizzResults::where([
            ['module_id', '=', $request->module_id1],
            ['user_id','=',  $request->user_id1]
        ])->get();

        if (count($quizzResults)<=0) {
            $quizzResult = new QuizzResults();
        } else {
            foreach ($quizzResults as $qr) {
                $quizzResult = $qr;
                break;
            }
        }
        $quizzResult->module_id= $request->module_id1;
        $quizzResult->user_id = $request->user_id1;
        $quizzResult->count = $request->result;
        $quizzResult->total_count = $request->total_count;
        $quizzResult->save();
        
         return Response::json("OK DOne");
    }

    public function getResult(){
        $data = array(
            'quizzResults' => QuizzResults::where('user_id', auth()->user()->id)->get(),
        );
        return view('students.quizzes.results')->with($data);
    }
}
