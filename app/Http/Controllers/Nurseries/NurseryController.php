<?php

namespace App\Http\Controllers\Nurseries;

use App\Http\Controllers\Controller;
use App\Http\Requests\Nurseries\NurseryRequest;
use App\Http\Requests\Nurseries\NurseryStatusRequest;
use App\Http\Requests\Nurseries\RateNurseryRequest;
use App\Http\Requests\Nurseries\StatusNurseryRequest;
use App\Models\Nursery;
use App\Models\Permission;
use App\Models\User;
use App\Notifications\NurseryStatusNotification;
use Illuminate\Http\Request;

class NurseryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $nurseries = Nursery::query();
        if ($request->status != "all") {
            $nurseries->where('status', $request->status);
        }
        $nurseries = $nurseries->with('media')->get();
        return contentResponse($nurseries);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NurseryRequest $request)
    {
        $user = User::create($request->validated() + ['password' => '12345test']);
        $nursery = $user->nursery()->create($request->validated());
        add_media($nursery, $request, 'nursery');
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Nursery $nurseries)
    {
        $nurseries->rates = round((float) $nurseries->reviews()->avg('rate'), 1);
        return contentResponse($nurseries->load('media', 'services', 'contacts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NurseryRequest $request, Nursery $nurseries)
    {
        $nurseries->update($request->validated());
        $nurseries->user()->update($request->safe()->only(['email', 'phone']));
        if ($request->has('services')) {
            $nurseries->services()->upsert($request->validated('services'), ['id'], ['content']);
        }
        if ($request->has('contacts')) {
            $nurseries->contacts()->upsert($request->validated('contacts'), ['id'], ['link', 'type', 'icon']);
        }
        add_media($nurseries, $request, 'nursery');
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function status(StatusNurseryRequest $request, Nursery $nursery)
    {
        $nursery->update(['status' => $request->validated('status')]);
        if ($nursery->status == "approved" && !$nursery->user) {
            $user = $nursery->user()->create(collect($nursery)->toArray() + ['password' => '12345test']);
            $nursery->user()->associate($user)->save();
            $user->owner_nursery()->associate($nursery)->save();
            $user->syncRoles(['owner']);
            $permssions = Permission::get();
            $user->syncPermissions(collect($permssions)->toArray());
        }
        $nursery->notify(new NurseryStatusNotification('test', $request->status));
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function rates(RateNurseryRequest $request, Nursery $nursery)
    {
        $nursery->update(['rates' => $request->validated('rates')]);
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nursery $nurseries)
    {
        $nurseries->forceDelete();
        return messageResponse();
    }
}
