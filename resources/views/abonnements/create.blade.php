@extends('layouts.app')

@section('title', 'Ajouter un Abonnement')

<link rel="stylesheet" href="{{ asset(path: 'styles/abonnementCreate.css') }}">

@section('content')
<div class="container py-5 d-flex justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <!-- En-tête -->
                <div class="text-center mb-4">
                    <h1 class="h4 fw-bold text-primary mb-2">
                        <i class="bi bi-calendar-plus me-2"></i> Ajouter un Abonnement
                    </h1>
                    <p class="text-muted mb-0">Remplissez les détails de l’abonnement</p>
                </div>

                <!-- Affichage des erreurs -->
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Erreur :</strong> Veuillez corriger les points suivants :
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                </div>
                @endif

                <!-- Formulaire -->
                <form action="{{ route('abonnements.store') }}" method="POST" id="abonnementForm" class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $userId }}">

                    <div class="mb-3">
                        <label for="nom" class="form-label fw-semibold">Nom de l'abonnement</label>
                        <input
                            type="text"
                            class="form-control @error('nom') is-invalid @enderror"
                            id="nom"
                            name="nom"
                            value="{{ old('nom') }}"
                            required>
                        @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="prix" class="form-label fw-semibold">Prix de l'abonnement (FCFA)</label>
                        <input
                            type="number"
                            class="form-control @error('prix') is-invalid @enderror"
                            id="prix"
                            name="prix"
                            value="{{ old('prix') }}"
                            min="0"
                            required>
                        @error('prix')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="date_debut" class="form-label fw-semibold">Date de début</label>
                        <input
                            type="date"
                            class="form-control @error('date_debut') is-invalid @enderror"
                            id="date_debut"
                            name="date_debut"
                            value="{{ old('date_debut') }}"
                            required
                            onchange="updateEndDate()">
                        @error('date_debut')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="type_periode" class="form-label fw-semibold">Type de période</label>
                        <select
                            id="type_periode"
                            name="type_periode"
                            class="form-select @error('type_periode') is-invalid @enderror"
                            required
                            onchange="updateEndDate()">
                            <option value="">Sélectionnez une période</option>
                            <option value="monthly">Mensuel</option>
                            <option value="quarterly">Trimestriel</option>
                            <option value="semiannual">Semestriel</option>
                            <option value="annual">Annuel</option>
                        </select>
                        @error('type_periode')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="date_fin" class="form-label fw-semibold">Date de fin</label>
                        <input
                            type="date"
                            class="form-control @error('date_fin') is-invalid @enderror"
                            id="date_fin"
                            name="date_fin"
                            value="{{ old('date_fin') }}"
                            readonly
                            required>
                        @error('date_fin')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Boutons -->
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
                        <button type="submit" class="btn btn-primary w-100 w-sm-auto">
                            <i class="bi bi-check-circle"></i> Ajouter l’abonnement
                        </button>
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary w-100 w-sm-auto">
                            <i class="bi bi-arrow-left"></i> Retour
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script JS pour calculer la date de fin -->
<script>
    function updateEndDate() {
        const startDate = document.getElementById('date_debut').value;
        const periodType = document.getElementById('type_periode').value;
        const endDateInput = document.getElementById('date_fin');

        if (!startDate || !periodType) {
            endDateInput.value = '';
            return;
        }

        let start = new Date(startDate);
        switch (periodType) {
            case 'monthly':
                start.setMonth(start.getMonth() + 1);
                break;
            case 'quarterly':
                start.setMonth(start.getMonth() + 3);
                break;
            case 'semiannual':
                start.setMonth(start.getMonth() + 6);
                break;
            case 'annual':
                start.setFullYear(start.getFullYear() + 1);
                break;
        }

        // Format YYYY-MM-DD
        const formatted = start.toISOString().split('T')[0];
        endDateInput.value = formatted;
    }
</script>

@endsection