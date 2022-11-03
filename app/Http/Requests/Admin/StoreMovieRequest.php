<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules()
	{
		return [
			'name_en'             => 'required',
			'name_ka'             => 'required',
			'director_en'         => 'required',
			'director_ka'         => 'required',
			'description_en'      => 'required',
			'description_ka'      => 'required',
			'genre'               => 'required',
			'year'                => 'required',
			'budget'              => 'required',
			'thumbnail'           => 'required|image',
		];
	}
}
