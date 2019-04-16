<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Homepage - Bibliotech</title>

    <!-- Include le librerie comuni -->
    <?php include "../php/imports.php";
    // Includi il codice per la paginazione
    include "../php/paginazione.php";
    // Includi il codice per la connessione al database
    include '../php/connessione.php'; ?>

    <!-- Carica il css per il catalogo -->
    <link rel="stylesheet" type="text/css" href="../css/area-personale.css">

</head>

<body class="wrapper">
    <!-- Pagina dell'header importata -->
    <?php include "../views/header.php"; ?>

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
                                <ul class="list-group-horizontal">
                                    <li class="list-group-item"><b>Nome Libro</b></li>
                                    <li class="list-group-item"><b>Data Inserimento</b></li>
                                    <li class="list-group-item"><b>Rimozione Libro</b></li>
                                </ul>

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

                                while ($row = mysqli_fetch_array($res)) {
                                    echo "<ul class='list-group-horizontal'>";
                                    echo    "<li class='list-group-item'>" . $row["Titolo"] . "</li> ";
                                    echo    "<li class='list-group-item'>" . $row["DataInserimento"] . "</li> ";
                                    $isbn = $row["ISBN"];
                                    echo "<li class='list-group-item'>
                                            <form action='' method='post'>
                                                <button type='submit' class='btn btn-danger btn-md center-block' name='rimuovi' value='$isbn'>Rimuovi</button>
                                            </form>
                                        </li>";

                                    echo "</ul>";
                                }

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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pagina del footer importata -->
    <?php include "../views/footer.php"; ?>
</body>