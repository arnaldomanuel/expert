<?php

use App\Http\Controllers\CourseGrantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned th    e "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return auth()->user();
});
Route::get('/user1', function (Request $request) {
    return auth()->user();
});
Route::middleware(['auth:api'])->group(function () {
    
Route::get('get/course/{slug}',[\App\Http\Controllers\StudentCourseController::class,'getCourse']);
Route::get('/get/viewQuizz/{id}', [\App\Http\Controllers\StudentQuizzController::class, 'viewQuizz']);
Route::post('/quizz/result', [\App\Http\Controllers\StudentQuizzController::class, 'postResult']);
Route::get('/aulas/{id}', [\App\Http\Controllers\StudentLessonsController::class, 'viewLesson' ]);
Route::get('/downloadPDF/{id}',[\App\Http\Controllers\StudentLessonsController::class,'downloadFile']);
Route::get('/my-courses', [\App\Http\Controllers\StudentCourseController::class, 'showStudentCourses']);
Route::get('last-viewed-course', [\App\Http\Controllers\StudentCourseController::class, 'getLastViewedCourse']);
Route::get('/my-results/quizz', [\App\Http\Controllers\StudentQuizzController::class, 'getResult']);
Route::post('/pay/mpesa',[\App\Http\Controllers\PaymentController::class, 'mpesa']);
Route::post('/request/course-grant',[CourseGrantController::class, 'requestAccessToken']);
Route::get('/course/get-access-status/{course_id}',[\App\Http\Controllers\PaymentController::class, 'getPaymentSucess']);
Route::get('/courses',[\App\Http\Controllers\StudentCourseController::class,'viewCourses']);
Route::get('/course/{slug}',[\App\Http\Controllers\StudentCourseController::class,'viewCourse']);
Route::get('/module/{id}',[\App\Http\Controllers\StudentCourseController::class,'viewModule']);
});
Route::post('/login',[\App\Http\Controllers\MobileController::class,'login']);

