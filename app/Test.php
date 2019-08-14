<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $guarded = [];
    public function scopeUpComingOrHappening($query)
    {
        return $query->where('status', 'Đang diễn ra')
            ->orWhere('status', 'Sắp diễn ra');
    }
    public function exam()
    {
        return $this->belongsTo('App\Exam');
    }
    public function scores()
    {
        return $this->hasMany('App\Score');
    }
    public function classroom()
    {
        return $this->belongsTo('App\Classroom');
    }
    public function getStatusAttribute()
    {
        $now = Carbon::now();
        $start = Carbon::parse($this->start_at);
        $end = Carbon::parse($this->start_at)->addMinutes($this->time + 5);
        return $now->lt($start) ? 'Sắp diễn ra' : (($now->gte($start) && $now->lte($end)) ? 'Đang diễn ra' : 'Kết thúc');
    }
}
