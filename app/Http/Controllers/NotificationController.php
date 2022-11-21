<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
	public function get(): JsonResponse
	{
		return response()->json(Auth::user()->notifications->load('from'), 200);
	}
}
