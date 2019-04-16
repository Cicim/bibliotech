<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Bibliotech - Recupero password</title>

    <!-- Importa tutte le librerie comuni -->
    <?php include_once "../php/imports.php" ?>

    <!-- Importa lo stile per il login -->
    <link href="../css/login.css" rel="stylesheet">
</head>

<body class="text-center">
    <!-- Includo l'header -->
    <?php include_once "../views/header.php" ?>

    <?php
    // Includi la funzione per la connessione
    include_once "../php/connessione.php";

    /**
     * @author Lorenzo Clazzer, 5CI
     * Funzione per il recupero della password
     * @return string Messaggio di errore
     */ 
    function reimposta()
    {
        // Connessione al Database
        $conn = connettitiAlDb();

        // Ottieni il codice di validazione
        $validazione = $_GET["codice"];
        // Se non è fornito
        if (!$validazione)
            return "Nessun codice fornito";

        // Ottieni l'account dal codice di validazione
        $ris_ricerca = mysqli_query($conn, "SELECT CodFiscale FROM Utenti WHERE CodiceValidazione = '$validazione'");
        // Conta i risultati
        if (mysqli_num_rows($ris_ricerca) == 0)
            return "Codice non valido";

        // Ottieni il codice fiscale
        $codFiscale = mysqli_fetch_row($ris_ricerca)[0];


        // Recupera le due password                         
        $pw1 = $_POST["password"];
        $pw2 = $_POST["conferma"];

        // Controlla che le due password combacino
        if ($pw1 != $pw2)
            return "Le due password non combaciano";

        // Calcola l'md5 della password
        $password = md5($pw1);

        // Resetta la password
        $qry = "UPDATE utenti SET CodiceValidazione = NULL, Password = '$password' WHERE CodFiscale = '$codFiscale'";
        // Esegui la query
        $qry_res = mysqli_query($conn, $qry);

        // Mostra un messaggio se l'email è esistente
        if(!$qry_res)
            return "Qualcosa è andato storto. Riprova.";
        else
            return "ok";
    }
    $stato = "";
    // Una volta inserito l'indirizzo e-mail per il recupero
    if (isset($_POST['password'])) 
        $stato = reimposta();
        
    ?>

    <!-- Form per recuperare la password -->
    <form class="form-signin" method="post" action="">
        <h1>Bibliotech</h1>
        <h1 class="h3 mb-3 font-weight-normal">Reimposta la password</h1> <br>

        <?php
            // Se il login è avvenuto con successo
            if ($stato == "ok") {
                // Torna alla homepage
                echo '<div class="alert alert-success" role="alert">';
                echo "Password reimpostata con successo";
                echo '</div>';
            }
            else if ($stato != '') {
                echo '<div class="alert alert-danger" role="alert">';
                echo $stato;
                echo '</div>';
            }
        ?>

        <!-- Casella per l'inserimento password -->
        <label for="password" class="sr-only">Password</label>
        <input type="password" name="password" class="form-control mb-0" placeholder="Password" onchange='passwordUguali()' pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required autofocus>

        <!-- Casella per l'inserimento conferma password -->
        <label for="conferma" class="sr-only">Conferma password</label>
        <input type="password" name="conferma" class="form-control" placeholder="Conferma password" onchange='passwordUguali()' pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>

        <!-- Pulsante per l'invio del form -->
        <button class="btn btn-lg btn-primary btn-info btn-block" type="submit">Reimposta</button> <br>

        <!-- Link per tornare al login -->
        <p class="mb-3 text-muted">
            <a href="login.php">Torna al login</a> 
        </p>

        <!-- Footer -->
        <p class="mt-5 mb-3 text-muted">&copy; Bibliotech, 2019 </p>
    </form>

    <!-- Javascript per il controllo delle password -->
    <script>
        /**
         * @author Claudio Cicimurri, 5CI
         * Funzione eseguita al cambiamento di valore nei campi
         * password e confermaPassword.
         * Fa diventare le password verdi se combaciano, altrimenti rosse
         */
        function passwordUguali() {
            if (document.getElementById('password').value ==
                document.getElementById('confermaPassword').value) {
                document.getElementById('confermaPassword').style.color = 'green';
            } else {
                document.getElementById('confermaPassword').style.color = 'red';
            }
        }
    </script>

</body>


</html> 