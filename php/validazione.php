<?php
    /**
     * @author Claudio Cicimurri, 5CI
     * Funzione utilizzata per poter uscire dal
     * processo di validazione con un errore
     * @return string Codice dell'errore o "ok" se tutto è andato a buon fine
     */
    function validazione() {
        // Connettiti al database
        require_once 'connessione.php';
        $conn = connettitiAlDB();

        // Ottieni il codice
        $codice = $_GET['codice'];

        // Cercalo sul database
        $query = "SELECT CodFiscale, Nome, Cognome FROM Utenti WHERE CodiceValidazione = '$codice' AND Validato = 0";
        $ris = mysqli_query($conn, $query);

        // Controlla che la ricerca per codice dia almeno un risultato
        if (mysqli_num_rows($ris) == 0)
            return "Codice non valido";

        // Ottieni i dati su questo account
        $dati = mysqli_fetch_row($ris);
        $codFiscale = $dati[0];
        $nome = $dati[1];
        $cognome = $dati[2];

        // Valida il codice per l'account selezionato
        $query_valida = "UPDATE Utenti SET Validato = 1, CodiceValidazione = NULL WHERE CodFiscale = '$codFiscale'";
        $ris_valida = mysqli_query($conn, $query_valida);

        if ($ris_valida)
            return "Account validato";
        else
            return mysqli_error($conn);
    }

    // Assicurati che sia entrato in questa pagina con un codice
    if (isset($_GET['codice']))
        echo validazione();

    // Esci dalla pagina
    echo '<script>close()</script>';
?>