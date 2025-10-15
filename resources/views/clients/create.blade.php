@extends('layouts.app')
<link rel="stylesheet" href="{{ asset(path: 'styles/clientsCreate.css') }}">

@section('title', 'Ajouter un client')

@section('content')
<div class="container py-5 d-flex justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <!-- En-tête -->
                <div class="text-center mb-4">
                    <h1 class="h4 fw-bold text-primary mb-2">
                        <i class="bi bi-person-plus-fill me-2"></i> Ajouter un client
                    </h1>
                    <p class="text-muted mb-0">Remplissez les informations ci-dessous</p>
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
                <form action="{{ route('clients.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nom du client</label>
                        <input
                            type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label fw-semibold">Téléphone du client</label>
                        <input
                            type="text"
                            class="form-control @error('phone') is-invalid @enderror"
                            id="phone"
                            name="phone"
                            value="{{ old('phone') }}"
                            required>
                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold">Email du client</label>
                        <input
                            type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Boutons -->
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
                        <button type="submit" class="btn btn-primary w-100 w-sm-auto">
                            <i class="bi bi-check-circle"></i> Ajouter le client
                        </button>
                        <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary w-100 w-sm-auto">
                            <i class="bi bi-arrow-left"></i> Retour
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection