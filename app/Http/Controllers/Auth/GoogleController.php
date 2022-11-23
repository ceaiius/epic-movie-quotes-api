<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
	public function redirect()
	{
		return Socialite::driver('google')->stateless()->redirect();
	}

	public function callbackGoogle()
	{
		try
		{
			$google_user = Socialite::driver('google')->stateless()->user();

			$user = User::firstWhere('email', $google_user->getEmail());

			if (!$user)
			{
				User::create([
					'username'  => $google_user->getName(),
					'email'     => $google_user->getEmail(),
				]);
				$payload = [
					'exp' => Carbon::now()->addDay(1)->timestamp,
					'uid' => User::where('email', $google_user->getEmail())->first()->id,
				];
				$jwt = JWT::encode($payload, config('auth.jwt_secret'), 'HS256');

				$cookie = cookie('access_token', $jwt, 30, '/', config('auth.front_end_top_level_domain'), true, true, false, 'Strict');

				return redirect(env('APP_URL') . 'home')->withCookie($cookie);
			}
			else
			{
				$payload = [
					'exp' => Carbon::now()->addDay(1)->timestamp,
					'uid' => User::where('email', $google_user->getEmail())->first()->id,
				];
				$jwt = JWT::encode($payload, config('auth.jwt_secret'), 'HS256');

				$cookie = cookie('access_token', $jwt, 30, '/', config('auth.front_end_top_level_domain'), true, true, false, 'Strict');

				return redirect(env('APP_URL') . 'home')->withCookie($cookie);
			}
		}
		catch(\Throwable $th)
		{
			dd('something ewnt wrong' . $th->getMessage());
		}
	}
}
