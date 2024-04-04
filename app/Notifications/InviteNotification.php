<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InviteNotification extends Notification implements ShouldQueue
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
			->subject("You have been invited to ORK4!")
			->greeting("Hail, and Well Met " . $this->name . "!")
			->line("Your invitation to join the online community of Amtgard has arrived!  Click the link below to register and claim your Persona.")
			->action("Claim Your Persona", $this->url)
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
