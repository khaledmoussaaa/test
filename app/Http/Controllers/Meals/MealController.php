<?php

namespace App\Http\Controllers\Meals;

use App\Http\Controllers\Controller;
use App\Http\Requests\Meals\MealRequest;
use App\Models\Meal;
use Illuminate\Http\Request;

class MealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $meals = Meal::branchScope($request)->get();
        return contentResponse($meals);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MealRequest $request)
    {
        $meal = Meal::create($request->Validated());
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Meal $meal)
    {
        return contentResponse($meal);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MealRequest $request, Meal $meal)
    {
        $meal->update($request->validated());
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meal $meal)
    {
        $meal->forceDelete();
        return messageResponse();
    }
}
