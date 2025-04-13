<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Configuration administrateur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 60px auto;
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-bottom: 10px;
        }

        .subtitle {
            color: #555;
            margin-bottom: 25px;
        }

        .btn {
            display: inline-block;
            margin: 10px 10px 0 0;
            background-color: black;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #333;
        }

        .logout {
            background-color: #c0392b;
            float: right;
        }

        .logout:hover {
            background-color: #992d22;
        }

        @media (max-width: 600px) {
            .btn {
                width: 100%;
                margin-bottom: 15px;
            }

            .logout {
                float: none;
                width: 100%;
                margin-top: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn logout">Se déconnecter</button>
        </form>

        <h1>Page Administrateur</h1>
        <p class="subtitle">Configuration des paramètres de sécurité</p>

        <a href="{{ route('clients.residentiels') }}" class="btn">Voir les clients résidentiels</a>
        <a href="{{ route('clients.affaires') }}" class="btn">Voir les clients d'affaires</a>
        <a href="{{ route('admin.users.create') }}" class="btn">Créer un utilisateur</a>
        <a href="{{ route('password.change') }}" class="btn">Modifier mot de passe</a>
        <a href="{{ route('admin.logs') }}" class="btn">🛡️ Journaux de sécurité</a>
        <a href="{{ route('home') }}" class="btn">⬅ Retour à l’accueil</a>

    </div>
</body>

</html>