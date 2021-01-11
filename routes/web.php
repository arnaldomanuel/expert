<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseGrantController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\QuizzController;
use App\Http\Controllers\SocialAuthFacebookController;
use App\Http\Controllers\StudentCourseController;
use App\Http\Controllers\StudentLessonsController;
use App\Http\Controllers\StudentQuizzController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::get('/ad', function(){
 return substr('arnaldo',0, 1) ;
});
Route::get('/cursos', [StudentCourseController::class, 'viewCourses' ]);
Route::get('/cursos/{slug}', [StudentCourseController::class, 'viewCourse' ]);
Route::get('/modulos/{id}', [StudentCourseController::class, 'viewModule' ]);
Route::get('/aulas/{id}', [StudentLessonsController::class, 'viewLesson' ]);
Route::get('/quizz/{id}', [StudentQuizzController::class, 'viewQuizz' ]);
Route::post('/quizz/result', [StudentQuizzController::class, 'postResult']);
Route::get('/my-results/quizz', [StudentQuizzController::class, 'getResult']);

Route::get('/meus-cursos', [StudentCourseController::class, 'showStudentCourses']);

Route::get('/admin/options', [AdminController::class, 'options']);
Route::post('/admin/saveOptions', [AdminController::class, 'saveOptions']);

Route::get('/auth/sign-in', [GoogleController::class, 'social'])->name('oauth');

Route::middleware(['auth'])->group(function () {
    Route::post('/request/course-grant', [CourseGrantController::class, 'requestAccessToken']);
});

Route::get('/admin/access-tokens', [CourseGrantController::class, 'getAccess']);
Route::post('/admin/approve-token', [CourseGrantController::class, 'approveToken']);
Route::post('/admin/reprove-token', [CourseGrantController::class, 'reproveTokken']);

Route::get('/admin/coursegrant/search', [CourseGrantController::class, 'search']);
Route::get('/admin/list-aproved-tokens', [CourseGrantController::class, 'listApprovedTokens']);
Route::get('/admin/list-reproved-tokens', [CourseGrantController::class, 'listReprovedTokens']);

Route::resource('/admin/module', ModuleController::class);
Route::resource('/admin/lesson', LessonController::class);
Route::resource('/admin/course', CourseController::class);
Route::resource('/admin/quizz', QuizzController::class);


Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('/facebook/redirect', [SocialAuthFacebookController::class, 'redirect']);
Route::get('/facebook/callback', [SocialAuthFacebookController::class, 'callback']);
