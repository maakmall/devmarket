<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signUp(SignUpRequest $request): UserResource
    {
        return User::create($request->validated())
            ->toResource()
            ->additional(['message' => 'User registered successfully']);
    }

    public function signIn(SignInRequest $request): UserResource | JsonResponse
    {
        if (!Auth::attempt($request->validated(), $request->boolean('remember'))) {
            return response()
                ->json(
                    ['message' => 'Email or password wrong'],
                    Response::HTTP_UNAUTHORIZED
                );
        }

        $request->session()->regenerate();

        return $request->user()
            ->toResource()
            ->additional(['message' => 'Signed in successfully']);
    }

    public function current(Request $request): UserResource
    {
        return $request->user()
            ->toResource()
            ->additional(['message' => 'Fetch authenticated user successfully']);
    }

    public function signOut(Request $request): JsonResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out successfully']);
    }

    public function update(UpdateUserRequest $request): UserResource
    {
        $request->user()->update($request->validated());

        return $request->user()
            ->toResource()
            ->additional(['message' => 'User updated successfully']);
    }
}
