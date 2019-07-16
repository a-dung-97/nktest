<?php

namespace App\Services;

use App\Teacher;
use App\Http\Resources\QuestionResource;
use Illuminate\Http\Response;
use App\Question;

class QuestionService
{
    protected $teacher;
    public function __construct()
    {
        if (auth()->check()) {
            $this->teacher = auth()->user()->teacher;
        }
    }
    public function all()
    {
        return QuestionResource::collection($this->teacher->questions()->with('topic')->paginate(20));
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
        $question = $this->teacher->questions()->create($request->all());
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
