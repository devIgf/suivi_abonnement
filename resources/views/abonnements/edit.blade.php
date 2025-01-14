@extends('layouts.app')

@section('title', 'Modifier l\'Abonnement')

@section('content')
<div class="container">
    <h1>Modifier l'Abonnement : {{ $abonnement->nom }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('abonnements.update', $abonnement) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="nom" class="form-label">Nom de l'Abonnement</label>
            <input type="text" class="form-control" id="nom" name="nom" value="{{ old('nom', $abonnement->nom) }}" required>
        </div>

        <div class="mb-3">
            <label for="date_debut" class="form-label">Date de Début</label>
            <input type="date" class="form-control" id="date_debut" name="date_debut" value="{{ old('date_debut', $abonnement->date_debut) }}" required>
        </div>

        <div class="mb-3">
            <label for="date_fin" class="form-label">Date de Fin</label>
            <input type="date" class="form-control" id="date_fin" name="date_fin" value="{{ old('date_fin', $abonnement->date_fin) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à Jour l'Abonnement</button>
        <a href="{{ route('abonnements.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection
