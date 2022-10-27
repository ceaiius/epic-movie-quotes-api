<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
	public function redirect()
	{
		return Socialite::driver('google')->redirect();
	}

	public function callbackGoogle()
	{
		try
		{
			$google_user = Socialite::driver('google')->user();

			$user = User::firstWhere('email', $google_user->getEmail());

			if (!$user)
			{
				$new_user = User::create([
					'username'  => $google_user->getName(),
					'email'     => $google_user->getEmail(),
				]);

				$token = Auth::login($new_user);
				$expires_in = auth('api')->factory()->getTTL() * 60;

				return redirect(env('APP_URL') . "redirect?token={$token}&expires_in={$expires_in}");
			}
			else
			{
				$token = Auth::login($user);
				$expires_in = auth('api')->factory()->getTTL() * 60;

				return redirect(env('APP_URL') . "redirect?token={$token}&expires_in={$expires_in}");
			}
		}
		catch(\Throwable $th)
		{
			dd('something ewnt wrong' . $th->getMessage());
		}
	}
}
