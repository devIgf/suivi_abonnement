<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mon Application Laravel')</title>
    <!-- Incluez vos fichiers CSS ici -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

</head>
<body>
    <header>
        <!-- Navigation ou d'autres éléments d'en-tête -->
    </header>

    <main class="my-4">
        @yield('content') <!-- Contenu spécifique à chaque vue -->
    </main>

    <footer class="container text-center my-4">
        <p>&copy; {{ date('Y') }} IGF-Sn. Tous droits réservés.</p>
    </footer>
</body>
</html>
