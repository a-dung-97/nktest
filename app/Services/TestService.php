<?php

namespace App\Services;

use App\Http\Resources\MixedQuestionResource;
use App\Http\Resources\ScoreResource;
use App\Http\Resources\TestResource;
use Illuminate\Http\Response;
use App\Http\Resources\StudentScoreResource;

class TestService
{
    protected $teacher;
    protected $student;
    public function __construct()
    {
        if (auth()->check()) {
            $this->teacher = auth()->user()->teacher;
            $this->student = auth()->user()->student;
        }
    }
    public function allByTeacher()
    {
        return TestResource::collection($this->teacher->tests()->with('classroom:id,name', 'exam:id')->latest()->get());
    }
    public function countTestByTeacher()
    {
        return $this->teacher->tests->count();
    }
    public function allByStudent()
    {
        return TestResource::collection(
            $this->student->classroom->tests()->with(['scores' => function ($query) {
                $query->where('student_id', $this->student->id);
            }])->get()->whereIn('status', ['Đang diễn ra', 'Sắp diễn ra'])
        );
    }

    public function create($request)
    {
        $test = $this->teacher->tests()->create([
            'name' => $request->name,
            'time' => $request->time,
            'start_at' => $request->start_at,
            'classroom_id' => $request->classroom_id,
            'exam_id' => $request->exam_id,
            'school_year_id' => getCurrentSchoolYear()->id,
        ]);
        $students = $test->classroom->students->pluck('id')->all();
        foreach ($students as $student) {
            $test->scores()->create([
                'student_id' => $student,
                'result' => 0
            ]);
        }
        return response($test, Response::HTTP_CREATED);
    }
    public function update($request, $test)
    {
        $test->update($request->all());
        return response('updated', Response::HTTP_ACCEPTED);
    }

    public function mixExam($test)
    {
        $exam = $test->exam;
        $questions = $exam->questions;
        $conditions = $exam->conditions;
        $easyQuestionCount = 0;
        $mediumQuestionCount = 0;
        $hardQuestionCount = 0;
        foreach ($conditions as $condition) {
            $easyQuestionCount += $condition['easy'];
            $mediumQuestionCount += $condition['medium'];
            $hardQuestionCount += $condition['hard'];
        }
        $hardQuestions = $questions->slice($easyQuestionCount + $mediumQuestionCount)->shuffle();
        $mediumQuestions = $questions->slice($easyQuestionCount)->take($mediumQuestionCount)->shuffle();
        $easyQuestions = $questions->take($easyQuestionCount)->shuffle();
        $questions = $easyQuestions->merge($mediumQuestions)->merge($hardQuestions);
        $questions = $questions->each(function ($item) {
            $item->answers = shuffle_assoc($item->answers);
        });
        return $questions;
    }
    public function createTest($test)
    {
        $exam = $test->exam;
        return MixedQuestionResource::collection($this->mixExam($test))
            ->additional([
                'test' => [
                    'name' => $exam->name,
                    'time' => $test->time,
                    'question_count' => $exam->question_count,
                ],
            ]);
    }

    public function compareToTrueAnswers($answers, $test)
    {
        $score = 0;
        $exam = $test->exam;
        $answers = collect($answers->all());
        $scorePerTrueAnswer = $exam->scorePerQuestion;
        $trueAnswers = $exam->true_answers;
        foreach ($answers as $key => $answer) {
            if ($answer == $trueAnswers[$key]) {
                $score += $scorePerTrueAnswer;
            }
        }
        return $score;
    }

    public function storeScore($answer, $test)
    {
        $score = $this->compareToTrueAnswers($answer, $test);
        // return $score;
        // $result = $test->scores()->create([
        //     'student_id' => $this->student->id,
        //     'result' => $score,
        // ]);
        //return $score;
        $this->student->scores()->where('test_id', $test->id)->first()->update(['result' => $score]);
        return response('ok', Response::HTTP_ACCEPTED);
    }
    public function getScoreByStudent()
    {
        return StudentScoreResource::collection($this->student->scores()->whereRaw('created_at<updated_at')->get());
    }
    public function getTestResult($test)
    {
        $result = $test->scores()->with('student')->get();
        return ScoreResource::collection($result)->additional([
            'meta' => [
                'name' => $test->name,
                'classroom' => $test->classroom->name,
                'score_per_question' => $test->exam->score_per_question
            ],
            'statistics' => [
                'min' => $result->min('result'),
                'max' => $result->max('result'),
                'avg' => round($result->avg('result'), 2)
            ]
        ]);
    }
}
