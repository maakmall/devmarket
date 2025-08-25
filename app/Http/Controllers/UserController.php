<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $validated = $request->validate([
            'pagesize' => 'nullable|integer|min:1'
        ]);

        $pageSize = $validated['pagesize'] ?? 10;

        $users = User::select(['id', 'name', 'email'])->paginate($pageSize);

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request): UserResource
    {
        return User::create($request->validated())
            ->toResource()
            ->additional(['message' => 'User registered successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): UserResource
    {
        return $user->toResource()
            ->additional(['message' => 'Fetched user detail successfully']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): UserResource
    {
        $user->update($request->validated());

        return $user->toResource()
            ->additional(['message' => 'User updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
