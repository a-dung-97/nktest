<?php

namespace App\Http\Controllers;

use App\Services\QuestionService;
use App\Question;
use App\Services\ClassroomService;

use App\Classroom;
use Illuminate\Http\Request;
use App\Services\ExamService;
use App\Http\Requests\QuestionRequest;
use App\Exam;
use App\Services\TestService;
use App\Http\Requests\TestRequest;
use App\Test;
use App\Subject;
use App\Topic;

class TeacherController extends Controller
{
    protected $questionService;
    protected $classroomService;
    protected $examService;
    protected $testService;
    public function __construct(
        QuestionService $questionService,
        ClassroomService $classroomService,
        ExamService $examService,
        TestService $testService
    ) {
        $this->questionService = $questionService;
        $this->classroomService = $classroomService;
        $this->examService = $examService;
        $this->testService = $testService;
    }
    //classroom
    public function  getTotalAmountOfAll()
    {
        //return auth()->user()->teacher;
        return [
            'classrooms' => $this->classroomService->countClassroomsByTeacher(),
            'questions' => $this->questionService->countQuestionByTeacher(),
            'exams' => $this->examService->countExamByTeacher(),
            'tests' => $this->testService->countTestByTeacher()
        ];
    }
    public function getAllClassrooms()
    {
        return $this->classroomService->findByTeacher();
    }
    public function getClassroom(Classroom $classroom)
    {
        return $this->classroomService->students($classroom);
    }

    //question
    public function countSubject()
    {
        return $this->questionService->countSubject();
    }
    public function countQuestionsByTopic(Subject $subject)
    {
        return $this->questionService->countQuestionsByTopics($subject);
    }
    public function countQuestionsRemainByTopics(Subject $subject)
    {
        return $this->questionService->countQuestionsRemainByTopics($subject);
    }
    public function getAllQuestions(Topic $topic)
    {
        return $this->questionService->all($topic);
    }
    public function getQuestion(Question $question)
    {
        return $this->questionService->find($question);
    }
    public function createQuestion(QuestionRequest $request)
    {
        return $this->questionService->create($request);
    }
    public function updateQuestion(Request $request, Question $question)
    {
        return $this->questionService->update($request, $question);
    }
    public function deleteQuestion(Question $question)
    {
        delete($question);
    }

    //exam
    public function getAllExams()
    {
        return $this->examService->all();
    }
    public function getExamQuestions(Exam $exam)
    {
        return $this->examService->questions($exam);
    }
    public function createExam(Request $request)
    {
        //return $this->questionService->random($request);
        //return $request;
        return $this->examService->create($request);
    }
    public function updateExam(Exam $exam, Request $request)
    {
        return $this->examService->updateExam($exam, $request);
    }
    public function deleteExam(Exam $exam)
    {
        return delete($exam);
    }
    public function getTopicNameById($id)
    {
        return Topic::find($id)->name;
    }

    //test
    public function getAllTests()
    {
        return $this->testService->allByTeacher();
    }
    public function createTest(TestRequest $request)
    {
        return $this->testService->create($request);
    }
    public function updateTest(TestRequest $request, Test $test)
    {
        return $this->testService->update($request, $test);
    }
    public function deleteTest(Test $test)
    {
        return delete($test);
    }
    public function getTestResult(Test $test)
    {
        return $this->testService->getTestResult($test);
    }
}
