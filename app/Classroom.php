<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $guarded = [];
    public function teacher()
    {
        return $this->belongsToMany('App\Teacher');
    }
    public function students()
    {
        return $this->hasMany('App\Student');
    }
    public function schoolYear()
    {
        return $this->belongsTo('App\SchoolYear', 'start_year');
    }
    public function tests()
    {
        return $this->hasMany('App\Test');
    }
    public function scopeGraduated($query)
    {
        $cur = explode('-', getCurrentSchoolYear()->name)[0];
        $graduated = ($cur - 3) . '-' . ($cur - 2);
        $schoolYear = SchoolYear::where('name', $graduated)->first();
        if ($schoolYear)
            return $query->where('start_year', '<>', $schoolYear->id);
        return $query;
    }
}
