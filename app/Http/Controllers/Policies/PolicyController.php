<?php

namespace App\Http\Controllers\Policies;

use App\Http\Controllers\Controller;
use App\Http\Requests\Policies\PolicyRequest;
use App\Models\Policy;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $policies = Policy::nurseryScope($request)->get();
        return contentResponse($policies);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(PolicyRequest $request)
    {
        $nursery = Policy::create($request->validated());
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Policy $policy)
    {
        return contentResponse($policy);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PolicyRequest $request, Policy $policy)
    {
        $policy->update($request->validated());
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Policy $policy)
    {
        $policy->forceDelete();
        return messageResponse();
    }
}
