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
    // Includi la funzione per generare il codice
    include "../php/utils.php";
    // Includi le librerie per inviare e-mail
    include "../php/invio.php";

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
        $qry = "SELECT Email, Validato, CodiceValidazione, Nome, Cognome FROM utenti WHERE utenti.Email = '$email'";
        // Esegui la query
        $qry_res = mysqli_query($conn, $qry) or die("Impossibile eseguire la query");
        // Mostra un messaggio se l'email è esistente
        $row = mysqli_fetch_row($qry_res);

        // Ottieni l'e-mail
        $email = $row[0];
        // Se l'email non è presente riporta un errore
        if (!$row[0])      
            return "Email non presente";
        
        // Controlla se l'utente è validato
        $validato = $row[1];
        if (!$validato)
            return "L'account deve essere validato";

        // Ottieni il codice di validazione
        $codice = $row[2];
        // Se esiste l'email non deve essere reinviata
        if ($codice)
            return "Una mail è già stata inviata";

        // Altrimenti, genera un nuovo codice
        $codice = generaCodice();

        // Ottieni nome e cognome dell'utente
        $nome = $row[3];
        $cognome = $row[4];
        
        // Esegui la query per l'aggiornamento del codice
        $ris = mysqli_query($conn, "UPDATE Utenti SET CodiceValidazione = '$codice' WHERE Email = '$email'");
        // Se la query fallisce
        if (!$ris)
            return "Errore durante l'aggiornamento del database<br>" . mysqli_error($conn);

        // Invia una mail
        $inviata = inviaMailDiRecupero($email, $codice, $nome, $cognome);
        // Se la mail non è stata inviata
        if (!$inviata)
            return "Errore durante l'invio della mail";

        // Chiudi la connessione
        mysqli_close($conn);
        // Riporta ok alla fine di tutto
        return "ok";
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