<?php

namespace App\Services;

use App\Teacher;
use App\Http\Resources\TeacherResource;
use Illuminate\Http\Response;
use App\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Subject;

class TeacherService
{
    public function all($request)
    {
        $teacher = Teacher::all();
        //return explode(' ', $request->query('subject'))[0] . '%';
        if ($request->query()) {
            //return explode(' ', Subject::find($request->query('subject'))->name . '%');
            $teacher = Teacher::where('subject', 'like', explode(' ', Subject::find($request->query('subject'))->name)[0] . '%')->get();
        }

        return TeacherResource::collection($teacher);
    }
    public function create($request)
    {
        array_add($request, 'email', makeEmail($request['name'], 'teacher'));
        $teacher = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['email']),
            'birthday' => Carbon::parse(strtotime($request['birthday']))->addHours(7)->toDateString(),
            'gender' => $request['gender'],
            'role' => 2
        ])->teacher()->create([
            'subject' => $request['subject']
        ]);
        return response(new TeacherResource($teacher), Response::HTTP_CREATED);
    }
    public function update($request, $teacher)
    {
        $teacher->update(['subject' => $request->subject]);
        $teacher->user->update([
            'name' => $request->name,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
        ]);
        return response('updated', Response::HTTP_ACCEPTED);
    }
}
