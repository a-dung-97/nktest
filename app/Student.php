<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class Student extends Model
{
    protected $guarded = [];
    public function classroom()
    {
        return $this->belongsTo('App\Classroom');
    }

    public function scores()
    {
        return $this->hasMany('App\Score');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function getNameAttribute()
    {
        return $this->user->name;
    }
    public function getEmailAttribute()
    {
        return $this->user->email;
    }
    public function getGenderAttribute()
    {
        return $this->user->gender;
    }
    public function getBirthdayAttribute()
    {
        return $this->user->birthday;
    }
    public function scopeGraduated($query)
    {
        return $query->whereIn('classroom_id', Classroom::graduated()->get()->pluck('id')->all());
    }
}
