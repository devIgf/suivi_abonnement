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
        // Log::info('Scheduler running at ' . now());
        $schedule->call(function () {
            // Récupérer les abonnements qui expirent dans 3 jours
            $abonnements = Abonnement::whereDate('date_fin', '<=', now()->addDays(7))->get();
    
            foreach ($abonnements as $abonnement) {
                Notification::route('mail', 'justeamour05@gmail.com') // Adresse e-mail destinataire
                    ->notify(new RappelEcheanceNotification($abonnement));
            }
        })->hourly(); // Assurez-vous que cette ligne est présente
    }
    
    

}
