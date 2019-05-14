<?php
// Librerie
include_once "connessione.php";
include_once "access-denied.php";
echo "<script>window.close()</script>";

// Ottieni il codice dell'utente
$cod = $_GET["id"];
// Connettiti al database
$conn = connettitiAlDb();

// Ottieni i permessi
$query = "SELECT Permessi FROM Utenti WHERE CodFiscale='$cod'";
$ris = mysqli_query($conn, $query);
$permessi = mysqli_fetch_row($ris)[0];

// Non puoi cambiare i permessi di un superamministratore
if ($permessi == SUPERAMMINISTRATORE_IPERGALATTICO) {
    echo "Impossibile eliminare questi privilegi";
    return;
}


// Scegli in cosa cambiare i privilegi
$cambiareIn = $permessi == BIBLIOTECARIO ? UTENTE_REGISTRATO : BIBLIOTECARIO;

// Cambia
$query = "UPDATE Utenti SET Permessi = $cambiareIn WHERE CodFiscale='$cod'";
// Esegui
$ris = mysqli_query($conn, $query);

// Query eseguita con successo
if (!$ris)
    echo "Errore durante l'esecuzione della query";
echo "Tutto fatto ($cambiareIn)";