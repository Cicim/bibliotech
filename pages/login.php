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
        if ($validato != 0)
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
            session_start();

            // Imposta i parametri della sessione
            $_SESSION['user_id'] = $codFiscale;
            $_SESSION['nome'] = $nome;
            $_SESSION['cognome'] = $cognome;

            return "ok";
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
                // Torna alla homepage
                echo "<script>location.href='index.php'</script>";
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

        <!-- Checkbox per essere ricordato -->
        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Ricordami
            </label>
        </div>
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