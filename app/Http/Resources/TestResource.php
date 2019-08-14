<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TestResource extends JsonResource
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
            'name' => $this->name,
            'time' => $this->time,
            'start_at' => $this->start_at,
            'classroom' => $this->classroom,
            'exam_id' => $this->exam->id,
            'status' => $this->status,
            'isFinished' => $this->scores->all()[0]->created_at < $this->scores->all()[0]->updated_at
        ];
    }
}
