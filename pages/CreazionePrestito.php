<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gestione utenti - Bibliotech</title>

    <!-- Include le librerie comuni -->
    <?php include "../php/imports.php"; ?>

    <!-- Carica il css per il catalogo -->
    <link rel="stylesheet" type="text/css" href="../css/catalogo.css">
</head>

<body>
    <!-- Pagina dell'header importata -->
    <?php include "../views/header.php"; ?>
    
    <!-- Rettangolo grigio per il titolo della sezione -->
    <div class="jumbotron" style="padding: 2rem 2rem">
        <h1 class="display-4 text-center">Creazione nuovo prestito</h1>
    </div>

    <!-- Prima riga (3 caselle) -->
    <div class="row">
            <!-- Titolo Libro -->
            <div class="col-md-4 mb-3">
                <label for="titolo">Titolo</label>
                <input type="text" class="form-control" name="titolo" placeholder="Es. Il fu Mattia Pascal" value="" required="true">
                <div class="invalid-feedback">Inserisci un titolo valido</div>
            </div>
            <!-- Autore -->
            <div class="col-md-4 mb-3">
                <label for="autore">Autore</label>
                <input type="text" class="form-control" name="autore" placeholder="Es. Pirandello" value="" required="true">
                <div class="invalid-feedback">Inserisci un autore valido.</div>
            </div>
    </div>

            <!-- Seconda riga (3 caselle) -->
            <div class="row">
                <!--Codice Fiscale Utente-->
                <div class="col-md-4 mb-3">
                    <label for="Codfisc">Codice Fiscale</label>
                    <input class="form-control w-100" name="Codfisc" placeholder="Es. HPFMWS46H48G903E" required="true">
                    <div class="invalid-feedback">Inserisci un codice fiscale valido</div>
                </div>

                <!-- Cognome Utente -->
                <div class="col-md-4 mb-3">
                    <label for="cognomeUt">Cognome Utente</label>
                    <input class="form-control w-100" name="cognomeUt" placeholder="Es. Rossi" required="true">
                    <div class="invalid-feedback">Inserisci un cognome valido.</div>
                </div>
            </div>

            <!-- Terza riga (2 caselle) -->
            <div class="row">
                <!-- Telefono Cellulare -->
                <div class="col-md-4 mb-3">
                    <label for="telCellulare">Telefono Cellulare</label>
                    <input type="text" class="form-control" name="telCellulare" placeholder="Cellulare" required="true">
                    <div class="invalid-feedback">Inserisci il numero di telefono.</div>
                </div>
                <!-- Telefono Fisso -->
                <div class="col-md-4 mb-3">
                    <label for="telFisso">Telefono Fisso</label>
                    <input type="text" class="form-control" name="telFisso" placeholder="Fisso (opzionale)">
                </div>
            </div>

             <!-- Pulsante per inviare -->
             <td align = "right">
                <a class="btn btn-success ml-2 block" id="btnConferma" href="SezioneAmministrativa.php">Conferma</a>
            </td>


<!--working progress-->


<!--Script php per l'invio dei dati al database-->
<?php
    //recupero dati inseriti nel form
    if (isset($_POST["nome"])) {
        //Connetto al DB
        include "connessione.php";
        $conn = connettitiAlDb();

        //Recupero i dati dal form
        $nome = $_POST["nome"];
        $cognome = $_POST["cognome"];
        $sesso = $_POST["sesso"];
        $viaPzz = $_POST["viaPzz"];
        $citta = $_POST["citta"];
        $numeroCivico = $_POST["numeroCivico"];
        $codFiscale = $_POST["codFiscale"];
        $dataNascita = date('Y-m-d', strtotime(str_replace('/', '-', $_POST["dataNascita"])));
        $telCellulare = $_POST["telCellulare"];
        $telFisso = $_POST["telFisso"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        //Se il telefono fisso non è stato inserito, allora settalo a NULL
        if ($telFisso == "") $fisso = "NULL";
        else $fisso = "'$telFisso'";

        //Genero l'hash della password
        $pwd = md5($password);

        //Query di inserimento campi nel database
        $qry = "INSERT INTO Utenti (CodFiscale, Nome, Cognome, Email, ViaPzz, NumeroCivico,
            TelefonoCellulare, TelefonoFisso, Validato, CodiceValidazione, DataValidazione,
            Sesso, Password, Citta, DataNascita, Permessi) VALUES
            ('$codFiscale', '$nome', '$cognome', '$email',
             '$viaPzz', $numeroCivico, '$telCellulare', $fisso, 1, NULL, '2019-03-12',
             '$sesso', '$pwd', 279, '$dataNascita', 3)";

        // Mostra l'errore
        if (!$query_res = mysqli_query($conn, $qry)) {
            echo ("ERROR: " . mysqli_error($conn));
        }

        //Chiudo la connessione
        mysqli_close($conn);
    }
    ?>




    <!-- Pagina del footer importata -->
    <?php include "../views/footer.php"; ?>

</body> 