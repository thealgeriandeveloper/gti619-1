<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
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

        .badge {
            background-color: #e74c3c;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 14px;
            margin-left: 10px;
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

        .button-group {
            margin-top: 30px;
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

        <h1>Bienvenue {{ auth()->user()->name }}
            @if(auth()->user()->role === 'admin')
                <span class="badge">Admin</span>
            @endif
        </h1>

        <p class="subtitle">Vous êtes connecté avec le rôle : <strong>{{ auth()->user()->role }}</strong></p>

        <div class="button-group">
            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'residentiel')
                <a href="{{ route('clients.residentiels') }}" class="btn">Voir les clients résidentiels</a>
            @endif

            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'affaires')
                <a href="{{ route('clients.affaires') }}" class="btn">Voir les clients d'affaires</a>
            @endif

            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.config') }}" class="btn">Mode Administrateur</a>
            @endif
        </div>
    </div>
</body>

</html>