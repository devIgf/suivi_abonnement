<?php

namespace App\Console;

use App\Models\Abonnement;
use App\Notifications\RappelEcheanceNotification;
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
    protected function schedule(Schedule $schedule) 
{   
    $schedule->call(function () {
        // Récupérer les abonnements qui expirent dans 7 jours
        $abonnements = Abonnement::whereDate('date_fin', '<=', now()->addDays(7))->get();

         // Liste des destinataires
         $destinataires = [
            'justeamour05@gmail.com',
        ];

        foreach ($abonnements as $abonnement) {
            // Récupérer l'utilisateur associé à l'abonnement
            $user = $abonnement->user; // Cela suppose que la relation est définie

            if ($user) { // Vérifiez si l'utilisateur existe
                // Envoyer la notification à l'adresse e-mail codée en dur
                Notification::route('mail', $destinataires) // Adresse e-mail destinataire
                    ->notify(new RappelEcheanceNotification($abonnement));
            } else {
                Log::warning('Aucun utilisateur associé pour l\'abonnement : ' . $abonnement->id);
            }
        }
    })->everyTwoMinutes();
}


    
    

}
