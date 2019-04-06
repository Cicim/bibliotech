<?php
    // Includi le utility per il login
    include 'login-utils.php';
    // Esegui la funzione di logout
    logout();

    // Stampa un messaggio
    echo "Logging out...";

    // Torna alla Homepage
    header("Location: ../index.php");
?>