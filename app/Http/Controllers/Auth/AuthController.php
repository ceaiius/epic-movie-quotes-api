<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
	public function user()
	{
		return response()->json(jwtUser(), 200);
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

	// public function login(LoginRequest $request): JsonResponse
	// {
	// 	$token = auth()->attempt($request->all());
	// 	if ($token && isset(auth()->user()->email_verified_at))
	// 	{
	// 		return $this->respondWithToken($token);
	// 	}
	// 	elseif ($token && !isset(auth()->user()->email_verified_at))
	// 	{
	// 		return response()->json(['error' => 'Please verify your email'], 404);
	// 	}
	// 	if (!$token)
	// 	{
	// 		return response()->json(['error' => 'User Does not exist!'], 404);
	// 	}
	// }

	// /**
	//  * Get the token array structure.
	//  */
	// protected function respondWithToken(string $token): JsonResponse
	// {
	// 	return response()->json([
	// 		'access_token' => $token,
	// 		'token_type'   => 'bearer',
	// 		'expires_in'   => 60 * 24 * 60,
	// 	]);
	// }

	public function login(LoginRequest $request): JsonResponse
	{
		$authenticated = auth()->attempt(
			[
				'email'    => $request->email,
				'password' => $request->password,
			]
		);

		if (!$authenticated)
		{
			return response()->json('wrong email or password', 401);
		}

		$remember = 1440;
		if ($request->remember == 'yes')
		{
			$remember = 43800;
		}

		$payload = [
			'exp' => Carbon::now()->addHours(4)->timestamp,
			'uid' => User::where('email', request()->email)->first()->id,
		];

		$jwt = JWT::encode($payload, config('auth.jwt_secret'), 'HS256');

		$cookie = cookie('access_token', $jwt, $remember, '/', config('auth.front_end_top_level_domain'), true, true, false, 'Strict');

		return response()->json('success', 200)->withCookie($cookie);
	}

	public function logout(): JsonResponse
	{
		$cookie = cookie('access_token', '', 0, '/', config('auth.front_end_top_level_domain'), true, true, false, 'Strict');

		return response()->json('success', 200)->withCookie($cookie);
	}

	public function me(): JsonResponse
	{
		return response()->json(
			[
				'message' => 'authenticated successfully',
				'user'    => jwtUser(),
			],
			200
		);
	}
}
