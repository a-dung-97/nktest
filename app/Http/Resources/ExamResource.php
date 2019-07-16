<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Subject;

class ExamResource extends JsonResource
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
            'subject' => $this->subject->name,
            'conditions' => $this->conditions,
            'questions_count' => $this->questions->count(),
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
