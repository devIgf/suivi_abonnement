<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Abonnement;
use Illuminate\Support\Facades\Log;

class AbonnementController extends Controller
{
    public function index() {
        // $abonnements = Abonnement::whereDate('date_fin', '<=', now()->addDays(3))->get();
        // dd($abonnements);
        $abonnements = Abonnement::all();
        return view('abonnements.index', compact('abonnements'));
    }

    public function create(Request $request)
{
    // Récupérer l'user_id à partir des paramètres de requête (ou d'une autre source)
    $userId = $request->input('user_id');
    
    return view('abonnements.create', compact('userId'));
}


    public function store(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'date_debut' => 'required|date',
        'date_fin' => 'required|date',
        'user_id' => 'required|exists:users,id', // Validation pour s'assurer que l'utilisateur existe
    ]);

    // Créer un nouvel abonnement
    Abonnement::create([
        'nom' => $request->nom,
        'user_id' => $request->user_id, // Associer l'abonnement à l'utilisateur
        'date_debut' => $request->date_debut,
        'date_fin' => $request->date_fin,
    ]);

    return redirect()->route('clients.show', $request->user_id)->with('success', 'Abonnement ajouté avec succès.');
}

    public function edit(Abonnement $abonnement) {
        return view('abonnements.edit', compact('abonnement'));
    }

    public function update(Request $request, Abonnement $abonnement)
    {
        Log::info('Mise à jour d\'un abonnement', [
            'id' => $abonnement->id,
            'renewal_type' => $request->renewal_type,
        ]);
    
        $request->validate([
            'renewal_type' => 'nullable|string',
        ]);
    
        // Convertir date_fin en un objet Carbon
        $dateFin = \Carbon\Carbon::parse($abonnement->date_fin);
    
        // Calculer la nouvelle date de fin si un type de renouvellement est sélectionné
        if ($request->renewal_type) {
            switch ($request->renewal_type) {
                case 'mensuel':
                    $abonnement->date_fin = $dateFin->addMonth(); // Ajoute un mois à la date actuelle de l'abonnement
                    break;
                case 'trimestriel':
                    $abonnement->date_fin = $dateFin->addMonths(3); // Ajoute trois mois
                    break;
                case 'semestriel':
                    $abonnement->date_fin = $dateFin->addMonths(6); // Ajoute six mois
                    break;
                case 'annuel':
                    $abonnement->date_fin = $dateFin->addYear(); // Ajoute un an
                    break;
            }
        }
    
        // Sauvegarder les modifications
        $abonnement->save();
    
        return redirect()->route('abonnements.index')->with('success', 'Abonnement mis à jour avec succès.');
    }
    

    


    public function destroy(Abonnement $abonnement) {
        $abonnement->delete();
        return redirect()->route('abonnements.index')->with('success', 'Abonnement supprimé avec succès.');
    }
}
