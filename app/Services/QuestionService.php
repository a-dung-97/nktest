<?php

namespace App\Services;

use App\Teacher;
use App\Http\Resources\QuestionResource;
use Illuminate\Http\Response;
use App\Question;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\TopicTeacherResource;
use Illuminate\Database\Eloquent\Builder;
use App\Subject;

class QuestionService
{
    protected $teacher;
    public function __construct()
    {
        if (auth()->check()) {
            $this->teacher = auth()->user()->teacher;
        }
    }
    public function all($topic)
    {
        return QuestionResource::collection($this->teacher->questions()->where('topic_id', $topic->id)->latest()->get());
    }
    public function countSubject()
    {
        return Subject::where('name', 'like', $this->teacher->subject . '%')->withCount('topics', 'questions')->get();
    }
    public function countQuestionsByTopics($subject)
    {
        return TopicTeacherResource::collection($subject->topics()->with(['questions' => function ($query) {
            $query->where('teacher_id', $this->teacher->id);
        }])->get());
    }
    public function countQuestionsRemainByTopics($subject)
    {
        return TopicTeacherResource::collection($subject->topics()->with(['questions' => function ($query) {
            $query->where('teacher_id', $this->teacher->id)->whereNotIn('id', DB::table('exam_question')->get()->pluck('question_id')->all());
        }])->get());
    }
    public function countQuestionByTeacher()
    {
        return $this->teacher->questions->count();
    }
    public function find($question)
    {
        return new QuestionResource($question);
    }
    public function create($request)
    {

        $question = $this->teacher->questions()->create([
            'content' => $request->content,
            'answers' => $request->answers,
            'topic_id' => $request->topic_id,
            'level' => $request->level,
            'true_answer' => $request->true_answer

        ]);
        return response(new QuestionResource($question), Response::HTTP_CREATED);
    }
    public function update($request, $question)
    {
        $question->update($request->all());
        return response('updated', Response::HTTP_ACCEPTED);
    }

    public function random($conditions, $duplication)
    {
        $easy = collect([]);
        $medium = collect([]);
        $hard = collect([]);
        $questions = collect([]);
        $query = collect($this->teacher->questions);
        if (!$duplication) $query = $query->whereNotIn('id', DB::table('exam_question')->get()->pluck('question_id')->all());
        foreach ($conditions as $condition) {
            $easy = $easy->merge(
                $query
                    ->where('level', 'Dễ')->where('topic_id', $condition['id'])
                    ->random($condition['easy'])
            );
            $medium = $medium->merge(
                $query
                    ->where('level', 'Trung bình')->where('topic_id', $condition['id'])
                    ->random($condition['medium'])
            );
            $hard = $hard->merge(
                $query
                    ->where('level', 'Khó')->where('topic_id', $condition['id'])
                    ->random($condition['hard'])
            );
        }
        $questions = $questions->merge($easy)->merge($medium)->merge($hard);
        return $questions;
    }
}
