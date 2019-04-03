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
    </head>
    
<body class="wrapper">
        <!-- Pagina dell'header importata -->
        <?php include "../views/header.php"; ?>

        <!-- Contenuto principale della pagina -->
        <div>
            <!-- Rettangolo grigio per il titolo della sezione -->
            <div class="jumbotron" style="padding: 2rem 2rem">
                <h1 class="display-4 text-center">Catalogo</h1>
            </div>

            <!-- Barra di ricerca -->
            <div class="container w-60" style="margin:auto">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Cosa stai cercando?">
                    <div class="input-group-append">
                        <!-- Desktop -->
                        <button class="btn btn-outline-info fa fa-filter" name="filtra" type="button"><span class="ml-2" style="font-family:arial">Filtri</span></button>
                        <button class="btn btn-outline-info fa fa-search full-search" name="cerca" type="button"><span class="ml-2" style="font-family:arial">Cerca</span></button>
                        <!-- Mobile -->
                        <button class="btn btn-outline-info fa fa-search small-search" name="cerca" type="button"></button>
                    </div>
                </div>
            </div>  
            <!-- Catalogo -->
            <div class="container books">

                <?php
                    // Crea la query per ottenere tutti i libri
                    $query = 'SELECT Libri.ISBN, Libri.Titolo, Editori.idEditore AS idEditore, Editori.Nome AS "nomeEditore",
                    Generi.Descrizione AS "Genere",
                    Tipologie.Descrizione AS "Tipologia"
                    FROM Libri, Generi, Editori, Tipologie
                    WHERE Libri.idGenere = Generi.idGenere
                    AND Libri.idEditore = Editori.idEditore
                    AND Libri.idTipo = Tipologie.idTipologia
                    ORDER BY Libri.DataAggiunta ASC, Libri.Titolo ASC';

                    // Stampa tutti i libri risultati dalla query
                    paginazione($query);
                    ?>

            </div>
        </div>

        <!-- Pagina del footer importata -->
        <?php include "../views/footer.php"; ?>
</body> 
</html>