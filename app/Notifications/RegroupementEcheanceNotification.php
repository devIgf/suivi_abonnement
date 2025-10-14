<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegroupementEcheanceNotification extends Notification
{
    // use Queueable; 

    protected $lines;


    /**
     * Create a new notification instance.
     */
    public function __construct($lines)
    {
        $this->lines = $lines;
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
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Rappel d\'Échéance des Abonnements')
            ->view('vendor.notifications.email', [
                'greeting' => 'Bonjour IGF!',
                'lines' => $this->lines
            ]);
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message_lines' => $this->lines,
        ];
    }
}
