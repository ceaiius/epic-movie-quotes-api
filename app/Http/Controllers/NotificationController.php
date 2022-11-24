<?php

namespace App\Http\Controllers;

use App\Models\Notifications;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
	public function get(): JsonResponse
	{
		$notifications = jwtUser()->notifications->sortDesc()->load('from');
		return response()->json($notifications->values()->all(), 200);
	}

	public function index(Request $request)
	{
		foreach ($request->ids as $id)
		{
			Notifications::where('id', $id)->update(['read'=>true]);
		}
	}

	public function count()
	{
		$count = Notifications::where('for_id', jwtUser()->id)->where('read', 0)->count();
		return response()->json($count, 200);
	}
}
