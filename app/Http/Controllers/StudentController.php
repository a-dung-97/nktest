<?php

namespace App\Http\Controllers;

use App\Test;
use App\Services\TestService;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    protected $testService;
    public function __construct(TestService $testService)
    {
        $this->testService = $testService;
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
}
