<?php

namespace App\Http\Controllers\Admin;

use App\Events\AddLikeEvent;
use App\Events\NotificationEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreQuoteRequest;
use App\Http\Requests\Admin\UpdateQuoteRequest;
use App\Models\Notifications;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuoteController extends Controller
{
	private function translate($request, $quote)
	{
		$translate_name = ['en' => $request->name_en, 'ka' => $request->name_ka];
		$quote->setTranslations('name', $translate_name);
		$quote->save();
	}

	public function index(): JsonResponse
	{
		$quotes = Quote::with('author')->with('users')->with('movies')->with('comments.author')->withCount('users')->orderBy('created_at', 'desc')->paginate(2);
		return response()->json($quotes, 200);
	}

	public function search(Request $request): JsonResponse
	{
		$quotes = [];
		$search = $request->search;
		if ($search[0] == '@')
		{
			$search = ltrim($search, '@');
			$quotes = Quote::whereHas('movies', function ($query) use ($search) {
				$query
					->where('name->en', 'like', $search . '%')
					->orWhere('name->ka', 'like', $search . '%');
			})->get();
		}
		elseif ($search[0] == '#')
		{
			$search = ltrim($search, '#');
			$quotes = Quote::query()
				->where('name->en', 'like', $search . '%')
				->orWhere('name->ka', 'like', $search . '%')
				->get();
		}
		else
		{
			$quotes = Quote::whereHas('movies', function ($query) use ($search) {
				$query
					->where('name->en', 'like', $search . '%')->orWhere('name->ka', 'like', $search . '%');
			})->orwhere('name->en', 'like', $search . '%')
			->orwhere('name->ka', 'like', $search . '%')->get();
		}
		return response()->json($quotes->load('author')->load('users')->load('movies')->load('comments.author'));
	}

	public function check(Request $request)
	{
		$like = DB::table('quote_user')->where('user_id', jwtUser()->id)->where('quote_id', $request->quote_id)->first();

		return response()->json($like ? true : false);
	}

	public function like(Request $request)
	{
		event(new AddLikeEvent($request->all()));

		$like = DB::table('quote_user')
			->where('user_id', $request->user_id)
			->where('quote_id', $request->quote_id)
			->first();

		if (empty($like))
		{
			DB::table('quote_user')
			 ->insert(
			 	[
			 		'quote_id' => $request->quote_id,
			 		'user_id'  => $request->user_id,
			 	]
			 );
			if ($request->author_id !== jwtUser()->id)
			{
				event(new NotificationEvent($request->all()));
				Notifications::create([
					'for_id'   => $request->author_id,
					'from_id'  => $request->user_id,
					'quotes_id'=> $request->quote_id,
					'type'     => 'like',
					'read'     => false,
				]);
			}

			return response()->json(['message' => 'like'], 200);
		}
		else
		{
			DB::table('quote_user')
			->where('user_id', $request->user_id)
			->where('quote_id', $request->quote_id)
			->delete();
			return response()->json(['message' => 'unlike'], 200);
		}
	}

	public function get(): JsonResponse
	{
		return response()->json(Quote::with('author')->with('movies')->with('comments.author')->withCount('users')->orderBy('created_at', 'desc')->get(), 200);
	}

	public function show(Request $request): JsonResponse
	{
		return response()->json(Quote::query()->take($request->id)->with('author')->with('movies')->with('comments.author')->withCount('users')->orderBy('created_at', 'desc')->get(), 200);
	}

	public function store(StoreQuoteRequest $request): JsonResponse
	{
		$attributes = $request->validated();
		$attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
		$attributes['user_id'] = jwtUser()->id;
		$quote = Quote::create($attributes);
		$this->translate($request, $quote);
		return response()->json('Quote added!', 200);
	}

	public function update(Quote $quote, UpdateQuoteRequest $request): JsonResponse
	{
		$attributes = $request->validated();
		if (isset($attributes['thumbnail']))
		{
			$attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
		}

		$this->translate($request, $quote);
		$quote->update($attributes);
		return response()->json('Quote updated!', 200);
	}

	public function destroy(Quote $quote): JsonResponse
	{
		$quote->delete();

		return response()->json($quote, 200);
	}
}
