<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Movie extends Model
{
	use HasFactory;

	use HasTranslations;

	protected $guarded = ['id', 'name', 'director', 'description'];

	public $translatable = ['name', 'director', 'description'];

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function quotes()
	{
		return $this->hasMany(Quote::class);
	}

	public function comments()
	{
		return $this->hasMany(Comment::class);
	}
}
