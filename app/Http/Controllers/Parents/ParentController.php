<?php

namespace App\Http\Controllers\Parents;

use App\Http\Controllers\Controller;
use App\Http\Requests\Parents\ParentRequest;
use App\Models\ParentKid;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $parents = ParentKid::branchScope($request)->withCount('kids')->get();
        return contentResponse($parents->load('user'));
    }

    /**
     * Display the specified resource.
     */
    public function show(ParentKid $parent)
    {
        return contentResponse($parent->load('user', 'kids'));
    }

    /**
     * Display the specified resource.
     */
    public function parentKids(User $user)
    {
        $parentKids = ParentKid::firstWhere('user_id', $user->id);
        return contentResponse($parentKids->load('user', 'kids.media', 'kids.classRoom.branch'));
    }

    /**
     * Display the specified resource.
     */
    public function parentBranches(User $user)
    {
        $parent = ParentKid::firstWhere('user_id', $user->id);
        $branch = $parent->branches->transform(function ($branch) {
            $branch->media = $branch->nursery->media ?? $branch->nursery->media[0]->getUrl();
            unset($branch->nursery);
            return $branch;
        });
        return contentResponse($branch);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ParentRequest $request, ParentKid $parent)
    {
        DB::beginTransaction();
        try {
            // Update the user
            $user = User::find($parent->user_id);
            $user->update($request->only(['name', 'email', 'phone']));
            $parent->update($request->except(['name', 'email', 'phone', 'kids']));
            if ($request->has('kids')) {
                // Prepare kids data for upsert
                $kidsData = collect($request->input('kids'))->map(function ($kid) use ($parent) {
                    return array_merge($kid, [
                        'parent_id' => $parent->id,
                        'nursery_id' => $parent->nursery_id,
                        'branch_id' => $parent->branch_id,
                    ]);
                })->toArray();
                // Upsert kids
                $parent->kids()->upsert(
                    $kidsData,
                    ['id'],
                    ['first_name', 'last_name', 'birth_date', 'gender', 'has_medical_case', 'description_medical_case']
                );
            }
            DB::commit();
            return messageResponse();
        } catch (\Exception $e) {
            DB::rollBack();
            return messageResponse($e->getMessage(), false, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ParentKid $parent)
    {
        $parent->forceDelete();
        return messageResponse();
    }
}
