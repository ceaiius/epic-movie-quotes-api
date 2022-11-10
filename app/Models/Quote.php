<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Quote extends Model
{
	use HasFactory;

	use HasTranslations;

	protected $fillable = ['movie_id', 'user_id', 'thumbnail', 'name'];

	protected $guarded = ['id', 'name', 'movie_id'];

	public $translatable = ['name'];

	public function author()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function movies()
	{
		return $this->belongsTo(Movie::class, 'movie_id');
	}

	public function comments()
	{
		return $this->hasMany(Comment::class, 'quote_id');
	}
}
