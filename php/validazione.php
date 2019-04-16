<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Bibliotech - Registrazione</title>

    <!-- Importa tutte le librerie comuni -->
    <?php include_once "imports.php" ?>
</head>

<body>
    <!-- Script per la validazione dell'account -->
    <?php
    /**
     * @author Claudio Cicimurri, 5CI
     * Funzione utilizzata per poter uscire dal
     * processo di validazione con un errore
     * @return string Codice dell'errore o "ok" se tutto è andato a buon fine
     */
    function validazione()
    {
        // Connettiti al database
        include 'connessione.php';
        $conn = connettitiAlDB();

        // Ottieni il codice
        $codice = $_GET['codice'];

        // Cercalo sul database
        $query = "SELECT CodFiscale, Nome, Cognome FROM Utenti WHERE CodiceValidazione = '$codice' AND Validato = 0";
        $ris = mysqli_query($conn, $query);

        // Controlla che la ricerca per codice dia almeno un risultato
        if (mysqli_num_rows($ris) == 0)
            return "Il codice fornito non è valido o è già stato validato. Assicurati di aver aperto l'e-mail giusta.";

        // Ottieni i dati su questo account
        $dati = mysqli_fetch_row($ris);
        $codFiscale = $dati[0];
        $nome = $dati[1];
        $cognome = $dati[2];

        // Valida il codice per l'account selezionato
        $query_valida = "UPDATE Utenti SET 
                         Validato = 1, CodiceValidazione = NULL, Permessi = 2
                         WHERE CodFiscale = '$codFiscale'";
        $ris_valida = mysqli_query($conn, $query_valida);

        // Richiedi le utility per il login
        include_once "login-utils.php";
        // Esegui il login con i dati letti
        effettualLogin($codFiscale, $nome, $cognome);

        if ($ris_valida)
            return "ok";
        else
            return mysqli_error($conn);
    }

    $stato = "";
    // Assicurati che sia entrato in questa pagina con un codice
    if (isset($_GET['codice']))
        $stato = validazione();
    ?>
    
    <!-- Fascia grigia -->
    <div class='jumbotron jumbotron-fluid'>
        <div class='container'>
            <!-- Cambia il testo a seconda dello stato -->
            <?php
                // Se non è stato fornito alcun codice
                if ($stato == "") {
                    echo "<h1 class='display-4 text-danger'>Nessun codice fornito</h1>";
                    echo "<p class='lead'>Questa pagina è stata pensata per essere aperta dal link inviato alla tua e-mail</p>";
                    echo '<a class="btn btn-primary btn-lg btn-danger" href="../pages/index.php" role="button">Torna all\'homepage</a>';
                }
                // Se la validazione è avvenuta con successo
                else if ($stato == "ok") {
                    echo "<h1 class='display-4 text-success'>Validazione effettuata!</h1>";
                    echo "<p class='lead'>Il tuo account è stato validato ed è stato eseguito l'accesso</p>";
                    echo '<a class="btn btn-primary btn-lg btn-success" href="../pages/index.php" role="button">Torna all\'homepage</a>';
                }
                // Altrimenti
                else {
                    echo "<h1 class='display-4 text-danger'>Errore durante la validazione</h1>";
                    echo "<p class='lead'>$stato</p>";
                    echo '<a class="btn btn-primary btn-lg btn-danger" href="../pages/index.php" role="button">Torna all\'homepage</a>';
                }
            ?>
        </div>
    </div>

    <!-- Stile per rendere il jumbotron a schermo intero -->
    <style>
        html, body {
            height: 100%;
        }
        .jumbotron-fluid {
            height: 100%;
            margin: 0;
            width: 100%;
            display: table;
        }
        .container {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }
    </style>

</body>

</html> 