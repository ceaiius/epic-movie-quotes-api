<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
	public function store(StoreCommentRequest $request, Quote $quote): JsonResponse
	{
		$attributes = $request->validated();
		$attributes['user_id'] = auth()->id();
		$quote->comments()->create($attributes);
		return response()->json('Comment posted!', 200);
	}
}
