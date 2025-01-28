<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        $clients = User::all();
        return view('welcome', compact('clients'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $abonnements = $user->abonnements;
        
        return view('clients.show', compact('user', 'abonnements'));
    }


    public function create() {
        return view('clients.create');
    }


    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            
        ]);

        User::create($request->all());
        return redirect()->route('clients.index')->with('success', 'Client ajouté avec succès.');
    }



    public function destroy(User $client) {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'client supprimé avec succès.');
    }

}
