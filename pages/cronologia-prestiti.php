<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Homepage - Bibliotech</title>

    <!-- Include le librerie comuni -->
    <?php include_once "../php/imports.php";
    // Includi il codice per la paginazione
    include_once "../php/paginazione.php";
    // Includi il codice per la connessione al database
    include '../php/connessione.php'; ?>

    <!-- Carica il css per il catalogo -->
    <link rel="stylesheet" type="text/css" href="../css/area-personale.css">
</head>

<!-- Esci in caso di accesso negato -->
<?php 
    include_once "../php/access-denied.php";
    livelloRichiesto(UTENTE_REGISTRATO); ?>
    
<body class="wrapper">
    <!-- Pagina dell'header importata -->
    <?php include_once "../views/header.php"; ?>

    <div class='container mt-4'>
        <div class='row'>
            <div class='col-md-3'>
                <div class='list-group'>
                    <a href='area-personale.php' class='list-group-item list-group-item-action'>Informazioni Utente</a>
                    <a href='lista-desideri.php' class='list-group-item list-group-item-action'>Lista Desideri</a>
                    <a href='#' class='list-group-item list-group-item-action active'>Cronologia Prestiti</a>
                </div>
            </div>
            <div class='col-md-9'>
                <div class='card'>
                    <div class='card-body'>
                        <div class='row'>
                            <div class='col-md-12'>
                                <?php
                                ?>

                                <ul class="list-group-horizontal">
                                    <li class="list-group-item"><b>Nome Libro</b></li>
                                    <li class="list-group-item"><b>Data Prestito</b></li>
                                    <li class="list-group-item"><b>Data Riconsegna</b></li>
                                </ul>


                                <!-- Script per l'ottenimento dei prestiti -->
                                <?php
                                $sql = "SELECT Titolo, DataConsegna, DataRiconsegna
                                        FROM Libri, Copie, Prestiti, Utenti
                                        WHERE Utenti.CodFiscale = '$codfisc'
                                        AND Copie.idCopia = Prestiti.idCopia
                                        AND Prestiti.CodFiscaleUtente = Utenti.CodFiscale
                                        AND Copie.ISBN = Libri.ISBN";

                                // Connettiti al database
                                $conn = connettitiAlDb();
                                // Esegui la query
                                $res = mysqli_query($conn, $sql);

                                // Stampa i risultati
                                while ($row = mysqli_fetch_array($res)) {
                                    echo "<ul class='list-group-horizontal'>";
                                    echo "<li class='list-group-item'>" . $row["Titolo"] . "</li> ";
                                    echo "<li class='list-group-item'>" . $row["DataConsegna"] . "</li> ";
                                    echo "<li class='list-group-item'>" . $row["DataRiconsegna"] . "</li> ";
                                    echo "</ul>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pagina del footer importata -->
    <?php include_once "../views/footer.php"; ?>
</body>