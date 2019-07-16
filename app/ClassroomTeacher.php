<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Builder;

class ClassroomTeacher extends Pivot
{
    protected $guarded = [];
    public $incrementing = true;
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('school_year_id', function (Builder $builder) {
            $builder->where('school_year_id', getCurrentSchoolYear()->id);
        });
    }
}
