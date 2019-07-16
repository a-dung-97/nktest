<?php
namespace App\Services;

use App\Http\Resources\TopicResource;
use Illuminate\Http\Response;

class TopicService
{

    public function create($subject,  $request)
    {
        $topic = $subject->topics()->create($request->all());
        return response(new TopicResource($topic), Response::HTTP_CREATED);
    }

    public function update($topic, $request)
    {
        $topic->update($request->all());
        return response('updated', Response::HTTP_ACCEPTED);
    }
}
