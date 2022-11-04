<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMovieRequest;
use App\Http\Requests\Admin\UpdateMovieRequest;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
	public function index(): JsonResponse
	{
		return response()->json(Auth::user()->movies, 200);
	}

	public function get(Movie $movie): JsonResponse
	{
		return response()->json($movie, 200);
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

	public function update(Movie $movie, UpdateMovieRequest $request)
	{
		$attributes = $request->validated();
		$attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
		$translate_name = ['en' => $request->name_en, 'ka' => $request->name_ka];
		$movie->setTranslations('name', $translate_name);
		$translate_director = ['en' => $request->director_en, 'ka' => $request->director_ka];
		$movie->setTranslations('director', $translate_director);
		$translate_description = ['en' => $request->description_en, 'ka' => $request->description_ka];
		$movie->setTranslations('description', $translate_description);
		$movie->save();
		$movie->update($attributes);
	}

	public function destroy(Movie $movie): JsonResponse
	{
		$movie->delete();

		return response()->json($movie, 200);
	}
}
