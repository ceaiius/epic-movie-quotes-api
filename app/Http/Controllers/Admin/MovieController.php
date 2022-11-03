<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMovieRequest;
use App\Models\Movie;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
	public function create()
	{
		return Auth::user()->movies;
	}

	public function store(StoreMovieRequest $request)
	{
		$attributes = $request->validated();
		$attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
		$attributes['user_id'] = auth()->id();
		$movie = Movie::create($attributes);
		$translate_name = ['en' => $request->name_en, 'ka' => $request->name_ka];
		$movie->setTranslations('name', $translate_name);
		$translate_director = ['en' => $request->director_en, 'ka' => $request->director_ka];
		$movie->setTranslations('director', $translate_director);
		$translate_description = ['en' => $request->description_en, 'ka' => $request->description_ka];
		$movie->setTranslations('description', $translate_description);
		$movie->save();
	}
}
