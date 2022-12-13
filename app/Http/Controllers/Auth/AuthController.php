<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Email;
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

	public function login(LoginRequest $request): JsonResponse
	{
		$user = User::where('username', $request->email)->first();
		$email = Email::where('email', $request->email)->first();
		$unvalidated = User::where('email', $request->email)->first();

		if ($email)
		{
			if ($email->email_verified_at !== null)
			{
				$email = Email::where('email', $request->email)->first()->user->email;

				$authenticated = auth()->attempt(
					[
						'email'    => $email,
						'password' => $request->password,
					]
				);
			}
			else
			{
				return response()->json('Email is not verified!', 401);
			}
		}
		elseif ($user)
		{
			if ($user->email_verified_at == null)
			{
				return response()->json('Email is not verified', 401);
			}
			else
			{
				$authenticated = auth()->attempt(
					[
						'email'    => $user->email,
						'password' => $request->password,
					]
				);
			}
		}
		elseif ($unvalidated)
		{
			if ($unvalidated->email_verified_at == null)
			{
				return response()->json('Email is not verified', 401);
			}
			else
			{
				$authenticated = auth()->attempt(
					[
						'email'    => $user->email,
						'password' => $request->password,
					]
				);
			}
		}
		else
		{
			$authenticated = auth()->attempt(
				[
					'email'    => $request->email,
					'password' => $request->password,
				]
			);
		}

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
			'uid' => auth()->user()->id,
		];

		$jwt = JWT::encode($payload, config('auth.jwt_secret'), 'HS256');

		$cookie = cookie('access_token', $jwt, $remember, '/', config('auth.front_end_top_level_domain'), true, true, false);

		return response()->json('Successfully logged in! ', 200)->withCookie($cookie);
	}

	public function logout(): JsonResponse
	{
		$cookie = cookie('access_token', '', 0, '/', config('auth.front_end_top_level_domain'), true, true, false);

		return response()->json('Successfully logged out!', 200)->withCookie($cookie);
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
