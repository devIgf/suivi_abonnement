@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('styles/welcome.css') }}">

@section('content')
<div class="container py-4">

    <!-- En-tête avec logo et titre -->
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between mb-4">
        <div class="d-flex align-items-center gap-3 mb-3 mb-md-0">
            <img src="{{ asset('images/igf.PNG') }}" alt="Logo IGF" class="rounded shadow-sm" height="70" width="70">
            <h1 class="h3 fw-bold text-primary mb-0">Liste des Clients</h1>
        </div>

        <a href="{{ route('clients.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="bi bi-person-plus-fill"></i> Ajouter un Client
        </a>
    </div>

    <!-- Tableau des clients -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            @if ($clients->isEmpty())
            <p class="text-center text-muted py-4 mb-0">
                Aucun client trouvé pour le moment.
            </p>
            @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">Téléphone</th>
                            <th scope="col">Email</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                        <tr>
                            <td class="fw-semibold">{{ $client->name }}</td>
                            <td>{{ $client->phone ?? '—' }}</td>
                            <td>{{ $client->email ?? '—' }}</td>
                            <td class="text-center p-2">
                                <a href="{{ route('clients.show', $client) }}"
                                    class="btn btn-sm btn-outline-info d-inline-flex align-items-center gap-1">
                                    <i class="bi bi-eye"></i> Voir Plus
                                </a>

                                <!-- Bouton Supprimer avec SweetAlert -->
                                <form action="{{ route('clients.destroy', $client) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center gap-1 delete-btn">
                                        <i class="bi bi-trash"></i> Supprimer
                                    </button>
                                </form>
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
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form');
                swal({
                    title: "Êtes-vous sûr ?",
                    text: "Cette action supprimera définitivement ce client.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    confirmButtonText: "Oui, supprimer",
                    cancelButtonText: "Annuler",
                    closeOnConfirm: false
                }, function(isConfirm) {
                    if (isConfirm) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>


@endsection