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
            Log::info('=== DEBUT Scheduler ===');

            // Mail de test
            Mail::raw('Ceci est un mail de test envoyé depuis le scheduler Laravel.', function ($message) {
                $message->to('justeamour05@gmail.com')
                    ->subject('Test Mail depuis Scheduler Laravel');
            });
            Log::info('Mail de test envoyé');

            // Recherche des abonnements
            $abonnements = Abonnement::whereBetween('date_fin', [now(), now()->addDays(15)])->get();
            Log::info('Abonnements trouvés : ' . $abonnements->count());

            foreach ($abonnements as $abonnement) {
                $user = $abonnement->user;
                Log::info('Abonnement ID: ' . $abonnement->id . ', Nom: ' . $abonnement->nom . ', Date fin: ' . $abonnement->date_fin);

                if ($user) {
                    Log::info('Envoi notification à : ' . $user->email);
                    $user->notify(new RappelEcheanceNotification($abonnement));
                    Log::info('Notification envoyée avec succès');
                } else {
                    Log::warning('Pas d\'utilisateur pour l\'abonnement ID: ' . $abonnement->id);
                }
            }

            Log::info('=== FIN Scheduler ===');
        })->everyMinute();
    }
}


// php artisan tinker
// php artisan schedule:run
// $user = App\Models\User::find(2); // ID d'un utilisateur valide
// $user->notify(new App\Notifications\RappelEcheanceNotification(1));
