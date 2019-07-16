<?php

namespace App\Services;

use App\Http\Resources\ExamResource;
use App\Http\Resources\QuestionResource;
use App\Teacher;

class ExamService
{
    protected $teacher;
    protected $questionService;
    protected $cast = [
        'conditions' => 'array',
    ];
    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
        if (auth()->check()) {
            $this->teacher = auth()->user()->teacher;
        }
    }
    public function all()
    {
        return ExamResource::collection($this->teacher->exams()->with('subject', 'questions')->get());
    }
    public function countExamByTeacher()
    {
        return $this->teacher->exams->count();
    }
    public function questions($exam)
    {
        return QuestionResource::collection($exam->questions);
    }
    public function create($request)
    {
        $questions = $this->questionService->random($request->conditions);
        //return $questions;
        $exam = $this->teacher->exams()->create([
            'name' => $request->exam['name'],
            'subject_id' => $request->exam['subject_id'],
            'conditions' => $request->conditions,
            'true_answers' => $questions->pluck('true_answer', 'id'),
        ]);
        $exam->questions()->attach($questions->pluck('id')->toArray());
        return $exam;
        //return [$questions, $questions->pluck('true_answer', 'id'), $questions->pluck('id')];
    }
}
