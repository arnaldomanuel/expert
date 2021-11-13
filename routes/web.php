<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseGrantController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\QuizzController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\SocialAuthFacebookController;
use App\Http\Controllers\StudentCourseController;
use App\Http\Controllers\StudentLessonsController;
use App\Http\Controllers\StudentQuizzController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckAdmin;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;

Route::get('send-mail', function () {

    $details = [
        'title' => 'Mail from ItSolutionStuff.com',
        'body' => 'This is for testing email using smtp'
    ];

    \Mail::to('arnaldo.nhaguilunguane@outlook.pt')->send(new \App\Mail\MyTestMail($details));

    dd("Email is Sent.");
});

Route::get('send-mail1', function () {

    $details = [
        'title' => 'Mail from ItSolutionStuff.com',
        'body' => 'This is for testing email using smtp'
    ];

    User::first()->notify(new VerifyEmail());

    dd("Email is Sent.");
});

Route::get('testes', function () {


   Auth::login(User::find(16));

    dd("" . auth()->user());
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/aulas1/{id}', [StudentLessonsController::class, 'viewLesson' ]);

Route::view('/', 'landing');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return redirect('/cursos');
    return view('dashboard');
})->name('dashboard');


Route::get('/ad', function(){
 return substr('arnaldo',0, 1) ;
});
Route::get('/cursos', [StudentCourseController::class, 'viewCourses' ]);
Route::get('/cursos/{slug}', [StudentCourseController::class, 'viewCourse' ]);
Route::get('/modulos/{id}', [StudentCourseController::class, 'viewModule' ]);


Route::get('/auth/sign-in', [GoogleController::class, 'social'])->name('oauth');
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('/facebook/redirect', [SocialAuthFacebookController::class, 'redirect']);
Route::get('/facebook/callback', [SocialAuthFacebookController::class, 'callback']);





Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/meus-cursos', [StudentCourseController::class, 'showStudentCourses']);
    Route::get('/aulas/{id}', [StudentLessonsController::class, 'viewLesson' ]);
    Route::get('/quizz/{id}', [StudentQuizzController::class, 'viewQuizz' ]);
    Route::post('/quizz/result', [StudentQuizzController::class, 'postResult']);
    Route::get('/my-results/quizz', [StudentQuizzController::class, 'getResult']);
    Route::post('/request/course-grant', [CourseGrantController::class, 'requestAccessToken']);
});

Route::middleware(['auth', CheckAdmin::class])->group(function () {
    Route::redirect('/admin', '/admin/course');
    Route::get('/admin/options', [AdminController::class, 'options']);
    Route::post('/admin/saveOptions', [AdminController::class, 'saveOptions']);
    Route::get('/admin/access-tokens', [CourseGrantController::class, 'getAccess']);
    Route::post('/admin/approve-token', [CourseGrantController::class, 'approveToken']);
    Route::post('/admin/reprove-token', [CourseGrantController::class, 'reproveTokken']);
    Route::post('/admin/update/objective', [CourseController::class, 'updateObjective']);
    Route::post('/admin/create/objective', [CourseController::class, 'createObjective']);
    Route::post('/admin/delete/objective', [CourseController::class, 'deleteObjective']);
    Route::get('/admin/coursegrant/search', [CourseGrantController::class, 'search']);
    Route::get('/admin/list-aproved-tokens', [CourseGrantController::class, 'listApprovedTokens']);
    Route::get('/admin/list-reproved-tokens', [CourseGrantController::class, 'listReprovedTokens']);
    Route::post('/admin/change-state-token', [CourseGrantController::class, 'changeState']);
    Route::get('/admin/course/{id}/members', [CourseController::class, 'members']);
    Route::resource('/admin/module', ModuleController::class);
    Route::resource('/admin/lesson', LessonController::class);
    Route::resource('/admin/course', CourseController::class);
    Route::resource('/admin/quizz', QuizzController::class);
    Route::resource('/admin/school-class', SchoolClassController::class);

});
