<?php

namespace App\Http\Controllers\Kids;

use App\Http\Controllers\Controller;
// Models
use App\Models\Kid;
use App\Models\User;
// DB
use Illuminate\Support\Facades\DB;
// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Kids\StoreKidRequest;
use App\Http\Requests\Kids\UpdateKidRequest;
use App\Models\Followup;
use Carbon\Carbon;

class KidController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kids = Kid::branchScope($request)->get();
        return contentResponse($kids->load('media', 'parent'));
    }

    public function store(StoreKidRequest $request)
    {
        DB::beginTransaction();
        try {
            // Create the user and associated parent data
            $user = User::create($request->validated() + ['password' => bcrypt('12345test')]);
            $parent = $user->parent()->create($request->safe()->except(['name', 'email']));
            $parent->branches()->sync($request->validated('branch_id'));

            // Create the kids and store them in the database
            $kids = $parent->kids()->createMany($request->validated('kids'));

            // Loop over each kid and add their media
            foreach ($kids as $index => $kid) {
                if ($request->hasFile("kids.{$index}.media")) {
                    $kid->addMediaFromRequest("kids.{$index}.media")
                        ->toMediaCollection('kids'); // specify collection name, e.g., 'kids'
                }
            }

            // Assign roles to the user
            $user->syncRoles(['parent']);

            DB::commit();
            return messageResponse(); // Success response
        } catch (\Exception $error) {
            DB::rollBack();
            return messageResponse($error->getMessage(), false, 500); // Error response
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Kid $kid)
    {
        return contentResponse($kid->load('media', 'parent.user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKidRequest $request, Kid $kid)
    {
        $kid->update($request->validated());
        add_media($kid, $request, 'kids');
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function birthday(Request $request)
    {
        $kids = Kid::branchScope($request)->whereMonth('birth_date', now()->month())
            ->orWhereMonth('birth_date', now()->addMonth()->month)
            ->get();

        $kids->transform(function ($kid) {
            $birthdayThisYear = Carbon::parse($kid->birth_date)->setYear(now()->year);
            if ($birthdayThisYear->isPast()) {
                $birthdayThisYear->addYear();
            }
            if (!$birthdayThisYear->isBefore(today())) {
                $kid->countdown = $birthdayThisYear->diffInDays(today(), true);
                return $kid;
            }
        });

        return contentResponse($kids);
    }

    /**
     * Display the specified resource.
     */
    public function followup(Request $request, Kid $kid)
    {
        $date = Carbon::parse($request->date);
        $followup = Followup::where('kid_id', $kid->id)->whereDate('date', $date)->firstOrFail();
        return contentResponse($followup->load('media','meals', 'subjects'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kid $kid)
    {
        $parent = $kid->parent;
        if ($parent->kids()->count() == 1) {
            $parent->forceDelete();
        } else {
            $kid->forceDelete();
        }
        return messageResponse();
    }
}
