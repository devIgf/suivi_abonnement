<?php

namespace App\Console;

use App\Models\Abonnement;
use App\Notifications\RappelEcheanceNotification;
use App\Notifications\RegroupementEcheanceNotification;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    // protected function schedule(Schedule $schedule): void
    // {
    //     // $schedule->command('inspire')->hourly();
    // }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }



    //Envois des e-mail à Diop
//     protected function schedule(Schedule $schedule) 
// {   
//     $schedule->call(function () {
//         $abonnements = Abonnement::whereDate('date_fin', '<=', now()->addDays(7))->get();

//          $destinataires = [
//             'justeamour05@gmail.com',
//             'adama.coulibaly@igf-sn.com'
//         ];

//         foreach ($abonnements as $abonnement) {
//             $user = $abonnement->user; 

//             if ($user) {
//                 Notification::route('mail', $destinataires) 
//                     ->notify(new RappelEcheanceNotification($abonnement));
//             } else {
//                 Log::warning('Aucun utilisateur associé pour l\'abonnement : ' . $abonnement->id);
//             }
//         }
//     })->everyTwoMinutes();
// }


protected function schedule(Schedule $schedule) 
{   
    $schedule->call(function () {
        // Récupérer tous les abonnements qui expirent dans 7 jours
        $abonnements = Abonnement::whereDate('date_fin', '<=', now()->addDays(7))->get();

        // Vérifiez s'il y a des abonnements à notifier
        if ($abonnements->isNotEmpty()) {
            // Construire le message
            $message = "Voici les abonnements qui arrivent à terme :\n\n";
            foreach ($abonnements as $abonnement) {
                $userName = $abonnement->user ? $abonnement->user->name : 'Cher utilisateur';
                $message .= "\n\n Abonnement : {$abonnement->nom}\n";
                $message .= "\n\n Client : {$userName}\n";
                $message .= "\n\n Prix : {$abonnement->prix} FCFA\n";
                $message .= "\n\n Date de début : {$abonnement->date_debut}\n";
                $message .= "\n\n Date de fin : {$abonnement->date_fin}\n\n";
            }

            // Envoyer l'e-mail avec tous les détails
            Notification::route('mail', 'justeamour05@gmail.com')
                ->notify(new RegroupementEcheanceNotification($message));
        }
    })->everyMinute();
}


    

}
