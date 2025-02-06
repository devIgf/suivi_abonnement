<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rappel d'Échéance</title>
</head>
<body style="justify-content:center;font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2 style="color: #0056b3;">{{ $greeting ?? 'Bonjour!' }}</h2>

    <p>Voici les abonnements qui arrivent à échéance :</p>

    @foreach ($lines as $line)
        @if (str_starts_with($line, 'Abonnement :'))
            <p><strong>{{ $line }}</strong></p>
        @else
            <p>{{ $line }}</p>
        @endif
    @endforeach

    <p><i>Merci d'utiliser notre application!</i></p>

    <hr>
    <p style="font-size: 12px; color: #666;">Ceci est un email automatique, merci de ne pas y répondre.</p>
</body>
</html>
