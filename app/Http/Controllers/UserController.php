<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SchoolYear;
use App\Http\Resources\StudentResource;
use App\Classroom;

class UserController extends Controller
{
    public function getCurrentSchoolYear()
    {
        return getCurrentSchoolYear()->name;
    }
    public function setCurrentSchoolYear()
    {
        //$current = explode('-', getCurrentSchoolYear()->name)[0];
        $current = explode('-', getCurrentSchoolYear()->name)[0];
        //$graduated = ($cur - 3) . '-' . ($cur - 2);
        //return $graduated;
        $schoolYear = SchoolYear::create(['name' => ($current + 1) . '-' . ($current + 2)]);
        return $schoolYear->name;
    }
    public function getStudentsOfClassroom(Classroom $classroom)
    {
        return StudentResource::collection($classroom->students);
    }
}
