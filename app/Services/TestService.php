<?php

namespace App\Services;

use App\Http\Resources\MixedQuestionResource;
use App\Http\Resources\ScoreResource;
use App\Http\Resources\TestResource;
use Illuminate\Http\Response;

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
        return TestResource::collection($this->teacher->tests()->with('classroom')->get());
    }
    public function countTestByTeacher()
    {
        return $this->teacher->tests->count();
    }
    public function allByStudent()
    {
        return TestResource::collection($this->student->classroom->tests()->upComingOrHappening()->get());
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
        //return $score;
        $result = $test->scores()->create([
            'student_id' => $this->student->id,
            'result' => $score,
        ]);
        return response($result, Response::HTTP_CREATED);
    }
    public function getScoreByStudent()
    {
        return ScoreResource::collection($this->student->scores);
    }
}
