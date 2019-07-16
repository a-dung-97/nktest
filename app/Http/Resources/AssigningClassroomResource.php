<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Classroom;
use App\Subject;
use App\Teacher;

class AssigningClassroomResource extends JsonResource
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
            'classroom' => Classroom::find($this->classroom_id)->name,
            'subject' => Subject::find($this->subject_id)->name,
            'teacher' => Teacher::find($this->teacher_id)->name
        ];
    }
}
