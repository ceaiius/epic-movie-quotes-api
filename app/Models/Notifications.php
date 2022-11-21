<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
	use HasFactory;

	protected $fillable = ['user_id', 'quotes_id', 'from_id', 'for_id'];

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function quote()
	{
		return $this->belongsTo(Quote::class, 'quotes_id');
	}

	public function from()
	{
		return $this->belongsTo(User::class, 'from_id');
	}
}
