<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;

class VerificationController extends Controller
{
	public function index(): JsonResponse
	{
		return  response()->json('email sent', 200);
	}

	public function show(EmailVerificationRequest $request): JsonResponse
	{
		$request->fulfill();
		return response()->json('Verified successfully', 200);
	}
}
