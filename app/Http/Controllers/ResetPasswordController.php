<?php

namespace App\Http\Controllers;

use App\Http\Requests\Notifications\ResetPasswordRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
	public function index($token)
	{
		return redirect(env('APP_URL') . '?token=' . $token . '&email=' . request()->email);
	}

	public function show(ResetPasswordRequest $request): RedirectResponse
	{
		$request->validated();

		$status = Password::reset(
			$request->only('email', 'password', 'password_confirmation', 'token'),
			function ($user, $password) {
				$user->forceFill([
					'password' => Hash::make($password),
				])->setRememberToken(Str::random(60));

				$user->save();

				event(new PasswordReset($user));
			}
		);

		return $status === Password::PASSWORD_RESET
					? redirect(env('APP_URL'))->with('status', __($status))
					: back()->withErrors(['email' => [__($status)]]);
	}
}
