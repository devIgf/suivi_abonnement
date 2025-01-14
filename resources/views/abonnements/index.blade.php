@extends('layouts.app')

@section('title', 'Mes Abonnements')

@section('content')
    <div class="container">
        <h1>Mes Abonnements</h1>
        <a href="{{ route('abonnements.create') }}" class="btn btn-primary">Ajouter un Abonnement</a>
        
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
                    <tr>
                        <td>{{ $abonnement->nom }}</td>
                        <td>{{ $abonnement->date_debut }}</td>
                        <td>{{ $abonnement->date_fin }}</td>
                        <td>
    <form action="{{ route('abonnements.update', $abonnement) }}" method="POST" style="display:inline;" class="renewal-form">
        @csrf
        @method('PUT')
        <select name="renewal_type" class="form-control color-danger" style="display: inline-block; width: 120px; background-color: yellow;">
            <option value="">Sélectionnez un type</option>
            <option value="mensuel">Mensuel</option>
            <option value="trimestriel">Trimestriel</option>
            <option value="semestriel">Semestriel</option>
            <option value="annuel">Annuel</option>
        </select>
    </form>

    <!-- Formulaire de suppression -->
    <form action="{{ route('abonnements.destroy', $abonnement) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Supprimer</button>
    </form>
</td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Script pour les confirmations -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script> 
        <script>
            // Confirmation pour le renouvellement
            document.querySelectorAll('.renewal-form select').forEach(select => {
    select.addEventListener('change', function() {
        const renewalType = this.value;
        if (renewalType) {
            swal({
                title: "Confirmation",
                text: "Êtes-vous sûr de vouloir renouveler cet abonnement en tant que " + renewalType + " ?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Oui",
                cancelButtonText: "Non",
                closeOnConfirm: false
            }, function() {
                // Soumettre le formulaire si l'utilisateur confirme
                select.form.submit();
            });
        } else {
            // Alerte si aucune option n'est sélectionnée
            swal("Erreur", "Veuillez sélectionner un type de renouvellement.", "error");
        }
    });
});



            // Confirmation pour la suppression
            document.querySelectorAll('.delete-button').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form'); // Récupère le formulaire parent
                    swal({
                        title: "Êtes-vous sûr ?",
                        text: "Vous ne pourrez pas récupérer cet abonnement !",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Oui, supprimer !",
                        cancelButtonText: "Non, annuler !",
                        closeOnConfirm: false
                    }, function() {
                        form.submit(); // Soumet le formulaire si l'utilisateur confirme
                    });
                });
            });
        </script>

    </div>
@endsection
