<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'content' => $this->content,
            'answers' => $this->answers,
            'true_answer' => $this->true_answer,
            'level' => $this->level,
            'topic' => $this->topic->name,
            'created_at' => $this->created_at->toDateTimeString()
        ];
    }
}
