<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $guarded = [];
    protected $casts = [
        'true_answers' => 'array',
        'conditions' => 'array'
    ];
    public function questions()
    {
        return $this->belongsToMany('App\Question');
    }
    public function teacher()
    {
        return $this->belongsTo('App\Teacher');
    }
    public function subject()
    {
        return $this->belongsTo('App\Subject');
    }
    public function test()
    {
        return $this->belongsTo('App\Test');
    }
    public function getQuestionCountAttribute()
    {
        return $this->questions->count();
    }
    public function getScorePerQuestionAttribute()
    {
        return 10 / $this->question_count;
    }
}
