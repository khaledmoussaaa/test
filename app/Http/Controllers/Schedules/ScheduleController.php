<?php

namespace App\Http\Controllers\Schedules;

use App\Http\Controllers\Controller;
use App\Http\Requests\Schedules\ScheduleRequest;
use App\Models\ClassRoom;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $classRoom = ClassRoom::with(['subjects.schedules' => function ($query) use ($request) {
            $query->where([['class_room_id', $request->class_room_id], ['date', $request->date]]);
        }])->find($request->class_room_id);

        $subjects = $classRoom->subjects->map(function ($subject) {
            return [
                'id' => $subject->id,
                'title' => $subject->title,
                'description' => $subject->description,
                'schedules' => $subject->schedules->transform(function ($schedule) {
                    return $schedule->pivot;
                }),
            ];
        });
        return contentResponse($subjects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ScheduleRequest $request, ClassRoom $classRoom)
    {
        $classRoom->schedules()->attach($request->safe());
        return messageResponse();
    }


    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Schedule $schedule)
    {
        $schedule->forceDelete();
        return messageResponse();
    }
}
