<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbonnementController;
use App\Http\Controllers\UserController;
use App\Models\Abonnement;
use Illuminate\Support\Facades\Mail;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/',  function () {
//     return view('welcome');
// });

Route::get('/', [UserController::class, 'index'])->name('accueil');

Route::resource('abonnements', AbonnementController::class);

Route::resource('clients', UserController::class);


// Route::get('/test-email', function () {
//     Mail::raw('Ceci est un test.', function ($message) {
//         $message->to('justeamour05@gmail.com')
//                 ->subject('Test Email');
//     });

//     return 'E-mail envoyé!';
// });



// Route::get('/test-update/{id}', function ($id) {
//     $abonnement = Abonnement::findOrFail($id);
//     $abonnement->date_fin = now()->addMonth(); 
//     $abonnement->save();
//     return "Abonnement mis à jour avec succès!";
// });
