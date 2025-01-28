<?php

namespace App\Http\Controllers\ClassRooms;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClassRooms\ClassRoomRequest;
use App\Http\Requests\ClassRooms\ClassRoomSubjectRequest;
use Illuminate\Http\Request;
use App\Models\ClassRoom;

class ClassRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $classrooms = ClassRoom::branchScope($request)->withCount('kids')->paginate(10);
        return contentResponse($classrooms->load('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClassRoomRequest $request)
    {
        $classroom = ClassRoom::create($request->validated());
        return messageResponse();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function assignSubject(ClassRoomSubjectRequest $request, ClassRoom $classroom)
    {
        $classroom->subjects()->sync(collect($request->validated('subjects'))->pluck('subject_id'));
        return messageResponse();
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function deleteAssignSubject(ClassRoomSubjectRequest $request, ClassRoom $classroom)
    {
        $classroom->subjects()->detach($request->validated('subject_id'));
        return messageResponse();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function classSubjects(ClassRoom $classroom)
    {
        return contentResponse($classroom->subjects);
    }

    /**
     * Display the specified resource.
     */
    public function show(ClassRoom $classroom)
    {
        return contentResponse($classroom->load('subjects', 'kids.media'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClassRoomRequest $request, ClassRoom $classroom)
    {
        $classroom->update($request->validated());
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassRoom $classroom)
    {
        $classroom->forceDelete();
        return messageResponse();
    }
}