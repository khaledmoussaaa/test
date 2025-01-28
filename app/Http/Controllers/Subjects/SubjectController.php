<?php

namespace App\Http\Controllers\Subjects;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subjects\SubjectRequest;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $branch_id = $request->branch_id;
        $nursery_id = $request->nursery_id;
        $subjects = Subject::orWhere([['branch_id', $branch_id], ['nursery_id', $nursery_id]])->get();
        return contentResponse($subjects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubjectRequest $request)
    {
        $subject = Subject::create($request->validated());
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        return contentResponse($subject);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubjectRequest $request, Subject $subject)
    {
        $subject->update($request->validated());
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->forceDelete();
        return messageResponse();
    }
}
