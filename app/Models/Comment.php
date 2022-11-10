<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	use HasFactory;

	protected $fillable = ['body', 'user_id'];

	public function quote()
	{
		return $this->belongsTo(Quote::class);
	}

	public function author()
	{
		return $this->belongsTo(User::class, 'user_id');
	}
}
