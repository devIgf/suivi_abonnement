@extends('layouts.app')

@section('content')
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
                        <tr>
                            <td>{{ $abonnement->nom }}</td>
                            <td>{{ $abonnement->date_debut }}</td>
                            <td>{{ $abonnement->date_fin }}</td>
                            <td>
    <form action="{{ route('abonnements.update', $abonnement) }}" method="POST" style="display:inline;" class="renewal-form">
        @csrf
        @method('PUT')
        <select name="renewal_type" class="form-control" style="display: inline-block; width: 120px; background-color: yellow;">
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
        @endif
    </div>

    
<!-- Script pour les confirmations -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>  -->


@endsection
 