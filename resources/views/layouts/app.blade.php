<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Suivi abonnements')</title>
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
        <script>
                function updateEndDate() {
                    const startDate = new Date(document.getElementById('date_debut').value);
                    const periodType = document.getElementById('type_periode').value;
                    let endDate;

                    switch (periodType) {
                        case 'monthly':
                            endDate = new Date(startDate.setMonth(startDate.getMonth() + 1));
                            break;
                        case 'quarterly':
                            endDate = new Date(startDate.setMonth(startDate.getMonth() + 3));
                            break;
                        case 'semiannual':
                            endDate = new Date(startDate.setMonth(startDate.getMonth() + 6));
                            break;
                        case 'annual':
                            endDate = new Date(startDate.setFullYear(startDate.getFullYear() + 1));
                            break;
                        default:
                            endDate = null; 
                    }

                    if (endDate) {
                        document.getElementById('date_fin').value = endDate.toISOString().split('T')[0];
                    } else {
                        document.getElementById('date_fin').value = ''; 
                    }
                }
        </script>
    </footer>
</body>
</html>
