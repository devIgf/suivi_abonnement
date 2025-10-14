<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RappelEcheanceNotification extends Notification { 
    // use Queueable;

    protected $abonnement;

    public function __construct($abonnement) {
        $this->abonnement = $abonnement;
    }

    public function via($notifiable) {
        return ['mail']; // Indique que nous envoyons une notification par e-mail
    }

    public function toMail($notifiable): MailMessage
{
    $userName = $this->abonnement->user ? $this->abonnement->user->name : 'Cher utilisateur';

    return (new MailMessage)
        ->subject('Rappel d\'Échéance d\'Abonnement')
        ->greeting('Bonjour Bineta!')
        ->line('Ceci est un rappel concernant l\'abonnement : ' . $this->abonnement->nom . ' du client ' . $userName)
        ->line('Date de début : ' . $this->abonnement->date_debut)
        ->line('Date de fin : ' . $this->abonnement->date_fin)
        ->line('N\'oubliez pas de renouveler cet abonnement avant la date d\'échéance.')
        ->line('Merci d\'utiliser notre application!')
        ->salutation('Cordialement, L\'équipe IGF');
}
}
