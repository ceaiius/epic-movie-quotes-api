<?php

use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\QuoteController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ForgetPasswordController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(AuthController::class)->group(function () {
	Route::post('register', 'register')->name('register');
	Route::post('login', 'login')->name('login');
	Route::get('user', 'user')->name('user');
	Route::get('me', 'me')->middleware('jwt.auth')->name('me');
	Route::get('logout', 'logout')->middleware('jwt.auth')->name('logout');
	Route::post('update', 'update')->name('update');
});

Route::controller(VerificationController::class)->group(function () {
	Route::get('email/verify', 'index')->name('verification.notice');
	Route::get('email/verify/{id}/{hash}', 'show')->middleware(['auth.verified', 'signed'])->name('verification.verify');
});

Route::controller(ForgetPasswordController::class)
	->group(function () {
		Route::get('forgot-password', 'index')->name('password.request.get');
		Route::post('/forgot-password', 'show')->name('password.email.post');
	});

Route::controller(ResetPasswordController::class)
->group(function () {
	Route::get('/reset-password/{token}', 'index')->name('password.reset.get');
	Route::post('/reset-password', 'show')->name('password.update.post');
});

Route::controller(GoogleController::class)->middleware(['cors'])->group(function () {
	Route::get('auth/google', 'redirect')->name('google-auth');
	Route::get('google', 'callbackGoogle');
});

Route::controller(MovieController::class)->group(function () {
	Route::get('movies', 'index')->name('movies');
	Route::post('movies', 'store')->name('store.movies');
	Route::get('movies/{movie}', 'get')->name('get.movies');
	Route::delete('movies/{movie}', 'destroy')->name('delete.movies');
	Route::post('movies/{movie}', 'update')->name('update.movies');
});

Route::controller(QuoteController::class)->group(function () {
	Route::get('quotes', 'index')->name('quotes');
	Route::get('quotes-all', 'get')->name('all.quotes');
	Route::post('quotes', 'store')->name('store.quotes');
	Route::delete('quotes/{quote}', 'destroy')->name('delete.quotes');
	Route::post('quotes/{quote}', 'update')->name('update.quotes');
	Route::post('quotes-like', 'like')->name('like.quotes');
});

Route::controller(CommentController::class)->group(function () {
	Route::post('comment/{quote}', 'store')->name('store.comments');
	Route::delete('comment/{comment}', 'destroy')->name('delete.comments');
});

Route::controller(NotificationController::class)->group(function () {
	Route::get('notifications', 'get')->name('get.notifications');
	Route::post('notifications', 'index')->name('update.notifications');
	Route::get('notifications-count', 'count')->name('count.notifications');
});
