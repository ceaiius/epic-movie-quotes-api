<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgetPasswordController;
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
	Route::post('/register', 'register')->name('register');
	Route::post('/login', 'login')->name('login');
	Route::get('/user', 'user')->name('user');
});

Route::controller(VerificationController::class)->group(function () {
	Route::get('email/verify', 'index')->name('verification.notice');
	Route::get('email/verify/{id}/{hash}', 'show')->middleware(['auth', 'signed'])->name('verification.verify');
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
