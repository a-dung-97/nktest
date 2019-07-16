<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Subject;
use App\Services\SubjectService;
use App\Services\ClassroomService;
use App\Http\Requests\SubjectRequest;
use App\Http\Requests\ClassroomRequest;
use App\Services\TeacherService;
use App\Teacher;
use Illuminate\Http\Request;
use App\Services\SchoolYearService;
use App\Http\Requests\SchoolYearRequest;
use App\Services\TopicService;
use App\Http\Requests\TopicRequest;
use App\Topic;
use App\Services\StudentService;
use App\Http\Requests\StudentRequest;
use App\Student;
use App\Http\Requests\TeacherRequest;
use Illuminate\Http\Response;
use App\ClassroomTeacher;

class AdminController extends Controller
{
    protected $subjectService;
    protected $classroomService;
    protected $teacherService;
    protected $schoolYearService;
    protected $topicService;
    protected $studentService;
    //Services Injection
    public function __construct(
        SubjectService $subjectService,
        ClassroomService $classroomService,
        TeacherService $teacherService,
        SchoolYearService $schoolYearService,
        TopicService $topicService,
        StudentService $studentService
    ) {
        $this->subjectService = $subjectService;
        $this->classroomService = $classroomService;
        $this->teacherService = $teacherService;
        $this->schoolYearService = $schoolYearService;
        $this->topicService = $topicService;
        $this->studentService = $studentService;
    }
    public function getTotalAmountOfAll()
    {
        return [
            'students' => Student::graduated()->count(),
            'classrooms' => Classroom::graduated()->count(),
            'teachers' => Teacher::all()->count(),
            'subjects' => Subject::all()->count()
        ];
    }
    public function getAllSubjects()
    {
        return $this->subjectService->all();
    }

    public function getTopicsOfSubject(Subject $subject)
    {
        return $this->subjectService->topics($subject);
    }

    public function createSubject(SubjectRequest $request)
    {
        //return $request;
        return $this->subjectService->create($request);
    }

    public function updateSubject(SubjectRequest $request, Subject $subject)
    {
        return $this->subjectService->update($request, $subject);
    }

    public function deleteSubject(Subject $subject)
    {
        return delete($subject);
    }
    // Topics

    public function createTopic(Subject $subject, TopicRequest $request)
    {
        return $this->topicService->create($subject, $request);
    }

    public function updateTopic(Topic $topic, TopicRequest $request)
    {
        return $this->topicService->update($topic, $request);
    }

    public function deleteTopic(Topic $topic)
    {
        delete($topic);
    }

    //Classroom Functions
    public function getAllClassrooms()
    {
        return $this->classroomService->all();
    }

    public function getStudentsOfClassroom(Classroom $classroom)
    {
        return $this->classroomService->students($classroom);
    }
    public function createStudents(Classroom $classroom, Request $request)
    {
        //return $request;
        return $this->studentService->create($classroom, $request);
    }
    public function updateStudent(Student $student, Request $requesst)
    {
        return $this->studentService->update($student, $requesst);
    }
    public function deleteStudent(Student $student)
    {
        return delete($student->user);
    }
    public function createClassroom(ClassroomRequest $request)
    {
        return $this->classroomService->create($request);
    }

    public function updateClassroom(ClassroomRequest $request, Classroom $classroom)
    {
        return $this->classroomService->update($request, $classroom);
    }

    public function deleteClassroom(Classroom $classroom)
    {
        return delete($classroom);
    }

    //Teacher Functions
    public function getAllTeachers(Request $request)
    {
        return $this->teacherService->all($request);
    }

    public function createTeacher(TeacherRequest $request)
    {
        return $this->teacherService->create($request);
    }

    public function updateTeacher(Request $request, Teacher $teacher)
    {
        return $this->teacherService->update($request, $teacher);
    }

    public function deleteTeacher(Teacher $teacher)
    {
        return delete($teacher->user);
    }

    //
    public function getAssigningClassrooms()
    {
        return $this->classroomService->getAssigningClassrooms();
    }
    public function createAssigningClassroom(Request $request)
    {
        return $this->classroomService->createAssigningClassroom($request);
    }
    public function deleteAssigningClassroom(ClassroomTeacher $classroomTeacher)
    {
        delete($classroomTeacher);
    }
    public function getCurrentSchoolYear()
    {
        return getCurrentSchoolYear();
    }

    public function createSchoolYear(SchoolYearRequest $request)
    {
        return $this->schoolYearService->create($request);
    }
}
