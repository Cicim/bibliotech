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

    <!-- Container -->
    <div class='container mt-4'>
        <div class='row'>
            <div class='col-md-3 '>
                <!-- Lista dei collegamenti dell'area utente -->
                <div class='list-group'>
                    <a href='area-personale.php' class='list-group-item list-group-item-action'>Informazioni Utente</a>
                    <a href='#' class='list-group-item list-group-item-action active'>Lista Desideri</a>
                    <a href='cronologia-prestiti.php' class='list-group-item list-group-item-action'>Cronologia Prestiti</a>
                </div>
            </div>
            <br>
            <div class='col-md-9'>
                <div class='card'>
                    <div class='card-body'>
                        <div class='row'>
                            <div class='col-md-12'>
                                <ul class="list-group">


                                    <!-- Script per la stampa della wishlist -->
                                    <?php
                                    // Connettiti al database
                                    $conn = connettitiAlDb();
                                    // Script della query
                                    $sql = "SELECT Titolo, DataInserimento, ISBN
                                        FROM Libri, Utenti, Lista_Interessi
                                        WHERE Utenti.CodFiscale = '$codfisc'
                                        AND Libri.ISBN = Lista_Interessi.ISBNLibro";
                                    // Esegui la query
                                    $res = mysqli_query($conn, $sql);

                                    // Controlla se ci sono dei prestiti
                                    if (mysqli_num_rows($res) > 0) {
                                        // Stampa i record trovati

                                        // Per ogni record trovato
                                        while ($row = mysqli_fetch_array($res)) {
                                            // Stampa l'elemento della lista
                                            $isbn = $row["ISBN"];
                                            echo '<li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-9">
                                                                <span class="font-weight-light font-italic">Inserito il: ' . $row["DataInserimento"] . '</span>
                                                                <span>' . $row["Titolo"] . '</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-2">
                                                            <form action="" method="post">
                                                                <button name="rimuovi" type="submit" value="' . $isbn . '" class="pt-0 pb-0 btn btn-danger btnRimuovi landscape"> Rimuovi </button>
                                                                <button name="rimuovi" type="submit" value="' . $isbn . '" class="pt-1 pb-1 btn btn-danger btnRimuovi portrait fa fa-trash"> </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                   </li>';
                                        }
                                    }
                                    // Altrimenti stampa un messaggio
                                    else echo "Nessun libro nella lista";

                                    if (isset($_POST['rimuovi'])) {
                                        $valore_isbn = $_POST['rimuovi'];

                                        $sql = "DELETE FROM lista_interessi 
                                            WHERE ISBNLibro = '$valore_isbn'";

                                        // Connettiti al database
                                        $conn = connettitiAlDb();

                                        $res = mysqli_query($conn, $sql);
                                        echo "<meta http-equiv='refresh' content='0;URL=lista-desideri.php'>";
                                    }

                                    ?>
                                </ul>
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