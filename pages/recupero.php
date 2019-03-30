<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Bibliotech - Recupero password</title>

    <!-- Importa tutte le librerie comuni -->
    <?php include "../php/imports.php" ?>

    <!-- Importa lo stile per il login -->
    <link href="../css/login.css" rel="stylesheet">
</head>

<body class="text-center">
    <!-- Includo l'header -->
    <?php include "../views/header.php" ?>

    <!-- Form per recuperare la password -->
    <form class="form-signin" method="post" action="">
        <h1>Bibliotech</h1>
        <h1 class="h3 mb-3 font-weight-normal">Recupero password</h1> <br>

        <!-- Casella per l'indirizzo e-mail -->
        <label for="inputEmail" class="sr-only">Indirizzo mail</label>
        <input type="email" name="inputEmail" class="form-control" placeholder="Indirizzo mail" required autofocus> <br>

        <!-- Pulsante per l'invio del form -->
        <button class="btn btn-lg btn-primary btn-info btn-block" type="submit">invia</button> <br>

        <!-- Link per tornare al login -->
        <p class="mb-3 text-muted">
            <a href="login.php">Torna al login</a>
        </p>

        <!-- Footer -->
        <p class="mt-5 mb-3 text-muted">&copy; Bibliotech, 2019 </p>
    </form>

    <?php
    // Includi la funzione per la connessione
    include "../php/connessione.php";

    // Una volta inserito l'indirizzo e-mail per il recupero
    if (isset($_POST['inputEmail'])) {
        // Recupero l'email inserita nel form                                    
        $email = $_POST["inputEmail"];
        // Connessione al Database
        $conn = connettitiAlDb();
        //esegui il controllo sull'email
        $qry = "SELECT Nome FROM utenti WHERE utenti.Email = '$email'";
        // Esegui la query
        $qry_res = mysqli_query($conn, $qry) or die("Impossibile eseguire la query");
        // Mostra un messaggio se l'email è esistente
        $row = mysqli_fetch_row($qry_res);

        // DI PROVA

        // Se l'email non è presente riporta errore
        if (!$row[0])
            echo "Email non presente nel DB";
        // Altrimenti riporta il nome dell'utente
        else {
            echo "Nome: " . $row[0];
        }
        //Chiudo la connessione
        mysqli_close($conn);
    }
    ?>

</body>


</html> 