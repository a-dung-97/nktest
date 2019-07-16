<?php

namespace App\Services;

use App\Classroom;
use App\Http\Resources\StudentResource;
use App\Http\Resources\ClassroomResource;
use Illuminate\Http\Response;
use App\Http\Resources\AssigningClassroomResource;
use App\ClassroomTeacher;
//use App\Teacher;

class ClassroomService
{
    protected $teacher;
    public function __construct()
    {
        if (auth()->check()) {
            $this->teacher = auth()->user()->teacher;
        }
    }
    public function all()
    {
        return ClassroomResource::collection(Classroom::graduated()->latest('id')->get());
    }
    public function findByTeacher()
    {
        return ClassroomResource::collection($this->teacher->classrooms);
    }
    public function countClassroomsByTeacher()
    {
        return $this->findByTeacher()->count();
    }
    public function students($classroom)
    {
        return StudentResource::collection($classroom->students);
    }
    public function create($request)
    {
        $classroom = Classroom::create([
            'name' => $request->name,
            'start_year' => getCurrentSchoolYear()->id
        ]);
        return response(new ClassroomResource($classroom), Response::HTTP_CREATED);
    }
    public function update($request, $classroom)
    {
        $classroom->update($request->all());
        return response('updated', Response::HTTP_ACCEPTED);
    }

    public function getAssigningClassrooms()
    {
        return AssigningClassroomResource::collection(ClassroomTeacher::all());
    }
    public function createAssigningClassroom($request)
    {
        $assign = ClassroomTeacher::create([
            'classroom_id' => $request->classroom_id,
            'subject_id' => $request->subject_id,
            'teacher_id' => $request->teacher_id,
            'school_year_id' => getCurrentSchoolYear()->id
        ]);
        return response(new AssigningClassroomResource($assign), Response::HTTP_CREATED);
    }
}
