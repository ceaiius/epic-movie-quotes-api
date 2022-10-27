<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class VerifiedUser extends Middleware
{
	/**
	 * Get the path the user should be redirected to when they are not authenticated.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return string|null
	 */
	protected function redirectTo($request)
	{
		if (!$request->expectsJson())
		{
			$user = User::find($request->id);
			$user->markEmailAsVerified();
			return env('APP_URL');
		}
	}
}
