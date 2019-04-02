<?php
    /**
     * Funzione per connettersi al database
     * @return mysqli Riporta connessione al database
     */
    function connettitiAlDb() {
        // Parametri per la connessione al server
        $host = "localhost";
        $user = "root";
        $db = "biblioteca";

        // Connessione al server DBMS
        $conn = mysqli_connect($host, $user, "") or die("Impossibile raggiungere il DBMS");

        // Selezione del database
        $seldb = mysqli_select_db($conn, $db) or die("Impossibile connettersi al database");

        return $conn;
    }
?>