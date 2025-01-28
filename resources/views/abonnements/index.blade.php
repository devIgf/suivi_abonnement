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
                        <!-- Formulaire de renouvellement -->
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
    <!-- Bouton qui appelle la fonction confirmDelete -->
    <button type="button" class="btn btn-danger" onclick="confirmDelete(this)">Supprimer</button> 
</form>


                    </td>                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Script pour la confirmation du renouvellement -->
    <script>
// Confirmation pour le renouvellement
document.querySelectorAll('.renewal-form select').forEach(select => {
    select.addEventListener('change', function() {
        const renewalType = this.value;
        if (renewalType) {
            swal({
                title: "Confirmation",
                text: "Êtes-vous sûr de vouloir renouveler cet abonnement en tant que " + renewalType + " ?",
                icon: "warning",
                buttons: {
                    cancel: "Non",
                    confirm: {
                        text: "Oui",
                        value: true,
                        visible: true,
                        className: "",
                        closeModal: true
                    }
                }
            }).then((willRenew) => {
                if (willRenew) {
                    
                    select.form.submit();
                }
            });
        } else {
            // Alerte si aucune option n'est sélectionnée
            swal("Erreur", "Veuillez sélectionner un type de renouvellement.", "error");
        }
    });
});
    </script>


</div>

@endsection
