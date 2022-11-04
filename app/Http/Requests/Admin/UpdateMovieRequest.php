<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMovieRequest extends FormRequest
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
			'name_en'             => 'nullable',
			'name_ka'             => 'nullable',
			'director_en'         => 'nullable',
			'director_ka'         => 'nullable',
			'description_en'      => 'nullable',
			'description_ka'      => 'nullable',
			'genre'               => 'nullable',
			'year'                => 'nullable',
			'budget'              => 'nullable',
			'thumbnail'           => 'nullable|image',
		];
	}
}
