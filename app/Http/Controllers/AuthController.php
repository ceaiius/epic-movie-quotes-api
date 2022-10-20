<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
	public function getUsers()
	{
		$username = Auth::user()->username;
		return $username;
	}

	public function register(RegisterRequest $request): JsonResponse
	{
		$attributes = $request->validated();
		$attributes['password'] = bcrypt($attributes['password']);
		$user = User::create($attributes);
		$user->save();

		return response()->json('User successfuly registered!', 200);
	}

	public function login(LoginRequest $request): JsonResponse
	{
		$token = auth()->attempt($request->all());
		if (!$token)
		{
			return response()->json(['error' => 'User Does not exist!'], 404);
		}

		return $this->respondWithToken($token);
	}

	public function user(): JsonResponse
	{
		return response()->json(auth()->user(), 200);
	}

	/**
	 * Get the token array structure.
	 */
	protected function respondWithToken(string $token): JsonResponse
	{
		return response()->json([
			'access_token' => $token,
			'token_type'   => 'bearer',
			'expires_in'   => 60 * 24 * 60,
		]);
	}
}
