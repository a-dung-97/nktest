<?php
namespace App\Services;

use App\SchoolYear;
use Illuminate\Http\Response;

class SchoolYearService
{
    public function create($request)
    {
        $schoolYear = SchoolYear::create($request->all());
        return response($schoolYear, Response::HTTP_CREATED);
    }
}
