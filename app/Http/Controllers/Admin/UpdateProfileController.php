<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ProfileEditRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

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

		$user->username = $attributes['username'];
		$user->save();
		return response()->json('profile updated', 200);
	}
}
