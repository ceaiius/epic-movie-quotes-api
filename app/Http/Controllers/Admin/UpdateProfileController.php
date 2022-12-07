<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AddEmailRequest;
use App\Http\Requests\Auth\ProfileEditRequest;
use App\Mail\VerifySecondaryMail;
use App\Models\Email;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UpdateProfileController extends Controller
{
	public function index(ProfileEditRequest $request): JsonResponse
	{
		$attributes = $request->validated();
		$user = User::find(jwtUser()->id);
		if (isset($attributes['thumbnail']))
		{
			$attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
			$user->thumbnail = $attributes['thumbnail'];
		}

		if (isset($attributes['username']))
		{
			$user->username = $attributes['username'];
		}
		if (isset($attributes['password']))
		{
			$user->password = Hash::make($attributes['password']);
		}
		$user->save();
		return response()->json('profile updated', 200);
	}

	public function get(): JsonResponse
	{
		return response()->json(jwtUser()->emails, 200);
	}

	public function store(AddEmailRequest $request): JsonResponse
	{
		$attributes = $request->validated();

		$attributes['user_id'] = jwtUser()->id;
		$attributes['token'] = Str::random(60);
		$email = Email::create($attributes);
		Mail::to(jwtUser()->email)->send(new VerifySecondaryMail(jwtUser(), $email));
		return response()->json('Email added!', 200);
	}

	public function destroy(Email $email): JsonResponse
	{
		$email->delete();
		return response()->json($email, 200);
	}

	public function verify(Request $request): JsonResponse
	{
		$email = Email::where('user_id', jwtUser()->id)->where('token', $request->token)->first();

		$email->email_verified_at = Carbon::now();

		$email->save();

		return response()->json('email verified!', 200);
	}

	public function primary(Request $request): JsonResponse
	{
		$user = User::where('id', jwtUser()->id)->first();
		$email = Email::where('email', $request->email)->first();
		$email->email = $user->email;
		$email->save();
		$user->email = $request->email;
		$user->save();
		return response()->json('Primary email changed!', 200);
	}
}
