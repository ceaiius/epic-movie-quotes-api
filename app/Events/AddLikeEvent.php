<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AddLikeEvent implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public $like;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($like)
	{
		$this->like = $like;
	}

	public function broadcastOn()
	{
		return new Channel('like-channel');
	}

	public function broadcastAs()
	{
		return 'add-like';
	}
}
