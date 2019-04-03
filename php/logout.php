<?php
    session_start();
    // Cancella i dati della sessione
    $_SESSION['user_id'] = null;
    $_SESSION['nome'] = '';
    $_SESSION['cognome'] = '';
    session_destroy();

    // Torna alla Homepage
    header("Location: ../index.php");
?>