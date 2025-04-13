<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Créer un utilisateur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
        }

        h1 {
            color: #333;
        }

        label {
            font-weight: bold;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            margin-top: 4px;
            margin-bottom: 15px;
        }

        button {
            background-color: black;
            color: white;
            padding: 10px 20px;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #333;
        }

        .message-success {
            color: green;
            font-weight: bold;
        }

        .error-list {
            color: red;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        a {
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <h1>Créer un nouvel utilisateur</h1>

    {{-- Affichage des messages de validation --}}
    @if ($errors->any())
        <div class="error-list">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Message de succès --}}
    @if (session('success'))
        <div class="message-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Formulaire --}}
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <label for="name">Nom complet</label>
        <input type="text" name="name" id="name" required>

        <label for="email">Adresse email</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>

        <label for="password_confirmation">Confirmation du mot de passe</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>

        <label for="role">Rôle</label>
        <select name="role" id="role" required>
            <option value="admin">Administrateur</option>
            <option value="residentiel">Préposé résidentiel</option>
            <option value="affaires">Préposé d'affaires</option>
        </select>

        <button type="submit">Créer</button>
    </form>

    {{-- Liste des utilisateurs existants --}}
    <h2>Utilisateurs existants</h2>

    @if ($users->isEmpty())
        <p>Aucun utilisateur n’a encore été créé.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('admin.config') }}">← Retour à la configuration</a>

</body>
@if ($errors->any())
    <div id="error-message"
        style="background-color: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border: 1px solid #f5c6cb; border-radius: 5px;">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>

    <script>
        setTimeout(() => {
            const msg = document.getElementById('error-message');
            if (msg) msg.style.display = 'none';
        }, 5000); // 5 secondes pour les erreurs
    </script>
@endif

</html>