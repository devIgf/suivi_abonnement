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
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }



    // protected function schedule(Schedule $schedule)
    // {
    //     $schedule->call(function () {
    //         Log::info('Scheduler exécuté : envoi notifications');
    //         $abonnements = Abonnement::whereBetween('date_fin', [now(), now()->addDays(15)])->get();

    //         foreach ($abonnements as $abonnement) {
    //             $user = $abonnement->user;
    //             if ($user) {
    //                 $user->notify(new RappelEcheanceNotification($abonnement));
    //             }
    //         }
    //     })->everyMinute();
    // }



    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            Log::info('Scheduler exécuté : envoi notifications');

            // Envoi d'un mail test simple pour vérifier la config mail
            Mail::raw('Ceci est un mail de test envoyé depuis le scheduler Laravel.', function ($message) {
                $message->to('justeamour05@gmail.com')
                    ->subject('Test Mail depuis Scheduler Laravel');
            });

            // Votre code original d'envoi de notifications à vos abonnements
            $abonnements = Abonnement::whereBetween('date_fin', [now(), now()->addDays(15)])->get();
            foreach ($abonnements as $abonnement) {
                $user = $abonnement->user;
                if ($user) {
                    $user->notify(new RappelEcheanceNotification($abonnement));
                }
            }
        })->everyMinute();
    }
}


// php artisan tinker
// php artisan schedule:run
// $user = App\Models\User::find(2); // ID d'un utilisateur valide
// $user->notify(new App\Notifications\RappelEcheanceNotification(1));
