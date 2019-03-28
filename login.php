<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Bibliotech - Login</title>

    <!-- Bootstrap core CSS -->
    <?php include "php/imports.php" ?>

    <!-- Custom styles for this template -->
    <link href="css/login.css" rel="stylesheet">
</head>

<body class="text-center">

    <?php include "php/header.php" ?>

    <form class="form-signin">
        <!-- Icona di Bibliotech -->
        <h1> Bibliotech </h1>
        <h1 class="h3 mb-3 font-weight-normal">Schermata di accesso</h1> <br>

        <label for="inputEmail" class="sr-only">Indirizzo mail</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Indirizzo mail" required autofocus>

        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>

        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Ricordami
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-info btn-block" type="submit">Accedi</button> <br>

        <a href="/bib2/php/recupero.php" class="text-info"> Recupero password </a> <br>
        <a href="/bib2/php/registrazione.php" class="text-info"> Registrati </a>
        <p class="mt-5 mb-3 text-muted">&copy; Bibliotech, 2019 </p>
    </form>
</body>

</html> 