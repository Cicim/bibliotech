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
    
    <!--Script PHP-->
    <?php
    // Includo la funzione per la connessione al DB
    require_once "../php/connessione.php";
    // Includi le utility per il login
    require_once "../php/login-utils.php";

    /**
     * @author Claudio Cicimurri, Lorenzo Clazzer, 5CI
     * Funzione per poter fermare il processo di login con
     * un messaggio di errore
     * @return string Codice di errore o "ok" se tutto è andato a buon fine
     */
    function login()
    {
        // Recupero le informazioni inserite nei form
        $email = $_POST["email"];
        $pw = $_POST["password"];

        // Connettiti al database
        $conn = connettitiAlDb();

        // Query per ottenere utente e la password hashata data la e-mail
        $qry = "SELECT Email, Password, CodFiscale, Nome, Cognome, Validato FROM Utenti WHERE Email = '$email'";
        $qry_res = mysqli_query($conn, $qry) 
            or die("Errore durante l'esecuzione della query");

        // Se la mail non è presente nel database
        if (mysqli_num_rows($qry_res) == 0)
            // Esci con un errore
            return "Indirizzo e-mail non trovato";

        // Ottiieni il primo risultato
        $ris = mysqli_fetch_row($qry_res);

        // Ottieni se l'account è validato
        $validato = $ris[5];
        // Esegui il controllo
        if ($validato == 0)
            // Esci con un errore
            return "Questo indirizzo e-mail non è ancora stato confermato";

        // Salva la password hashata
        $md5 = $ris[1];
        // Salva il codice fiscale
        $codFiscale = $ris[2];        
        // Ottieni nome e cognome
        $nome = $ris[3];
        $cognome = $ris[4];

        // Controlla se la password è giusta
        if (md5($pw) == $md5) {
            // Effettua il login
            $logged = effettualLogin($codFiscale, $nome, $cognome);

            // Se il login è stato effettuato
            if ($logged) return "ok";
            // Altrimenti, avverti che l'utente è già loggato con un altro account
            else return "Hai già eseguito il login con un altro account";
        } 
        // Altrimenti la password è sbagliata
        else 
            // Esci con un errore
            return "Password errata";
    }

    $stato = "";
    if (isset($_POST["email"])) 
        $stato = login();
    ?>

    <form class="form-signin" name="log" method="post" action="">
        <!-- Icona di Bibliotech -->
        <h1>Bibliotech</h1>
        <h1 class="h3 mb-3 font-weight-normal">Schermata di accesso</h1> <br>

        <?php
            // Se il login è avvenuto con successo
            if ($stato == "ok") {
                header("Location: index.php");
            }
            else if ($stato != '') {
                echo '<div class="alert alert-danger" role="alert">';
                echo $stato;
                echo '</div>';
            }
        ?>

        <!-- Casella per l'e-mail -->
        <label for="email" class="sr-only">Indirizzo mail</label>
        <input type="email" name="email" class="form-control" placeholder="Indirizzo mail" required autofocus>

        <!-- Casella per la password -->
        <label for="password" class="sr-only">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Password" required>

        <br>
        <button class="btn btn-lg btn-primary btn-info btn-block" type="submit" name="accedi">Accedi</button> <br>

        <!-- Collegamento alla pagina per recuperare la password -->
        <a href="recupero.php" class="text-info">Recupero password </a> <br>
        <!-- Collegamento alla pagina per la registrazione -->
        <a href="registrazione.php" class="text-info"> Registrati </a>

        <!-- Footer -->
        <p class="mt-5 mb-3 text-muted">&copy; Bibliotech, 2019 </p>
    </form>

</body>

</html> 