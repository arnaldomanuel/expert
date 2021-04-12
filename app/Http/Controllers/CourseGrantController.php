<?php

namespace App\Http\Controllers;

use App\Models\CourseGrant;
use App\Models\SchoolClass;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Response;

class CourseGrantController extends Controller
{

    public function getAccess(){
        $data = array(
            'schoolClasses' => SchoolClass::join('courses', 'school_classes.course_id', '=', 'courses.id')
                                        ->select('courses.name as curso', 'school_classes.*')
                                        ->where([
                                            ['courses.user_id', auth()->user()->id],
                                            ['school_classes.active', 1]
                                        ])->get(),
            'courseGrants' => CourseGrant::join('courses', 'course_grants.course_id', '=', 'courses.id')
                                ->select('courses.*', 'course_grants.*')
                                ->where([
                                    ['courses.user_id', auth()->user()->id],
                                    ['course_grants.authorize', 0]
                                ])->paginate(40),
        );
        return view('course-grant.course-grant-list')->with($data);
    }
    public function approveToken(Request $request){
        $courseGrant = CourseGrant::where([
            ['token', $request->token],
            ['user_id', $request->user_id]
            ])->first();
        if ($courseGrant) {
            $courseGrant->authorize = 1;
            $courseGrant->school_classs_id  = $request->school_class_id;
            $courseGrant->save();
            $request->session()->flash('activity', 'Código de acesso aprovado');
        }
        else {
            $request->session()->flash('error', 'Código de acesso não existe');
        }

      
        return redirect('/admin/access-tokens');
    }

    public function reproveTokken(Request $request){
        $courseGrant = CourseGrant::where([
            ['token', $request->token],
            ['user_id', $request->user_id]
            ])->first();
        if ($courseGrant) {
            $courseGrant->authorize = 2;
            $courseGrant->save();
            $request->session()->flash('activity', 'Código de acesso reprovado');
        } else {
            $request->session()->flash('error', 'Código de acesso não existe');
        }
        return redirect('/admin/access-tokens');
    }

    public function listReprovedTokens(){
        $data = array(
            'courseGrants' => CourseGrant::join('courses', 'course_grants.course_id', '=', 'courses.id')
                                ->select('courses.*', 'course_grants.*')
                                ->where([
                                    ['courses.user_id', auth()->user()->id],
                                    ['course_grants.authorize', 2]
                                ])->paginate(40),
        );
        return view('course-grant.reproved')->with($data);
    }

    public function listApprovedTokens(){
        $data = array(
            'courseGrants' => CourseGrant::join('courses', 'course_grants.course_id', '=', 'courses.id')
                                ->select('courses.*', 'course_grants.*')
                                ->where([
                                    ['courses.user_id', auth()->user()->id],
                                    ['course_grants.authorize', 1]
                                ])->paginate(40),
        );
        return view('course-grant.approved')->with($data);
    }

    public function requestAccessToken(Request $request){
       $courseGrant= CourseGrant::where([
            ['user_id', '=', auth()->user()->id],
            ['course_id', '=', $request->course_id],
            ['authorize', '=', 0]
        ])->first();

       if (!$courseGrant) {
            $courseGrant = new CourseGrant();
       }
        $courseGrant->user_id = auth()->user()->id;
        $courseGrant->course_id = $request->course_id;
        $token = Str::random(8);
        try {
            $courseGrant->token = $token;
            $courseGrant->save();
        } catch (QueryException $ex) {
            
            if (Str::contains($ex->getMessage(), 'course_grants_token_unique')) {
                $courseGrant->token = $token . Str::random(3);
                $courseGrant->save(); 
            }
        }
        return Response::json($courseGrant->token);
    }

    public function search(Request $request){
        $token = $request->search;

        $data = array(
            'schoolClasses' => SchoolClass::join('courses', 'school_classes.course_id', '=', 'courses.id')
                                    ->select('courses.name as curso', 'school_classes.*')
                                    ->where([
                                        ['courses.user_id', auth()->user()->id],
                                        ['school_classes.active', 1]
                                    ])->get(),
            'courseGrants' => CourseGrant::join('courses', 'course_grants.course_id', '=', 'courses.id')
                                ->select('courses.*', 'course_grants.*')
                                ->where([
                                    ['courses.user_id', auth()->user()->id],
                                    ['course_grants.token', $token]
                                ])->paginate(40),
        );
        return view('course-grant.course-grant-list')->with($data);
    }

    public function changeState(Request $request){
        $courseGrant = CourseGrant::find($request->course_grant_id);
        $courseGrant->authorize=$request->state;;
        $courseGrant->save();

        $request->session()->flash('activity', 'Estado do token alterado com sucesso');
        return redirect('/admin/access-tokens');
        
    }
}
