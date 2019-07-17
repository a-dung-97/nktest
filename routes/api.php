<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:admin']], function () {
    Route::get('amount', 'AdminController@getTotalAmountOfAll');
    Route::group(['prefix' => 'subjects'], function () {
        Route::get('/', 'AdminController@getAllSubjects');
        Route::get('/{subject}', 'AdminController@getTopicsOfSubject');
        Route::post('/', 'AdminController@createSubject');
        Route::put('/{subject}', 'AdminController@updateSubject');
        Route::delete('/{subject}', 'AdminController@deleteSubject');
        Route::post('/{subject}', 'AdminController@createTopic');
    });

    Route::group(['prefix' => 'topics'], function () {
        Route::put('/{topic}', 'AdminController@updateTopic');
        Route::delete('/{topic}', 'AdminController@deleteTopic');
    });
    Route::group(['prefix' => 'classrooms'], function () {
        Route::get('/', 'AdminController@getAllClassrooms');

        Route::post('/', 'AdminController@createClassroom');
        Route::post('/{classroom}', 'AdminController@createStudents');
        Route::put('/{classroom}', 'AdminController@updateClassroom');
        Route::delete('/{classroom}', 'AdminController@deleteClassroom');
    });
    Route::put('/students/{student}', 'AdminController@updateStudent');
    Route::delete('/students/{student}', 'AdminController@deleteStudent');
    Route::group(['prefix' => 'teachers'], function () {
        Route::get('/', 'AdminController@getAllTeachers');
        Route::post('/', 'AdminController@createTeacher');
        Route::put('/{teacher}', 'AdminController@updateTeacher');
        Route::delete('/{teacher}', 'AdminController@deleteTeacher');
    });

    Route::get('/assignment', 'AdminController@getAssigningClassrooms');
    Route::post('/assignment', 'AdminController@createAssigningClassroom');
    Route::delete('/assignment/{classroomTeacher}', 'AdminController@deleteAssigningClassroom');
});


Route::group(['prefix' => 'teacher', 'middleware' => ['auth', 'role:teacher']], function () {
    Route::get('amount', 'TeacherController@getTotalAmountOfAll');
    Route::get('/count-subject', 'TeacherController@countSubject');
    Route::get('/count-subject/{subject}', 'TeacherController@countQuestionsByTopic');
    Route::group(['prefix' => 'classrooms'], function () {
        Route::get('/', 'TeacherController@getAllClassrooms');
    });
    Route::group(['prefix' => 'questions'], function () {
        Route::get('/topics/{topic}', 'TeacherController@getAllQuestions');
        Route::post('/', 'TeacherController@createQuestion');
        Route::get('/{question}', 'TeacherController@getQuestion')->middleware('can:view,question');
        Route::put('/{question}', 'TeacherController@updateQuestion')->middleware('can:update,question');
        Route::delete('/{question}', 'TeacherController@deleteQuestion')->middleware('can:delete,question');
    });

    Route::group(['prefix' => 'exams'], function () {
        Route::get('/', 'TeacherController@getAllExams');
        Route::get('/{exam}', 'TeacherController@getExamQuestions');
        Route::post('/', 'TeacherController@createExam');
    });
    Route::group(['prefix' => 'tests'], function () {
        Route::get('/', 'TeacherController@getAllTests');
        Route::get('/{test}', 'TeacherController@getTestResult');
        Route::post('/', 'TeacherController@createTest');
        Route::put('/{test}', 'TeacherController@updateTest');
        Route::delete('/{test}', 'TeacherController@deleteTest');
    });
});

Route::group(['prefix' => 'student', 'middleware' => ['auth', 'role:student']], function () {
    Route::get('/tests', 'StudentController@getAllTests');
    Route::get('/tests/{test}', 'StudentController@getTest');
    Route::post('tests/{test}', 'StudentController@submitAnswers');
    Route::get('scores', 'StudentController@getScore');
});

Route::get('schoolyear', 'UserController@getCurrentSchoolYear');
Route::post('schoolyear', 'UserController@setCurrentSchoolYear');
Route::get('/classrooms/{classroom}', 'UserController@getStudentsOfClassroom');
Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});
