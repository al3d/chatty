<?php

namespace App\Notifications;

use App\Support\Url;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegisteredNotification extends Notification
{
    use Queueable;

    protected $password;

    public function __construct($password)
    {
        $this->generatedPassword = $password;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Welcome to chatty')
            ->line('Welcome to chatty, ' . $notifiable->name)
            ->line('We\'ve created a password for you:')
            ->line(sprintf('<b>%s</b>', $this->password))
            ->line('Keep it safe. You can change it in the app.')
            ->action('Visit Chatty', url(Url::frontend()))
            ->line('Thank you for joining!');
    }
}
