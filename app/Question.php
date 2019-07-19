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
}
