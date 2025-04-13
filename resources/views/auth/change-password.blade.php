<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier le mot de passe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        form {
            max-width: 400px;
        }

        label {
            font-weight: bold;
            margin-top: 12px;
            display: block;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-top: 6px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .success {
            color: green;
            margin-bottom: 15px;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: -8px;
            margin-bottom: 10px;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .back-button {
            margin-top: 25px;
        }
    </style>
</head>

<body>
    <h2>Modifier le mot de passe</h2>

    @if (session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('password.change') }}">
        @csrf

        <label>Mot de passe actuel</label>
        <input type="password" name="password_actuel" required>
        @error('password_actuel')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Nouveau mot de passe</label>
        <input type="password" name="new_password" required>
        @error('new_password')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Confirmer le nouveau mot de passe</label>
        <input type="password" name="new_password_confirmation" required>

        <button type="submit">Changer le mot de passe</button>
    </form>

    <div class="back-button">
        <a href="{{ route('home') }}">
            <button>⬅ Retour à l’accueil</button>
        </a>
    </div>
</body>

</html>