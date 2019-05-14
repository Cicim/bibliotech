<!-- Pagina creata interamente da Claudio Cicimurri -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Bibliotech - Restituisci il libro</title>

    <!-- Inclusione librerie di Bootstrap -->
    <?php include_once "../php/imports.php"; ?>
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
            <h1 class="display-5 text-center">Restituisci il libro</h1>
        </div>

        <!-- Contenitore -->
        <div class="container">
            <!-- Rinnovo della data -->
            <form action="" method="POST">
                <!-- Pulsante per restituire il libro -->
                <button type="submit" name="fatto" class="btn btn-info">Restituisci libro</button>
                <a class="btn btn-warning ml-2 block" href="vis-prestiti-scadenze.php"><i class="fa fa-arrow-left"></i> Torna alla sezione prestiti</a>
            </form>
            <?php

            if (isset($_GET['idPrestito'])) {
                include_once "../php/connessione.php";
                // Ottieni la data odierna
                $dataOdierna = date("Y-m-d");
                // Ottieni l'id del prestito
                $id = $_GET['idPrestito'];
                // Ottieni il codice fiscale del bibliotecario
                $codFiscale = logged();

                // Connettiti al database
                $conn = connettitiAlDb();

                if (isset($_POST['fatto'])) {
                    // Prima query per riconsegnare il libro
                    $query = "UPDATE Prestiti
                     SET DataRiconsegna = '$dataOdierna',
                         bibRiconsegna = '$codFiscale'
                     WHERE idPrestito = $id";

                     
                    $ris = mysqli_query($conn, $query);
                    
                    // Esegui la query per ottenere l'id della copia
                    $query = "SELECT idCopia FROM Prestiti WHERE idPrestito=$id";
                    $ris = mysqli_query($conn, $query);
                    
                    // Ottieni la riga
                    $idCopia = mysqli_fetch_row($ris)[0];
                    
                    // Esegui infine la query per rendere disponibile il libro
                    $query = "UPDATE Copie
                        SET Prestato = 0
                        WHERE idCopia=$idCopia";
                    $ris = mysqli_query($conn, $query);
                    
                    if (!$ris)
                        echo "Errore durante l'esecuzione della query";
                    
                }
            }
            ?>
        </div>
    </div>


    <!-- Pagina del footer importata -->
    <?php include_once "../views/footer.php"; ?>

</body>