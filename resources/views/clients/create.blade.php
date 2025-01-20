@extends('layouts.app')

@section('title', 'Ajouter un client')

@section('content')
<div class="container col-6">
    <h1>Ajouter un client</h1>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('clients.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nom du client</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Téléphone du client</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email du client</label>
            <input type="text" class="form-control" id="email" name="email" required>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter client</button>
        <a href="{{ route('clients.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection
