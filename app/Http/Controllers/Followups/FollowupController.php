<?php

namespace App\Http\Controllers\Followups;

use App\Http\Controllers\Controller;
use App\Http\Requests\Followups\AttendanceRequest;
use App\Http\Requests\Followups\FollowupRequest;
use App\Http\Requests\Followups\MediaFollowupRequest;
use App\Models\Attendance;
use App\Models\ClassRoom;
use App\Models\Followup;
use App\Models\Kid;
use Illuminate\Http\Request;

class FollowupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kids = Kid::classScope($request)->get();
        $classRoom = ClassRoom::findOrFail($request->class_room_id);
        $kids->transform(function ($kid) use ($request) {
            $kid->attend = $kid->attendances()->where('kid_id', $kid->id)->attendanceDateScope($request)->exists();
            $kid->followup_id = $kid->followup_id = $kid->followup()->attendanceDateScope($request)->first()?->id;
            return $kid;
        });
        return contentResponse(['classRoom' => $classRoom, 'kids' => $kids]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AttendanceRequest $request)
    {
        $attendance = Attendance::kidScope($request)->AttendanceDateScope($request)->first();
        // dump($attendance, $request);
        if (!$attendance) {
            $attendance = Attendance::create($request->validated());
            $attendance->kid->followup()->create($request->validated());
        } else {
            $attendance->forceDelete();
            $attendance->kid->followup()->dateScope($request)->delete();
        }
        return messageResponse();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FollowupRequest $request, Followup $followUp)
    {
        // Update the follow-up details
        $followUp->update($request->safe()->except(['meals', 'subjects']));

        // Handle meals with pivot data (amount)
        $meals = collect($request->validated('meals'))->mapWithKeys(function ($meal) {
            return [$meal['meal_id'] => ['amount' => $meal['amount']]];
        });

        $followUp->meals()->sync($meals);

        // Handle subjects (if applicable)
        $subjects = collect($request->validated('subjects'))->mapWithKeys(function ($subject) {
            return [$subject['subject_id'] => ['description' => $subject['description']]];
        });

        $followUp->subjects()->sync($subjects);

        return messageResponse();
    }

    /**
     * Update the specified resource in storage.
     */
    public function media(MediaFollowupRequest $request, Followup $followUp)
    {
        add_media($followUp, $request, 'followups');
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Followup $followup)
    {
        return contentResponse($followup->load('media', 'meals', 'subjects'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Followup $followUp)
    {
        $followUp->forceDelete();
        return messageResponse();
    }
}
