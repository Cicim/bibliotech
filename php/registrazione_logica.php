<?php
    include "registrazione.php";

    //recupero dati inseriti nel form
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $sesso = $_POST["sesso"];
    $viaPzz = $_POST["viaPzz"];
    $citta = $_POST["citta"];
    $numeroCivico = $_POST["numeroCivico"];
    $codFiscale = $_POST["codFiscale"];
    $dataNascita = $_POST["datetimepicker"];
    $telCellulare = $_POST["telCellulare"];
    $telFisso = $_POST["telFisso"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    //variabili per la connessione al DB
    $host = "localhost";
    $user = "root";
    $db = "bibliotech";

    //connetto al DB
    $conn = mysqli_connect($host, $user, "") or die("Impossibile raggiungere il DBMS");
    
    //connetto al database
    $seldb = mysqli_select_db($conn, $db) or die("Impossibile connettersi al database");

    //definisco la query di inserimento
    $qry = "INSERT INTO Utenti 
        (CodFiscale, Nome, Cognome, Email, ViaPzz, NumeroCivico, TelefonoCellulare, TelefonoFisso, Validato, Sesso, Password, Città, DataNascita, Permessi) VALUES
        (\"$codFiscale\", \"$nome\", \"$cognome\", \"$viaPzz\", \"$numeroCivico\", \"$telCellulare\", \"$telFisso\", 0, \"$sesso\", \"$password\", \"$citta\", \"$dataNascita\", 0)";

    //stampo gli indirizzi delle stazioni
    $query_res = mysqli_query($conn, $qry) or die("Impossibile eseguire la query");

?>