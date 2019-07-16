<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    protected $guarded = [];
    public function subject()
    {
        return $this->belongsTo('App\Subject');
    }
    public function questions()
    {
        return $this->hasMany('App\Question');
    }
}
