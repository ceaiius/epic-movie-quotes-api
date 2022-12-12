<?php

namespace App\Http\Controllers;

use App\Events\AddCommentEvent;
use App\Events\DeleteCommentEvent;
use App\Events\NotificationEvent;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Notifications;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
	public function store(StoreCommentRequest $request, Quote $quote): JsonResponse
	{
		$attributes = $request->validated();
		$attributes['user_id'] = jwtUser()->id;
		$attributes['movie_id'] = $quote->movie_id;
		$attributes['quote_id'] = $quote->id;

		if ($request->author_id !== jwtUser()->id)
		{
			event(new NotificationEvent($request->all()));
			Notifications::create([
				'for_id'   => $request->author_id,
				'from_id'  => $request->user_id,
				'quotes_id'=> $request->quote_id,
				'type'     => 'comment',
				'read'     => false,
			]);
		}

		$comment = Comment::create($attributes);
		event(new AddCommentEvent($comment->load('author')));
		return response()->json('Comment posted!', 200);
	}

	public function destroy(Comment $comment): JsonResponse
	{
		event(new DeleteCommentEvent($comment));
		$comment->delete();

		return response()->json($comment, 200);
	}
}
