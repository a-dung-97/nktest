<?php

namespace App\Services;

use App\Subject;
use App\Http\Resources\TopicResource;
use App\Http\Resources\SubjectResource;
use Illuminate\Http\Response;

class SubjectService
{
    public function all()
    {
        return SubjectResource::collection(Subject::all());
    }
    public function topics($subject)
    {
        return TopicResource::collection($subject->topics);
    }
    public function create($request)
    {
        $subject = Subject::create($request->all());
        return response(new SubjectResource($subject), Response::HTTP_CREATED);
    }
    public function update($request, $subject)
    {
        $subject->update($request->all());
        return response('updated', Response::HTTP_ACCEPTED);
    }
}
