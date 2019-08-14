<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];
    protected $casts = [
        'answers' => 'array'
    ];

    public function getImageAtrribute($value)
    { }
    public function teacher()
    {
        return $this->belongsTo('App\Teacher', 'teacher_id');
    }
    public function topic()
    {
        return $this->belongsTo('App\Topic');
    }
    public function scopeLevel($query, $type)
    {
        return $query->where('level', $type);
    }
    public function getLevelAttribute($value)
    {
        return ($value == 1) ? 'Dễ' : ($value == 2 ? 'Trung bình' : 'Khó');
    }
    public function setLevelAttribute($value)
    {
        $this->attributes['level'] = ($value == 'Dễ') ? 1 : ($value == 'Trung bình' ? 2 : 3);
    }
}
