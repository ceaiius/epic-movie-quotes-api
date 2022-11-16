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
	private function translate($request, $movie)
	{
		$translate_name = ['en' => $request->name_en, 'ka' => $request->name_ka];
		$movie->setTranslations('name', $translate_name);
		$translate_director = ['en' => $request->director_en, 'ka' => $request->director_ka];
		$movie->setTranslations('director', $translate_director);
		$translate_description = ['en' => $request->description_en, 'ka' => $request->description_ka];
		$movie->setTranslations('description', $translate_description);
		$movie->save();
	}

	public function index(): JsonResponse
	{
		return response()->json(Auth::user()->movies->load('comments'), 200);
	}

	public function get(Movie $movie): JsonResponse
	{
		return response()->json($movie, 200);
	}

	public function store(StoreMovieRequest $request): JsonResponse
	{
		$attributes = $request->validated();
		$attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
		$attributes['user_id'] = auth()->id();
		$movie = Movie::create($attributes);
		$this->translate($request, $movie);
		return response()->json('Movie added!', 200);
	}

	public function update(Movie $movie, UpdateMovieRequest $request): JsonResponse
	{
		$attributes = $request->validated();
		$attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
		$this->translate($request, $movie);
		$movie->update($attributes);
		return response()->json('Movie updated!', 200);
	}

	public function destroy(Movie $movie): JsonResponse
	{
		$movie->delete();

		return response()->json($movie, 200);
	}
}