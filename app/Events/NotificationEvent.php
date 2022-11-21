<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationEvent implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(public $like)
	{
		$this->like = $like;
	}

	public function broadcastOn()
	{
		return new PrivateChannel('like-notification.' . $this->like['author_id']);
	}

	public function broadcastAs()
	{
		return 'notify-like';
	}
}
