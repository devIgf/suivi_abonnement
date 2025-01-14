<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RappelEcheanceNotification extends Notification implements ShouldQueue {
    use Queueable;

    protected $abonnement;

    public function __construct($abonnement) {
        $this->abonnement = $abonnement;
    }

    public function via($notifiable) {
        return ['mail']; // Indique que nous envoyons une notification par e-mail
    }

    public function toMail($notifiable): MailMessage {
        return (new MailMessage)
            ->subject('Rappel d\'Échéance d\'Abonnement') // Sujet de l'e-mail
            ->greeting('Bonjour!')
            ->line('Ceci est un rappel concernant votre abonnement : ' . $this->abonnement->nom)
            ->line('Date de début : ' . $this->abonnement->date_debut)
            ->line('Date de fin : ' . $this->abonnement->date_fin)
            ->line('N\'oubliez pas de renouveler votre abonnement avant la date d\'échéance.')
            ->action('Voir Détails', url('/abonnements/' . $this->abonnement->id)) // Lien vers les détails de l'abonnement
            ->line('Merci d\'utiliser notre application!');
    }
}
