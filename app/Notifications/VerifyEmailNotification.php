<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends Notification
{
	/**
	 * The callback that should be used to create the verify email URL.
	 *
	 * @var \Closure|null
	 */
	public static $createUrlCallback;

	/**
	 * The callback that should be used to build the mail message.
	 *
	 * @var \Closure|null
	 */
	public static $toMailCallback;

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
		$verificationUrl = $this->verificationUrl($notifiable);

		if (static::$toMailCallback)
		{
			return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
		}

		return $this->buildMailMessage($verificationUrl);
	}

	/**
	 * Get the verify email notification mail message for the given URL.
	 *
	 * @param string $url
	 *
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	protected function buildMailMessage($url)
	{
		return (new MailMessage)
			->subject(Lang::get('Verify Email Address'))
			->line(Lang::get('Please click the button below to verify your email address.'))
			->view('email-verification', ['url'=>$url]);
	}

	/**
	 * @codeCoverageIgnore
	 */
	protected function verificationUrl($notifiable)
	{
		if (static::$createUrlCallback)
		{
			return call_user_func(static::$createUrlCallback, $notifiable);
		}

		return URL::temporarySignedRoute(
			'verification.verify',
			Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
			[
				'id'     => $notifiable->getKey(),
				'hash'   => sha1($notifiable->getEmailForVerification()),
			],
		);
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
