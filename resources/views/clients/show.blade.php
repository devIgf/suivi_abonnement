@extends('layouts.app')
<link rel="stylesheet" href="{{ asset(path: 'styles/clientsShow.css') }}">

@section('content')

<div class="container py-4">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body text-center">
            <h1 class="card-title mb-3 text-primary fw-bold">
                Utilisateur : {{ $user->name }}
            </h1>
            <p class="text-muted mb-4">📧 {{ $user->email }}</p>

            <div class="d-flex flex-wrap justify-content-center gap-2">
                <a href="{{ route('abonnements.create', ['user_id' => $user->id]) }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Ajouter un abonnement
                </a>
                <a href="{{ route('accueil') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Retour
                </a>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h2 class="h5 mb-0 fw-bold">Liste des abonnements</h2>
        </div>
        <div class="card-body">
            @if ($abonnements->isEmpty())
            <p class="text-center text-muted">Aucun abonnement trouvé pour cet utilisateur.</p>
            @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>Nom</th>
                            <th>Date de début</th>
                            <th>Date de fin</th>
                            <th>Prix</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($abonnements as $abonnement)
                        @php
                        $dateFin = \Carbon\Carbon::parse($abonnement->date_fin);
                        $needsRenewal = $dateFin->lessThanOrEqualTo(now()->addDays(15));
                        @endphp
                        <tr class="{{ $needsRenewal ? 'table-warning' : '' }}">
                            <td>{{ $abonnement->nom }}</td>
                            <td>{{ $abonnement->date_debut }}</td>
                            <td>{{ $abonnement->date_fin }}</td>
                            <td>{{ number_format($abonnement->prix, 0, ',', ' ') }} FCFA</td>
                            <td class="text-center">
                                <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-2">

                                    <!-- Formulaire de renouvellement -->
                                    <form action="{{ route('abonnements.update', $abonnement) }}" method="POST" class="renewal-form d-flex align-items-center gap-2">
                                        @csrf
                                        @method('PUT')
                                        <select
                                            name="renewal_type"
                                            class="form-select form-select-sm renewal-select"
                                            style="width: 150px;"
                                            @if(!$needsRenewal)
                                            disabled
                                            title="Renouvellement disponible seulement si l'abonnement expire dans 15 jours"
                                            @else
                                            title="Choisissez un type de renouvellement"
                                            @endif>
                                            <option value="">Type de renouvellement</option>
                                            <option value="mensuel">Mensuel</option>
                                            <option value="trimestriel">Trimestriel</option>
                                            <option value="semestriel">Semestriel</option>
                                            <option value="annuel">Annuel</option>
                                        </select>

                                    </form>

                                    <!-- Formulaire de suppression -->
                                    <form action="{{ route('abonnements.destroy', $abonnement) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger delete-btn">
                                            <i class="bi bi-trash"></i> Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function() { // Assurez-vous que le DOM est chargé

        document.querySelectorAll('.renewal-select').forEach(select => {
            select.addEventListener('change', function(event) { // Écoute le changement de sélection
                event.preventDefault(); // Empêche la soumission immédiate du formulaire

                const form = this.closest('form');

                swal({
                    title: "Êtes-vous sûr de vouloir renouveler ?",
                    text: "Confirmez le type de renouvellement.",
                    type: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Oui, renouveler!",
                    cancelButtonText: "Annuler",
                    closeOnConfirm: false,
                    closeOnCancel: true
                }, (isConfirm) => { // Utilisation de la syntaxe de callback de SweetAlert 1.x
                    if (isConfirm) {
                        form.submit(); // Soumet le formulaire si l'utilisateur confirme
                    } else {
                        // Optionnel : Réinitialiser la sélection si l'utilisateur annule
                        select.value = "";
                    }
                });
            });
        });

    });
</script>

<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('form'); // Récupérer le formulaire parent
            swal({
                title: "Êtes-vous sûr ?",
                text: "Cette action supprimera définitivement cet abonnement.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Oui, supprimer",
                cancelButtonText: "Non, annuler",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function(isConfirm) {
                if (isConfirm) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection