<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	use HasFactory;

	protected $fillable = ['body', 'user_id', 'movie_id', 'quote_id'];

	public function quote()
	{
		return $this->belongsTo(Quote::class, 'quote_id');
	}

	public function movie()
	{
		return $this->belongsTo(Movie::class, 'movie_id');
	}

	public function author()
	{
		return $this->belongsTo(User::class, 'user_id');
	}
}
