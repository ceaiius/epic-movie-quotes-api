<?php

namespace App\Http\Controllers;

use App\Http\Requests\Notifications\ForgetPasswordRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;

class ForgetPasswordController extends Controller
{
	public function index(): JsonResponse
	{
		return  response()->json('email sent', 200);
	}

	public function show(ForgetPasswordRequest $request): JsonResponse
	{
		$request->validated();

		$status = Password::sendResetLink(
			$request->only('email')
		);

		$status === Password::RESET_LINK_SENT
			? back()->with(['status' => __($status)])
			: back()->withErrors(['email' => __($status)]);

		return response()->json('Password changed!!!!');
	}
}
