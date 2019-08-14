<?php

namespace App\Services;

use App\Http\Resources\ExamResource;
use App\Http\Resources\QuestionResource;
use App\Teacher;
use Illuminate\Http\Response;

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
        return ExamResource::collection($this->teacher->exams()->with('subject', 'questions')->latest()->get());
    }
    public function countExamByTeacher()
    {
        return $this->teacher->exams->count();
    }
    public function questions($exam)
    {
        return QuestionResource::collection($exam->questions()->with('topic:id,name')->get());
    }
    public function updateExam($exam, $request)
    {
        $exam->update($request->all());
        return response('updated', Response::HTTP_ACCEPTED);
    }
    public function create($request)
    {
        $questions = $this->questionService->random($request->conditions, $request->duplication);
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
