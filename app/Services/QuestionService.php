<?php

namespace App\Services;

use App\Teacher;
use App\Http\Resources\QuestionResource;
use Illuminate\Http\Response;
use App\Question;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\TopicTeacherResource;
use Illuminate\Database\Eloquent\Builder;

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
        return  DB::select('select subjects.id,subjects.name,(select count(id) 
        FROM topics where subject_id=subjects.id) as count
        from questions,topics,subjects where questions.topic_id=topics.id 
        and subjects.id=topics.subject_id 
        and questions.teacher_id=? group by subjects.id', [$this->teacher->id]);
    }
    public function countQuestionsByTopics($subject)
    {
        // $id = $this->teacher->id;
        // return DB::select("select questions.topic_id as id,topics.name,count(questions.id) 
        // FROM questions,topics,subjects WHERE questions.topic_id=topics.id and topics.subject_id=subjects.id 
        // and subjects.id=? GROUP by questions.topic_id ", [$subject]);
        //return $subject->topics()->with('questions')->get();
        return TopicTeacherResource::collection($subject->topics()->with(['questions' => function ($query) {
            $query->where('teacher_id', 1);
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
