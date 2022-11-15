<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeleteCommentEvent implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public $comment;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($comment)
	{
		$this->comment = $comment;
	}

	public function broadcastOn()
	{
		return new Channel('delete-comment-channel');
	}

	public function broadcastAs()
	{
		return 'delete-comment';
	}
}
