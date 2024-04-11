<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification implements ShouldQueue
{
	use Queueable;
	
	/**
	 * The password reset URL.
	 *
	 * @var string
	 */
	protected $name;
	protected $url;
	
	/**
	 * Create a new notification instance.
	 */
	public function __construct(string $name, string $url)
	{
		$this->name = $name;
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
			->subject("Welcome to ORK4!")
			->greeting("Hail, and Well Met " . $this->name . "!")
			->line("Your account has been successfully created. Sign in to your account to customize your persona profile, check your credits, communicate with your officers, give recommendations, and much more!")
			->action("Login to ORK4", config('app.url') . "/login")
			->line("We can't wait to see what you accomplish!")
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
