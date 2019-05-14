<!-- Pagina scritta dal gruppo 2 -->
<!-- Passata di mano al gruppo 1 (D'Averio, incontro del 16/04/2019) -->
<!-- Modifiche a cura di Claudio Cicimurri, 5CI -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Creazione di un prestito - Bibliotech</title>

    <!-- Inclusione librerie di Bootstrap -->
    <?php include_once "../php/imports.php"; ?>

    <!-- Importa tutte le librerie per il datepicker -->
    <script src="https://momentjs.com/downloads/moment.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
</head>

<!-- Esci in caso di accesso negato -->
<?php
include_once "../php/access-denied.php";
livelloRichiesto(BIBLIOTECARIO); ?>

<body class="wrapper">
    <!-- Pagina dell'header importata -->
    <?php include_once "../views/header.php"; ?>

    <div>
        <!-- Titolo della pagina -->
        <div class="jumbotron" style="padding: 2rem 2rem">
            <h1 class="display-5 text-center">Rinnova il prestito</h1>
        </div>

        <!-- Contenitore -->
        <div class="container">
            <!-- Rinnovo della data -->
            <form action="" method="POST">

                <label for="DataRinnovata">Seleziona la nuova data di scadenza del prestito</label>
                <div class="form-group">
                    <div class="input-group date" id="datetimepicker" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" id="DataRinnovata" name="DataRinnovata" data-target="#datetimepicker"/>
                        <div class="input-group-append" data-target="#datetimepicker" data-toggle="datetimepicker">
                            <div class="input-group-text">
                                <i class="fa fa-calendar" style="font-size:24px"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Codice per il datetimepicker -->
                <script type="text/javascript">
                    $(function() {
                        $('#datetimepicker').datetimepicker({
                            format: 'YYYY-MM-DD',
                            locale: 'it',
                        });
                    });
                </script>


                <!-- Pulsante per creare il prestito -->
                <button type="submit" class="btn btn-info">Rinnova prestito</button>
                <a class="btn btn-warning ml-2 block" href="vis-prestiti-scadenze.php"><i class="fa fa-arrow-left"></i> Torna alla sezione prestiti</a>
                <br>
                <br>
            </form>
            <?php

            if (isset($_GET['idPrestito'])) {

                $id = $_GET['idPrestito'];

                include_once "../php/connessione.php";
                $conn = connettitiAlDb();
                if (isset($_POST['DataRinnovata'])) {
                    // Esegui la query per sostituire la data di riconsegna
                    $query = "UPDATE Prestiti
                      SET DataRiconsegna = \"" . $_POST['DataRinnovata'] .
                        "\" WHERE idPrestito = \"$id\"";

                    $risultato = mysqli_query($conn, $query);

                    if (!$risultato) {
                        echo "Errore nella query";
                    }
                }
            }
            ?>
        </div>
    </div>


    <!-- Pagina del footer importata -->
    <?php include_once "../views/footer.php"; ?>

</body>