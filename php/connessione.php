<?php
/**
 * @author Claudio Cicimurri, 5CI
 * Funzione per connettersi al database
 * @return mysqli Riporta connessione al database
 */
function connettitiAlDb()
{
    // Parametri per la connessione al server
    $host = "localhost";
    $user = "root";
    $db = "Biblioteca";

    // Connessione al server DBMS
    $conn = mysqli_connect($host, $user, "") or die("Impossibile raggiungere il DBMS");

    // Selezione del database
    mysqli_select_db($conn, $db) or die("Impossibile connettersi al database");

    // Ottieni i dati in utf-8
    mysqli_query($conn, "set names 'utf8'");

    return $conn;
}

/**
 * @author Claudio Cicimurri, 5CI
 * Funzione per ottenere l'id di una città
 * data la stringa in input
 * @param string $citta Stringa da cercare
 * @return int|false Codice della città trovato sul database. False in caso di errore
 */
function ottieniIdCitta($citta)
{
    $conn = connettitiAlDb();
    // Porta città al lowercase
    $citta = strtolower($citta);
    // Cerca la città con il nome dato (tutto in lowercase)
    $ris = mysqli_query($conn, "SELECT idCitta FROM Citta WHERE LOWER(Nome) = '$citta'");

    // Controlla che abbia riportato almeno un risultato
    if (mysqli_num_rows($ris) == 0)
        return false;

    // Ottieni il primo risultato
    $id = mysqli_fetch_row($ris);

    // Chiudi la connessione al database
    mysqli_close($conn);

    // Riportalo
    return $id[0];
}
