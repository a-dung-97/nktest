<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    protected $guarded = [];
    public function topics()
    {
        return $this->hasMany('App\Topic');
    }
    public function getPathAttribute()
    {
        return "http://nktest.test/api/admin/subjects/$this->id";
    }
}
