<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Journaux de sécurité</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        table,
        th,
        td {
            border: 1px solid #ccc;
        }

        th {
            background-color: #f7f7f7;
            padding: 12px;
            text-align: left;
        }

        td {
            padding: 10px;
        }

        .back-button {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <h1>Journaux de sécurité</h1>

    <table>
        <thead>
            <tr>
                <th>Utilisateur</th>
                <th>Événement</th>
                <th>Détails</th>
                <th>IP</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td>{{ $log->user->name ?? 'Utilisateur supprimé' }}</td>
                    <td>{{ $log->event }}</td>
                    <td>{{ $log->details }}</td>
                    <td>{{ $log->ip }}</td>
                    <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="back-button">
        <a href="{{ route('home') }}">
            <button>⬅ Retour à l’accueil</button>
        </a>
    </div>
</body>

</html>