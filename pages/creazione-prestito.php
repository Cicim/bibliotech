<!-- Pagina scritta dal gruppo 2 -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gestione utenti - Bibliotech</title>

    <!-- Inclusione librerie di Bootstrap -->
    <?php include "../php/imports.php"; ?>

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
            <!-- IdPrestito -->
            <div class="col-md-4 mb-3">
                <label for="idPrestitp">idPrestito</label>
                <input type="text" class="form-control" name="idPrestito" placeholder="Es. 254123" value="" required="true">
                <div class="invalid-feedback">Inserisci un id valido</div>
            </div>
            <!-- Codice Fiscale Utente -->
            <div class="col-md-4 mb-3">
                <label for="Codfisc">Codice Fiscale</label>
                <input type="text" class="form-control" name="Codfisc" placeholder="Es. HPFMWS46H48G903E" value="" required="true">
                <div class="invalid-feedback">Inserisci un codice fiscale valido.</div>
            </div>
    </div>

    <!-- Seconda riga (3 caselle) -->
    <div class="row">
        <!--Data consegna -->
        <div class="col-md-4 mb-3">
            <label for="dataRicons">Data Riconsegna</label>
            <input class="form-control w-100" name="dataRicons" placeholder="Es. 21/2/2017" required="true">
            <div class="invalid-feedback">Inserisci una data per la consegna valida</div>
        </div>

        <!--  -->
        <div class="col-md-4 mb-3">
            <label for="idCopia">idCopia</label>
            <input class="form-control w-100" name="idCopia" placeholder="Es. 9000" required="true">
            <div class="invalid-feedback">Inserisci un id valido.</div>
        </div>
    </div>

<!--working progress-->


<!--Script php per l'invio dei dati al database-->
<?php

    //recupero dati inseriti nel form
    if (isset($_POST["titolo"])) {
        //Connetto al DB
        include "connessione.php";
        $conn = connettitiAlDb();

        //Recupero i dati dal form
        $idPrestito = $_POST["idPrestito"];
        $CodFisc = $_POST["CodFisc"];
        $dataRicons = $_POST["dataRicons"];
        $idCopia = $_POST["idCopia"];

        //Se il telefono fisso non è stato inserito, allora settalo a NULL
        if ($telFisso == "") $fisso = "NULL";
        else $fisso = "'$telFisso'";

        //Query di inserimento campi nel database
        $query =  "INSERT INTO Prestiti (idPrestito,  codFiscaleUtente, DataRiconsegna, idCopia) VALUES
        ('$idPrestito', '$Codfisc', '$dataRicons', $idCopia')";
       

        // Mostra l'errore
        if (!$query_res = mysqli_query($conn, $query)) {
            #echo ("ERROR: " . mysqli_error($conn));
            echo "Errore";
        }

        //Chiudo la connessione
        mysqli_close($conn);
    }
    ?>


    <!-- Pulsante per inviare -->
    <!--
        Bottone e la query sopra non funzionano poiche non sono riusciro a collegarli e quindi è probabile che la query funzioni ma al click del tasto conferma non si avvia.
        ps : se qualcuno sa come fare potrebbe farlo o darmi informazioni su come farlo .

        <td align = "right">
            <a class="btn btn-success ml-2 block" id="btnConferma" href="sezione-amministrativa.php">Conferma</a>
        </td>
        <br>
        <br>
    -->

    <div align = "center">
        <!-- Bottone per tornare alla pagina principale della sezione amministrativa -->
        <a class="btn btn-danger ml-2 block" id="btnAnnulla" href="sezione-amministrativa.php"><i class="fa fa-arrow-left"></i> Annulla</a>

        <!-- Conferma della creazione del prestito -->
        <a class="btn btn-success ml-2 block" id="btnConferma" href="#"><i class="fa fa-check"></i> Crea prestito</a>
        <!-- Esecuzione della query -->
    </div>

    <br>

    <!-- Pagina del footer importata -->
    <?php include "../views/footer.php"; ?>

</body> 