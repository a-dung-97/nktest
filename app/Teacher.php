<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $guarded = [];
    protected $hidden = ['password'];

    public function classrooms()
    {
        return $this->belongsToMany('App\Classroom')->wherePivot('school_year_id', getCurrentSchoolYear()->id);
    }
    public function questions()
    {
        return $this->hasMany('App\Question');
    }
    public function exams()
    {
        return $this->hasMany('App\Exam');
    }
    public function tests()
    {
        return $this->hasManyThrough('App\Test', 'App\Exam');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function homeworks()
    {
        return $this->hasMany('App\Homework');
    }
    public function getNameAttribute()
    {
        return $this->user->name;
    }
    public function getEmailAttribute()
    {
        return $this->user->email;
    }
}
