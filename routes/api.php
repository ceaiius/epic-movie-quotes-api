<?php

use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\QuoteController;
use App\Http\Controllers\Admin\UpdateProfileController;
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
});

Route::controller(VerificationController::class)->group(function () {
	Route::get('email/verify', 'index')->name('verification.notice');
	Route::get('email/verify/{id}/{hash}', 'show')->middleware(['auth.verified', 'signed'])->name('verification.verify');
});

Route::post('/forgot-password', [ForgetPasswordController::class, 'show'])->name('password.email.post');

Route::controller(ResetPasswordController::class)
->group(function () {
	Route::get('/reset-password/{token}', 'index')->name('password.reset.get');
	Route::post('/reset-password', 'show')->name('password.update.post');
});

Route::controller(GoogleController::class)->middleware(['cors'])->group(function () {
	Route::get('auth/google', 'redirect')->name('google.auth');
	Route::get('google', 'callbackGoogle')->name('google.callback');
});

Route::middleware('jwt.auth')->group(function () {
	Route::controller(MovieController::class)->group(function () {
		Route::get('movies', 'index')->name('movies');
		Route::post('movies', 'store')->name('movies.store');
		Route::get('movies/{movie}', 'get')->name('movies.get');
		Route::delete('movies/{movie}', 'destroy')->name('movies.destroy');
		Route::post('movies/{movie}', 'update')->name('movies.update');
	});

	Route::controller(QuoteController::class)->group(function () {
		Route::get('quotes', 'index')->name('quotes');
		Route::get('quotes-all', 'get')->name('quotes.all');
		Route::post('quotes', 'store')->name('quotes.store');
		Route::delete('quotes/{quote}', 'destroy')->name('quotes.destroy');
		Route::post('quotes/{quote}', 'update')->name('quotes.update');
		Route::post('quotes-like', 'like')->name('quotes.like');
		Route::post('check', 'check')->name('quotes.check');
		Route::post('quotes-show', 'show')->name('quotes.show');
	});

	Route::controller(CommentController::class)->group(function () {
		Route::post('comment/{quote}', 'store')->name('comments.store');
		Route::delete('comment/{comment}', 'destroy')->name('comments.destroy');
	});

	Route::controller(NotificationController::class)->group(function () {
		Route::get('notifications', 'get')->name('notifications.get');
		Route::post('notifications', 'index')->name('notifications.update');
		Route::get('notifications-count', 'count')->name('notifications.count');
	});

	Route::controller(UpdateProfileController::class)->group(function () {
		Route::post('update', 'index')->name('update');
		Route::post('emails-store', 'store')->name('emails.store');
		Route::get('emails', 'get')->name('emails.get');
		Route::delete('emails/{email}', 'destroy')->name('emails.destroy');
		Route::post('emails-verify', 'verify')->name('emails.verify');
		Route::post('emails-primary', 'primary')->name('emails.primary');
	});
});
