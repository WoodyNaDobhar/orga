<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification implements ShouldQueue
{
	use Queueable;
	
	/**
	 * The password reset URL.
	 *
	 * @var string
	 */
	protected $url;

	/**
	 * Create a new notification instance.
	 */
	public function __construct(string $url)
	{
		$this->url = $url;
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @return array<int, string>
	 */
	public function via(object $notifiable): array
	{
		return ['mail'];
	}

	/**
	 * Get the mail representation of the notification.
	 */
	public function toMail(object $notifiable): MailMessage
	{
		return (new MailMessage)
			->subject("ORK4 Password Reset Request")
			->greeting("Hail, and Well Met " . $notifiable->persona->name . "!")
			->line("We have received a request to reset your password.  If this was you, please click the link below to continue the process.")
			->action("Reset Password", $this->url)
			->line("If you did not make this request, please disregard.  If it keeps happening let the ORK4 team know!")
			->salutation("Thanks! - Your ORK4 Team");
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(object $notifiable): array
	{
		return [
			//
		];
	}
}
