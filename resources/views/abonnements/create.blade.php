@extends('layouts.app')

@section('title', 'Ajouter un Abonnement')

@section('content')
<div class="container col-6">
    <h1>Ajouter un Abonnement</h1>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
 
    <form action="{{ route('abonnements.store') }}" method="POST">
    @csrf
    <!-- Champ caché pour user_id -->
    <input type="hidden" name="user_id" value="{{ $userId }}">

    <div class="mb-3">
        <label for="nom" class="form-label">Nom de l'Abonnement</label>
        <input type="text" class="form-control" id="nom" name="nom" required>
    </div>
    
    <div class="mb-3">
        <label for="prix" class="form-label">Prix de l'Abonnement</label>
        <input type="number" class="form-control" id="prix" name="prix" required>
    </div>

    <div class="mb-3">
        <label for="date_debut" class="form-label">Date de Début</label>
        <input type="date" class="form-control" id="date_debut" name="date_debut" required onchange="updateEndDate()">
    </div>

    <!-- Select pour le type de période -->
    <div class="mb-3">
        <label for="type_periode" class="form-label">Type de Période</label>
        <select id="type_periode" name="type_periode" class="form-select" onchange="updateEndDate()">
            <option value="">Sélectionnez une période</option>
            <option value="monthly">Mensuel</option>
            <option value="quarterly">Trimestriel</option>
            <option value="semiannual">Semestriel</option>
            <option value="annual">Annuel</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="date_fin" class="form-label">Date de Fin</label>
        <input type="date" class="form-control" id="date_fin" name="date_fin" required readonly>
    </div>

    <button type="submit" class="btn btn-primary">Ajouter Abonnement</button>
    <a href="{{ url()->previous() }}" class="btn btn-secondary">Retour</a>
</form>
</div>
@endsection
