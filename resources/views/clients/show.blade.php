@extends('layouts.app')

@section('content')
<style>
    .expiring-soon {
        background-color: bisque;
    }

    select[disabled] {
        background-color: rgb(143, 0, 0);
        /* Grise la couleur */
        cursor: not-allowed;
        /* Change le curseur */
        opacity: 0.6;
        /* Réduit l'opacité */
    }
</style>
<div class="container">
    <h1>Détails de l'Utilisateur : {{ $user->name }}</h1>
    <p>Email : {{ $user->email }}</p>

    <a href="{{ route('abonnements.create', ['user_id' => $user->id]) }}" class="btn btn-primary">Ajouter un Abonnement</a>
    <a href="{{ route('accueil') }}" class="btn btn-secondary">Retour</a>

    <h2>Abonnements</h2>
    @if ($abonnements->isEmpty())
    <p>Aucun abonnement trouvé pour cet utilisateur.</p>
    @else
    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Date de Début</th>
                <th>Date de Fin</th>
                <th>Prix</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($abonnements as $abonnement)
            @php
            $dateFin = \Carbon\Carbon::parse($abonnement->date_fin);
            $isExpiringSoon = $dateFin->diffInDays(now()) <= 15;
                @endphp
                <tr class="{{ $isExpiringSoon ? 'expiring-soon' : '' }}">
                <td>{{ $abonnement->nom }}</td>
                <td>{{ $abonnement->date_debut }}</td>
                <td>{{ $abonnement->date_fin }}</td>
                <td>{{ $abonnement->prix }}</td>
                <td>
                    <form action="{{ route('abonnements.update', $abonnement) }}" method="POST" style="display:inline;" class="renewal-form">
                        @csrf
                        @method('PUT')
                        <select name="renewal_type" class="form-control renewal-select" {{-- Ajout de la classe 'renewal-select' --}}
                            style="display: inline-block; width: 120px;"
                            {{ $isExpiringSoon ? '' : 'disabled' }}
                            title="{{ $isExpiringSoon ? '' : 'Le renouvellement ne peut être effectué que si l\'abonnement expire dans 7 jours ou moins.' }}">
                            <option value="">Sélectionnez un type</option>
                            <option value="mensuel">Mensuel</option>
                            <option value="trimestriel">Trimestriel</option>
                            <option value="semestriel">Semestriel</option>
                            <option value="annuel">Annuel</option>
                        </select>
                    </form>

                    <!-- Formulaire de suppression -->
                    <form action="{{ route('abonnements.destroy', $abonnement) }}" method="POST" class="delete-form" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger delete-btn">Supprimer</button>
                    </form>
                </td>
                </tr>
                @endforeach
        </tbody>

    </table>

    @endif
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