<?php

namespace App\Console;

use App\Models\Abonnement;
use App\Notifications\RappelEcheanceNotification;
use App\Notifications\RegroupementEcheanceNotification;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }



    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            Log::info('Scheduler exécuté : envoi notifications');

            // Récupération des abonnements (expire dans 15 jours OU déjà expirés)
            $abonnements = Abonnement::with('user')
                ->where('date_fin', '<=', now()->addDays(15))
                ->get();

            Log::info('Abonnements trouvés : ' . $abonnements->count());

            // Si des abonnements existent, envoyer UN SEUL mail groupé
            if ($abonnements->count() > 0) {
                // Préparer le contenu du mail
                $lignes = [];
                $lignes[] = "Bonjour Binet@,";
                $lignes[] = "";
                $lignes[] = "Vous avez " . $abonnements->count() . " abonnement(s) nécessitant votre attention :";
                $lignes[] = "";
                $lignes[] = str_repeat("-", 80);
                $lignes[] = "";

                foreach ($abonnements as $abonnement) {
                    $userName = $abonnement->user ? $abonnement->user->name : 'Client inconnu';
                    $joursRestants = now()->diffInDays($abonnement->date_fin, false);
                    $statut = $joursRestants >= 0
                        ? "expire dans {$joursRestants} jour(s)"
                        : "expiré depuis " . abs($joursRestants) . " jour(s)";

                    $lignes[] = "📌 CLIENT : {$userName}";
                    $lignes[] = "   Abonnement : {$abonnement->nom}";
                    $lignes[] = "   Date de fin : {$abonnement->date_fin} ({$statut})";
                    $lignes[] = "   Prix : " . number_format($abonnement->prix, 0, ',', ' ') . " FCFA";
                    $lignes[] = "";
                }

                $lignes[] = str_repeat("-", 80);
                $lignes[] = "";
                $lignes[] = "Merci de renouveler ces abonnements dès que possible.";
                $lignes[] = "";
                $lignes[] = "Cordialement,";
                $lignes[] = "Votre système de gestion d'abonnements";

                // Convertir le tableau en texte
                $contenu = implode("\n", $lignes);

                // Envoyer le mail directement à l'adresse du manager
                Mail::raw($contenu, function ($message) {
                    $message->to('justeamour05@gmail.com')  // Email au secretariat
                        ->subject('📋 Rappel d\'Échéance des Abonnements');
                });

                Log::info('Mail groupé envoyé au manager');
            } else {
                Log::info('Aucun abonnement à notifier');
            }
        })->everyMinute();
    }
}


// php artisan tinker
// php artisan schedule:run
// $user = App\Models\User::find(2); // ID d'un utilisateur valide
// $user->notify(new App\Notifications\RappelEcheanceNotification(1));
