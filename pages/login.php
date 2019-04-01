<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Bibliotech - Login</title>

    <!-- Importa tutte le librerie comuni -->
    <?php include "../php/imports.php" ?>

    <!-- Importa lo stile per il login -->
    <link href="../css/login.css" rel="stylesheet">
</head>

<!-- Tutta la pagina è centrata -->
<body class="text-center">
    <!-- Importa l'header -->
    <?php include "../views/header.php" ?>

    <form class="form-signin">
        <!-- Icona di Bibliotech -->
        <h1>Bibliotech</h1>
        <h1 class="h3 mb-3 font-weight-normal">Schermata di accesso</h1> <br>

        <!-- Casella per l'e-mail -->
        <label for="inputEmail" class="sr-only">Indirizzo mail</label>
        <input type="email" name="inputEmail" class="form-control" placeholder="Indirizzo mail" required autofocus>

        <!-- Casella per la password -->
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="inputPassword" class="form-control" placeholder="Password" required>

        <!-- Checkbox per essere ricordato -->
        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Ricordami
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-info btn-block" type="submit">Accedi</button> <br>

        <!-- Collegamento alla pagina per recuperare la password -->
        <a href="recupero.php" class="text-info">Recupero password </a> <br>
        <!-- Collegamento alla pagina per la registrazione -->
        <a href="registrazione.php" class="text-info"> Registrati </a>

        <!-- Footer -->
        <p class="mt-5 mb-3 text-muted">&copy; Bibliotech, 2019 </p>
    </form>
</body>

</html> 