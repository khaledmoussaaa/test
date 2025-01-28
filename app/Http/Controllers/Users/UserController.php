<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::where('nursery_id', $request->nursery_id)->whereHasRole(['admin', 'teacher'])->paginate(10);
        return contentResponse($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $user = User::create($request->validated() + ['password' => '12345test']);
        $user->syncRoles($request->safe()->only('role'));
        $user->syncPermissions($request->validated('managments'));
        return messageResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return contentResponse($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());
        if ($request->has('managments')) {
            $user->syncPermissions($request->validated('managments'));
        }
        return messageResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->forceDelete();
        return messageResponse();
    }
}
