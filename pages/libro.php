<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include_once "../php/imports.php" ?>
    <?php include_once "../php/connessione.php" ?>
    <?php include_once "../php/login-utils.php" ?>
    <link rel="stylesheet" type="text/css" href="../css/libro.css">
</head>

<!-- wrapper:
     - header (importato da ../views/header.php)
     - contenuto
     - footer (importato da ../views/footer.php)
-->

<body class="wrapper">
    <?php
    // Connessione al Database
    $conn = connettitiAlDb();
    // Ottieni i dati in utf-8
    mysqli_query($conn, "set names 'utf8'");

    // ISBN libro
    $isbn = false;

    // Ottieni l'ISBN del libro da visualizzare
    if (isset($_GET["ISBN"])) {
        // Se l'ISBN esiste mettilo nella variabile
        $isbn = $_GET["ISBN"];
    }

    // Ottieni i dati sul libro
    $q1 = "SELECT ISBN, Titolo, Descrizione, AnnoPubblicazione From Libri WHERE Libri.ISBN = '$isbn'";
    $q2 = "SELECT Generi.Descrizione, Tipologie.Descrizione, Editori.Nome, Lingue.Descrizione, Collane.Nome
                FROM Generi, Tipologie, Editori, Lingue, Collane, Libri
                WHERE Libri.idGenere = Generi.idGenere
                AND Libri.idTipo = Tipologie.idTipologia
                AND Libri.idEditore = Editori.idEditore
                AND Libri.idLingua = Lingue.idLingua
                AND Libri.idCollana = Collane.idCollana
                AND Libri.ISBN = '$isbn'";
    $q3 = "SELECT CONCAT(Autori.NomeAutore, ' ', Autori.CognomeAutore) AS Autore, Autori.idAutore
            FROM Autori, Autori_Libri, Libri
            WHERE Autori.idAutore = Autori_Libri.idAutore
            AND Autori_Libri.ISBNLibro = Libri.ISBN
            AND Libri.ISBN = '$isbn'";

    // Estrai i dati dalla query
    $q1_res = mysqli_query($conn, $q1) or die("Impossibile eseguire query1<br>" . mysqli_error($conn));
    $q2_res = mysqli_query($conn, $q2) or die("Impossibile eseguire query1<br>" . mysqli_error($conn));
    $q3_res = mysqli_query($conn, $q3) or die("Impossibile eseguire query1<br>" . mysqli_error($conn));

    // Ottieni i dati sul libro
    $row = mysqli_fetch_row($q1_res);
    $row2 = mysqli_fetch_row($q2_res);

    // Ottieni tutti gli autori
    $autori = array();
    while ($row3 = mysqli_fetch_row($q3_res)) {
        // Salva gli autori nell'array
        $autori[] = $row3[0];
        $id_a[] = $row3[1];
    }

    // Salva i dati in variabili
    $titolo = htmlspecialchars($row[1]);
    $desc = htmlspecialchars($row[2]); // Non perviene per alcun libro (inutile)
    $anno = $row[3];
    $genere = htmlspecialchars($row2[0]);
    $tipo = htmlspecialchars($row2[1]);
    $editore = htmlspecialchars($row2[2]);
    $lingua = htmlspecialchars($row2[3]);
    $collana = htmlspecialchars($row2[4]);
    ?>

    <!-- header importato -->
    <?php include_once "../views/header.php" ?>

    <!-- contenuto principale della pagina -->
    <div>
        <!--                    TITOLO                  -->
        <!--                  di $autore                -->
        <div class=<?php
                    if ($titolo) {
                        if ($isbn) echo '"jumbotron"';
                        else echo '"jumbotron text-danger bg-warning"';
                    } else
                        echo '"jumbotron text-danger bg-warning"';
                    ?> style="padding: 2rem 2rem">
            <h1 class="display-4 text-center">
                <?php
                    if ($titolo) {
                        // Se l'ISBN è valido e i dati non sono stati recuperati
                        echo $titolo;
                    } else if (!$titolo && $isbn) {
                        // Se l'ISBN non è valido e non è stato possibile recuperare i dati
                        echo "Errore nel caricamento del libro";
                    }
                    // Se non è stato possibile recuperare l'ISBN
                    else
                        echo "Errore nel caricamento del codice ISBN";
                    ?>
            </h1>
            <h5 class="display-5 text-center">
                <?php
                    // Controlla se l'isbn è stato reperito
                    // per mostrare il messaggio di errore nel caso
                    // in cui non lo sia stato
                    if ($titolo) {
                        // Controlla se la lista degli autori è vuota
                        if (sizeof($autori) > 0) {
                            // Impagina gli autori di modo che compaiano
                            // in una lista referenziabile
                            echo "di ";
                            for ($i = 0; $i < sizeof($autori); $i++) {
                                echo "<a style='text-style: italic' href='catalogo.php?titolo=&cerca=1&autore=";
                                echo $autori[$i];
                                echo "&editore=&collana=&tipologia=&genere='>" . $autori[$i] . "</a>";

                                if ($i < sizeof($autori) - 1) echo ", ";
                            }
                        } else echo "Autore non pervenuto";
                    } else if (!$titolo && $isbn) {
                        echo "Non è stato possibile recuperare i dati per questo ISBN!<br>Controlla se il codice è esistente nel database e riprova!";
                    } else {
                        echo "Non è stato possibile recuperare il codice ISBN dall'URL!<br>Verificare che l'accesso alla pagina sia stato effettuato in modo corretto!";
                    }
                    ?>
            </h5>
        </div>

        <?php
        // Controlla se è stato effettuato l'accesso, allora aggiungi il pulsante 'Aggiungi alla lista'
        if (logged()) {
            // Controlla se il libro è stato già aggiunto
            $queryControllo = "SELECT * 
                               FROM lista_interessi
                               WHERE ISBNLibro = '$isbn'
                               AND codFiscaleUtente = '$codfisc'";
            
            $qc_res = mysqli_query($conn, $queryControllo);

            // Controlla le righe trovate
            if (mysqli_num_rows($qc_res) >= 1) {
                // Se il libro è presente
                echo "<div class='col text-center mb-4'>";
                echo "<form action='libro.php?ISBN=$isbn' method='post'>";
                echo "<button type='submit' class='btn btn-primary btn-lg' name='rimuovi'>Rimuovi dalla Lista</button>";
                echo "</form>";
                
            } else {
                // Se il libro non è presente
                echo "<div class='col text-center mb-4'>";
                echo "<form action='libro.php?ISBN=$isbn' method='post'>";
                echo "<button type='submit' class='btn btn-primary btn-lg' name='aggiungi'>Aggiungi a Lista</button>";
                echo "</form>";
                echo "</div>";
            }

        }
        ?>

        <!-- Tabella dettagli del libro -->
        <table class="table table-striped mb-5" style="max-width:60%;margin:auto;">
            <tbody>
                <tr>
                    <th scope="row">Genere</th>
                    <td><?php echo $genere ?></td>
                </tr>
                <tr>
                    <th scope="row">Editore</th>
                    <td><?php echo $editore ?></td>
                </tr>
                <tr>
                    <th scope="row">Collana</th>
                    <td><?php echo $collana ?></td>
                </tr>
                <tr>
                    <th scope="row">Pubblicazione</th>
                    <td><?php echo $anno ?></td>
                </tr>
                <tr>
                    <th scope="row">Lingua</th>
                    <td><?php echo $lingua ?></td>
                </tr>
                <tr>
                    <th scope="row">ISBN/Codice</th>
                    <td><?php echo $isbn ?></td>
                </tr>
            </tbody>
        </table>

        <?php
        if (isset($_POST['aggiungi'])) {
            $sql = "INSERT INTO lista_interessi (codFiscaleUtente, ISBNLibro, DataInserimento)
            VALUES ('$codfisc', '$isbn', curdate());";

            // Esegui la query
            $res = mysqli_query($conn, $sql);

            // Stampa l'alert
            echo "<div class='alert alert-success alert-dismissible m-5'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Libro Aggiunto!</strong><a href='lista-desideri.php'> Clicca qui </a> per andare alla Lista Desideri
                  </div> ";
            
            // Ricarica la pagina
            echo "<meta http-equiv='refresh' content='0;URL=libro.php?ISBN=".$isbn."'>";
        }
        // Se clicchi sul pulsante "Rimuovi dalla Lista"
        if (isset($_POST['rimuovi'])) {
            $sql = "DELETE FROM lista_interessi
                        WHERE codFiscaleUtente = '$codfisc'
                        AND ISBNLibro = '$isbn'";

            // Esegui la query
            $res = mysqli_query($conn, $sql);

            // Controlla se la query funziona
            echo mysqli_affected_rows($conn);

            // Stampa l'alert
            echo "<div class='alert alert-success alert-dismissible m-5'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <strong>Libro Rimosso!</strong><a href='lista-desideri.php'> Clicca qui </a> per andare alla Lista Desideri
                  </div> ";
            
            // Ricarica la pagina
            echo "<meta http-equiv='refresh' content='0;URL=libro.php?ISBN=".$isbn."'>";
        }
        ?>

    </div>

    <!-- footer importato -->
    <?php include_once "../views/footer.php" ?>
</body>

</html>