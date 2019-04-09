<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Catalogo</title>

    <!-- Include le librerie comuni -->
    <?php include "../php/imports.php";
    // Includi il codice per la paginazione
    include "../php/paginazione.php";
    // Includi il codice per la connessione al database
    include '../php/connessione.php'; ?>

    <!-- Carica il css per il catalogo -->
    <link rel="stylesheet" type="text/css" href="../css/catalogo.css">
    <!-- Carica il js e il css per la combobox -->
    <script src="../js/combobox.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/combobox.css">
</head>

<body class="wrapper">
    <!-- Pagina dell'header importata -->
    <?php include "../views/header.php"; ?>

    <!-- Connessione al database -->
    <?php
    // Connettiti al database
    $conn = connettitiAlDb();
    // Ottieni i dati in utf-8
    mysqli_query($conn, "set names 'utf8'");
    ?>

    <!-- Contenuto principale della pagina -->
    <div>
        <!-- Rettangolo grigio per il titolo della sezione -->
        <div class="jumbotron" style="padding: 2rem 2rem">
            <h1 class="display-4 text-center">Catalogo</h1>
        </div>

        <!-- Barra di ricerca -->
        <form method="get">
            <div class="container w-60" style="margin:auto">
                <div class="input-group mb-0">
                    <input type="text" name="titolo" class="form-control" placeholder="Cosa stai cercando?" value="<?php echo isset($_GET['titolo']) ? $_GET['titolo'] : '' ?>" autofocus>
                    <div class="input-group-append">
                        <!-- Desktop -->
                        <button class="btn btn-outline-info fa fa-filter" name="filtra" type="button" data-toggle="collapse" data-target="#filterForm"><span class="ml-2" style="font-family:arial">Filtri</span></button>
                        <button type="submit" value="1" class="btn btn-outline-info fa fa-search full-search" name="cerca" type="button"><span class="ml-2" style="font-family:arial">Cerca</span></button>
                        <!-- Mobile -->
                        <button type="submit" value="1" class="btn btn-outline-info fa fa-search small-search" name="cerca" type="button"></button>
                    </div>
                </div>
                <!-- Filtro -->
                <div class="jumbotron text-center collapse py-1 mt-0" style="margin:auto" id="filterForm">
                    <h1 class="display-4 mt-2" style="font-size: 16pt !important">
                        <?php
                        // Controlla se ci sono filtri
                        if (haFiltri())
                            // E stampa un pulsante che porta alla stessa pagina
                            // meno tutti i filtri settati
                            echo "<a href='catalogo.php?titolo=" . $_GET["titolo"] . "&cerca=&autore=&editore=&collana=&tipologia=&genere=' class='text-danger'> Rimuovi filtri</a>";
                        else
                            // Altrimenti manda il solito messaggio
                            echo "Aggiungi filtri";
                        ?>
                    </h1>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="autore">Autore</label>
                            <input class="form-control w-100" name="autore" placeholder="Nome o Cognome autore" value="<?php echo isset($_GET['autore']) ? $_GET['autore'] : '' ?>">
                        </div>
                        <div class="col-6 mb-3">
                            <label for="editore">Editore</label>
                            <input class="form-control w-100" name="editore" placeholder="Nome editore" value="<?php echo isset($_GET['editore']) ? $_GET['editore'] : '' ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="collana">Collana</label>
                            <input class="form-control w-100" name="collana" placeholder="Nome collana" value="<?php echo isset($_GET['collana']) ? $_GET['collana'] : '' ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <!-- Tipologia -->
                            <label for="">Tipologia</label>
                            <div class="input-group" id="comboboxTipologia">
                                <input type="text" class="form-control" placeholder="Cerca tipologia...">
                                <div class="input-group-prepend" data-toggle="dropdown">
                                    <button class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown"></button>
                                    <div class="dropdown-menu dropdown-menu-right combobox-content">
                                        <!-- Script per importare tutte le opzioni -->
                                        <?php
                                        $query = "SELECT * FROM Tipologie";

                                        // Esegui la query
                                        $qres = mysqli_query($conn, $query);

                                        // Stampa i link
                                        while ($row = mysqli_fetch_assoc($qres))
                                            // Stampa gli a href
                                            echo "<a class=dropdown-item href='#' value='" . $row["idTipologia"] . "'>" . $row["Descrizione"] . "</a>";
                                        ?>
                                    </div>
                                </div>
                                <!-- <input name="genere" id="tipologia" type="text" class="d-none"> -->
                            </div>
                            <input name="tipologia" id="tipologia" type="text" class="d-none" value="<?php echo isset($_GET['tipologia']) ? $_GET['tipologia'] : '' ?>">
                        </div>
                        <script>
                            $(function() {
                                combobox($('#comboboxTipologia'), $('#tipologia'));
                            });
                        </script>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <!-- Genere -->
                            <label for="autore">Genere</label>
                            <div class="input-group" id="comboboxGenere">
                                <input type="text" class="form-control" placeholder="Cerca genere...">
                                <div class="input-group-prepend" data-toggle="dropdown">
                                    <button class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown"></button>
                                    <div class="dropdown-menu dropdown-menu-right combobox-content">
                                        <!-- Script per importare tutte le opzioni -->
                                        <?php
                                        $query = "SELECT * FROM Generi";

                                        // Esegui la query
                                        $qres = mysqli_query($conn, $query);

                                        // Stampa i link
                                        while ($row = mysqli_fetch_assoc($qres))
                                            // Stampa gli a href
                                            echo "<a class=dropdown-item href='#' value='" . $row["idGenere"] . "'>" . $row["Descrizione"] . "</a>";
                                        ?>
                                    </div>
                                </div>
                                <input name="genere" id="genere" type="text" class="d-none" value="<?php echo isset($_GET['genere']) ? $_GET['genere'] : '' ?>">
                            </div>
                            <script>
                                $(function() {
                                    combobox($('#comboboxGenere'), $('#genere'));
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Catalogo -->
        <div class="container books">
            <!-- Script per la ricerca -->
            <?php

            /**
             * @author Claudio Cicimurri, 5CI
             * Funzione per generare la funzione MATCH di SQL, per comodità
             * @param string $field Il nome del campo
             * @param string $against Il testo della ricerca
             * @param int $weight Il peso del campo nella ricerca
             * @return string La parte di query generata 
             */
            function generaMatch($field, $against, $weight)
            {
                return "MATCH ($field) AGAINST ('$against' IN BOOLEAN MODE) * $weight";
            }

            // Definisci la query di ricerca senza impostarla
            $ricerca = '';

            /**
             * @author Andrea Cicimurri, 5CI
             * Controlla se ci sono filtri settati nella pagina di ricerca
             * Ingnora la casella principale del Titolo
             * @return bool true se ci sono filtri, altrimenti false
             * */
            function haFiltri()
            {
                if (isset($_GET["cerca"]))
                    if ($_GET["autore"] || $_GET["editore"] || $_GET["genere"] || $_GET["tipologia"] || $_GET["collana"])
                        return true;
                    else return false;
            }

            // Assicurati che sia stata effettuata una ricerca
            if (isset($_GET['cerca'])) {
                // ANCHOR Ricerche testuali possibili
                // Titolo del libro (Libri.Titolo)      PESO: 1
                $titolo = $_GET['titolo'];
                // Autore del libro (Autori.NomeAutore, Autori.CognomeAutore,
                //                   Autori.NomeArte)   PESO: 0.4, 0.6, 0.8
                $autore = $_GET['autore'];
                // Nome dell'editore (Editori.Nome)     PESO: 0.8
                $editore = $_GET['editore'];
                // Nome della collana (Collane.Nome)    PESO: 0.5
                $collana = $_GET['collana'];

                // ANCHOR Ricerche per id possibili
                // Tipologia (Tipologie.idTipologia)
                $tipologia = $_GET['tipologia'];
                // Genere (Generi.idGenere)
                $genere = $_GET['genere'];

                // ANCHOR Attributi necessari per la stampare i dati su un libro
                //  - Libri.ISBN,
                //  - Libri.Titolo, 
                //  - Editori.idEditore AS idEditore, 
                //  - Editori.Nome AS nomeEditore,
                //  - Generi.Descrizione AS Genere,
                //  - Tipologie.Descrizione AS Tipologia

                // ANCHOR Componi la query per la ricerca
                //  Inizia con i SELECT generali
                $ricerca = 'SELECT Libri.ISBN, Libri.Titolo, Editori.idEditore AS idEditore, Editori.Nome AS "nomeEditore",
                Generi.Descrizione AS "Genere", Tipologie.Descrizione AS "Tipologia"';
                // ANCHOR Memorizza tutte le ricerche testuali da effettuare
                $testuale = array();
                // Aggiungi solo le query che esistono
                if ($titolo != '')
                    $testuale[] = generaMatch('Libri.Titolo', $titolo, 1);
                if ($editore != '')
                    $testuale[] = generaMatch('Editori.Nome', $editore, 0.3);
                if ($collana != '')
                    $testuale[] = generaMatch('Collane.Nome', $collana, 0.5);

                // Crea la match per il punteggio per gli autori
                $scoreAutori = '';
                if ($autore != '') {
                    $scoreAutori = "(SELECT SUM(" . generaMatch('Autori.NomeAutore', $autore, 0.4) .
                        "\n + " . generaMatch('Autori.CognomeAutore', $autore, 0.6) .
                        "\n + " . generaMatch('Autori.NomeArte', $autore, 0.8) . ")
     FROM Autori, Autori_Libri 
     WHERE Autori_Libri.ISBNLibro = Libri.ISBN 
       AND Autori_Libri.idAutore = Autori.idAutore 
     GROUP BY Libri.ISBN)";
                }
                // Ottieni la somma dei punteggi per i testi tranne gli autori
                $testuale = join(" + \n", $testuale);

                // Unisci gli score
                if ($testuale != '' and $scoreAutori != '')
                    $score = $testuale . " +\n" . $scoreAutori;
                else if ($testuale != '')
                    $score = $testuale;
                else $score = $scoreAutori;
                // Contempla anche il caso in cui non viene effettuata una ricerca testuale
                if ($testuale == '' and $scoreAutori == '')
                    $score = '';

                // Aggiungi gli altri select
                if ($score != '')
                    $ricerca .= ", \n$score AS Score\n";


                // ANCHOR Aggiungi i from
                $ricerca .= "FROM Libri, Generi, Editori, Tipologie, Collane\n";

                // ANCHOR Aggiungi le condizioni di WHERE generali
                $ricerca .= "WHERE Libri.idGenere = Generi.idGenere
    AND Libri.idEditore = Editori.idEditore
    AND Libri.idTipo = Tipologie.idTipologia
    AND Libri.idCollana = Collane.idCollana\n";


                // Aggiungi la condizione per le ricerche testuali
                // cioè che il punteggio della ricerca sia diverso da 0
                if ($score != '')
                    $ricerca .= "AND ($score) <> 0\n";

                // ANCHOR Aggiungi ricerca per id
                if ($tipologia != '')
                    $ricerca .= "AND Tipologie.idTipologia = $tipologia\n";
                if ($genere != '')
                    $ricerca .= "AND Generi.idGenere = $genere\n";

                // ANCHOR Ordina per punteggio
                if ($score != '')
                    $ricerca .= 'ORDER BY Score DESC';
            }

            // Se non è stata impostata, mostra tutti i libri
            if ($ricerca == '')
                // Crea la query per ottenere tutti i libri
                $ricerca = 'SELECT Libri.ISBN, Libri.Titolo, Editori.idEditore AS idEditore, Editori.Nome AS "nomeEditore",
                        Generi.Descrizione AS "Genere",
                        Tipologie.Descrizione AS "Tipologia"
                        FROM Libri, Generi, Editori, Tipologie
                        WHERE Libri.idGenere = Generi.idGenere
                        AND Libri.idEditore = Editori.idEditore
                        AND Libri.idTipo = Tipologie.idTipologia
                        ORDER BY Libri.DataAggiunta ASC, Libri.Titolo ASC';

            // Passa alla funzione di paginazione la query
            // corretta per la ricerca effettuata
            paginazione($ricerca);
            ?>

        </div>
    </div>

    <!-- Pagina del footer importata -->
    <?php include "../views/footer.php"; ?>
</body>

</html>