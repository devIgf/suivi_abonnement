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
        <div class="mb-3">
            <label for="nom" class="form-label">Nom de l'Abonnement</label>
            <input type="text" class="form-control" id="nom" name="nom" required>
        </div>

        <div class="mb-3">
            <label for="date_debut" class="form-label">Date de Début</label>
            <input type="date" class="form-control" id="date_debut" name="date_debut" required>
        </div>

        <div class="mb-3">
            <label for="date_fin" class="form-label">Date de Fin</label>
            <input type="date" class="form-control" id="date_fin" name="date_fin" required>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter Abonnement</button>
        <a href="{{ route('abonnements.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection
