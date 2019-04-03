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
     * @author Lorenzo Clazzer, 5CI
     * Funzione per il recupero della password
     * @return string Messaggio di errore
     */ 
    function reimposta()
    {
        // Recupero l'email inserita nel form                                    
        $pw1 = $_POST["password"];
        $pw2 = $_POST["conferma"];

        // Controlla che le due password combacino
        if ($pw1 != $pw2)
            return "Le due password non combaciano";

        $password = md5($pw1);
        // Da abilitare a validazione prevista: $validazione = $_GET["cval"];
        $validazione = "F98VzydVmFxXW799d9142438c97d318b8b979cb12b6a7";

        // Connessione al Database
        $conn = connettitiAlDb();
        //esegui il controllo sull'email
        $qry = "UPDATE utenti SET Password = '$password' WHERE CodiceValidazione = '$validazione'";
        // Esegui la query
        $qry_res = mysqli_query($conn, $qry) or die("Impossibile eseguire la query");
        // Mostra un messaggio se l'email è esistente
        if(!$qry_res)
            return "Qualcosa è andato storto. Riprova.";
        else
            return "ok";

        // Chiudo la connessione
        mysqli_close($conn);
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
    <script type="text/javascript">
        // Controllo per combaciamento password
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