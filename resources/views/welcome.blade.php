@extends('layouts.app')

@section('content')
    <div class="container">
        <img src="images/igf.PNG" alt="" height="100" width="100">
        <h1>Liste des Clients</h1>
        <a href="{{ route('clients.create') }}" class="btn btn-primary">Ajouter un Client</a>
        
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)
                    <tr>
                        <td>{{ $client->name }}</td>
                        <td>{{ $client->phone }}</td>
                        <td>{{ $client->email }}</td>
                        <td>
                            <a href="{{ route('clients.show', $client) }}" class="btn btn-info">Voir Plus</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
