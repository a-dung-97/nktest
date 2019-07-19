<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TopicTeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $questions = $this->questions;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'easy' => $questions->where('level', '1')->count(),
            'medium' => $questions->where('level', '2')->count(),
            'hard' => $questions->where('level', '3')->count()
        ];
    }
}
