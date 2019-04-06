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
                    <input type="text" name="titolo" class="form-control" placeholder="Cosa stai cercando?">
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
                    <h1 class="badge badge-info mt-2" style="font-size: 16pt !important">Aggiungi filtri</h1>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="autore">Autore</label>
                            <input class="form-control w-100" name="autore" placeholder="Nome o Cognome autore">
                        </div>
                        <div class="col-6 mb-3">
                            <label for="editore">Editore</label>
                            <input class="form-control w-100" name="editore" placeholder="Nome editore">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="collana">Collana</label>
                            <input class="form-control w-100" name="collana" placeholder="Nome collana">
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
                            <input name="tipologia" id="tipologia" type="text" class="d-none">
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
                                <input name="genere" id="genere" type="text" class="d-none">
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
            // Definisci la query di ricerca senza impostarla
            $ricerca = '';

            // Assicurati che sia stata effettuata una ricerca
            if (isset($_GET['cerca'])) {
                // Ottieni la query per il titolo
                $titolo = $_GET['titolo'];
                // Ottieni la query per l'autore
                $autore = $_GET['autore'];
                // Ottieni la query per l'editore
                $editore = $_GET['editore'];
                // Ottieni la query per la collana
                $collana = $_GET['collana'];

                // Ottieni la tipologia cercata
                $tipologia = $_GET['tipologia'];
                // Ottieni il genere cercata
                $genere = $_GET['genere'];

                
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