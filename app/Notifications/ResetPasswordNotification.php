<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class ResetPasswordNotification extends Notification
{
	/**
	 * The password reset token.
	 *
	 * @var string
	 */
	public $token;

	/**
	 * The callback that should be used to create the reset password URL.
	 *
	 * @var (\Closure(mixed, string): string)|null
	 */
	public static $createUrlCallback;

	/**
	 * The callback that should be used to build the mail message.
	 *
	 * @var (\Closure(mixed, string): \Illuminate\Notifications\Messages\MailMessage)|null
	 */
	public static $toMailCallback;

	/**
	 * Create a notification instance.
	 *
	 * @param string $token
	 *
	 * @return void
	 */
	public function __construct($token)
	{
		$this->token = $token;
	}

	/**
	 * Get the notification's channels.
	 *
	 * @param mixed $notifiable
	 *
	 * @return array|string
	 */
	public function via($notifiable)
	{
		return ['mail'];
	}

	/**
	 * @codeCoverageIgnore
	 *
	 * @param mixed $notifiable
	 *
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable)
	{
		if (static::$toMailCallback)
		{
			return call_user_func(static::$toMailCallback, $notifiable, $this->token);
		}

		return $this->buildMailMessage($this->resetUrl($notifiable));
	}

	/**
	 * @param string $url
	 *
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	protected function buildMailMessage($url)
	{
		return (new MailMessage)
			->subject(Lang::get('Reset Password Notification'))
			->line(Lang::get('You are receiving this email because we received a password reset request for your account.'))
			->view('forgot-password', ['url'=>$url]);
	}

	/**
	 * @codeCoverageIgnore
	 */
	protected function resetUrl($notifiable)
	{
		if (static::$createUrlCallback)
		{
			return call_user_func(static::$createUrlCallback, $notifiable, $this->token);
		}

		return url(route('password.reset.get', [
			'token' => $this->token,
			'email' => $notifiable->getEmailForPasswordReset(),
		], false));
	}

	/**
	 * @codeCoverageIgnore
	 */
	public static function createUrlUsing($callback)
	{
		static::$createUrlCallback = $callback;
	}

	/**
	 * @codeCoverageIgnore
	 */
	public static function toMailUsing($callback)
	{
		static::$toMailCallback = $callback;
	}
}
