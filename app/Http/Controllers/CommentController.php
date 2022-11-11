<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
	public function store(StoreCommentRequest $request, Quote $quote): JsonResponse
	{
		$attributes = $request->validated();
		$attributes['user_id'] = auth()->id();
		$attributes['movie_id'] = $quote->movie_id;
		$quote->comments()->create($attributes);
		return response()->json('Comment posted!', 200);
	}

	public function destroy(Comment $comment): JsonResponse
	{
		$comment->delete();

		return response()->json($comment, 200);
	}
}
