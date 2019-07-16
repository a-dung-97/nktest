<?php

namespace App\Services;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use App\Http\Resources\StudentResource;
use Illuminate\Support\Carbon;

class StudentService
{
    public function create($classroom, $request)
    {
        //return $request;
        $request = $request->students;
        $students = [];
        foreach ($request as $student) {
            array_push($students, array_add($student, 'email', makeEmail($student['name'], 'student')));
        }
        //return $students;
        //return Carbon::parse(strtotime($students[3]['birthday']))->addHours(7)->toDateString();
        foreach ($students as $student) {
            User::create([
                'name' => $student['name'],
                'email' => $student['email'],
                'password' => Hash::make($student['email']),
                'birthday' => Carbon::parse(strtotime($student['birthday']))->addHours(7)->toDateString(),
                'gender' => $student['gender'],
                'role' => 3
            ])->student()->create([
                'classroom_id' => $classroom->id
            ]);
        }
        //$students = $classroom->students()->createMany($students);
        return response('created', Response::HTTP_CREATED);
    }
    public function update($student, $request)
    {
        $student->user->update($request->all());
        return response('updated', Response::HTTP_ACCEPTED);
    }
}
