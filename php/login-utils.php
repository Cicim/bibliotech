<?php
/**
 * @author Lorenzo Clazzer, Claudio Cicimurri, 5CI
 * Riporta il codice dell'utente se ha eseguito il login
 * @return string|false Codice utente o false in caso di errore
 */
function logged()
{
    // Imposta false come valore di default
    $ret = false;
    // Controlla che esista una sessione
    if (isset($_SESSION['user_id'])) {
        // Avvia la sessione
        session_start();
        // A seconda dell'id della sessione, salva il valore
        // da riportare in una variabile
        if ($_SESSION['user_id'] != "")
            $ret = $_SESSION['user_id'];
        else
            $ret = false;
    }
    // Chiudi la sessione
    session_abort();

    // Riporta il risultato
    return $ret;
}

/**
 * @author Claudio Cicimurri, 5CI
 * Funzione per impostare le variabili della sessione
 * necessare per effettuare il login
 * @param string $codFiscale La chiave univoca dell'utente estratta dal database
 * @param string $nome Il nome dell'utente estratto dal database
 * @param string $cognome Il cognome dell'utente estratto dal database
 * @return bool Se il login è stato effettuato
 */
function effettualLogin($codFiscale, $nome, $cognome)
{
    // Assicurati che l'utente non sia già loggato
    if (isset($_SESSION['user_id']))
        return false;

    // Inizia la sessione (anche se potrebbe dare errore)
    session_start();

    // Imposta i parametri della sessione
    $_SESSION['user_id'] = $codFiscale;
    $_SESSION['nome'] = $nome;
    $_SESSION['cognome'] = $cognome;

    // Riporta true per notificare che il login è avvenuto con successo
    return true;
}

/**
 * @author Claudio Cicimurri, 5CI
 * Funzione per cancellare le variabili di sessione ed effettuare
 * il logout
 * @return true Quando il logout è stato effettuato
 */
function logout()
{ 
    // Crea la sessione
    session_start();
    // Cancella i dati della sessione
    $_SESSION['user_id'] = null;
    $_SESSION['nome'] = '';
    $_SESSION['cognome'] = '';
    // Chiudi la sessione
    session_destroy();

    // Riporta true per notificare che il logout è avvenuto con successo
    return true;
}

