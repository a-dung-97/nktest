<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    protected $guarded = [];
    public function classroom()
    {
        return $this->belongsTo('App\Classroom');
    }
    public function teacher()
    {
        return $this->belongsTo('App\Teacher');
    }
}
