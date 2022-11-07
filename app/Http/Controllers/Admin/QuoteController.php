<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreQuoteRequest;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;

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
		return response()->json(Quote::with('author')->with('movies')->get(), 200);
	}

	public function store(StoreQuoteRequest $request)
	{
		$attributes = $request->validated();
		$attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
		$attributes['user_id'] = auth()->id();
		$quote = Quote::create($attributes);
		$this->translate($request, $quote);
	}
}
