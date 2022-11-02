<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMovieRequest;
use App\Models\Movie;

class MovieController extends Controller
{
	public function create()
	{
		return Movie::all();
	}

	public function store(StoreMovieRequest $request)
	{
		$attributes = $request->validated();
		$attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
		$attributes['user_id'] = auth()->id();

		Movie::create($attributes);
	}
}
