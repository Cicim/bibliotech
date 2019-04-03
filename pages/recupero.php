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

    <?php
    // Includi la funzione per la connessione
    include "../php/connessione.php";

    /**
     * Funzione per il recupero della password
     * @return string Messaggio di errore
     */
    function recupero()
    {
        // Recupero l'email inserita nel form                                    
        $email = $_POST["email"];
        // Connessione al Database
        $conn = connettitiAlDb();
        //esegui il controllo sull'email
        $qry = "SELECT Email FROM utenti WHERE utenti.Email = '$email'";
        // Esegui la query
        $qry_res = mysqli_query($conn, $qry) or die("Impossibile eseguire la query");
        // Mostra un messaggio se l'email è esistente
        $row = mysqli_fetch_row($qry_res);

        // Se l'email non è presente riporta errore
        if (!$row[0])                    
            return "Email non presente";
        // Altrimenti riporta il nome dell'utente
        else 
            return "ok";

        // Chiudo la connessione
        mysqli_close($conn);
    }
    $stato = "";
    // Una volta inserito l'indirizzo e-mail per il recupero
    if (isset($_POST['email'])) 
        $stato = recupero();
        
    ?>

    <!-- Form per recuperare la password -->
    <form class="form-signin" method="post" action="">
        <h1>Bibliotech</h1>
        <h1 class="h3 mb-3 font-weight-normal">Recupero password</h1> <br>

        <?php
            // Se il login è avvenuto con successo
            if ($stato == "ok") {
                // Torna alla homepage
                echo '<div class="alert alert-success" role="alert">';
                echo "Ti abbiamo inviato una mail. Controlla la tua casella.";
                echo '</div>';
            }
            else if ($stato != '') {
                echo '<div class="alert alert-danger" role="alert">';
                echo $stato;
                echo '</div>';
            } 
        ?>

        <!-- Casella per l'indirizzo e-mail -->
        <label for="email" class="sr-only">Indirizzo mail</label>
        <input type="email" name="email" class="form-control" placeholder="Indirizzo mail" required autofocus> <br>

        <!-- Pulsante per l'invio del form -->
        <button class="btn btn-lg btn-primary btn-info btn-block" type="submit">Invia</button> <br>

        <!-- Link per tornare al login -->
        <p class="mb-3 text-muted">
            <a href="login.php">Torna al login</a>
        </p>

        <!-- Footer -->
        <p class="mt-5 mb-3 text-muted">&copy; Bibliotech, 2019 </p>
    </form>

    

</body>


</html> 