<?php

namespace App\Http\Controllers;

use App\Http\Requests\Notifications\ForgetPasswordRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;

class ForgetPasswordController extends Controller
{
	public function show(ForgetPasswordRequest $request): JsonResponse
	{
		$request->validated();
		if (User::where('email', $request->email)->exists())
		{
			if ($request->email)
			{
				$status = Password::sendResetLink(
					$request->only('email')
				);
			}

			$status === Password::RESET_LINK_SENT
				? back()->with(['status' => __($status)])
				: back()->withErrors(['email' => __($status)]);

			return response()->json('Password reset link sent!', 200);
		}
		else
		{
			return response()->json('Email not found!', 404);
		}
	}
}
