<?php

namespace App\Http\Controllers;

use App\Models\Notifications;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
	public function get(): JsonResponse
	{
		$notifications = Auth::user()->notifications->sortDesc()->load('from');
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
		$count = Notifications::where('read', 0)->count();
		return response()->json($count, 200);
	}
}