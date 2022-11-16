<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
	public function user()
	{
		return  Auth::user();
	}

	public function register(RegisterRequest $request): JsonResponse
	{
		$attributes = $request->validated();
		$attributes['password'] = bcrypt($attributes['password']);
		$user = User::create($attributes);
		Auth::login($user);
		event(new Registered($user));

		return response()->json('User successfuly registered!', 200);
	}

	public function login(LoginRequest $request): JsonResponse
	{
		$token = auth()->attempt($request->all());
		if ($token && isset(auth()->user()->email_verified_at))
		{
			return $this->respondWithToken($token);
		}
		elseif ($token && !isset(auth()->user()->email_verified_at))
		{
			return response()->json(['error' => 'Please verify your email'], 404);
		}
		if (!$token)
		{
			return response()->json(['error' => 'User Does not exist!'], 404);
		}
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
