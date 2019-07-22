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
        return QuestionResource::collection($this->teacher->questions()->where('topic_id', $topic->id)->get());
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

    public function random($conditions)
    {
        $easy = collect([]);
        $medium = collect([]);
        $hard = collect([]);
        $questions = collect([]);
        //return $conditions[0]['id'];
        //return $this->teacher;
        foreach ($conditions as $condition) {
            $easy = $easy->merge(
                $this->teacher
                    ->questions()
                    ->where([['level', 1], ['topic_id', $condition['id']]])
                    ->get()
                    ->random($condition['easy'])
            );
            $medium = $medium->merge(
                $this->teacher
                    ->questions()
                    ->where([['level', 2], ['topic_id', $condition['id']]])
                    ->get()
                    ->random($condition['medium'])
            );
            $hard = $hard->merge(
                $this->teacher
                    ->questions()
                    ->where([['level', 3], ['topic_id', $condition['id']]])
                    ->get()
                    ->random($condition['hard'])
            );
        }
        $questions = $questions->merge($easy)->merge($medium)->merge($hard);
        return $questions;
    }
}
