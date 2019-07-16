<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
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
            'birthday' => $this->user->birthday,
            'gender' => $this->user->gender,
            'last_name' => $this->user->last_name,
            'email' => $this->email,
            'subject' => $this->subject
        ];
    }
}
