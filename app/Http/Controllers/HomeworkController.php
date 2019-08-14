<?php

namespace App\Http\Controllers;

use App\Homework;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomeworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ['data' => Homework::with('classroom')->get()];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $homework = auth()->user()->teacher->homeworks()->create($request->all());
        return response(['data' => $homework], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Homework  $homework
     * @return \Illuminate\Http\Response
     */
    public function show(Homework $homework)
    {
        return response(['data' => $homework], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Homework  $homework
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Homework $homework)
    {
        $homework->update($request->all());
        return response('updated', Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Homework  $homework
     * @return \Illuminate\Http\Response
     */
    public function destroy(Homework $homework)
    {
        return delete($homework);
    }
}
