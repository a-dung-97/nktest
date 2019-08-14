<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Test;
use Carbon\Carbon;

class StudentScoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'test' => Test::find($this->test_id)->name,
            'result' => $this->result,
            'created_at' => Carbon::parse($this->created_at)->toDateString()
        ];
    }
}
