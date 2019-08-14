<?php

namespace App\Http\Controllers;

use App\Test;
use App\Services\TestService;
use Illuminate\Http\Request;
use App\Http\Resources\HomeworkResource;

class StudentController extends Controller
{
    protected $testService;
    public function __construct(TestService $testService)
    {
        $this->testService = $testService;
    }
    public function getAmount()
    {
        $classroom = auth()->user()->student->classroom;
        return [
            'classroom' => $classroom->name,
            'subjects' => $classroom->subjects->count(),
            'tests' => $classroom->tests()->get()->whereIn('status', ['Đang diễn ra', 'Sắp diễn ra'])->count(),
            'homeworks' => $classroom->homeworks->count()
        ];
    }
    public function getAllTests()
    {
        return $this->testService->allByStudent();
    }
    public function getTest(Test $test)
    {
        return $this->testService->createTest($test);
    }
    public function submitAnswers(Request $request, Test $test)
    {
        return $this->testService->storeScore($request, $test);
    }
    public function getScore()
    {
        return $this->testService->getScoreByStudent();
    }
    public function getHomeworks()
    {
        return HomeworkResource::collection(auth()->user()->student->classroom->homeworks()->with('teacher')->get());
    }
}
