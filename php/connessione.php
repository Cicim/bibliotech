<?php
    function connettitiAlDb() {
        //variabili per la connessione al DB
        $host = "localhost";
        $user = "root";
        $db = "biblioteca";

        //connetto al DB
        $conn = mysqli_connect($host, $user, "") or die("Impossibile raggiungere il DBMS");

        //connetto al database
        $seldb = mysqli_select_db($conn, $db) or die("Impossibile connettersi al database");

        return $conn;
    }
?>