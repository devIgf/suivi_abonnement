@extends('layouts.app')

@section('content')
<style>
    .expiring-soon {
    background-color:orange;
}

select[disabled] {
    background-color:rgb(143, 0, 0); /* Grise la couleur */
    cursor: not-allowed; /* Change le curseur */
    opacity: 0.6; /* Réduit l'opacité */
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
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($abonnements as $abonnement)
        @php
            // Vérifier si la date de fin est dans 7 jours ou moins
            $dateFin = \Carbon\Carbon::parse($abonnement->date_fin);
            $isExpiringSoon = $dateFin->diffInDays(now()) <= 7 && $dateFin->isFuture();
        @endphp
        <tr class="{{ $isExpiringSoon ? 'expiring-soon' : '' }}">
            <td>{{ $abonnement->nom }}</td>
            <td>{{ $abonnement->date_debut }}</td>
            <td>{{ $abonnement->date_fin }}</td>
            <td>
                <form action="{{ route('abonnements.update', $abonnement) }}" method="POST" style="display:inline;" class="renewal-form">
                    @csrf
                    @method('PUT')
                    <select name="renewal_type" class="form-control" 
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
 